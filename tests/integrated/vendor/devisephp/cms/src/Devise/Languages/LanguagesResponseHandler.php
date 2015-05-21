<?php namespace Devise\Languages;

use Illuminate\Routing\Redirector;
use Devise\Languages\LanguagesManager as Manager;

/**
 * Handles responses for language routes. This class
 * is likely used as a response_path to a dvs_page
 * field.
 */
class LanguagesResponseHandler
{
    /**
     * [$Redirect description]
     * @var [type]
     */
    private $Redirect;

    /**
     * [$Manager description]
     * @var [type]
     */
    private $Manager;

    /**
     * Construct new response handler
     *
     * @param Redirector $Redirect
     * @param Response   $Response
     * @param Manager    $Manager
     */
    public function __construct(Redirector $Redirect, Manager $Manager)
    {
        $this->Manager = $Manager;
        $this->Redirect = $Redirect;
    }

    /**
     * Patch a language's active flag
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirect
     */
    public function requestPatchLanguage($id, $input)
    {
        $this->Manager->modifyActiveFlag($id, $input['active']);
        return '';
    }
}