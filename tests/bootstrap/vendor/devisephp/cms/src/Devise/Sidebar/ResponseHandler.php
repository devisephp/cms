<?php namespace Devise\Sidebar;

use Devise\Sidebar\SidebarManager as Manager;
use Illuminate\Support\Facades\Response;
use Devise\Support\DeviseValidationException;


/**
 * Class ResponseHandler is the controller action
 * that handles fetching the sidebar. It is named
 * @package Devise\Sidebar
 */
class ResponseHandler
{
    /**
     * Fetches the sidebar view for us
     *
     * @var SidebarManager
     */
    private $Manager;

    /**
     * Construct new response handler for fetching the sidebar
     * view
     *
     * @param Manager    $Manager
     */
    public function __construct(Manager $Manager)
    {
        $this->Manager = $Manager;
    }

    /**
     * Loads the sidebar menu which houses settings and grid items
     * to be clicked on. Clicking on a grid item will allow us
     * to edit the form for a specific element.
     *
     * @param  array    $input
     * @return Response
     */
    public function requestSidebarPartial($input)
    {
        try {
            $code = 200;
            $view = $this->Manager->fetchPartialView($input['data']);
            $response = [ 'html' => $view ];
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * When we click the element box inside of the sidebar it loads
     * the form for a specific element
     *
     * @param  array    $input
     * @return Response
     */
    public function requestElementPartial($input)
    {
        try {
            $code = 200;
            $view = $this->Manager->fetchElementView($input['data']);
            $response = [ 'html' => $view ];
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * Reloads the entire grid. The grid is where all the elements/collection
     * items reside. We can click on one of these grid items to load the element
     * partial
     *
     * @param  array    $input
     * @return Response
     */
    public function requestElementGridPartial($input)
    {
        try {
            $code = 200;
            $view = $this->Manager->fetchElementGridView($input['data']);
            $response = [ 'html' => $view ];
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * Request that a new model be created
     *
     * @param  array $input
     * @return Response
     */
    public function requestCreateModel($input)
    {
        try {
            $code = 200;
            $response = $this->Manager->createModel($input);
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * Request that a model be updated
     *
     * @param  array $input
     * @return Response
     */
    public function requestUpdateModel($input)
    {
        try {
            $code = 200;
            $response = $this->Manager->updateModel($input);
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }

    /**
     * Request that a group be updated
     *
     * @param  array $input
     * @return Response
     */
    public function requestUpdateGroup($input)
    {
        try {
            $code = 200;
            $response = $this->Manager->updateGroup($input);
        } catch (DeviseValidationException $e) {
            $code = 403;
            $response = [ 'message' => $e->getMessage(), 'errors' => $e->getErrors() ];
        }

        return Response::json($response, $code);
    }
}