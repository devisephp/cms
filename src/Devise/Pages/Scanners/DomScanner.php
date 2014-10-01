<?php namespace Devise\Pages\Scanners;

use Devise\Pages\Scanners\Items\DeviseItem;
use Devise\Pages\Scanners\Items\InferredItem;
use Devise\Pages\Scanners\Items\InputItem;
use Devise\Support\Files\FileManager;
use DomXpath;
use HTML5;
use Session;

class DomScanner {
    public $errors = array();
    public $message = '';
    /**
     * instance of php Domelement
     * @var $errors
     */
    private $dom = array();
    private $deviseItems;
    private $DeviseItem;
    private $InferredItem;
    private $FileManager;
    private $InputItem;

    private $inferredItemTypes = array(
        'data',
        'section',
        'layout'
    );

    /**
     * instance of php xpath
     * @var $errors
     */
    private $xpath = array();
    

    public function __construct(DeviseItem $DeviseItem, InferredItem $InferredItem, InputItem $InputItem, FileManager $FileManager)
    {
        $this->DeviseItem = $DeviseItem;
        $this->InferredItem = $InferredItem;
        $this->InputItem = $InputItem;
        $this->FileManager = $FileManager;
    }

    /**
     * Assumes validation has happened and html will parse
     * @param string $html
     * @return bool
     */
    public function scan($html)
    {
        $this->dom = HTML5::loadHTML($html);
        $this->xpath = new DomXpath($this->dom);

        $this->findAll();
        $this->checkPaths();
        
        return $this->respond();
    }

    private function checkPaths()
    {
        $this->FileManager->validatePaths($this->deviseItems);
        $this->errors = array_merge($this->errors, $this->FileManager->errors);
    }

    private function respond()
    {
        if(count($this->errors)){
            $this->message = 'Errors';
            return false;   
        } else {
            usort($this->deviseItems, array($this, 'sortByOrder'));
            $this->storeResults();
            return $this->deviseItems;
        }
    }

    private function storeResults()
    {
        Session::put('deviseItems', $this->deviseItems);
        Session::put('templateHtml', $this->dom->saveHtml());
    }

    private function sortByOrder($a, $b) {
        return strcasecmp($a['order'], $b['order']);
    }

    private function findAll()
    {
        $this->searchForDataDeviseAttributes();
        $this->serachForInputs();
    }

    private function searchForDataDeviseAttributes()
    {
        // looking for 'data-devise' attributes
        foreach ($this->xpath->query("//*[@*[starts-with(name(), 'data-devise')]]") as $node) {
            $this->setNodeId($node);
            $this->findAttributes($node);
        }
    }

    private function serachForInputs()
    {
        // looking for form inputs
        foreach ($this->xpath->query("//*[local-name()='input' or local-name()='textarea' or local-name()='select']") as $node) {
            $this->setNodeId($node);
            $this->saveItem($this->InputItem->create($node));
        }
    }

    private function findAttributes($node)
    {
        foreach ($node->attributes as $name => $attrNode) {
            if(strpos($name, 'data-devise') !== false){
                $this->saveDeviseItem($name, $node);
            }
        }
    }

    private function saveDeviseItem($attributeName, $node)
    {
        $settings = $this->DeviseItem->create($attributeName, $node);
        $this->saveItem($settings);

        $this->checkForInferred($settings);
    }

    private function checkForInferred($settings)
    {
        if(in_array($settings['type'], $this->inferredItemTypes)){
            $this->saveItem($this->InferredItem->create($settings));
        }
    }

    private function saveItem($settings)
    {
        if($settings != null){
            if(isset($settings['errors'])){
                $this->errors = array_merge($this->errors, $settings['errors']);
            }
            $this->deviseItems[] = $settings;
        }
    }

    private function setNodeId($node)
    {
        if(!$node->hasAttribute('id')){
            $id = 'dvs-' .  (count($this->deviseItems) + 1);
            $node->setAttribute('id', $id);
        }
    }
}