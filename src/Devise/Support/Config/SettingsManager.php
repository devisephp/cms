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
	 * [__construct description]
	 * @param Framework $Framework
	 */
	public function __construct(Framework $Framework)
	{
		$this->files = $Framework->File;
		$this->overridesFile = $Framework->Container->make('config.overrides.file');
	}

	/**
	 * [update description]
	 * @param  [type] $settings
	 * @return [type]
	 */
	public function update($settings)
	{
		$contents = $this->prettyVarExport($settings);

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