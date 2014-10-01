<?php namespace Devise\Languages;

use Language;

class LanguageDetector
{
	protected $LocaleDetector, $Language;

	public function __construct(LocaleDetector $LocaleDetector, Language $Language)
	{
		$this->LocaleDetector = $LocaleDetector;
		$this->Language = $Language;
	}

	/**
	 * Get the current language for the locale
	 * this will probably use the cookie as default
	 *
	 * @return Language
	 */
	public function current()
	{
		$locale = $this->LocaleDetector->current();

		$language = $this->Language->where('active', 1)->where('code', $locale)->first();

		// this language is not active, so let's the locale
		// to be something different, like the default one
		if (!$language)
		{
			$locale = $this->LocaleDetector->universal();
			$this->LocaleDetector->update($locale);
			$language = $this->Language->where('code', $locale)->first();
		}

		return $language;
	}

	/**
	 * Update the current language for this
	 * browser
	 *
	 * @param  Language $language
	 * @return void
	 */
	public function update($language)
	{
		$this->LocaleDetector->update($language->code);
	}
}