<?php

class DeviseBindingAdapterTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->adapter = $this->app->make('Devise\Editor\Helpers\DeviseBindingAdapter');
	}

	/**
	 * no changes should be made to this view because
	 * there are no data-devise tags in it
	 */
	public function test_that_nothing_is_done_to_view()
	{
		$output = $this->adapter->compile('<h3>Hello</h3>');
		assertContains('<h3>Hello</h3>', $output);
	}

	/**
	 * this keyname is not valid, so we should expect an exception
	 *
	 * @expectedException Devise\Fields\Exceptions\InvalidFieldKeyException
	 */
	public function test_that_keys_are_unique()
	{
		$output = $this->adapter->compile('<p data-devise="some-keyName, type, humanName">Hello</p>');
	}

	/**
	 * make sure that the data-devise tags are no longer there
	 * and that there is now dvs-keyName-id="keyName" in view
	 */
	public function test_that_data_devise_is_renamed()
	{
		$output = $this->adapter->compile('<h3>Hello</h3><p data-devise="keyName, type, humanName">Hello</p>');
		assertContains('<h3>Hello</h3><p data-dvs-keyName-id="keyName">Hello</p>', $output);
	}

	/**
	 * make sure that the data-devise tags are no longer there
	 * and that there is now dvs-keyName-id="keyName" in view
	 */
	public function test_that_data_devise_is_renamed_for_collection_types()
	{
		$output = $this->adapter->compile('<p data-devise="collection[keyName], type, humanName">Hello</p>');
		assertContains('<p data-dvs-collection-keyName-id="collection-keyName">Hello</p>', $output);
	}

	/**
	 * make sure that a App::make('deviseDataJavascriptBindings')
	 * was added to the view, and that the bindings are all correct
	 */
	public function test_that_data_devise_is_added_to_page_data_container()
	{
		$output = $this->adapter->compile('<p data-devise="keyName, type, humanName">Hello</p>');
		assertContains('<?php App::make("deviseDataJavascriptBindings")->merge(\'[{"key":"keyName","type":"type","humanName":"humanName","group":null,"category":null,"alternateTarget":null}]\'); ?>', $output);
	}

	/**
	 * make sure that a App::make('deviseDataJavascriptCollections')
	 * was added to the view, and that the collections are all correct
	 */
	public function test_that_data_devise_collection_type_is_added_to_page_data_container()
	{
		$output = $this->adapter->compile(
			'<p data-devise="col[keyName], type, humanName">Hello</p>' . PHP_EOL .
			'<p data-devise="col[anotherName], type, humanName">Hello</p>'
		);

		assertContains('<?php App::make("deviseDataJavascriptCollections")->merge(\'{"col":[{"key":"keyName","type":"type","humanName":"humanName","group":null,"category":null,"alternateTarget":null},{"key":"anotherName","type":"type","humanName":"humanName","group":null,"category":null,"alternateTarget":null}]}\'); ?>', $output);
	}
}