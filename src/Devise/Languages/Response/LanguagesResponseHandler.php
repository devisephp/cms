<?php namespace Devise\Languages\Response;

use Illuminate\Routing\Redirector;
use Devise\Languages\LanguagesManager as Manager;

class LanguagesResponseHandler
{
    private $Redirect, $Manager;

    /**
     * Construct new response handler
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
     * Update a language
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirect
     */
    public function requestPatchLanguage($id, $input)
    {
        $this->Manager->patchLanguage($id, $input);
        return '';
    }
}