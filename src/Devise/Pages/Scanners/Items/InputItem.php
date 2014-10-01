<?php namespace Devise\Pages\Scanners\Items;
use Config;
use Devise\Pages\Helpers\Nodes;

class InputItem extends BaseItem{

    protected $rules = array(
        'name' => 'required',
        'type' => 'required',
        'parent' => 'required',
        'tag' => 'required',
        'order' => 'required|min:0',
    );

    protected $messages = array(
        'required' => ':attribute could not be found in.',
    );
    
    public function create($node)
    {
        $name = $this->getName($node);

        $newItem = array(
            'name' => $name,
            'id' => $node->getAttribute('id'),
            'type' => 'input',
            'order' => $this->getOrderIndex('input'),
            'parent' => Nodes::findParentTemplateName($node),
            'tag' => $node->tagName
        );

        if($name == ''){
            dd($newItem);
        }

        $this->validate($newItem);
        return $newItem;
    }

    private function getName($node)
    {
        if($node->hasAttribute('name')) return $node->getAttribute('name');
        if($node->hasAttribute('type')) return $node->getAttribute('type');
        return $node->tagName;
    }
}