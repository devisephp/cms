<?php namespace Devise\Pages\Interrupter;

class ViewOpener
{
	/**
	 * Search for view paths
	 *
	 * @var Illuminate\View\FileViewFinder
	 */
	public $finder;

	/**
	 * [__construct description]
	 */
	public function __construct()
	{
		$this->finder = \App::make('view.finder');
	}

	/**
	 * Attempt to open the view path
	 * if something fails then we silently
	 * fail and return an empty string...
	 *
	 * @param  string $path
	 * @return string
	 */
	public function open($includeStatement, &$includedViews)
	{
		$path = $this->pathFromIncludeStatement($includeStatement);

		if (in_array($path, $includedViews))
		{
			return '';
		}

		$includedViews[] = $path;

		try
		{
			$realpath = $this->finder->find($path);
			return file_get_contents($realpath);
		}

		catch (\Exception $e)
		{
			// we just return an empty string, we are going to passively fail
			// here because it is not always possible to search inside of
			// the @include(...) view path, for example, what if it was
			// @include ($somevar . '_item') there is no way to find this
			// view without first rendering the page
		}

		return '';
	}

	protected function pathFromIncludeStatement($statement)
	{
		$pattern = "/@include\s*\(\s*\'([^']+)\'|" . '@include\s*\(\s*\"([^"]+)\"/';

		preg_match($pattern, $statement, $matches);

		// we can't figure out how to open this path so bail
		if (count($matches) != 2)
		{
			return null;
		}

		return $matches[1];
	}
}