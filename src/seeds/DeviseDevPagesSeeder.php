<?php

class DeviseDevPagesSeeder extends Seeder
{
	public function run()
    {
		$pages = array(
            // array(
            //     'id'                      => '1',
            //     'language_id'             => '45',
            //     'translated_from_page_id' => '0',
            //     'view'                    => 'devise::admin.pages.index',
            //     'title'                   => 'Manage Pages',
            //     'http_verb'               => 'get',
            //     'route_name'              => 'dvs-pages',
            //     'published'               => '1',
            //     'is_admin'                => '1',
            //     'dvs_admin'               => '1',
            //     'slug'                    => '/admin/pages',
            //     'short_description'       => 'Allows the management of devise pages',
            //     'response_type'           => 'View'
            // ),
        );


		foreach ( $pages as $page ) {
			DB::table( 'dvs_pages' )->insert( array( $page ) );
		}
	}

}
