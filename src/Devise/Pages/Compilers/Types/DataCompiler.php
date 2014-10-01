<?php namespace Devise\Pages\Compilers\Types;

class DataCompiler extends BaseCompiler {

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
        return '{{ $' . str_replace('.', '->', $options['name']) . ' }}';
    }
}