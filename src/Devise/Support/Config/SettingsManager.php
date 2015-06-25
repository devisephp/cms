<?php namespace Devise\Support\Config;

use Devise\Support\Framework;

/**
 * SettingsManager is used to update the config overrides file
 * which allows an admin to override any config variable in devise
 *
 */
class SettingsManager
{
	/**
	 * Create a new settings manager
	 *
	 * @param Framework $Framework
	 */
	public function __construct(Framework $Framework, $overridesFile = null)
	{
		$this->files = $Framework->File;
		$this->basePath = $Framework->Container->basePath();
		$this->overridesFile = $overridesFile ?: $Framework->Container->make('config.overrides.file');
	}

	/**
	 * Overrides the settings inside of the overrides file
	 * this does not merge... so if you have settings in your
	 * overrides file that aren't in the $settings array they
	 * will be lost. To keep them we need to use the merge()
	 * method instead
	 *
	 * @param  array $settings
	 * @return void
	 */
	public function update(array $settings)
	{
		$contents = $this->varExport($settings);

		$this->files->put($this->overridesFile, $contents);
	}

	/**
	 * Merges these settings in with the other settings from
	 * the overrides config file
	 *
	 * @param  array $settings
	 * @return void
	 */
	public function merge(array $settings)
	{
		$merged = array_merge_values(require $this->overridesFile, $settings);

		$contents = $this->varExport($merged);

		$this->files->put($this->overridesFile, $contents);
	}

	/**
	 * Removes these overrides from the overrides config
	 * so we can go back to whatever defaults we need. Not
	 * being used as far as I know yet, but it could come
	 * in handy soon...
	 *
	 * @param  array  $settings
	 * @return void
	 */
	public function remove(array $settings)
	{
		$overrides = array_merge_values(require $this->overridesFile);

		foreach ($settings as $setting)
		{
			unset($overrides[$setting]);
		}

		$contents = $this->varExport($overrides);

		$this->files->put($this->overridesFile, $contents);
	}

	/**
	 * Makes the variable export to the config file look
	 * pretty and human readable...
	 *
	 * @param  array $content
	 * @return string
	 */
    protected function prettyVarExport($content)
    {
        $arrayRep = var_export($content, true);
        $arrayRep = str_replace('\\\\', "\\", $arrayRep);
        $arrayRep = preg_replace('/[ ]{2}/', "\t", $arrayRep);
        $arrayRep = preg_replace("/\=\>[ \n\t]+array[ ]+\(/", '=> array(', $arrayRep);
        $arrayRep = preg_replace("/\d+ => /", '', $arrayRep);
		$arrayRep = preg_replace("/\n/", "\n\t", $arrayRep);

        return "<?php return " . $arrayRep . ';';
    }

    /**
     * Exports the variable in an uglier version, but doesn't mess
     * with formatting
     *
     * @param  array $content
     * @return string
     */
    protected function varExport($content)
    {
        $arrayRep = var_export($content, true);
        $arrayRep = str_replace("=> 'true'", "=> true", $arrayRep);
        $arrayRep = str_replace("=> 'false'", "=> false", $arrayRep);

        return "<?php return " . $arrayRep . ';';
    }
}