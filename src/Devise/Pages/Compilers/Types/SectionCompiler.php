<?php namespace Devise\Pages\Compilers\Types;

use Config;
use Devise\Pages\Helpers\Nodes;
use DomXpath;
use HTML5;

class SectionCompiler extends BaseCompiler {
    private $templateSaveHistory = array();

    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function parse($node, $options)
    {
        $path = (isset($options['path'])) ? $options['path'] : $options['name'];
        $skipList = (Config::get('devise::skip.template')) ? Config::get('devise::skip.template') : array();
        if(!in_array($path, $skipList)) {
            $dom = \HTML5::loadHTML($this->dom->saveHtml($node));
            $xpath = new DomXpath($dom);
            
            $this->addBladeYields($xpath, $dom, $node->getAttribute('data-devise'));
            $this->addBladeIncludes($xpath, $dom, $node->getAttribute('data-devise'));
            $this->cleanDeviseAttributes($xpath, $dom);

            $dom->removeChild($dom->firstChild);
            $templateNode = $dom->firstChild->firstChild;
        
            $html = "\n@section('" . $options['name'] . "')\n" . $this->sanitize( $dom->saveHtml($templateNode) ) . "\n@stop\n";

            if(in_array($path, $this->templateSaveHistory)){
                // add to template if path is history
                $this->FileManager->saveViewFile($path, $html, true);
            } else {
                // create temlate if path is not in history
                $html = "@extends('". $options['parent'] ."')\n\n" . $html;
                $this->FileManager->saveViewFile($path, $html);
            }

            $this->templateSaveHistory[] = $path;
        }
    }
}