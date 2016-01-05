<?php namespace Devise\Pages\Interpreter;

use PhpParser\ParserFactory;

class DeviseParser
{
	/**
	 * Create a new Devise Parser
	 *
	 * @param Parser $parser
	 */
	public function __construct(Parser $parser = null)
	{
		$this->parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
	}

	/**
	 * Parses the string for us
	 *
	 * @param  string $str
	 * @return array
	 */
	public function parse($str)
	{
		return $this->parser->parse($str);
	}

	/**
	 * Get the list of regex'ed devise tags out of the html
	 *
	 * @param  string $html
	 * @return array
	 */
	public function getDeviseTags($html)
	{
		$tags = [];

		$matches = $this->matches($html, "/\s?data-devise=[\"]([^\"]*)[\"]/");

		foreach ($matches as $match) $tags[] = new DeviseTag($match[0]);

		$matches = $this->matches($html, "/\s?data-devise=[']([^']*)[']/");

		foreach ($matches as $match) $tags[] = new DeviseTag($match[0]);

		$matches = $this->matches($html, "/\s?data-devise-<\?php echo devise_tag_cid\(((?!\?>).)*\) \?>/");

		foreach ($matches as $match) $tags[] = new DeviseTag($match[0], 'parsed');

		$matches = $this->matches($html, "/\s?data-devise-create-model=[\"'] *([^\"'])*[\"']/");

		foreach ($matches as $match) $tags[] = new DeviseTag($match[0], 'creator');

		return $tags;
	}

	/**
	 * Check the html to see if it has any devise tags in it
	 *
	 * @param  string  $html
	 * @return boolean
	 */
	public function hasDeviseTags($html)
	{
		return count($this->getDeviseTags($html)) > 0;
	}

	/**
	 * Finds a regex pattern and returns the match for us
	 *
	 * @param  string $html
	 * @param  string $pattern
	 * @return array
	 */
	protected function matches($html, $pattern)
	{
		preg_match_all($pattern, $html, $matches, PREG_OFFSET_CAPTURE);

		if (!isset($matches[0])) return array();

		return $matches[0];
	}
}

