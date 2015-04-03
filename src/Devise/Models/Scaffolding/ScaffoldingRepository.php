<?php namespace Devise\Models\Scaffolding;

class ScaffoldingRepository
{

    /**
     * Gets a list of field types for models
     *
     * @return array
     */
    public function getModelFieldTypesList()
    {
        return array(
            'increments' => 'Auto-Increment',
            'boolean' => 'Boolean',
            'date' => 'Date',
            'datetime' => 'Datetime',
            'datetime' => 'Datetime',
            'integer' => 'Integer',
            'string' => 'String',
            'text' => 'Text',
        );
    }

    /**
     * Gets a list of form types
     *
     * @return array
     */
	public function getModelFormTypesList()
    {
        return array(
            'checkbox' => 'Checkbox Group',
            'radio' => 'Radio Group',
            'select' => 'Select',
            'text' => 'Text',
            'textarea' => 'Textarea',
        );
    }
}