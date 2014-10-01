<?php namespace Devise\Pages\Compilers\Types;

use Devise\Pages\Helpers\Nodes;
use Devise\Pages\Parsers\AttributeParser;
use Devise\Support\Files\FileManager;
use Config;
use File;

class BaseCompiler {
    public $dom;
    public $xpath;

    protected $AttributeParser;
    protected $FileManager;
    protected $pregReplacements = array(
        '/%7B%7B%20/' => '{{ ',
        '/%24/' =>  '$',
        '/-&gt;/' =>  '->',
        '/%20%7D%7D/' =>  ' }}',
        '/{&quot;/' =>  '{"',
        '/&quot;:&quot;/' =>  '":"',
        '/&quot;}/' =>  '"}',
        '/&lt;/' =>  '<',
        '/&gt;/' =>  '>',
        '/\/&gt;/' =>  '/>',
        '/=&amp;gt;/' => '=>',
        '/=&gt;/' => '=>'
    );

    public function __construct(AttributeParser $AttributeParser, FileManager $FileManager)
    {
        $this->AttributeParser = $AttributeParser;
        $this->FileManager = $FileManager;
    }

    protected function sanitize($html)
    {
        foreach ($this->pregReplacements as $pattern => $replacement) {
            $html = preg_replace($pattern, $replacement, $html);
        }
        return $html;
    }

    protected function addBladeYields($xpath, $dom, $parentAttrValue = '')
    {
        foreach ($xpath->query("//*[starts-with(@data-devise, 'section')]") as $node) {
            $attrValue = $node->getAttribute('data-devise');
            if($attrValue != $parentAttrValue){
                $settings = $this->AttributeParser->parse($attrValue);
                Nodes::replaceWithBladeYield($node, $dom, $settings['name']);
            }
        }
    }

    protected function addBladeIncludes($xpath, $dom, $parentAttrValue = '')
    {
        foreach ($xpath->query("//*[starts-with(@data-devise, 'include')]") as $node) {
            $attrValue = $node->getAttribute('data-devise');
            if($attrValue != $parentAttrValue){
                $settings = $this->AttributeParser->parse($attrValue);
                Nodes::replaceWithBladeInclude($node, $dom, $settings['name']);
            }
        }
    }

    protected function cleanDeviseAttributes($xpath, $dom)
    {
        foreach ($xpath->query("//*[@*[starts-with(name(), 'data-devise')]]") as $node) {
            $queue = array();
            foreach ($node->attributes as $name => $attrNode) {
                if(strpos($name, 'data-devise') !== false){
                    $queue[] = $name;
                }
                if($name == 'id' && strpos($attrNode->value, 'dvs-') !== false){
                    $queue[] = $name;
                }
            }

            foreach ($queue as $attr) {
                $node->removeAttribute($attr);
            }
        }
    }

    protected function updateViaSelector($node, $replaceWith, $params)
    {
        if($params[0] == 'style'){
            Nodes::replaceStyle($node, $replaceWith, $params);
        } else {
            Nodes::replaceData($node, $replaceWith, $params);
        }
    }
}