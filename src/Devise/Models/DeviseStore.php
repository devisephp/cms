<?php

namespace Devise\Models;

use Event;
use Devise\Models\Repositories\DvsRelationshipsRepository;
use Devise\Support\Helpers\DeviseArray;
use Devise\Models\Validation\ModelValidator;
use Route;
use Exception;

/**
 * Class Store
 * @package Devise\Devise
 */
class DeviseStore {

    /**
     * @var
     */
    public $errors = array();

    /**
     * @var Repositories\DvsRelationshipsRepository
     */
    private $DvsRelationshipsRepository;

    /**
     * @var \Devise\Support\Helpers\DeviseArray
     */
    private $DeviseArray;

    /**
     * @var array
     */
    private $relationshipList;

    /**
     * @var
     */
    private $ModelValidator;


	/**
	 * @param DeviseArray $DeviseArray
	 * @param DvsRelationshipsRepository $DvsRelationshipsRepository
	 * @param ModelValidator $ModelValidator
	 */
	function __construct(
        DeviseArray $DeviseArray,
        DvsRelationshipsRepository $DvsRelationshipsRepository,
        ModelValidator $ModelValidator
    )
    {
        $this->DeviseArray = $DeviseArray;
        $this->DvsRelationshipsRepository = $DvsRelationshipsRepository;
        $this->ModelValidator = $ModelValidator;

        $this->relationshipList = $this->DvsRelationshipsRepository->aliasKeys();
        $this->ModelValidator->relationshipList = $this->relationshipList;
    }

    /**
     * @param $id
     * @param $input
     * @param array $exludedRules  Key-pair values of fieldname and validation rules to be excluded
     * @return bool
     */

    public function update($id, $input, $exludedRules = array())
    {
        $errors = $this->ModelValidator->validate($input, 'updateRules', $exludedRules);

        if(count($errors)){
            $this->errors = $errors;
            return false;
        } else {
            return $this->updateModelsFromInput($id, $input);
        }
    }

    /**
     * Handles storing of new record
     * @param array $input
     * @param array $exludedRules  Key-pair values of fieldname and validation rules to be excluded
     * @return Response
     */
    public function store($input, $exludedRules = array())
    {
        $errors = $this->ModelValidator->validate($input, 'createRules', $exludedRules);

        if(count($errors)){
            $this->errors = $errors;
            return false;
        } else {
            $saved = array();
            foreach($input as $model => $values) {
                // Build the base model
                $model = new $model;

                // Build the properties of the base model
                $properties = $this->buildProperties($values);

                $model = $model->create($properties);

                // Parse and save down the array
                $this->parseRelationships($model, $values);
                $saved[] = $model;
            }

            return $saved;
        }
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws \Exception
     */
    private function updateModelsFromInput($id, $input)
    {
        $saved = array();
        foreach ($input as $modelname => $values) {
            $model = new $modelname;

            // Find this level of the array
            $model = $model->findOrFail($id);

            // Build the properties of the base model
            $properties = $this->buildProperties($values);

            // Apply the current model's properties
            $this->applyProperties($model, $properties);

            // Build the properties of the base model
            $this->parseRelationships($model, $values);

            $model->push();
            $saved[] = $model;
        }

        return $saved;
    }

    /**
     * @param $model
     * @param $values
     */
    private function parseRelationships($model, $values)
    {
        // Now search for relations from this level
        foreach ($values as $relationOrField => $value) {

            $relatedModel = false;

            // Is array and found the relationship from the relationships table
            if (is_array($value) && !$this->DeviseArray->isOneDimensional($value)) {

                // Does this relation have old models that need to be linked to the parent?
                $existingRecords = $this->relationHasExistingRecords($relationOrField, $value);
                if($existingRecords) {
                    $relatedModel = $this->bridgeExistingRecords($model, $existingRecords, $relationOrField, $value);
                }

                // Does this relation have new models that need to be created?
                if($this->relationHasNewRecords($value)) {
                    $relatedModel = $this->bridgeNewRecords($model, $relationOrField, $value);
                }

                if($relatedModel) {
                    $this->parseRelationships($relatedModel, $value);
                }

            } else if (is_array($value) && isset($this->relationshipList[$relationOrField])) {

                // Does this relation have old models that need to be linked to the parent?
                $existingRecords = $this->relationHasExistingRecords($relationOrField, $value);
                if($existingRecords) {
                    $this->bridgeExistingRecords($model, $existingRecords, $relationOrField, $value);
                }

                // Does this relation have new models that need to be created?
                if($this->relationHasNewRecords($value) && !$existingRecords) {
                    $this->bridgeNewRecords($model, $relationOrField, $value);
                }
            }
        }
    }

    /**
     * @param $relation
     * @param $value
     * @return mixed
     */
    private function createRelatedModel($relation, $value)
    {
        $relation = $this->relationshipList[$relation];

        // Build the properties of the related model
        $properties = $this->buildProperties($value);

        // Create a new instance of the related model
        $relatedModel = new $relation['model_2']($properties);

        // Create the related model with the properties defined
        $relatedModel->save();

        return $relatedModel;
    }

    /**
     * @param $relationship
     * @return string
     */
    private function getPrimaryKey($relationship)
    {
        $modelName = $this->relationshipList[$relationship]['model_2'];
        $model = new $modelName;
        return (is_null($model->primaryKey)) ? 'id' : $model->primaryKey;
    }

    /**
     * @param $values
     * @return array
     */
    private function buildProperties($values)
    {
        $properties = array();

        foreach($values as $relationOrField => $value)
        {
            if (!is_array($value) && strpos($relationOrField, 'pivot|') === false) {
                $properties[$relationOrField] = $value;
            }
        }

        return $properties;
    }

    /**
     * @param $values
     * @return array
     */
    private function getPivotProperties($values)
    {
        $pivotValues = array();

        foreach($values as $relationOrField => $value)
        {
            if (!is_array($value) && strpos($relationOrField, 'pivot|') !== false) {
                $pivotValues[str_replace('pivot|', '', $relationOrField)] = $value;
            }
        }

        return $pivotValues;
    }

    /**
     * @param $model
     * @param $properties
     */
    private function applyProperties(&$model, $properties)
    {
        foreach($properties as $property => $value)
        {
            $model->$property = $value;
        }
    }

    /**
     * @param $values
     * @return bool
     */
    private function relationHasNewRecords($values)
    {
        if (
            count($this->buildProperties($values)) > 0 ||
            count($this->DeviseArray->numericKeys($values)) > 0
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param $relationship
     * @param $values
     * @return bool
     */
    private function relationHasExistingRecords($relationship, $values)
    {
        $associativeKeys = $this->DeviseArray->assocKeys($values);

        foreach($associativeKeys as $key => $values)
        {
            if($key == $this->getPrimaryKey($relationship))
            {
                return $values;
            }
        }

        return false;
    }

    /**
     * @param $model
     * @param $existingRecords
     * @param $relationOrField
     * @param $values
     * @return bool
     */
    private function bridgeExistingRecords($model, $existingRecords, $relationOrField, $values)
    {
        $relatedModel = false;

        if (is_array($existingRecords)) {
            $relatedModel = $this->bridgeRecord($model, $relationOrField, $values, null, $existingRecords);
        } else {
            $relatedModel = $this->bridgeRecord($model, $relationOrField, $values, $existingRecords);
        }
        return $relatedModel;
    }

    /**
     * @param $model
     * @param $relationOrField
     * @param $values
     * @return bool|mixed
     */
    private function bridgeNewRecords($model, $relationOrField, $values)
    {
        $relatedModel = false;

        // Properties exist as keys
        if (count($this->buildProperties($values)) > 0) {
            // Create the new related model
            $relatedModel = $this->createRelatedModel($relationOrField, $values);

            // Get any pivot properties
            $pivotProperties = $this->getPivotProperties($values);

            // Determine proper method name using relationships config
            $relationMethod = $this->getRelationshipMethod($model, $relationOrField);

             // Bridge the relation
            $this->bridgeRelation($model->$relationMethod(), $relatedModel, $this->relationshipList[$relationOrField]['type'], $pivotProperties);
        }


        // There are multiple indexed records that need to be added
        if (count($this->DeviseArray->numericKeys($values)) > 0) {
            foreach ($values as $k => $v) {
                if(is_numeric($k)) {

                    // Create the new related model
                    $relatedModel = $this->createRelatedModel($relationOrField, $v);

                    // Get any pivot properties
                    $pivotProperties = $this->getPivotProperties($v);

                    // Determine proper method name using relationships config
                    $relationMethod = $this->getRelationshipMethod($model, $relationOrField);

                     // Bridge the relation
                    $this->bridgeRelation($model->$relationMethod(), $relatedModel, $this->relationshipList[$relationOrField]['type'], $pivotProperties);
                }
            }
            return $relatedModel;
        }
        return $relatedModel;
    }

    /**
     * @param $model
     * @param $relationOrField
     * @param $values
     * @param $existingPrimaryKey
     * @param null $existingRecords
     * @return mixed
     */
    private function bridgeRecord($model, $relationOrField, $values, $existingPrimaryKey = null, $existingRecords = null)
    {
        $modelName = $this->relationshipList[$relationOrField]['model_2'];
        $type = $this->relationshipList[$relationOrField]['type'];

        if ($existingRecords !== null) {
            $relatedModel = $this->getExistingRelatedModels($existingRecords, $values, $modelName);
        } else {
            $relatedModel = $this->getExistingRelatedModel($existingPrimaryKey, $values, $modelName);
        }

        $this->bridgeRelation($model->$relationOrField(), $relatedModel, $type);

        return $relatedModel;
    }


    /**
     * @param $relation
     * @param $relatedModel
     * @param $type
     * @param array $pivotProperties
     */
    private function bridgeRelation($relation, $relatedModel, $type, $pivotProperties = array())
    {
        switch($type) {
            case 'hasOne':
            case 'hasMany':
            case 'morphOne':
            case 'morphMany':
                $this->bridgeHasManyHasOne($relation, $relatedModel);

                break;

            case 'belongsTo':
                $this->bridgeBelongsTo($relation, $relatedModel);

                break;

            case 'belongsToMany':
                $this->bridgeBelongsToMany($relation, $relatedModel, $pivotProperties);

                break;
        }
    }

    /**
     * @param $relation
     * @param $relatedModel
     */
    private function bridgeHasManyHasOne($relation, $relatedModel)
    {
        if (is_array($relatedModel)) {
            foreach ($relatedModel as $rm) {
                $relation->save($rm);
            }
        } else {
            $relation->save($relatedModel);
        }
    }

    /**
     * @param $relation
     * @param $relatedModel
     */
    private function bridgeBelongsTo($relation, $relatedModel)
    {
        if (is_array($relatedModel)) {
            foreach ($relatedModel as $rm) {
                $relation->associate($rm)->save();
            }
        } else {
            $relation->associate($relatedModel)->save();
        }
    }

    /**
     * @param $relation
     * @param $relatedModel
     * @param $pivotProperties
     */
    private function bridgeBelongsToMany($relation, $relatedModel, $pivotProperties)
    {
        if (is_array($relatedModel)) {
            $ids = array();
            foreach($relatedModel as $rm) {
                $ids[] = $rm->id;
            }
            $relation->sync($properties);
        } else {
            $relation->attach($relatedModel->id, $pivotProperties);
        }
    }

    /**
     * @param $existingRecords
     * @param $values
     * @param $modelName
     * @return array
     */
    private function getExistingRelatedModels($existingRecords, $values, $modelName)
    {
        $relatedModels = array();
        foreach($existingRecords as $existingRecord) {
            $relatedModels[] = $this->getExistingRelatedModel($existingRecord, $values, $modelName);
        }

        return $relatedModels;
    }

    /**
     * @param $existingPrimaryKey
     * @param $values
     * @param $modelName
     * @return mixed
     */
    private function getExistingRelatedModel($existingPrimaryKey, $values, $modelName)
    {
        $relatedModel = new $modelName;
        $relatedModel = $relatedModel->findOrFail($existingPrimaryKey);

        // Get the properties for this related model
        $properties = $this->buildProperties($values);

        // Apply the current model's properties
        $this->applyProperties($relatedModel, $properties);
        return $relatedModel;
    }

    /**
     * @param $listeners
     * @internal param $type
     * @return bool
     */
    private function checkEventForFailures($listeners)
    {
        if(count($listeners) == 0 || !in_array(false, $listeners, true)) {
            return true;
        }
        return false;
    }

    /**
     * Retrieves the relationship method name by checking if the aliased method exists (in
     * related  model) and if it doesn't it attempts to use the modelMethod from config array
     * @param object $model
     * @param string $relationOrField
     * @return string
     */
    private function getRelationshipMethod($model, $relationOrField)
    {
        return (method_exists($model, $relationOrField)) ? $relationOrField : $this->relationshipList[$relationOrField]['modelMethod'];
    }
}