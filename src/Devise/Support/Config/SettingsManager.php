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
	public function update($settings)
	{
		$contents = $this->prettyVarExport($settings);

		$this->files->put($this->overridesFile, $contents);
	}

	/**
	 * Merges these settings in with the other settings from
	 * the overrides config file
	 *
	 * @param  array $settings
	 * @return void
	 */
	public function merge($settings)
	{
		$merged = array_merge(require $this->overridesFile, $settings);

		$contents = $this->prettyVarExport($merged);

		$this->files->put($this->overridesFile, $contents);
	}

	/**
	 * [prettyVarExport description]
	 * @param  [type] $content
	 * @return [type]
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
}