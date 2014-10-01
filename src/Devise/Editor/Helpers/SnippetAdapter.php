<?php namespace Devise\Editor\Helpers;

class SnippetAdapter
{
	public function compile($view)
	{
		$replacements = [];

		$pattern = '/@snippet(.+?)@endsnippet/s';

		preg_match_all($pattern, $view, $matches);

		// loop through all the pattern matches
		foreach ($matches[0] as $index => $match)
		{
			$replacements[$match] = $matches[1][$index];
		}

		// loop through all the replacements
		foreach ($replacements as $replace => $with)
		{
			$original = $with;
			$with = htmlentities($with);
			$with = str_replace('@', '&#64;', $with);
			$with = str_replace('{', '&#123;', $with);
			$with = str_replace('}', '&#125;', $with);
			$with = str_replace(' data-devise=', ' data&#45;devise=', $with);
			$view = str_replace($replace, "{$original} <pre class=\"devise-code-snippet\">{$with}</pre>", $view);
		}

		return $view;
	}
}
