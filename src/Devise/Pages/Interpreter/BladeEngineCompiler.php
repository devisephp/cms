<?php namespace Devise\Pages\Interpreter;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;

/**
 * This class merely decorates the another compiler
 * and thus giving us the extra functionality we need
 * to work properly...
 *
 */
class BladeEngineCompiler implements CompilerInterface
{
	/**
	 * Construct a new blade compiler
	 *
	 * @param CompilerInterface $compiler
	 * @param DeviseCompiler    $DeviseCompiler
	 */
	public function __construct(CompilerInterface $compiler, DeviseCompiler $DeviseCompiler, DeviseParser $DeviseParser)
	{
		$this->compiler = $compiler;
		$this->DeviseCompiler = $DeviseCompiler;
		$this->DeviseParser = $DeviseParser;
	}

	/**
	 * Get the path to the compiled version of a view.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public function getCompiledPath($path)
	{
		return $this->compiler->getCompiledPath($path);
	}

	/**
	 * Determine if the given view is expired.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public function isExpired($path)
	{
		return $this->compiler->isExpired($path);
	}

	/**
	 * Compile the view at the given path.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public function compile($path = null)
	{
		$this->compiler->compile($path);

		$path = $this->getCompiledPath($path);

		if (! file_exists($path)) return;

		$html = file_get_contents($path);

		if (! $this->DeviseParser->hasDeviseTags($html)) return;

		$html = $this->DeviseCompiler->compile($html);

		file_put_contents($path, $html);
	}

	/**
	 * [extend description]
	 * @param  \Closure $closure [description]
	 * @return [type]            [description]
	 */
	public function extend(\Closure $closure)
	{
		return $this->compiler->extend($closure);
	}

	/**
	 * Any calls made we proxy to the underlying compiler
	 *
	 * @param  [type] $method    [description]`
	 * @param  [type] $arguments [description]
	 * @return [type]            [description]
	 */
	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->compiler, $method), $arguments);
	}
}