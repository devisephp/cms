<?php namespace Devise\Sidebar;

use Mockery as m;

class SidebarDataTranslatorTest extends \DeviseTestCase
{
    public function test_it_translates_array_into_sidebar_data_object()
    {
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $FieldManager->shouldReceive('findOrCreateField')->times(9)->andReturnSelf();
        $CollectionSet = new \DvsCollectionSet;
        $CollectionsRepository = m::mock('Devise\Pages\Collections\CollectionsRepository');
        $SidebarDataTranslator = new SidebarDataTranslator($FieldManager, $CollectionSet, $CollectionsRepository);

        $data = [
            'page_id' => 1,
            'page_version_id' => 1,
       		"coordinates" => [ "top" => 647, "left" => "101.5" ],
            "categoryName" => "Headings",
            "categoryCount" => 3,
            "groups" => [
                "Heading 1" => [
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                ],
                "Heading 2" => [
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                ],
                "Heading 3" => [
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                    [ "key" => "title", "type" => "text", "humanName" => "Title", 'index' => 1, 'alternateTarget' => '' ],
                ],
            ],
        ];

        $SidebarDataTranslator->translateFromInputArray($data);
    }
}