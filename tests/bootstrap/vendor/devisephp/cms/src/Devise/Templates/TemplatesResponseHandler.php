<?php namespace Devise\Templates;

use Devise\Support\Framework;

/**
 * Class TemplatesResponseHandler is used to retrieve template data
 *
 * @package Devise\Templates
 */
class TemplatesResponseHandler
{
    protected $TemplatesManager;

    public function __construct(TemplatesManager $TemplatesManager, Framework $Framework)
    {
        $this->TemplatesManager = $TemplatesManager;
        $this->Redirect = $Framework->Redirect;
    }

    /**
     * Executes store template method in TemplatesManager
     * and properly handles the response.
     *
     * @param  array  $input
     * @return Redirect
     */
    public function executeStore($input)
    {
        $input = array_except($input, ['_method', '_token']);

        if($this->TemplatesManager->storeTemplate($input)) {
            return $this->Redirect->route('dvs-templates')
                ->with('message', 'Template registered succesfully');
        }

        return $this->Redirect->route('dvs-templates-register')
            ->withInput()
            ->withErrors($this->TemplatesManager->errors)
            ->with('message', 'There were validation errors');
    }

    /**
     * Executes update template method in TemplatesManager and
     * handles the response accordingly.
     *
     * @param  string  $templatePath  Path to template
     * @param  array  $input
     * @return Redirect
     */
    public function executeUpdate($templatePath, $input)
    {
        $input = array_except($input, ['_method', '_token']);

        if($this->TemplatesManager->updateTemplate($input)) {
            return $this->Redirect->route('dvs-templates')
                ->with('message', 'Template updated succesfully');
        }

        return $this->Redirect->route('dvs-templates-edit', $templatePath)
            ->withErrors($this->TemplatesManager->errors)
            ->with('message', 'There were validation errors');
    }

    /**
     * Executes destroy template method in TemplatesManager
     * and properly handles the response.
     *
     * @param  string  $templatePath
     * @return Redirect
     */
    public function executeDestroy($templatePath)
    {
        if($this->TemplatesManager->destroyTemplate($templatePath)) {
            return $this->Redirect->route('dvs-templates')
                ->with('message', 'Template deleted succesfully');
        }

        return $this->Redirect->route('dvs-templates')
            ->withErrors($this->TemplatesManager->errors)
            ->with('message', 'There were validation errors');
    }

     /**
     * Executes store variable method from TemplatesManager
     *
     * @param  array  $input
     * @return Redirect
     */
    public function executeVariableStore($templatePath, $input)
    {
        $input = array_except($input, ['_method', '_token']);

        if($this->TemplatesManager->storeNewVariable($templatePath, $input)) {
            return $this->Redirect->route('dvs-templates-edit', $templatePath)
                ->with('message', 'Variable succesfully created');
        }

        return $this->Redirect->route('dvs-templates-edit', $templatePath)
            ->withErrors($this->TemplatesManager->errors)
            ->with('message', 'There were validation errors');
    }

}