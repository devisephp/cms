<?php namespace Devise\Pages\Interrupter\Nodes;

class NodeFactory
{
	public function createNodeFromRegexMatch($match)
	{
		$matched = $match[0];
		$position = $match[1];

		if (strpos($matched, '@if') === 0)
		{
			return new IfNode($matched, $position);
		}

		if (strpos($matched, '@foreach') === 0)
		{
			return new ForeachNode($matched, $position);
		}

		if (strpos($matched, ' data-devise') === 0)
		{
			return new DeviseTagNode($matched, $position);
		}

		if (strpos($matched, '@endif') === 0)
		{
			return new EndIfNode($matched, $position);
		}

		if (strpos($matched, '@endforeach') === 0)
		{
			return new EndForeachNode($matched, $position);
		}

		if (strpos($matched, '@include') === 0)
		{
			return new IncludeNode($matched, $position);
		}

		throw new UnidentifiedNodeException('Could not identify this node from the regex match ' . $matched . ' at ' . $position);
	}
}