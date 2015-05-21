<?php namespace Devise\Pages\Docs;

use Devise\Support\Str;

class LiveSpan
{
	/**
	 * [__construct description]
	 * @param Str $Str
	 */
	public function __construct(Str $Str)
	{
		$this->Str = $Str;
	}

	/**
	 * [replace description]
	 * @param  [type] $str
	 * @return [type]
	 */
	public function replace($str)
	{
		return $this->Str->replaceBetween($str, '@livespan', function($between)
		{
			$parts = explode(',', $between);

			$selector = array_shift($parts);

			$default = implode(',', $parts);

			$default = substr($default, 0, 1) === ' ' ? substr($default, 1) : $default;

			return "<span data-livespan=\"{$selector}\">{$default}</span>";
		});
	}
}