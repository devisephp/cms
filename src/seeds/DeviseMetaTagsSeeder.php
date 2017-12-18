<?php

class DeviseMetaTagsSeeder extends DeviseSeeder
{
	public function run() {

		$metaItems = array(
			array(
				'key' => 'itemscope',
				'page_id' => null,
        'property' => 'itemtype',
				'value' => ''
			),
      array(
				'key' => 'description',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'name',
				'page_id' => null,
        'property' => 'itemprop',
				'value' => ''
			),
      array(
				'key' => 'description',
				'page_id' => null,
        'property' => 'itemprop',
				'value' => ''
			),
      array(
				'key' => 'image',
				'page_id' => null,
        'property' => 'itemprop',
				'value' => ''
			),
      array(
				'key' => 'twitter:card',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'twitter:site',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'twitter:title',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'twitter:description',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'twitter:creator',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'twitter:image:src',
				'page_id' => null,
        'property' => 'name',
				'value' => ''
			),
      array(
				'key' => 'og:title',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'og:type',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'og:url',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'og:image',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'og:description',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'og:site_name',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'article:published_time',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'article:modified_time',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'article:section',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'article:tag',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
      array(
				'key' => 'fb:admins',
				'page_id' => null,
        'property' => 'property',
				'value' => ''
			),
		);

		$this->findOrCreateRows('dvs_meta', ['key'], $metaItems);
	}
}
