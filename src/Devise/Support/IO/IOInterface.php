<?php namespace Devise\Support\IO;

interface IOInterface
{
	public function confirm($question, $default = false);
	public function ask($question, $default = null);
	public function askWithCompletion($question, array $choices, $default = null);
	public function secret($question, $fallback = true);
	public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null);
	public function table(array $headers, array $rows, $style = 'default');
	public function info($string);
	public function line($string);
	public function comment($string);
	public function question($string);
	public function error($string);
}