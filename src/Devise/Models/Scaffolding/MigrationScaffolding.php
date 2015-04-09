<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;
use \Artisan;
use \Schema;

/**
 * Class MigrationScaffolding
 * @package Devise\Models\Scaffolding
 */
class MigrationScaffolding {

	/**
	 * These are the constants built upon the name of 
	 * model we are building 
	 * @var array
	 */
	protected $constants;

	/**
	 * Fields of the model
	 * @var array
	 */
	protected $fields;

	/**
	 * Constructor - initialize and inject the framework
	 * @param Framework $Framework 
	 */
	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
	}

	/**
	 * The primary initialization for building migrations
	 * @param  array $constants 
	 * @param  array $fields    
	 * @return bool            Did we make migrations or not?
	 */
	public function buildAndRun($constants, $fields)
	{
		$this->constants = $constants;
		$this->fields = $fields;

		if ($this->tableDoesNotExist()) {
			if($this->buildMigration()) {
				return $this->runMigration();
			}
		}

		return false;
	}

	/**
	 * @return mixed
     */
	public function runMigration()
	{
		return Artisan::call('migrate');
	}

	/**
	 * @return string
     */
	public function getMigrationTemplatePath()
	{
		return base_path() . '/vendor/devisephp/cms/src/scaffolding/migrations/create_model.txt';
	}

	/**
	 * @return string
     */
	public function getTargetFilePath()
	{
		return base_path() . '/database/migrations/' . date('Y_m_d_His') . '_create_'. $this->constants['snakeCasePlural'] .'.php';
	}

	/**
	 * @param $targetFile
	 * @param $template
	 * @return mixed
	 */
	public function saveMigration($targetFile, $template)
	{
		return $this->Framework->File->put($targetFile, $template);
	}

	/**
	 * @return bool
     */
	private function tableDoesNotExist()
	{
		return Schema::hasTable($this->constants['snakeCasePlural']) !== true;
	}

	/**
	 * @return mixed
     */
	private function buildMigration()
	{
		$migrationTemplate = $this->getMigrationTemplatePath();
		$targetFile = $this->getTargetFilePath();;

		$template = $this->Framework->File->get($migrationTemplate);

		foreach($this->constants as $key => $value) {
			$template = str_replace('*|'.$key.'|*', $value, $template);
		}

		$template = $this->convertFields($template);

		return $this->saveMigration($targetFile, $template);
	}

	/**
	 * @param $template
	 * @return mixed
     */
	private function convertFields($template)
	{
		// Build Fields
		$replacement = $this->buildFields();
		
		// Build Indexes
		$replacement .= $this->buildIndexes();

		// Replace the migrationFields variable with what we've built
		$template = str_replace('*|migrationFields|*', $replacement, $template);

		return $template;
	}

	/**
	 * @return string
     */
	private function buildFields()
	{
		$replacementFields = '';
		$tab = '                ';

		foreach($this->fields as $field) {

			$type = is_array($field['type']) ? $field['type'][0] : $field['type'];
			$type = ($type !== "") ?: $type = "string";

			$default = isset($field['default']) ? "->default('".$field['default']."')" : '';
			$nullable = (isset($field['nullable']) && $field['nullable'] === true) ? "->nullable()" : "";

			$parameters = $this->buildParameters($field);

			$replacementFields .= $tab . '$table->'.$type."('". $field['name'] . "'" . $parameters .")" . $default . $nullable . ";" . PHP_EOL;
		}

		return $replacementFields;
	}

	/**
	 * @return string
     */
	private function buildIndexes()
	{
		$replacementIndexes = "";
		$tab = '                ';

		foreach($this->fields as $field) {
			if (isset($field['index'])) {
				$replacementIndexes .= $tab . '$table->' . $field['index'] ."('".$field['name']."');";
			}
		}

		return $replacementIndexes;
	}

	/**
	 * @param $field
	 * @return string
     */
	private function buildParameters($field)
	{
		$parameters = '';

		if (is_array($field['type'])) {
			foreach(array_slice($field['type'], 1) as $param) {
				$parameters .= ", " . $param;
			}
		}

		return $parameters;
	}
}