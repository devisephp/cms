<?php namespace Devise\Models\Validation;

use App;
use Config;
use DeviseArray;
use Validator;

/**
 * Class ModelValidator
 * @package Devise\Models
 */
class ModelValidator {
    public $relationshipList = array();

    private $rulesPropName = 'rules';
    private $excludedRules = array();
    private $errors = array();

    /**
     * Create and run validator on model instance
     * @param  object $model
     * @param  array $data
     * @return mixed
     */
    public function validate($data, $rulesPropName = 'rules', $excludedRules = array())
    {
        $this->rulesPropName = $rulesPropName;
        $this->excludedRules = $excludedRules;
        foreach ($data as $modelName => $modelData) {
            $this->handleModel($modelName, $modelData);
        }

        return $this->errors;
    }

    private function handleModel($name, $data)
    {
        $properties = $this->buildProperties($data);
        $model = $this->loadModel($name);
        $this->validateModel($model, $properties);
        
        foreach ($data as $IndexOrModelRelationName => $childData) {
            if(DeviseArray::isAssoc($childData)){
                $this->handleModel($IndexOrModelRelationName, $childData);
            } else {
                foreach ($childData as $subChildData) {
                    $this->handleModel($IndexOrModelRelationName, $subChildData);
                }
            }
        }
    }

    private function loadModel($name)
    {
        if(isset($this->relationshipList[ $name ])){
            return App::make( $this->relationshipList[ $name ]['model_2'] );
        } else {
            return App::make( $name );
        }
    }

    private function validateModel($model, $data)
    {
        $rulesPropName = $this->rulesPropName;
        $rules = (empty($this->excludedRules)) ? $model->$rulesPropName : $this->getRulesWithExclusions($model->$rulesPropName);
        $messages = ($model->messages) ? $model->messages : array();

        if($rules !== null){
            $validator = validator::make($data, $rules, $messages);
            if($validator->fails()){
                return $this->errors = array_merge($this->errors, $validator->errors()->all());
            }
        }
    }

    /**
     * @param $values
     * @return array
     */
    private function buildProperties(&$values)
    {
        $properties = array();

        foreach($values as $relationOrField => $value)
        {
            if (!is_array($value) && strpos($relationOrField, 'pivot|') === false) {
                $properties[$relationOrField] = $value;
                unset($values[ $relationOrField ]);
            }
        }

        return $properties;
    }


    /**
     * Compares model rules to excluded rules and returns revised array of rules
     * @param  array $rules
     * @return array
     */
    private function getRulesWithExclusions($rules)
    {
        foreach($this->excludedRules as $fieldname => $rule) {
            if(in_array($fieldname, array_keys($rules))) {
                $rules[$fieldname] = $rule;
            }
        }
        return $rules;
    }

}