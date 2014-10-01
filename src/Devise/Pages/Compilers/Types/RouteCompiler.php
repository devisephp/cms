<?php namespace Devise\Pages\Compilers\Types;

class RouteCompiler extends BaseCompiler {

    public function parse($node, $options)
    {  
        $replaceWith = $this->getReplacement($node, $options);

        if($options['selector'] == 'content'){
            $node->nodeValue = $replaceWith;
        } else {
            if(is_string($options['selector'])){
                $node->setAttribute($options['selector'], $replaceWith);
            } else {
                $this->updateViaSelector($node, $replaceWith, $options['selector']);
            }
        }
    }

    private function getReplacement($node, $options)
    {
        if(isset($options['params']) && $options['params'] != ''){
            $paramsArr = explode(',', $options['params']);
            $paramsString = "$" . implode(",$", $paramsArr);
            return "{{ URL::route('". $options['name'] ."',array(" . $paramsString . ")) }}";
        } else {
            return "{{ URL::route('". $options['name'] ."') }}";
        }
    }
}