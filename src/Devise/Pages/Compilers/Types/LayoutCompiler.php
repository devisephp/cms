<?php namespace Devise\Pages\Compilers\Types;

use Config;
use Devise\Pages\Helpers\Nodes;
use DomXpath;
use HTML5;

class LayoutCompiler extends BaseCompiler {
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
            $this->addBladeYields($this->xpath, $this->dom);
            $this->addBladeIncludes($this->xpath, $this->dom);
            $this->cleanDeviseAttributes($this->xpath, $this->dom);
            $html = $this->sanitize($this->dom->saveHtml());
            
            $this->FileManager->saveViewFile($path, $html);
        }
    }
}