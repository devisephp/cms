<?php namespace Devise\Pages\Interpreter;

/**
 * Class ViewOpener opens a view for an include statement in this format:
 *
 *   "@include('some.path.here", ...)
 *
 * We will use Laravel's view path finder in order to transform the 'some.path.here' into a real
 * file that we can open and inspect the html and thus fetch all devise tags from it.
 *
 * @package Devise\Pages\Interpreter
 */
class ViewOpener
{
	/**
	 * Search for view paths
	 *
	 * @var Illuminate\View\FileViewFinder
	 */
	protected $finder;

    /**
     * Construct a new view opener
     * @param Illuminate\View\FileViewFinder $finder
     */
	public function __construct($finder = null, $file = null)
	{
		$this->finder = $finder ?: \App::make('view')->getFinder();
		$this->file = $file ?: \App::make('files');
	}

    /**
     * Attempt to open the view path if something fails then we silently
     * fail and return an empty string...
     *
     * We have added the includedViews array so we do not attempt to open up those views
     * (we don't need to because we've already found all the devise tags inside of those
     * files since they've already been opened). If view#1 includes view#2 which includes
     * view#1, this would have cause an infinite loop but b/c we keep up with which views
     * have been included we know when to stop).
     *
     * @param $includeStatement
     * @param $includedViews
     * @return string
     */
	public function open($includeStatement, &$includedViews)
	{
		$path = $this->pathFromIncludeStatement($includeStatement);

		if (is_null($path) || in_array($path, $includedViews))
		{
			return '';
		}

		$includedViews[] = $path;

		return $this->openViewPath($path);
	}

	/**
	 * Recursively finds every view that is included inside this view
	 *
	 * @param  [type] $view
	 * @return [type]
	 */
	public function findAllIncludedViews($viewPath, $ignore = [])
	{
		$content = $this->openViewPath($viewPath);

		$includes = $this->includeStatements($content);

		$ignore[] = $viewPath;

		foreach ($includes as $include)
		{
			if (!in_array($include, $ignore))
			{
				$ignore[] = $include;
				$includes = array_merge($includes, $this->findAllIncludedViews($include, $ignore));
			}
		}

		return array_unique($includes);
	}

	/**
	 * Find the real path
	 *
	 * @param  [type] $path
	 * @param  [type] &$includedViews
	 * @return [type]
	 */
	public function openViewPath($path)
	{
		try
		{
			$realpath = $this->finder->find($path);
			return $this->file->get($realpath);
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

	/**
	 * Gets the included views from all these matches
	 *
	 * @param  string $content
	 * @return array
	 */
	protected function includeStatements($content)
	{
		$includes = [];

		$pattern = "/@include\s*\(\s*\'([^']+)\'|" . '@include\s*\(\s*\"([^"]+)\"/';

		preg_match_all($pattern, $content, $matches);

		for ($i = 0; $i < count($matches[1]); $i++)
		{
			$includes[] = $matches[1][$i] ? $matches[1][$i] : $matches[2][$i];
		}

        return array_unique($includes);
	}

    /**
     * Finds the path from a $statement string. The pattern below
     * searches for "@include('this.is.what.we.want', ...)"
     *
     * @param $statement
     * @return null
     */
	protected function pathFromIncludeStatement($statement)
	{
		$matches = $this->includeStatements($statement);

        return count($matches) > 0 ? array_pop($matches) : null;
	}


}