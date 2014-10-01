<?php namespace Devise\Indexer;

use Config;
use Devise\Data\DeviseData;
use Devise\Indexer\DeviseIndexerForm\DeviseIndexerForm;
use Devise\Indexer\Exceptions\IndexerException;
use Exception;

class DeviseIndexer {
    private $definedRelationships = array();
    private $joins = array();
    private $DeviseIndexerForm;
    private $DeviseData;
    private $requiredModels;

    public function __construct(DeviseIndexerForm $DeviseIndexerForm, DeviseData $DeviseData)
    {
        $this->DeviseIndexerForm = $DeviseIndexerForm;
        $this->DeviseData = $DeviseData;
    }

    /**
     * Primary function for building indexer data set
     *
     * @param  array  $fields          Fields to be returned in dataset
     * @param  array  $options         Additional options for dataset query
     * @param  boolean  $isForm
     * @return object
     */
    public function load($fields = array(), $options = array(), $isForm = false)
    {
        if(isset($options['dvs_options'])){
            $this->translateKeys($options['dvs_options']);

            $options = $this->loadForm($options);

            $model = $this->DeviseIndexerForm->baseModel;

            $fields = $this->parseFields($model, $fields);

            // load relationships
            $this->loadRelationships($model);

            // build select statement(s) for data builder
            $selects = array('select' => $fields);

            // merge select fields and options
            $buildOptions = array_merge($selects, $this->joins, $options);

            // pass $baseModel along with build options to DeviseData
            return $this->DeviseData->build($model, $buildOptions);
        } else {
            return false;
        }
    }

    /**
    * Parse fields array to determine direct descendent using
    * dot-notated relation(s). Then only the model and field names
    * are returned in the rebuild array of fields.
    *
    * @param  object  $model
    * @param  array  $fields
    * @return array
    */
    private function parseFields(&$model, $fields)
    {
        $relationshipAliases = array();
        $directDecendants = array();

        foreach($fields as &$modelRelationField) {
            $relationsArr = explode('.', $modelRelationField);
            $fieldName = array_pop($relationsArr);

            array_shift($relationsArr);

            if(count($relationsArr)){
                $relationshipAliases = array_merge($relationshipAliases, $relationsArr);
                $directDecendants[] = reset($relationsArr);
                $modelRelationField = array_pop($relationsArr) . '.' . $fieldName;
            } else {
                $modelRelationField = $model->getTable() . '.' . $fieldName;
            }
        }

        $model->relationshipAliases = array_merge($model->relationshipAliases, array_unique($relationshipAliases));
        $model->directDecendants = array_merge($model->directDecendants, array_unique($directDecendants));

        return $fields;
    }
    /**
     * load form data and submit to translate function in DeviseIndexerForm
     *
     * @param  array  $input
     * @return object
     */
    private function loadForm($input)
    {
        // translate form data and format for DeviseIndexer
        return $this->DeviseIndexerForm->translate($input);
    }

    /**
     * Retrieves relationships from relationships config file so
     * an array of relationship objects and an aliasMap can be built
     *
     * @param object  $model
     * @return void
     */
    private function loadRelationships($model)
    {
        if(count($model->relationshipAliases)) {
            $relationships = array();
            $aliasMap = array();
            // make sure no duplicates exist
            $model->relationshipAliases = array_unique($model->relationshipAliases);
            foreach($model->relationshipAliases as $relationshipAlias) {
                if(Config::has('devise::relationships.'.$relationshipAlias)){
                    $relationships[] = (object) Config::get('devise::relationships.'.$relationshipAlias);

                    $aliasMap[Config::get('devise::relationships.'.$relationshipAlias.'.model_2')] = $relationshipAlias;
                } else {
                    throw new IndexerException("Unable to find a relationship for \"" . $relationshipAlias . "\"");
                }
            }
            
            // Build "join" statements for all relationships
            foreach($relationships as $relationship){
                $this->buildJoin($relationship, $aliasMap, $model);
            }
        }
    }

    /**
     * Builds join data prepped for data builder
     *
     * @param  array   $relationship    Array of relationship objects
     * @param  string  $aliasMap        Array of model_2 names (key) and aliases (value)
     * @param  object  $model
     * @return Void
     */
    private function buildJoin($relationship, $aliasMap, $model)
    {
        $joinType = 'leftJoin';
        $baseModel = new $relationship->model_1;
        $relatedModel = new $relationship->model_2;

        $baseModelName = get_class($baseModel);
        $relatedModelName = get_class($relatedModel);

        $relatedModelTable = $relatedModel->getTable();
        $foreignKey = $relationship->foreign_key;

        $relatedAlias = (isset($aliasMap[ $relatedModelName ])) ? $aliasMap[ $relatedModelName ] : $relatedModelTable;

        if(in_array($relatedAlias, $model->directDecendants)){
            $baseAlias = $model->getTable();
        } else {
            $baseAlias = (isset($aliasMap[ $baseModelName ])) ? $aliasMap[ $baseModelName ] : $baseModel->getTable();
        }

        if( isset( $model->joins[ $relatedAlias] ) ){
            $joinType = $model->joins[ $relatedAlias ];
        }

        $pivotTable = $relationship->pivot_table;
        $pivotBaseModelKey = $relationship->pivot_key_model_1;
        $pivotRelatedModelKey = $relationship->pivot_key_model_2;

        switch($relationship->type) {
            case 'belongsTo':
                $this->joins[ $joinType ][] = array($relatedModelTable . ' as ' . $relatedAlias, $relatedAlias.'.id', '=', $baseAlias.'.'.$foreignKey);
                break;

            case 'belongsToMany':
                // join pivot table first
                $this->joins[ $joinType ][] = array($pivotTable, $pivotTable.'.'.$pivotBaseModelKey, '=', $baseAlias.'.id');

                // then add join for related model
                $this->joins[ $joinType ][] = array($relatedModelTable . ' as ' . $relatedAlias, $relatedAlias.'.id', '=', $pivotTable.'.'.$pivotRelatedModelKey);
                break;

            case 'hasOne':
            case 'hasMany':
                $this->joins[ $joinType ][] = array($relatedModelTable . ' as ' . $relatedAlias, $relatedAlias.'.'.$foreignKey, '=', $baseAlias.'.id');
                break;

            case 'morphOne':
            case 'morphMany':
                $this->joins[ $joinType ][] = array(
                    'on' => array(
                        array($relatedModelTable . ' as ' . $relatedAlias, $relatedAlias.'.'.$foreignKey.'_id','=', $baseAlias.'.id')
                    ),
                    'where' => array(
                        array($relatedAlias.'.'.$foreignKey.'_type','=', $baseModelName)
                    )
                );
                break;

            case 'morphTo':
                $this->joins[ $joinType ][] = array(
                    'on' => array(
                        array($relatedModelTable . ' as ' . $relatedAlias, $relatedAlias.'.id','=', $baseAlias.'.'.$foreignKey.'_id')
                    ),
                    'where' => array(
                        array($baseAlias.'.'.$foreignKey.'_type','=', get_class($relatedModel))
                    )
                );
                break;
        }

        // check if related model is soft
        if($relatedModel->softDelete) {

            $lastIndex = count($this->joins[ $joinType ]) - 1;
            if(in_array($relationship->type, array('morphTo','morphMany','morphOne'))){
                $this->joins[ $joinType ][$lastIndex]['where'][] = array($relatedAlias.'.deleted_at','=','0000-00-00 00:00:00');
            } else {
                $lastJoin = $this->joins[ $joinType ][$lastIndex];
                $this->joins[ $joinType ][$lastIndex] = array(
                    'on' => array(
                        $lastJoin
                    ),
                    'where' => array(
                        array($relatedAlias.'.deleted_at','=','0000-00-00 00:00:00')
                    )
                );
            }
        }

        return true;
    }

    /**
     * Checks options keys and removes any invalid keys
     *
     * @param $array $options
     * @return array
     */
    private function translateKeys(&$options)
    {
        // Array of valid eloquent conditions
        $validKeys = array('orderBy', 'groupBy', 'where', 'orWhere', 'join', 'joinWhere', 'leftJoinWhere', 'on', 'orOn');

        foreach($options as $key => $option) {
            if(!in_array($key, $validKeys) && !is_numeric($key)) {
                $options['where']['dvsg-' . $key] = $option;

                $this->translateKeys( $options['where']['dvsg-' . $key] );
                unset($options[$key]);
            }
        }
    }
}