<?php

namespace Devise\Transfer;

use DB;
use Config;


/**
 * Class Transfer
 * @package Devise\Transfer
 */
class Transfer
{
    /**
     * @var
     */
    var $config;

    /**
     *
     */
    public function __construct()
    {
        $this->config = Config::get('devise::transfer.config');
    }

    /**
     * @param null $config
     * @param null $node
     * @param null $number
     * @return array|bool
     */
    public function process($config = null, $node = null, $number = null)
    {
        $this->setConfig($config);

        $results = $this->processConfiguration($node, $number, true);
        if (is_array($results)) {
            return $results;
        }

        return true;
    }

    /**
     * @param null $config
     * @param null $node
     * @param null $number
     */
    public function preview($config = null, $node = null, $number = null)
    {
        $this->setConfig($config);

        $this->processConfiguration($node, $number, false);
    }

    /**
     * @param null $config
     */
    public function setConfig($config = null)
    {
        $this->config = is_null($config) ? $this->config : $config;
    }

    /**
     * @param $node
     * @param $number
     * @param bool $live
     * @return array|bool
     */
    private function processConfiguration($node, $number, $live = false)
    {
        foreach ($this->config['transfers'] as $table => $tableConfig) {

            if ($node == null || $node == $table) {
                $results = $this->getSourceData($tableConfig, $table, $live, $number);
                $node = null;

                if ($results !== true) {
                    return array(
                        'node' => $table,
                        'number' => $results['number'],
                        'percent' => $results['percent']
                    );
                }
            }
        }

        return true;
    }

    /**
     * @param $table
     * @param $sourceData
     */
    private function transferTable($table, $sourceData)
    {
        DB::connection($this->config['destination_db'])
            ->table($table)
            ->insert((array)$sourceData);
    }

    /**
     * @param $table
     * @param $destinationTable
     * @param $live
     * @param $number
     * @return array
     */
    private function getSourceData($table, $destinationTable, $live, $number)
    {
        $fields = $this->generateSelectFields($table);

        $query = DB::connection($this->config['source_db'])->table($table['source_table']);
        $query = $this->generateRelations($table, $query);
        $query = $this->where($table, $query);
        $query = $this->groupBy($table, $query);
        $query = $this->orderBy($table, $query);
        $query = $this->distinct($table, $query);
        $query = $query->select($table['source_table'].'.'.$table['source_id']);

        $this->debug(!$live, $query, $fields, $table);

        return $this->processRecords($table, $destinationTable, $number, $query, $fields);
    }

    /**
     * @param $table
     * @return array
     */
    private function generateSelectFields($table)
    {
        $fields = array();

        foreach ($table['fields'] as $key => $field) {
            if ($field !== null && !is_array($field)) {
                array_push($fields, $field . ' as ' . $key);
            } else {
                $this->runMySQLFunctions($fields, $table, $key);
            }
        }

        return $fields;
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    private function generateRelations($table, $query)
    {
        if(isset($table['source_db_relations'])) {
            foreach($table['source_db_relations'] as $foreignTable => $relation) {
	            if (isset($relation['subquery'])) {
		            $query = $query->$relation['type'](DB::raw($relation['subquery']), function($rel) use ($relation) {
			            $rel->on($relation['local'], '=', $relation['foreign']);
		            });
	            } else {
		            $query = $query->$relation['type']($foreignTable, $relation['local'], '=', $relation['foreign']);
	            }
            }
        }

        return $query;
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    private function distinct($table, $query)
    {
        if(isset($table['distinct']) && $table['distinct'] === true) {
            $query->distinct();
        }

        return $query;
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    private function orderBy($table, $query)
    {
        if(isset($table['order_by'])) {
            $direction = 'asc';
            if (isset($table['order_by'][1])) {
                $direction = $table['order_by'][1];
            }

            $query = $query->orderBy($table['order_by'][0], $direction);
        }

        return $query;
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    private function groupBy($table, $query)
    {
        if(isset($table['group_by'])) {
            $query = $query->groupBy($table['group_by']);
        }

        return $query;
    }

    /**
     * @param $table
     * @param $query
     * @return mixed
     */
    private function where($table, $query)
    {
        if(isset($table['where'])) {
            if(is_string($table['where'][0])){
                $query = call_user_func_array( array($query, 'where'), $table['where']);
            } else {
                foreach ($table['where'] as $where) {
                    $query = call_user_func_array( array($query, 'where'), $where);
                }
            }
        }

        return $query;
    }

    /**
     * @param $param
     * @param $table
     * @return mixed
     */
    private function runfunctions($param, $table)
    {
        if(isset($table['functions'])) {

            foreach($param as $field => &$value) {
                if (array_key_exists($field, $table['functions'])) {
                    $value = call_user_func_array( $table['functions'][$field], array($value));
                }
            }

            unset($value);

            foreach($table['fields'] as $field => $value) {
                if ($value === null) {
                    if (array_key_exists($field, $table['functions'])) {
	                    if (isset($table['mysql_functions'][$field])) {
		                    $value = call_user_func_array( $table['functions'][$field], array($field));
	                    } else {
		                    $param[ $field ] = call_user_func( $table['functions'][ $field ] );
	                    }
                    }
                }
            }
        }

        return $param;
    }


    /**
     * @param $fields
     * @param $table
     * @param $field
     */
    private function runMySQLFunctions(&$fields, $table, $field)
    {
        if(isset($table['mysql_functions'])) {
            if (array_key_exists($field, $table['mysql_functions'])) {
                array_push($fields, $table['mysql_functions'][$field]);
            }
        }
    }


    /**
     * @param $table
     * @param $data
     * @return mixed|null
     */
    private function processFields($table, &$data)
    {
        $d = null;
        foreach ($data as &$d) {
            $d = $this->runfunctions((array)$d, $table);
        }
        unset($d);

        return $data;
    }

    /**
     * @param $table
     * @param $destinationTable
     * @param $number
     * @param $query
     * @param $fields
     * @return array
     */
    private function processRecords($table, $destinationTable, $number, $query, $fields)
    {
        $numberOfRecords = DB::connection($this->config['source_db'])
                                ->table($table['source_table'])
                                ->select(DB::raw('count(*) as c'))
                                ->first()
                                ->c;

        $numberPerPage = 5000;
        $numberPerLoop = 500;
        $page = 1;
        $loopStart = 0;
        $totalIterations = ceil($numberOfRecords / $numberPerLoop);


        if ($number !== null) {
            $loopStart = ($number * $numberPerPage) / $numberPerLoop;
            $page = $number + 1;
        }

        for ($i = $loopStart; $i < $totalIterations; $i++) {

            if (($i * $numberPerLoop) >= $page * $numberPerPage) {
                return array(
                    'number'  => $page++,
                    'percent' => round((($number * $numberPerPage) / $numberOfRecords) * 100)
                );
            }

            $data = $query->select($fields)->skip($numberPerLoop * $i)->take($numberPerLoop)->get();
            
            if(count($data) == 0) break;

            $this->processFields($table, $data);
            $this->transferTable($destinationTable, $data);
        }

        return array(
            'number'  => 'done',
            'percent' => 100
        );
    }

    /**
     * @param $live
     * @param $query
     * @param $fields
     */
    private function debug($live, $query, $fields, $table)
    {
        if ($live) {
            print_r($query->select($fields)->take(5)->toSql());
            $sample = $query->select($fields)->take(5)->get();

            var_dump($sample);

            $processedSample = $this->processFields($table, $sample);

            dd($processedSample);
        }
    }
}