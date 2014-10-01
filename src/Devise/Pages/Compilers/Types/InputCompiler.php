<?php namespace Devise\Pages\Compilers\Types;

use Devise\Pages\Exceptions\PagesException;
use Devise\Pages\Helpers\Nodes;

class InputCompiler extends BaseCompiler {

    private $validFields = array('input','textarea','select');

    public function parse($node, $options)
    {
        $replaceWith = $this->getReplacement($node, $options);
        $node->parentNode->replaceChild($this->dom->createTextNode($replaceWith), $node);
    }
    
    private function getReplacement($node, $options)
    {
        if($options['name'] != 'submit'){
            $type = ucfirst($node->getAttribute('type'));
            $tagName = ucfirst($node->tagName);
            $functionName = 'get' . $type . $tagName;

            if(method_exists($this, $functionName)){
                return $this->$functionName($options['name'], $node);

            } else {
                throw new PagesException('Unable to parse ' . $node->tagName . ' with name ' . $options['name']);
            }
        } else {
            $value = str_replace("'", "\'", $node->getAttribute('value'));
            return $this->getSubmit($value, $node);
        }
    }

    private function getTextInput($name, $node){
        $attributes = $this->getAttributesString($node, array('name','value','type'));
        $value = ($node->hasAttribute('value')) ? ", '" . str_replace("'", "\'", $node->getAttribute('value')) . "'" : ', null';
        return "{{ Form::text('" . $name . "'" . $value . "" . $attributes . "); }}";
    }

    private function getHiddenInput($name, $node){
        $attributes = $this->getAttributesString($node, array('name','value','type'));
        $value = ($node->hasAttribute('value')) ? ", '" . str_replace("'", "\'", $node->getAttribute('value')) . "'" : ', null';
        return "{{ Form::hidden('" . $name . "'" . $value . "" . $attributes . "); }}";
    }

    private function getRadioInput($name, $node){
        $attributes = $this->getAttributesString($node, array('name','value','type'));
        $value = ($node->hasAttribute('value')) ? ", '" . str_replace("'", "\'", $node->getAttribute('value')) . "'" : ', null';
        $checked = ($node->hasAttribute('checked')) ? ", true" : ', false';
        return "{{ Form::radio('" . $name . "'" . $value . "" . $checked . "" . $attributes . "); }}";
    }


    private function getCheckboxInput($name, $node){
        $attributes = $this->getAttributesString($node, array('name','value','type'));
        $value = ($node->hasAttribute('value')) ? ", '" . str_replace("'", "\'", $node->getAttribute('value')) . "'" : ', null';
        $checked = ($node->hasAttribute('checked')) ? ", true" : ', false';
        return "{{ Form::checkbox('" . $name . "'" . $value . "" . $checked . "" . $attributes . "); }}";
    }

    private function getTextArea($name, $node){
        $attributes = $this->getAttributesString($node, array('name','value','type'));
        $value = ",'" . str_replace(array("\r\n", "\r", "\n"), '\n', $node->textContent) . "'";
        return "{{ Form::textarea('" . $name . "'" . $value . "" . $attributes . "); }}";
    }

    private function getSelect($name, $node){
        $options = $this->getSelectOptionsString($node);
        return "{{ Form::select('" . $name . "'" . $options . "); }}";
    }

    private function getSubmit($value, $node){
        $attributes = $this->getAttributesString($node, array('type','value'));
        return "{{ Form::submit('" . $value . "'" . $attributes . "); }}";
    }

    private function getAttributesString($node, $ignore = array())
    {
        $string = "";
        foreach ($node->attributes as $name => $attrNode) {
            if(!in_array($name, $ignore)){
                if($string != ""){
                    $string .= ", ";
                }
                $string .= "'". $name ."'=>'". $attrNode->value ."'";
            }
        }

        if($string != ""){
            $string = ", array(" . $string .")";
        }

        return $string;
    }

    private function getSelectOptionsString($node)
    {
        $string = "";
        foreach ($this->xpath->query("//option", $node) as $node) {
            if($string != ""){
                $string .= ", ";
            }
            $value = str_replace("'", "\'", $node->getAttribute('value'));
            $string .= "'" . $value . "'=>'". $node->textContent ."'";
        }

        if($string != ""){
            $string = ", array(" . $string .")";
        }

        return $string;
    }
}