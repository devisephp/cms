<?php
//class PagesTestSeeder extends Seeder {
//
//	public function run()
//	{
//		// Uncomment the below to wipe the table clean before populating
//		DB::table('dvs_templates')->delete();
//
//		$dvs_templates = array (
//  0 => array (
//    'id' => 1,
//    'name' => 'layout',
//    'location' => 'layouts',
//    'blade' => 'frontent',
//    'parent_id' => '0',
//    'created_at' => '0000-00-00 00:00:00',
//    'updated_at' => '0000-00-00 00:00:00',
//  ),
//  1 => array (
//    'id' => 2,
//    'name' => 'level 1',
//    'location' => 'pages',
//    'blade' => 'something',
//    'parent_id' => '1',
//    'created_at' => '2014-04-02 17:52:56',
//    'updated_at' => '2014-04-02 17:52:56',
//  ),
//  2 => array (
//    'id' => 3,
//    'name' => 'bottom level',
//    'location' => 'pages',
//    'blade' => 'somethingelse',
//    'parent_id' => '2',
//    'created_at' => '2014-04-02 17:53:30',
//    'updated_at' => '2014-04-02 17:53:30',
//  ),
//  3 => array (
//    'id' => 27,
//    'name' => 'Front End',
//    'location' => 'layouts/',
//    'blade' => 'front_end11',
//    'parent_id' => NULL,
//    'created_at' => '2014-04-21 21:05:36',
//    'updated_at' => '2014-04-23 20:23:02',
//  ),
//  4 => array (
//    'id' => 28,
//    'name' => 'Child',
//    'location' => 'pages/',
//    'blade' => 'child11',
//    'parent_id' => '27',
//    'created_at' => '2014-04-21 21:05:36',
//    'updated_at' => '2014-04-23 21:21:16',
//  ),
//  5 => array (
//    'id' => 29,
//    'name' => 'Grandchild',
//    'location' => 'pages/',
//    'blade' => 'grandchild111',
//    'parent_id' => '28',
//    'created_at' => '2014-04-21 21:05:36',
//    'updated_at' => '2014-04-23 21:21:16',
//  ),
//);
//		// Uncomment the below to run the seeder
//
//		DB::table('dvs_templates')->insert($dvs_templates);
//
//
//
//
//
//    DB::table('dvs_pages')->delete();
//
//    $dvs_pages = array (
//  0 => array (
//    'id' => 1,
//    'template_id' => 17,
//    'name' => 'Faces',
//    'published' => 1,
//    'slug' => 'your-awesome/dude',
//    'short_description' => 'sdf',
//    'meta_title' => NULL,
//    'meta_description' => NULL,
//    'meta_keywords' => NULL,
//    'head' => NULL,
//    'footer' => NULL,
//    'created_at' => '2014-03-18 21:14:03',
//    'updated_at' => '2014-04-16 13:05:47',
//    'deleted_at' => NULL,
//  ),
//  1 => array (
//    'id' => 2,
//    'template_id' => 1,
//    'name' => 'sdfs',
//    'published' => NULL,
//    'slug' => 'yes-i-am',
//    'short_description' => NULL,
//    'meta_title' => NULL,
//    'meta_description' => NULL,
//    'meta_keywords' => NULL,
//    'head' => NULL,
//    'footer' => NULL,
//    'created_at' => '0000-00-00 00:00:00',
//    'updated_at' => '2014-04-16 13:06:01',
//    'deleted_at' => NULL,
//  ),
//  2 => array (
//    'id' => 23,
//    'template_id' => 0,
//    'name' => '2v v',
//    'published' => NULL,
//    'slug' => 'duder_long-title',
//    'short_description' => NULL,
//    'meta_title' => NULL,
//    'meta_description' => NULL,
//    'meta_keywords' => NULL,
//    'head' => NULL,
//    'footer' => NULL,
//    'created_at' => '0000-00-00 00:00:00',
//    'updated_at' => '0000-00-00 00:00:00',
//    'deleted_at' => NULL,
//  ),
//  3 => array (
//    'id' => 24,
//    'template_id' => 0,
//    'name' => 'aw3fsw',
//    'published' => NULL,
//    'slug' => 'ho-bag',
//    'short_description' => NULL,
//    'meta_title' => NULL,
//    'meta_description' => NULL,
//    'meta_keywords' => NULL,
//    'head' => NULL,
//    'footer' => NULL,
//    'created_at' => '0000-00-00 00:00:00',
//    'updated_at' => '0000-00-00 00:00:00',
//    'deleted_at' => NULL,
//  ),
//);
//    // Uncomment the below to run the seeder
//
//    DB::table('dvs_pages')->insert($dvs_pages);
//
//
//
//
//    DB::table('dvs_fields')->delete();
//
//    $dvs_fields = array (
//  0 => array (
//    'id' => 55,
//    'template_id' => 29,
//    'human_name' => 'This Is the Editor',
//    'key' => 'this_is_the_editor',
//    'type' => 'editor',
//    'settings' => '{"selector":"content","group":"boss","default":"This is a header title"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  1 => array (
//    'id' => 56,
//    'template_id' => 29,
//    'human_name' => 'This Is the Guy',
//    'key' => 'this_is_the_guy',
//    'type' => 'editor',
//    'settings' => '{"selector":"content","default":"                <p> what the helll!!!<\\/p>                <div class=\\"what\\">ccc<\\/div>            "}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  2 => array (
//    'id' => 57,
//    'template_id' => 29,
//    'human_name' => 'This Is the Name',
//    'key' => 'this_is_the_name',
//    'type' => 'image',
//    'settings' => '{"selector":"data-whatever","default":"something"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  3 => array (
//    'id' => 58,
//    'template_id' => 29,
//    'human_name' => 'This Is the Name',
//    'key' => 'this_is_the_name_1',
//    'type' => 'image',
//    'settings' => '{"selector":"data-whatever2","default":""}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  4 => array (
//    'id' => 59,
//    'template_id' => 29,
//    'human_name' => 'This Is the dude',
//    'key' => 'this_is_the_dude',
//    'type' => 'image',
//    'settings' => '{"selector":"src","default":"whatever.jpg"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  5 => array (
//    'id' => 60,
//    'template_id' => 29,
//    'human_name' => 'This Is the rock',
//    'key' => 'this_is_the_rock_1',
//    'type' => 'image',
//    'settings' => '{"selector":["data-face","dude"],"group":"boss","default":""}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  6 => array (
//    'id' => 61,
//    'template_id' => 29,
//    'human_name' => 'This Is the truck',
//    'key' => 'this_is_the_truck_1',
//    'type' => 'image',
//    'settings' => '{"selector":["data-obj","attachment"],"default":"null"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  7 => array (
//    'id' => 62,
//    'template_id' => 29,
//    'human_name' => 'This Is the Name',
//    'key' => 'this_is_the_name_2',
//    'type' => 'image',
//    'settings' => '{"selector":["style","background-image"],"default":"whatever.jpg"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  8 => array (
//    'id' => 63,
//    'template_id' => 29,
//    'human_name' => 'This Is the rock',
//    'key' => 'this_is_the_rock',
//    'type' => 'image',
//    'settings' => '{"selector":["data-face","dude"],"group":"boss","default":""}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//  9 => array (
//    'id' => 64,
//    'template_id' => 0,
//    'human_name' => 'This Is the truck',
//    'key' => 'this_is_the_truck',
//    'type' => 'image',
//    'settings' => '{"selector":["data-obj","attachment"],"default":"null"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 21:21:16',
//  ),
//  10 => array (
//    'id' => 65,
//    'template_id' => 0,
//    'human_name' => 'This Is the day',
//    'key' => 'this_is_the_day',
//    'type' => 'image',
//    'settings' => '{"selector":["style","background-image"],"default":"whatever.jpg"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 21:21:16',
//  ),
//  11 => array (
//    'id' => 66,
//    'template_id' => 0,
//    'human_name' => 'This Is the time',
//    'key' => 'this_is_the_time',
//    'type' => 'editor',
//    'settings' => '{"selector":"content","default":"Blammo"}',
//    'created_at' => '2014-04-23 20:14:29',
//    'updated_at' => '2014-04-23 21:21:16',
//  ),
//  12 => array (
//    'id' => 67,
//    'template_id' => 29,
//    'human_name' => 'This Is the time',
//    'key' => 'this_is_the_time_1',
//    'type' => 'editor',
//    'settings' => '{"selector":"content","default":"Blammo"}',
//    'created_at' => '2014-04-23 20:15:02',
//    'updated_at' => '2014-04-23 20:33:22',
//  ),
//);
//    // Uncomment the below to run the seeder
//
//    DB::table('dvs_fields')->insert($dvs_fields);




?>