<?php namespace Devise\Pages\Compilers\Types;

use DomXpath;
use HTML5;
use Devise\Pages\Helpers\Nodes;

class IncludeCompiler extends BaseCompiler {

    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function parse($node, $options)
    {
        if(!$options['existing'] || isset($options['overwrite'])){
            $dom = \HTML5::loadHTML($this->dom->saveHtml($node));
            $xpath = new DomXpath($dom);
            $this->addBladeYields($xpath, $dom, $node->getAttribute('data-devise'));
            $this->addBladeIncludes($xpath, $dom, $node->getAttribute('data-devise'));
            $this->cleanDeviseAttributes($xpath, $dom);
            $dom->removeChild($dom->firstChild);
            $templateNode = $dom->firstChild->firstChild;
            $html = $this->sanitize( $dom->saveHtml($templateNode) );
            $this->FileManager->saveViewFile($options['name'], $html);
        }
    }
}