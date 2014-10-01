<?php namespace Devise\Indexer\DeviseIndexerForm;

class DeviseIndexerForm {
    private $options;
    private $nestedFluent;

    public $baseModel;
    public $relationshipAliases = array();
    public $directDecendants = array();
    public $joins = array();

    public function __construct()
    {
        $this->options = array();
        $this->nestedFluent = array('orWhere', 'andWhere', 'on', 'orOn', 'where');
    }

    /**
     * Primary function used to translate incoming form data (for use in DeviseIndexer)
     *
     * @param  array  $input
     * @return Void
     */
    public function translate($input)
    {
        if(isset($input['dvs_options'])) {
            foreach($input['dvs_options'] as $key => $option) {
                $this->parseOperator($key, $option);
            }

            $this->baseModel->relationshipAliases = array_unique($this->relationshipAliases);
            $this->baseModel->directDecendants = array_unique($this->directDecendants);
            $this->baseModel->joins = array_unique($this->joins);

            return array('conditions' => $this->options);
        }


        return false;
    }

    private function parseOperator($operator, $options)
    {
        foreach ($options as $key => $conditions) {
            if(strpos($key, 'dvsg') !== false){
                // found a group
                $this->options[ $key ] = $this->handleGroup($conditions);
            } else {
                // simple condition
                $this->options['dvsg-default'][$operator] =  $this->buildCondition($key, $conditions);
            }
        }
    }

    private function handleGroup($conditions)
    {
        $groupOptions = array();
        foreach ($conditions as $operator => $operatorOptions) {
            foreach ($operatorOptions as $key => $conditions) {
                $groupOptions[ $operator ] = $this->buildCondition($key, $conditions);
            }
        }
        return $groupOptions;
    }

    private function buildCondition($field, $conditions)
    {
        $field = $this->parseModelRelations($field);

        $condition = array();
        if(!$this->isOneDimensional($conditions)){
            // if the conditions array is not one dimensional
            $key = key($conditions);
            $filters = $conditions[ $key ];
            foreach ($filters as $value) {
                $condition[] = array(
                    $field,
                    $key,
                    $value
                );
            }
        } else {
            foreach ($conditions as $key => $value) {
                $condition[] = array(
                    $field,
                    $key,
                    $value
                );
            }
        }
        return $condition;
    }

    private function parseModelRelations($modelRelationField)
    {
        $relationsArr = explode('.', $modelRelationField);
        $fieldName = array_pop($relationsArr);

        $baseModelName = array_shift($relationsArr);
        if(!isset($this->baseModel)){
            $this->baseModel = new $baseModelName;
        }

        if(count($relationsArr)){
            $this->parseJoins($relationsArr);
            $this->relationshipAliases = array_merge($this->relationshipAliases, $relationsArr);
            $this->directDecendants[] = reset($relationsArr);

            return array_pop($relationsArr) . '.' . $fieldName;
        } else {
            return $this->baseModel->getTable() . '.' . $fieldName;
        }
    }

    private function parseJoins(&$relations)
    {
        foreach ($relations as &$relation) {
            if(strpos($relation,'|')){
                $parts = explode('|', $relation);
                $relation = $parts[0];
                $this->joins[ $relation ] = $parts[1];
            }
        }
    }

    /**
     *
     * @param  array  $array
     * @return boolean
     */
    private function isOneDimensional($array)
    {
        return (count($array) == count($array, COUNT_RECURSIVE));
    }

}