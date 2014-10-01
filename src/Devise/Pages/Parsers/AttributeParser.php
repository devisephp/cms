<?php namespace Devise\Pages\Parsers;

use Config;

class AttributeParser {
    /*
    * testing tag version.  this should not end up in the production project
    */
    private $fieldTypes = array();
    private $settings = array();
    public function __construct()
    {
        $this->fieldTypes = Config::get('devise::compiler.field-types');
    }

    public function parse($value)
    {
        $this->settings = array();
        $parts = explode('|', $value);
        foreach ($parts as $index => $part) {
            switch ($index) {
                case 0:
                    $this->parseTypeOptions($part);
                break;
                case 1:
                    $this->parseNameOptions($part);
                break;
                case 2:
                    $this->parseSelectorOptions($part);
                break;
                default:
                    $this->parseKeyValOptions($part);
                break;
            }
        }
        
        return $this->settings;
    }

    private function parseTypeOptions($options)
    {
        $this->settings['type'] = (in_array($options, $this->fieldTypes)) ? 'field' : $options;
        if($this->settings['type'] == 'field'){
            $this->settings['field-type'] = $options;
        }
    }

    private function parseNameOptions($options)
    {
        if(strpos($options, ':')){
            list($name, $path) = explode(':', $options);
            $this->settings['path'] = $path;
            $this->settings['name'] = $name;
        } else {
            $this->settings['name'] = $options;
        }
    }

    private function parseSelectorOptions($options)
    {
        if(strpos($options, ':')){
            list($selector, $property) = explode(':', $options);
            if($selector != 'group'){
                $this->settings['selector'] = $selector;
                $this->settings['property'] = $property;
            } else {
                $this->parseKeyValOptions($options);
            }
        } else {
            $this->settings['selector'] = $options;
        }
    }
    private function parseKeyValOptions($options)
    {
        list($key, $value) = explode(':', $options);
        $this->settings[ $key ] = $value;
    }
}