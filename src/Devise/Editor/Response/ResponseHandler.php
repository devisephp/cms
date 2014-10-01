<?php namespace Devise\Editor\Response;

use Devise\Common\ValidationException;
use Devise\Editor\EditorManager as Manager;
use Illuminate\Support\Facades\Response;

class ResponseHandler
{
   private $Manager;

    /**
     * Construct new response handler
     * @param Manager    $Manager
     */
    public function __construct(Manager $Manager)
    {
        $this->Manager = $Manager;
    }

    /**
     * Create a new menu then redirect to edit page
     *
     * @param  array $input
     * @return Redirect
     */
    public function requestPartial($input)
    {
        try {
            $code = 200;
        	$view = $this->Manager->fetchPartialView($input['data']);
            $response = [ 'html' => $view ];
        } catch (ValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }
}
