<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;
use \Artisan;
use \Schema;

class MigrationScaffolding {

	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
	}

	public function buildAndRun($constants, $fields)
	{
		$this->constants = $constants;
		$this->fields = $fields;

		if ($this->tableDoesNotExist()) {
			$this->buildMigration();
			$this->runMigration();
		}
	}

	private function tableDoesNotExist()
	{
		return Schema::hasTable($this->constants['snakeCasePlural']) !== true;
	}

	private function runMigration()
	{
		Artisan::call('migrate');
	}

	private function buildMigration()
	{
		$migrationTemplate = base_path() . '/vendor/devisephp/cms/src/scaffolding/migrations/create_model.txt';
		$targetFile = base_path() . '/database/migrations/' . date('Y_m_d_His') . '_create_'. $this->constants['snakeCasePlural'] .'.php';

		$template = $this->Framework->File->get($migrationTemplate);

		foreach($this->constants as $key => $value) {
			$template = str_replace('*|'.$key.'|*', $value, $template);
		}

		$template = $this->convertFields($template);

		$this->Framework->File->put($targetFile, $template);		
	}

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

	private function buildFields()
	{
		$replacementFields = '';
		$tab = '                ';

		foreach($this->fields as $field) {

			$type = is_array($field['type']) ? $field['type'][0] : $field['type'];
			$default = isset($field['default']) ? "->default('".$field['default']."')" : '';
			$nullable = (isset($field['nullable']) && $field['nullable'] === true) ? "->nullable()" : "";

			$parameters = $this->buildParameters($field);

			$replacementFields .= $tab . '$table->'.$type."('". $field['name'] . "'" . $parameters .")" . $default . $nullable . ";" . PHP_EOL;
		}

		return $replacementFields;
	}

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