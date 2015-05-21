<?php namespace Devise\Pages\Docs;

use Mockery as m;

class CreatorTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->Framework = new \Devise\Support\Framework;
		$this->LiveSpan = m::mock('Devise\Pages\Docs\LiveSpan');
		$this->CommonMarkConverter = m::mock('League\CommonMark\CommonMarkConverter');
		$this->Creator = new Creator($this->LiveSpan, $this->Framework, $this->CommonMarkConverter);
	}

	public function test_it_can_create_devise_docs_for_view()
	{
		$content = 'some content';
		$this->Creator->View = m::mock('SomeViewObj');
		$this->Creator->View->shouldReceive('make')->twice()->andReturnSelf();
		$this->Creator->View->shouldReceive('render')->twice()->andReturn($content);
		$this->CommonMarkConverter->shouldReceive('convertToHtml')->once()->with($content)->andReturn($content);
		$this->LiveSpan->shouldReceive('replace')->once()->with($content)->andReturn($content);
		assertContains($content, $this->Creator->deviseDocs('devise::some.view.path'));
	}
}