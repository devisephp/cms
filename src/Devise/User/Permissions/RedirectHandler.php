<?php namespace Devise\User\Permissions;

use Illuminate\Routing\Redirector as Redirect;
use Exception;

class RedirectHandler {
    protected $Redirect;

    public function __construct(Redirect $Redirect)
    {
        $this->Redirect = $Redirect;
    }

    public function redirect($conditionObject)
    {
        $redirectType = $conditionObject->redirect_type;

        switch($redirectType) {
            case 'page':
            // @todo - Need to insert in the devise pages routing for the redirect
                return '';
                break;

            case 'route':
            case 'to':
            case 'action':
                    return $this->Redirect->$redirectType($conditionObject->redirect)->with('message', $conditionObject->redirect_message);
                break;

            default:
            case 'back':
                try {
                    return $this->Redirect->back()->with('message', $conditionObject->redirect_message);
                } catch(Exception $e) {
                    throw new Exception('Unable to go back due to no referrer.');
                }
            break;
        }
    }
}