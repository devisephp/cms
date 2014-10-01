<?php namespace Devise\Pages\Compilers\Types;

use Devise\Pages\Helpers\Nodes;
use Exception;

class FormCompiler extends BaseCompiler {

    private $validFields = array('input','textarea','select');

    public function parse($node, $options)
    {
        $replaceWith = $this->getReplacement($node, $options);

        $node->parentNode->replaceChild($this->dom->createTextNode($replaceWith), $node);
    }

    private function getReplacement($node, $options)
    {
        $attributes = $this->getAttributesString($node, array('data-devise'));
        if(isset($options['selector'])){
            $controllerName = $options['selector'] . 'Controller';

            if(isset($options['property']) && $options['property'] == 'open'){
                $action = $controllerName . '@store';
                $newForm = "{{ Form::open(array('action'=>'$action', " . $attributes . ")) }}";
            } else {
                $action = $controllerName . '@update';
                $varName = '$' . strtolower($options['selector']);
                $newForm = "{{ Form::model($varName, array('action'=>'$action', 'method'=>'put', " . $attributes . ")) }}";
            }
        } else {
            $newForm = "{{ Form::open(array('route'=>'" . $options['name'] . "', " . $attributes . ")) }}";
        }

        $newForm .= $this->sanitize(Nodes::getInnerHtml($node));
        $newForm .= "{{ Form::close() }}";
        return $newForm;
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
            $string = $string;
        }

        return $string;
    }

}