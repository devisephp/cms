<?php namespace Devise\Pages\Docs;

use League\CommonMark\CommonMarkConverter;
use Devise\Support\Framework;

class Creator
{
	/**
	 * [__construct description]
	 * @param LiveSpan            $LiveSpan
	 * @param Framework           $Framework
	 * @param CommonMarkConverter $MardownConverter
	 */
	public function __construct(LiveSpan $LiveSpan, Framework $Framework, CommonMarkConverter $MarkdownConverter)
	{
		$this->LiveSpan = $LiveSpan;
		$this->View = $Framework->View;
		$this->MarkdownConverter = $MarkdownConverter;
	}

	/**
	 * Returns devise docs for the sidebar for this view path
	 *
	 * @param  string $viewPath
	 * @return string
	 */
	public function deviseDocs($viewPath)
	{
		$content = '';

		$view = $this->getDocView($viewPath);

		if ($view)
		{
			$content = $view->render();
			$content = $this->MarkdownConverter->convertToHtml($content);
			$content = $this->LiveSpan->replace($content);
		}

		$hascontent = !is_null($view);

		return $this->View->make('devise::layouts.docs', compact('hascontent', 'content'))->render();
	}

	/**
	 * Returns the doc view if there is one
	 *
	 * @param  string $viewPath
	 * @return \View
	 */
	protected function getDocView($viewPath)
	{
		$viewPath = str_replace('devise::', '', $viewPath);

		$viewPath = "devise::docs.{$viewPath}";

		try { return $this->View->make($viewPath); }

		catch (\Exception $e) { }

		return null;
	}
}