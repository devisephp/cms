<?php namespace Devise\Pages\Compilers;

use Config;
use DomXpath;
use Exception;
use Event;
use HTML5;
use Session;
class CompilerEngine {
    public $message;

    private $deviseItems;
    private $html;
    private $dom;
    private $xpath;
    private $compilers;

    public function __construct($compilers)
    {
        $this->compilers = $compilers;
        $this->setDeviseData();
    }

    public function compile($userSettings = array())
    {
        if($this->deviseItems){
            Event::fire('compiler.engine.begin');
            $this->deviseItems = array_reverse($this->mergeSettings($userSettings));
            
            $this->dom = HTML5::loadHTML($this->html);
            $this->xpath = new DomXpath($this->dom);

            $this->compileItems();

            $this->forgetDeviseData();

            return true;
        } else {
            $this->message = 'No devise items found.';
            return false;   
        }
    }

    private function setDeviseData()
    {
        if(Session::get( 'deviseItems')){
            $this->deviseItems = Session::get( 'deviseItems');
            $this->html = Session::get( 'templateHtml' );
        }
    }

    private function forgetDeviseData()
    {
        if(Session::get( 'deviseItems')){
            Session::forget( 'deviseItems' );
            Session::forget( 'templateHtml' );
        }
    }

    private function compileItems()
    {
        foreach ($this->deviseItems as $item) {
            Event::fire('pages.' . $item['type'] . '.parsing', array($item));
            if(isset($item['id']) && $node = $this->xpath->query("//*[@id=\"" . $item['id'] . "\"]")->item(0)){
                $this->compileItem($item, $node);
            }
            Event::fire('pages.' . $item['type'] . '.parsed', array($item));
        }
    }

    private function compileItem($item, $node)
    {
        if(isset($this->compilers[ $item['type'] ])){
            $compiler = $this->compilers[ $item['type'] ];
            $compiler->dom = $this->dom;
            $compiler->xpath = $this->xpath;
            $compiler->parse($node, $item);
        }
    }

    private function mergeSettings($userSettings)
    {
        $merged = array();
        foreach ($this->deviseItems as $index => $settings) {
            if(isset($userSettings[ $index ])){
                $settings = array_merge($settings, $userSettings[ $index ]);
            }
            $merged[] = $settings;
        }
        return $merged;
    }
}