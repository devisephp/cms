<?php namespace Devise\Collections;

use CollectionInstance;
use FieldVersion;
use Field;

class CollectionInstanceManager
{
    private $CollectionInstance;
	private $FieldVersion;

	public function __construct(CollectionInstance $CollectionInstance, FieldVersion $FieldVersion)
	{
        $this->CollectionInstance = $CollectionInstance;
		$this->FieldVersion = $FieldVersion;
	}

    public function duplicateInstancesForPage($fromPageId, $toPageId)
    {
        $instances = $this->CollectionInstance
                        ->where('page_id', $fromPageId)
                        ->get();

        foreach ($instances as $oldInstance) {

            $instance = $this->CollectionInstance->create(array(
                'collection_set_id' => $oldInstance->collection_set_id,
                'page_id' => $toPageId,
                'name' => $oldInstance->name,
                'sort' => $oldInstance->sort
            ));

            $newFields = Field::where('collection_set_id', '=', $oldInstance->collection_set_id)
                        ->where('page_id','=',$toPageId)
                        ->get();

            foreach ($newFields as $newField) {
                $oldField = Field::with(array('latestPublishedVersion' => function($query) use ($oldInstance){
                            $query->where('collection_instance_id','=',$oldInstance->id);
                        }))
                        ->where('collection_set_id', '=', $oldInstance->collection_set_id)
                        ->where('page_id','=',$fromPageId)
                        ->where('key',$newField->key)
                        ->first();
                if($oldField->latestPublishedVersion){
                    $newFieldVersion = $this->FieldVersion->create(array(
                        'collection_instance_id' => $instance->id,
                        'field_id' => $newField->id,
                        'stage' => 'published',
                        'value' => $oldField->latestPublishedVersion->value,
                        'published_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ));
                }
            }
        }
    }
}