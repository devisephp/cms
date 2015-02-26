<?php namespace Devise\Pages\Interpreter;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\Filesystem\Filesystem;

/**
 * This class merely decorates the blade compiler
 * and thus giving us the extra functionality we need
 * to work properly...
 *
 */
class ExtendedBladeCompiler implements CompilerInterface
{
	/**
	 * Construct a new blade compiler
	 *
	 * @param CompilerInterface $compiler
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 */
	public function __construct(CompilerInterface $compiler, Filesystem $files)
	{
		$this->compiler = $compiler;
		$this->files = $files;
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
	public function compile($path)
	{
		$this->compiler->afterCompiled = [];

		$result = $this->compiler->compile($path);

		$this->runAfterCompiledClosures($path);

		return $result;
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

	/**
	 * [runAfterCompiledClosures description]
	 * @return void
	 */
	public function runAfterCompiledClosures($path)
	{
		$compiledPath = $this->compiler->getCompiledPath($path);

		$view = $this->files->get($compiledPath);

		foreach ($this->compiler->afterCompiled as $hook)
		{
			$view = $hook($view, $this->compiler);

			$this->files->put($compiledPath, $view);
		}
	}
}