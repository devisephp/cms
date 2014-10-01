<?php

use Devise\Pages\Repositories\TemplatesRepository;
use Devise\Pages\Scanners\DomScanner;
use Devise\Pages\Compilers\CompilerEngine;
use \View;

class DeviseTemplateController extends Controller {
    protected $TemplatesRepository;
    protected $DomScanner;

    /**
     * Creates a new DeviseTemplateController instance.
     *
     * @param  TemplatesRepository  $TemplatesRepository
     * @param  DomScanner  $DomScanner
     * @param  CompilerEngine  $CompilerEngine
     */
    public function __construct(TemplatesRepository $TemplatesRepository, DomScanner $DomScanner, CompilerEngine $CompilerEngine)
    {
        $this->TemplatesRepository = $TemplatesRepository;
        $this->DomScanner = $DomScanner;
        $this->CompilerEngine = $CompilerEngine;
    }

	/**
	 * Displays a list of templates
	 *
	 * @return Response
	 */
	public function index()
	{
        $templates = $this->TemplatesRepository->lists();
        return View::make(
            Config::get('devise::pages.views.templates.index'),
            compact('templates')
        );
	}

    /**
     * Displays an edit form for a template
     *
     * @return Response
     */
    public function upload()
    {
        return View::make(
            Config::get('devise::pages.views.templates.upload')
        );
    }

    /**
     * Displays a review form for the user to complete the import process
     *
     * @return Response
     */
    public function review()
    {
        if(Input::file('file') || Input::has('view')){
            if(Input::has('file')){
                $html = File::get(Input::file('file')->getRealPath());
            }
            if(Input::has('view')){
                $html = View::make(Input::get('view'))->render();
            }
            $items = $this->DomScanner->scan($html);
            
            if($items){
                return View::make(
                    Config::get('devise::pages.views.templates.review'),
                    compact('items', 'warnings')
                );
                
            } else {
                return Redirect::route('dvs_template_upload')
                    ->withInput()
                    ->withErrors($this->DomScanner->errors)
                    ->with('message', $this->DomScanner->message);
            }
        } else {
            return Redirect::route('dvs_template_upload')
                ->withInput()
                ->with('message', 'No html found.');
        }
    }

    /**
     * Saves the new template
     *
     * @return Response
     */
    public function store()
    {
        if($this->CompilerEngine->compile(Input::get('settings'))){

            return Redirect::route('dvs_template_index')->with('message-success', 'Templates Saved');

        } else {
            return Redirect::route('dvs_template_upload')
                ->withInput()
                ->with('message', $this->CompilerEngine->message);
        }
    }
}