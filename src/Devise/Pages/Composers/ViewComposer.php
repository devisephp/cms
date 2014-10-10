<?php namespace Devise\Pages\Composers;

use Config;
use Route;
use Devise\Pages\Data\DataBuilder;

class ViewComposer
{
    private static $firstView = true;

    private $DataBuilder;
    private $loadedClasses = array();

    /**
    * Create new instance of TemplateComposer
    *
    * @return array
    **/
    public function __construct(DataBuilder $DataBuilder)
    {
        $this->DataBuilder = $DataBuilder;
    }

    /**
    * Injects data from config into the current view
    *
    * @return array
    **/
    public function compose($view)
    {
        // will only run if this is the first view in the stack
        // example: grandchild @extends('child') @extends('layout') 
        // grandchild is the 'first view'

        if(self::$firstView){
            $viewData = $view->getData();
            $viewName = $view->getName();
            $vars = $this->getVars($viewName);
            if(count($vars)){
                $this->DataBuilder->setData($viewData);
                $data = $this->DataBuilder->compile($vars);
                foreach ($data as $varName => $value) {
                    $view->with($varName, $value);
                }
            }
            self::$firstView = false;
        }
    }

    private function getVars($name)
    {
        $vars = Config::get('devise::view-vars')[$name];
        $parent = Config::get('devise::view-extensions.' . $name);

        if($vars || $parent){
            $vars = ($vars) ? $vars : array();
            if($parent){
                $parentVars = Config::get('devise::view-vars.' . $parent);
                return array_merge($vars, $parentVars);
            }
            return $vars;
        }
        return array();
    }
}