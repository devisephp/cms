<?php namespace Devise\Pages\Interpreter;

use Mockery as m;

class DeviseCompilerTest extends \DeviseTestCase
{
	public function test_it_compiles_with_pristine_view()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret1'));
		assertContains('	<div>Something here</div>', $outcome);
		assertContains("if (DeviseUser::checkConditions('canUseDeviseEditor'))", $outcome);
	}

	public function test_it_registers_app_makes()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret1'));
		assertContains("App::make('dvsPageData')->register('col[key2]', 'collection', 'col', 'key2', 'text', 'human', 'collection human', 'group', 'category', 'alternate');", $outcome);
		assertContains("App::make('dvsPageData')->register('col[key1]', 'collection', 'col', 'key1', 'text', 'human', 'collection human', 'group', 'category', 'alternate');", $outcome);
		assertContains("App::make('dvsPageData')->register('key3', 'field', null, 'key3', 'text', 'Key3', null, null, null, null);", $outcome);
		assertContains("App::make('dvsPageData')->register('key2', 'field', null, 'key2', 'type', 'Human name 2', null, null, null, null);", $outcome);
		assertContains("App::make('dvsPageData')->register('key1', 'field', null, 'key1', 'type', 'Human name 1', null, null, null, null);", $outcome);
		assertContains("App::make('dvsPageData')->register('\$key', 'variable', null, '\$key', 'variable', 'human', null, 'group', 'category', 'alternate');", $outcome);
	}

	public function test_it_renames_devise_tags_properly()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret1'));
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'key1\', "field", null, "key1", "type", "Human name 1", null, null, null, null, null) ?>="key1"', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'key2\', "field", null, "key2", "type", "Human name 2", null, null, null, null, null) ?>="key2"', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'$key\', "variable", null, [\'$key\' => $key,], "variable", "human", null, "group", "category", "alternate", null) ?>="$key">Something here</div>', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'key3\', "field", null, "key3", "text", "Key3", null, null, null, null, null) ?>="key3">Something here</div>', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'col[key1]\', "collection", "col", "key1", "text", "human", "collection human", "group", "category", "alternate", $defaultValues) ?>="col[key1]">Something here</div>', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'col[key2]\', "collection", "col", "key2", "text", "human", "collection human", "group", "category", "alternate", [\'value\' => \'durka\']) ?>="col[key2]">Something here</div>', $outcome);
	}

	public function test_it_creates_placeholder_tags_for_conditions()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret2'));
		assertContains('<span data-dvs-placeholder="key1" data-dvs-placeholder="durka" data-dvs-placeholder="key5" data-dvs-placeholder="key2" data-dvs-placeholder="durka2" data-dvs-placeholder="key3" data-dvs-placeholder="key4"></span>', $outcome);
		assertContains('<span data-dvs-placeholder="durka"></span>', $outcome);
		assertContains('<span data-dvs-placeholder="durka2"></span>', $outcome);
	}

	public function test_it_creates_placeholder_tags_for_loops()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret3'));
		assertContains('<span data-dvs-placeholder="key1" data-dvs-placeholder="key2" data-dvs-placeholder="key3"></span>', $outcome);
		assertContains('<span data-dvs-placeholder="key2" data-dvs-placeholder="key3"></span>', $outcome);
		assertContains('<span data-dvs-placeholder="key3"></span>', $outcome);
	}

	public function test_it_sets_default_values()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret3'));
		assertContains("App::make('dvsPageData')->setDefaults('outside', null);", $outcome);
		assertContains("App::make('dvsPageData')->setDefaults('key3', null);", $outcome);
		assertContains("App::make('dvsPageData')->setDefaults('key2', null);", $outcome);
		assertContains("App::make('dvsPageData')->setDefaults('key1', null);", $outcome);
	}

	public function test_it_can_handle_model_tags()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret4'));
		assertContains("App::make('dvsPageData')->register('\$page', 'variable', null, '\$page', 'variable', 'The Page Man!', null, null, null, null);", $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'$page\', "variable", null, [\'$page\' => $page,], "variable", "The Page Man!", null, null, null, null, null) ?>="$page"></div>', $outcome);
		assertContains('App::make(\'dvsPageData\')->setDefaults(\'$page\', null);', $outcome);
	}

	public function test_it_can_handle_model_attribute_tags()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret5'));
		assertContains("App::make('dvsPageData')->register('\$page->view', 'variable', null, '\$page->view', 'variable', 'The Page View', null, null, null, null);", $outcome);
		assertContains('App::make(\'dvsPageData\')->setDefaults(\'$page->view\', null);', $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'$page->view\', "variable", null, [\'view\' => $page->view,\'$page\' => $page,], "variable", "The Page View", null, null, null, null, null) ?>="$page->view"></div>', $outcome);
	}

	public function test_it_can_handle_create_model_tags()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret6'));
		assertContains("App::make('dvsPageData')->register('creator-07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null, null);", $outcome);
		assertContains("App::make('dvsPageData')->setDefaults('creator-07bc2f9dadb7314768a55b1f9cd404dc', null);", $outcome);
		assertContains('<div data-devise-<?php echo devise_tag_cid(\'creator-07bc2f9dadb7314768a55b1f9cd404dc\', "creator", null, "DvsPage", "creator", "The Page Creator", null, null, null, null, null) ?>="creator-07bc2f9dadb7314768a55b1f9cd404dc"></div>', $outcome);
	}

	public function test_it_can_echo_dvsmagic()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.interpret7'));
		assertContains('echo startdvsmagic() . dvsmagic($value) . enddvsmagic();', $outcome);
		assertContains('echo startdvsmagic() . dvsmagic($page->test->value) . enddvsmagic();', $outcome);
		assertContains('echo startdvsmagic() . dvsmagic($page->test->value(\'hmm\')) . enddvsmagic();', $outcome);
		assertContains('echo $page->test->value ? startdvsmagic() . dvsmagic($page->test->value) . enddvsmagic() : \'durka\';', $outcome);
		assertContains('startdvsmagic() . dvsmagic($page->test->value) . enddvsmagic() . \'durka\' . (startdvsmagic() . dvsmagic($page->test->another_value) . enddvsmagic());', $outcome);
		assertContains('echo e(startdvsmagic() . dvsmagic($page->test->value) . enddvsmagic());', $outcome);
	}

	public function test_it_handles_random1_view()
	{
		$compiler = new DeviseCompiler;
		$outcome = $compiler->compile($this->fixture('devise-views.random1'));
	}
}