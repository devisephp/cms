<?php

class DeviseGlobalFieldsSeeder extends Seeder
{
    public function run()
    {
        DB::table('dvs_global_fields')->delete();

        $data = array(
            array(
                'id'          => 1,
                'language_id' => 45,
                'type'        => 'image',
                'human_name'  => 'Key #1',
                'key'         => 'key1',
                'json_value'  => '{"url": "/media/kitten.jpg"}',
            ),
        );

        DB::table('dvs_global_fields')->insert($data);
    }
}
