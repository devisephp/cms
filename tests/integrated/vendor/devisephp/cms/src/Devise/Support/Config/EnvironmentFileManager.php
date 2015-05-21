<?php namespace Devise\Support\Config;

use Devise\Support\Framework;

/**
 * SettingsManager is used to update the config overrides file
 * which allows an admin to override any config variable in devise
 *
 */
class EnvironmentFileManager
{
	/**
	 * Create a new settings manager
	 *
	 * @param Framework $Framework
	 */
	public function __construct(Framework $Framework, $envFile = null)
	{
		$this->files = $Framework->File;
		$this->basePath = $Framework->Container->basePath();
		$this->envFile = $envFile ?: $this->basePath . '/.env';
	}

	/**
	 * This will save the settings to the env file
	 *
	 * @param  array  $settings
	 * @return array
	 */
	public function save(array $settings)
	{
		$contents = "";
		$newline = "";

		foreach ($settings as $key => $value)
		{
			$contents .= is_numeric($key) ? $newline . $value : $newline . "{$key}={$value}";
			$newline = PHP_EOL;
		}

		file_put_contents($this->envFile, $contents);

		return $settings;
	}

	/**
	 * Merge in environment settings
	 *
	 * @param  array  $settings
	 * @return [type]
	 */
	public function merge(array $settings)
	{
		$merged = array_merge($this->get(null, false), $settings);

		return $this->save($merged);
	}

    /**
     * Checks for existence of .env file, if not
     * it creates a new one.
     *
     * @return void
     */
    public function createIfNotExists()
    {
        if(!$this->files->exists($this->envFile)) {
            $this->save(['APP_DEBUG' => true]);
        }
    }

	/**
	 * Extract the settings from the env file
	 * it should be in format DB_HOST=something
	 * and take up no more than one line
	 *
	 * @param  string  $file
	 * @param  boolean $settingsOnly
	 * @return array
	 */
	public function get($file = null, $settingsOnly = true)
	{
		$settings = [];

		$envFile = $file ?: $this->envFile;

		if (!file_exists($envFile)) return $settings;

		$contents = file_get_contents($envFile);

		$lines = explode(PHP_EOL, $contents);

		foreach ($lines as $line)
		{
			$lineParts = explode("=", $line);

			if (count($lineParts) == 2)
			{
				$key = array_shift($lineParts);
				$settings[$key] = implode('=', $lineParts);
			}
			else if (!$settingsOnly)
			{
				$settings[] = $line;
			}
		}

	    return $settings;
	}
}