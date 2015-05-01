<?php

use Devise\Pages\Fields\LiveFieldValue;
use Illuminate\Database\Eloquent\SoftDeletes;

class DvsModelField extends Eloquent
{
    use SoftDeletes;

    public $dvs_type = 'model_field';

    protected $softDelete = true;

	protected $table = 'dvs_model_fields';

    protected $guarded = array();

    protected $_value;

    protected $dates = ['deleted_at'];

    protected $appends = ['values', 'scope', 'rules', 'picks', 'type'];

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValueAttribute()
    {
        $json = $this->json_value ?: '{}';
        $this->_value = $this->_value ?: new LiveFieldValue($json, $this->id, 'model');
        return $this->_value;
    }

    /**
     * Sometimes we've been using values instead of value
     * so this is here for backwards compatability support
     *
     * @return FieldValue
     */
    public function getValuesAttribute()
    {
        return $this->getValueAttribute();
    }

    /**
     * Get the rules for this field type
     *
     * @return []
     */
    public function getRulesAttribute()
    {
        $config = config('devise.model-mapping');

        $config = array_get($config, $this->model_type, []);

        $config = array_get($config, 'rules', []);

        return $config;
    }

    /**
     * Gets only the rules that are picked
     * instead of all the rules
     *
     * @return []
     */
    public function getPickedRulesAttribute()
    {
        $rules = [];

        $allRules = $this->rules;

        $picks = $this->picks;

        foreach ($picks as $modelAttr => $fieldAttr)
        {
            if (isset($allRules[$modelAttr])) $rules[$modelAttr] = $allRules[$modelAttr];
        }

        return $rules;
    }

    /**
     * Get the messages for this field type
     *
     * @return []
     */
    public function getMessagesAttribute()
    {
        $config = config('devise.model-mapping');

        $config = array_get($config, $this->model_type, []);

        $config = array_get($config, 'messages', []);

        return $config;
    }

    /**
     * Get the picks for this field type
     *
     * @return []
     */
    public function getPicksAttribute()
    {
        $config = config('devise.model-mapping');

        $config = array_get($config, $this->model_type, []);

        $config = array_get($config, 'picks', []);

        $config = array_get($config, $this->mapping, []);

        return $config;
    }

    /**
     * Get the field type this field type represetnts
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        $config = config('devise.model-mapping');

        $config = array_get($config, $this->model_type, []);

        $config = array_get($config, 'types', []);

        $config = array_get($config, $this->mapping, '');

        return $config;
    }

    /**
     * Let's us know if the scope of this field is global or page
     *
     * @return string
     */
    public function getScopeAttribute()
    {
        return 'model';
    }

    /**
     * This syncs the model values with all this fields values
     * which is useful in case the user updates the model outside
     * of the context of the model field
     *
     * @param  Eloquent $model
     * @return void
     */
    public function syncValuesWithModelValues($model = null)
    {
        $model = ($model === null) ? $this->model : $model;

        foreach ($this->picks as $modelAttribute => $fieldAttribute)
        {
            $this->values->merge([ $fieldAttribute => $model->{$modelAttribute} ]);
        }
    }

    /**
     * A field belongs to a model
     *
     * @return Eloquent\Relationships\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}