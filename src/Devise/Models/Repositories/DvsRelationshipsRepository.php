<?php namespace Devise\Models\Repositories;

use Illuminate\Config\Repository as Config;
use DvsRelationship;

class DvsRelationshipsRepository {

    private $DvsRelationship;

    function __construct(DvsRelationship $DvsRelationship, Config $Config)
    {
        $this->DvsRelationship = $Config->get('devise::relationships');
    }

    function lists($field1, $field2)
    {
        $list = array();
        foreach($this->DvsRelationship as $relationship) {
            $list[$relationship->$field1] = $relationship->$field2;
        }

        return $list;
    }

    function aliasKeys()
    {
        return $this->DvsRelationship;
    }
}