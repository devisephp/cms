<?php namespace Devise\Pages\Fields;

use Devise\Support\ValidationException;
use Illuminate\Support\Facades\Response;

class FieldsResponseHandler
{
    /**
     * FieldManager manages fields
     *
     * @var FieldManager
     */
    private $Manager;

    /**
     * Construct new response handler
     *
     * @param Manager    $Manager
     */
    public function __construct(FieldManager $Manager)
    {
        $this->Manager = $Manager;
    }

    /**
     * Update field, creates a new version of the field
     * this returns json
     *
     * @param  integer $fieldId
     * @param  array   $input
     * @return json
     */
    public function requestUpdate($fieldId, $input)
    {
        try
        {
            $code = 200;
            $response = $this->Manager->updateField($fieldId, $input);
        }
        catch (ValidationException $e)
        {
            $code = 403;
            $response = ['message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * Resets a fields values
     *
     * @param  integer $fieldId
     * @return json
     */
    public function requestReset($fieldId, $scope)
    {
        $field = $this->Manager->resetField($fieldId, $scope);

        return $field;
    }
}