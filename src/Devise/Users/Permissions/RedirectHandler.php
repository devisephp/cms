<?php namespace Devise\Users\Permissions;

use Devise\Support\Framework;

/**
 * Class RedirectHandler handles redirecting
 * @package Devise\Users\Permissions
 */
class RedirectHandler
{
    /**
     * @var \Illuminate\Routing\Redirector
     */
    protected $Redirect;

    /**
     * Construct a new redirector
     *
     * @param Framework $Framework
     */
    public function __construct(Framework $Framework)
    {
        $this->Redirect = $Framework->Redirect;
    }

    /**
     * The redirect handles redirecting appropriately based on the
     * condition object passed in. The condition object is a json like
     * stdClass object that mimics the arrays inside of config/permissions-conditions
     *
     * @param $conditionObject
     * @throws \Devise\Support\DeviseException
     */
    public function redirect($conditionObject)
    {
        $redirectType = $conditionObject->redirect_type;
        $redirectMessage = isset($conditionObject->redirect_message) ? $conditionObject->redirect_message : '';

        switch ($redirectType)
        {
            case 'route':
            case 'to':
            case 'action':
                    return $this->Redirect->$redirectType($conditionObject->redirect)->with('message-errors', $redirectMessage);
            break;

            default:
            case 'back':
                try
                {
                    return $this->Redirect->back()->with('message-errors', $redirectMessage);
                }
                catch(\Exception $e)
                {
                    throw new \Devise\Support\DeviseException('Unable to go back due to no referrer.');
                }
            break;
        }
    }
}