<?php namespace Devise\Pages\Scanners\Items;

use Devise\Pages\Helpers\Nodes;
use Devise\Pages\Helpers\Strings;
use Devise\Pages\Repositories\FieldsRepository;
use Devise\Pages\Parsers\AttributeParser;
use Config;
use File;

class DeviseItem extends BaseItem{

    protected $rules = array(
        'name' => 'required',
        'type' => 'required',
        'parent' => 'required',
        'tag' => 'required',
        'order' => 'required|min:0',
        'field-type' => 'required_if:type,field',
        'key' => 'required_if:type,field',
        'selector' => 'required_if:type,field'
    );

    protected $typeDefaults = array(
        'color' => array(),
        'date' => array(),
        'image' => array(
            'img' => 'src'
        ),
        'link' => array(
            'a' => 'href'
        ),
        'select' => array(),
        'textarea' => array(),
        'string' => array(),
        'video' => array(
            'video' => 'src'
        ),
        'editor' => array(),
        'route' => array(
            'a' => 'href'
        ),
    );

    protected $tagDefaults = array(
        'input' => 'value'
    );

    protected $messages = array(
        'required' => ':attribute could not be found.',
    );

    protected $FieldsRepository;

    protected $AttributeParser;

    public function __construct(FieldsRepository $FieldsRepository, AttributeParser $AttributeParser)
    {
        $this->FieldsRepository = $FieldsRepository;
        $this->AttributeParser = $AttributeParser;
        parent::__construct();
    }

    public function create($attributeName, $node)
    {
        $settings = array();
        $settings['tag'] = $node->tagName;
        $settings['id'] = $node->getAttribute('id');
        $settings['parent'] = Nodes::findParentTemplateName($node);
        $settings = array_merge($settings, $this->AttributeParser->parse($node->getAttribute($attributeName)));
        $this->addTypeDefaults($settings);
        $settings['order'] = $this->getOrderIndex($settings['type']);

        $this->validate($settings);
        
        return $settings;
    }

    private function addTypeDefaults(&$settings)
    {
        if($settings['type'] == 'field' || $settings['type'] == 'data' || $settings['type'] == 'route'){
            if(!isset($settings['selector'])){
                $settings['selector'] = $this->genSelectorWithDefault($settings);
            }
        }

        if($settings['type'] == 'field'){
            $settings['key'] = Strings::fromHuman($settings['name']);
            $settings['template'] = $settings['parent'];

            if($field = $this->FieldsRepository->retrieveForScanner($settings['parent'], $settings['key'])){
                $settings['db-id'] = $field->id;
                $settings['template'] = $field->template;
            }
        }

        if($settings['type'] == 'include'){
            $viewPaths = Config::get('view.paths');
            $path = $settings['name'];
            $bladePath = $viewPaths[0] . '/' . str_replace('.', '/', $path);
            $settings['existing'] = File::exists($bladePath . '.blade.php');
        }
    }

    private function genSelectorWithDefault($settings)
    {
        $type = (isset($settings['field-type'])) ? $settings['field-type'] : $settings['type'];
        $typeDefaults = (isset($this->typeDefaults[ $type ])) ? $this->typeDefaults[ $type ] : array();
        $defaults = array_merge($this->tagDefaults, $typeDefaults);
        
        if(isset($defaults[ $settings['tag'] ])){
            return $defaults[ $settings['tag'] ];
        }

        return 'content';
    }
}