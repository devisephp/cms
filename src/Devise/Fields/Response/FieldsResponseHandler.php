<?php namespace Devise\Fields\Response;

use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Response;
use Devise\Fields\FieldManager as Manager;
use Devise\Common\ValidationException;

class FieldsResponseHandler
{
    private $Manager;

    /**
     * Construct new response handler
     * @param Redirector $Redirect
     * @param Response   $Response
     * @param Manager    $Manager
     */
    public function __construct(Manager $Manager)
    {
        $this->Manager = $Manager;
    }

    /**
     * Update field, creates a new version of the field
     * this returns json
     *
     * @param  integer $fieldId
     * @param  array $input
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
}