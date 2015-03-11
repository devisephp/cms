<?php namespace Devise\Support;

use Closure;

class Str
{
	protected function closetag($str)
	{
		$str = ltrim($str);
		$closetag = substr($str, 0, 1);

		if ($closetag == '(') $closetag = ')';
		if ($closetag == '[') $closetag = ']';
		if ($closetag == '{') $closetag = '}';
		if ($closetag == '<') $closetag = '>';

		return $closetag;
	}

	protected function opentag($str)
	{
		$str = ltrim($str);
		return substr($str, 0, 1);
	}

	protected function escaped($str)
	{
		$lookingback = true;
		$count = 1;

		while ($lookingback && $count < strlen($str))
		{
			if (substr($str, $count * -1, 1) === '\\') $count++;
			else $lookingback = false;
		}

		return --$count;
	}

	public function replaceBetween($haystack, $needle, Closure $replacementMethod)
	{
		$parts = explode($needle, $haystack);

		$sumOfParts = $parts[0];

		foreach ($parts as $index => $part)
		{
			if ($index === 0) continue;

			if ($count = $this->escaped($parts[$index - 1]))
			{
				$sumOfParts = substr($sumOfParts, 0, $count * -1) . $needle . $part;

				continue;
			}

			$start = strpos($part, $this->opentag($part));

			$end = strpos($part, $this->closetag($part));

			$between = substr($part, $start + 1, $end - $start - 1);

			$between = $replacementMethod($between);

			$sumOfParts .= substr_replace($part, $between, 0, $end + 1);
		}

		return $sumOfParts;
	}
}