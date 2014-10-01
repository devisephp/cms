<?php namespace Devise\Data;

class DeviseData {
    private $model;

    public function build($model, $settings = array())
    {
        $this->model = $model;
        foreach ($settings as $operator => $options) {
            if($operator == 'select'){
                $this->select($options);
            }
            if(strpos(strtolower($operator), 'join') !== false){
                $this->handleJoins($operator, $options);
            }
            if($operator == 'conditions'){
                $this->handleConditions($options);
            }
        }
        return $this->model;
    }

    private function select($fields)
    {
        $this->model = call_user_func_array(array($this->model, 'select'), $fields);
    }

    private function handleJoins($joinType, $settings)
    {
        foreach ($settings as $key => $options) {
            if($this->isEndPoint($options)){
                $this->join($joinType, $options);
            } else {
                $this->joinClosure($joinType, $options);
            }
        }
    }

    private function joinClosure($joinType, $options)
    {
        $closure = function($join) use ($options) {
            foreach ($options as $method => $instance) {
                foreach ($instance as $params) {
                    if($method == 'on'){
                        array_shift($params);
                    }
                    $join  = call_user_func_array(array($join, $method), $params);
                }
            }
        };

        $this->model = call_user_func_array(
            array(
                $this->model,
                $joinType
            ),
            array(
                $options['on'][0][0],
                $closure
            )
        );
    }

    private function join($joinType, $params)
    {
        $this->model = call_user_func_array(array($this->model, $joinType), $params);
    }

    private function handleConditions($groups)
    {
        foreach ($groups as $groupName => $options) {
            if($groupName == 'dvsg-default'){
                $this->handleCondition($options);
            } else {
                $this->whereClosure($options);
            }
        }
    }

    private function handleCondition($options)
    {
        foreach ($options as $operator => $paramGroups) {
            foreach ($paramGroups as $params) {
                $this->executeCondition($operator, $params);
            }
        }
    }

    private function executeCondition($operator, $params)
    {
        $this->model = call_user_func_array(array($this->model, $operator), $params);
    }

    private function whereClosure($options)
    {
        $closure = function($query) use ($options) {
            foreach ($options as $method => $instance) {
                foreach ($instance as $params) {
                    $query  = call_user_func_array(array($query, $method), $params);
                }
            }
        };

        $this->model = call_user_func(
            array(
                $this->model,
                'where'
            ),
            $closure
        );
    }

    /**
     * Compares count with rescursive count to figure out if the array is multidimensional
     * A non-multidimensional array means an "endpoint" has been reached
     *
     * @param  array  $array
     * @return boolean
     */
    private function isEndPoint($array)
    {
        return (count($array) == count($array, COUNT_RECURSIVE));
    }

    /**
     * Retrieves table of the related model from value string
     *
     * @param  array  $valuesArray   Contains strings for DeviseData statement
     * @return string
     */
    private function getRelatedModelTable($valuesArray)
    {
        return head(explode(".", head($valuesArray)));
    }

    /**
     * Detects if an array is associative
     *
     * @param  array  $array
     * @return boolean
     */
    private function is_assoc($array) {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }
}