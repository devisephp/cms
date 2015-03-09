<?php namespace Devise\Pages\Interpreter;

use PhpParser\PrettyPrinter\Standard;
use PhpParser\NodeTraverser;

/**
 * purpose of this class is to add placeholder tags
 * and also rename devise tags and lastly append on
 * App::make('dvsPageData')->bindings for devise tags,
 * collections, models and model creators
 */
class DeviseCompiler
{
	/**
	 * Compile the view with devise code in it
	 *
	 * @param  string $view
	 * @return string
	 */
	public function compile($view)
	{
		$this->parser = new DeviseParser;

		$prettyPrinter = new Standard;

		$pristine = $this->pristine($view);

		$modified = $this->modified($view);

		$pristine[0]->stmts = $modified;

		$result = $prettyPrinter->prettyPrintFile($pristine);

		return $result;
	}

	/**
	 * Get the pristine AST
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function pristine($view)
	{
		$ast = $this->parser->parse($view);

		$traverser = new NodeTraverser;

		$traverser->addVisitor(new Modifiers\CreatePristineSection($this->parser));

		return $traverser->traverse($ast);
	}

	/**
	 * Get the modified AST
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function modified($view)
	{
		$ast = $this->parser->parse($view);

		$traverser = new NodeTraverser;

		$traverser->addVisitor(new Modifiers\RegisterDeviseTags($this->parser));

		$traverser->addVisitor(new Modifiers\AddPlaceHolderTags($this->parser));

		return $traverser->traverse($ast);
	}
}