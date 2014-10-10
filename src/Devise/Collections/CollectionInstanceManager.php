<?php namespace Devise\Collections;

use CollectionInstance;

class CollectionInstanceManager
{
    private $CollectionInstance;

	public function __construct(CollectionInstance $CollectionInstance)
	{
        $this->CollectionInstance = $CollectionInstance;
	}
}