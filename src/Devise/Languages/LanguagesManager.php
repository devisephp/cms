<?php namespace Devise\Languages;

use Language;
use Devise\Common\Manager;

class LanguagesManager extends Manager
{
	protected $Language;

	/**
	 * Construct a new user manager
	 *
	 * @param Language $Language
	 */
	public function __construct(Language $Language)
	{
		$this->Language = $Language;
	}

	/**
	 * Updates the active field of a language
	 *
	 * @param  array $input
	 * @return $this
	 */
	public function patchLanguage($id, $input)
	{
		$language = $this->Language->findOrFail($id);
		$language->active = $input['active'] === "true" || $input['active'] === true;
		$language->save();

		return $this;
	}
}