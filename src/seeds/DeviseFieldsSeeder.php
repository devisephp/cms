<?php

class DeviseFieldsSeeder extends Seeder
{

    public function run()
    {
        DB::table('dvs_fields')->delete();

        $data = array(
            array(
                'id'                        => 1,
                'page_version_id'           => 1,
                'collection_instance_id'    => null,
                'type' 				        => 'text',
                'human_name'                => 'Good-Bye',
                'key'                       => 'hello',
                'json_value'                => '{}',
            ),
            array(
                'id'                        => 2,
                'collection_instance_id'    => null,
                'page_version_id'           => 1,
                'type'                      => 'textarea',
                'human_name'                => 'Good-Bye',
                'key'                       => 'goodbye',
                'json_value'                => '{}',
            ),
            array(
                'id'                        => 3,
                'collection_instance_id'    => 1,
                'page_version_id'           => 1,
                'type'                      => 'image',
                'human_name'                => 'Key #1',
                'key'                       => 'key1',
                'json_value'                => '{"bar": "awesome"}'
            ),
        );

        DB::table('dvs_fields')->insert($data);
    }
}
