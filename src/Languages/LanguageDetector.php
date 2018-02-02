<?php namespace Devise\Languages;

use Devise\Models\DvsLanguage;

/**
 * Language detector is used to determine the current and
 * universal languages for this system. It uses LocaleDetector
 * to get the universal code, i.e 'en', 'es', and then fetches
 * the DvsLanguage from the database
 */
class LanguageDetector
{
	/**
	 * Protected fields for this class
	 *
	 * @var Devise\Languages\LocaleDetector
	 * @var Devise\Languages\Language
	 */
	protected $LocaleDetector, $Language;

	/**
	 * Create a new Language Detector
	 *
	 * @param LocaleDetector $LocaleDetector
	 * @param Language       $Language
	 */
	public function __construct(LocaleDetector $LocaleDetector, DvsLanguage $Language, $Config = null)
	{
		$this->LocaleDetector = $LocaleDetector;
		$this->Language = $Language;
        $this->Config = $Config ?: \Config::getFacadeRoot();
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
	 * Get the universal language that we fallback
	 * to... which is likely english because that
	 * is the default in laravel's Config::get(app.locale)
	 *
	 * @return Language
	 */
	public function universal()
	{
		$locale = $this->LocaleDetector->universal();

		return $this->Language->where('code', $locale)->first();
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

    /**
     * Returns the primary language id for this system
     *
     * @return integer
     */
    public function primaryLanguageId()
    {
        return $this->Config->get('devise.languages.primary_language_id');
    }
}