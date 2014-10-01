<?php namespace Devise\Pages\Scanners\Items;

use Config;
use Validator;

class BaseItem {

    protected $orderDefaults = array();

    protected $rules = array();

    protected $messages = array();

    protected $typeDefaults = array(
        'color' => array(),
        'date' => array(),
        'image' => array(
            'img' => 'src'
        ),
        'link' => array(
            'a' => 'href'
        ),
        'select' => array(),
        'textarea' => array(),
        'string' => array(),
        'video' => array(
            'video' => 'src'
        ),
        'editor' => array(),
        'route' => array(
            'a' => 'href'
        ),
    );

    protected $tagDefaults = array(
        'input' => 'value'
    );

    public function __construct()
    {
        $this->orderDefaults = Config::get('devise::compiler.type-order');
    }

    protected function getOrderIndex($type)
    {
        $orderIndex = array_search($type, $this->orderDefaults);
        return ($orderIndex !== false) ? $orderIndex : (count($this->orderDefaults) - 1);
    }

    protected function validate(&$settings){
        if($settings){
            $messages = $this->compileSpecificMessages($settings['type']);
            $validation = Validator::make($settings, $this->rules, $messages);
            if($validation->fails()){
                $settings['errors'] = $validation->errors()->all();
            }
        }
    }

    protected function compileSpecificMessages($type)
    {
        $messages = array();
        foreach ($this->messages as $key => $value) {
            $messages[ $key] = $type .' '. $value;
        }
        return $messages;
    }

    protected function getDefaultSelector($settings)
    {
        $typeDefaults = (isset($this->typeDefaults[ $settings['type'] ])) ? $this->typeDefaults[ $settings['type'] ] : array();
        $defaults = array_merge($this->tagDefaults, $typeDefaults);
        
        if(isset($defaults[ $settings['tag'] ])){
            return $defaults[ $settings['tag'] ];
        }

        return $selector;
    }
}