<?php namespace Devise\Pages\Scanners\Items;

use Config;
use Devise\Pages\Exceptions\PagesException;

class InferredItem extends BaseItem{

    protected $rules = array(
        'type' => 'required',
        'parent' => 'required',
        'order' => 'required|min:0',
    );

    protected $messages = array(
        'required' => ':attribute could not be found.',
    );
    
    private $templateHistory = array();
    private $variableHistory = array();
    public function create($settings)
    {
        $functionName = 'create' . strtoupper($settings['type']);

        if(method_exists($this, $functionName)){
            $newItem = $this->$functionName($settings);
            $this->validate($newItem);
            return $newItem;
        } else {
            throw new PagesException('Unable to create InferredItem for ' . $settings['type']);
        }
    }

    private function createData($settings)
    {
        list($variablename) = explode('.', $settings['name']);
        if(!in_array($variablename, $this->variableHistory)){
            $this->variableHistory[] = $variablename;
            $existingVariable = Config::get('devise::templates.' . $settings['parent'] . '.vars.' . $variablename);
            $newItem = array(
                'name' => $variablename,
                'existing' => ($existingVariable != null),
                'type' => 'variable',
                'order' => $this->getOrderIndex('variable'),
                'parent' => $settings['parent'],
                'class' => '',
                'function' => '',
                'params' => ''
            );

            if($existingVariable){
                if(is_string($existingVariable)){
                    list($class,$function) = explode('.', $existingVariable);
                    $newItem['class'] = $class;
                    $newItem['function'] = $function;
                } else {
                    list($class,$function) = explode('.', key($existingVariable));
                    $newItem['class'] = $class;
                    $newItem['function'] = $function;
                    $newItem['params'] = implode(',', reset($existingVariable));
                }
            }
            
            return $newItem;
        }
    }

    public function createSection($settings)
    {
        return $this->createTemplate($settings);
    }

    public function createLayout($settings)
    {
        return $this->createTemplate($settings);
    }

    private function createTemplate($settings)
    {
        $path = (isset($settings['path'])) ? $settings['path'] : $settings['name'];
        if(!in_array($path, $this->templateHistory)){
            $this->templateHistory[] = $path;
            return array(
                'path' => $path,
                'existing' => (in_array($path, Config::get('devise::views'))),
                'type' => 'template',
                'order' => $this->getOrderIndex('template'),
                'parent' => $settings['parent']
            );
        }
    }
}