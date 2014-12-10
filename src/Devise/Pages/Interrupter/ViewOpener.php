<?php namespace Devise\Pages\Interrupter;

/**
 * Class ViewOpener opens a view for an include statement in this format:
 *
 *   "@include('some.path.here", ...)
 *
 * We will use Laravel's view path finder in order to transform the 'some.path.here' into a real
 * file that we can open and inspect the html and thus fetch all devise tags from it.
 *
 * @package Devise\Pages\Interrupter
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
	public function __construct($finder = null)
	{
		$this->finder = $finder ?: \App::make('view.finder');
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

    /**
     * Finds the path from a $statement string. The pattern below
     * searches for "@include('this.is.what.we.want', ...)"
     *
     * @param $statement
     * @return null
     */
	protected function pathFromIncludeStatement($statement)
	{
		$pattern = "/@include\s*\(\s*\'([^']+)\'|" . '@include\s*\(\s*\"([^"]+)\"/';

		preg_match($pattern, $statement, $matches);

		// we can't figure out how to open this path so bail
		if (count($matches) == 0)
		{
			return null;
		}

        return array_pop($matches);
	}
}