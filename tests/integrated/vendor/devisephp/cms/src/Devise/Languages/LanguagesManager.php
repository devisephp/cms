<?php namespace Devise\Languages;

/**
 * The languages manager allows us to manage
 * the all things related to DvsLanguage model
 */
class LanguagesManager
{
	/**
	 * Uses the DvsLanguage model to look
	 * manage dvs_languages table
	 *
	 * @var DvsLanguage
	 */
	protected $Language;

    /**
     * Construct a new language manager
     *
     * @param \DvsLanguage $Language
     */
	public function __construct(\DvsLanguage $Language)
	{
		$this->Language = $Language;
	}

    /**
     * Updates the active field of a language
     *
     * @param $id
     * @param $isActive
     * @internal param array $input
     * @return $this
     */
	public function modifyActiveFlag($id, $isActive)
	{
		$language = $this->Language->findOrFail($id);
		$language->active = $isActive === 'true' || $isActive === true || $isActive === 1;
		$language->save();

		return $this;
	}
}