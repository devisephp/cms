<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;
use Devise\Templates\TemplatesManager;

/**
 * Class TemplateScaffolding
 * @package Devise\Models\Scaffolding
 */
class TemplateScaffolding {

	/**
	 * @param TemplatesManager $TemplatesManager
	 * @param Framework $Framework
     */
	public function __construct(TemplatesManager $TemplatesManager, Framework $Framework)
	{
		$this->TemplatesManager = $TemplatesManager;
		$this->Framework        = $Framework;
	}

	/**
	 * @param $templates
	 * @return bool
     */
	public function insertTemplateConfiguration($templates)
	{
		$inputs = [];
		foreach ($templates as $template => $file) {
			if(is_array($file)) {
				$inputs[] = array_except($file, 'view');
			}
		}

		return $this->TemplatesManager->storeMultipleTemplates($inputs);
	}

	/**
	 * @param $files
	 * @param $constants
	 * @param $fields
	 * @return bool
     */
	public function convertTemplatesAndSave($files, $constants, $fields)
	{
		$this->constants = $constants;

		foreach ($files as $template => $file) {
			$template = $this->Framework->File->get($template);
			$file = (is_array($file)) ? $file['view'] : $file;

			// Check to see that the file doesn't already exist
			if (!$this->Framework->File->isFile($file)) {

				foreach($this->constants as $key => $value) {
					$template = str_replace('*|'.$key.'|*', $value, $template);
				}

				$template = $this->convertFields($template, $fields);
				$template = $this->convertIndexes($template, $fields);
				$template = $this->convertCreateAndUpdateFields('create', $template, $fields);
				$template = $this->convertCreateAndUpdateFields('update', $template, $fields);

				$this->Framework->File->put($file, $template);
			}
		}

		return true;
	}


	/**
	 * @param $type
	 * @param $template
	 * @param $fields
	 * @return mixed
     */
	protected function convertCreateAndUpdateFields($type, $template, $fields)
	{
		if (str_contains($template, '*|'.$type.'Fields|*')) {

			$replacement = '';
			$tab = '            ';
			$ignoreFields = ['id', 'created_at', 'updated_at', 'deleted_at'];

			foreach($fields as $field) {
				if ((!isset($field[$type]) || $field[$type] !== false) && !in_array($field['name'], $ignoreFields) ) {

					$replacement .= $tab . '$' . $this->constants['singularVar'] . "->". $field['name'] . ' = $input[\''. $field['name'] ."'];" . PHP_EOL;
				}
			}

			$template = str_replace('*|'.$type.'Fields|*', $replacement, $template);
		}

		return $template;
	}

	/**
	 * @param $template
	 * @param $fields
	 * @return mixed
     */
	protected function convertIndexes($template, $fields)
	{
		if (str_contains($template, '*|indexHeaders|*') || str_contains($template, '*|indexFields|*') ) {

			$replacementHeaders = '';
			$replacementFields = '';
			$tab = '    ';

			foreach($fields as $field) {
				if (isset($field['displayIndex']) && $field['displayIndex'] === true) {

					$replacementHeaders .= $tab . '<th><?= Sort::link(\'' . $field['name'] . '\') ?></th>' . PHP_EOL;

					$replacementFields  .= $tab . $tab . "<td><?= $" . $this->constants['singularVar'] . "['". $field['name'] ."'] ?></td>" . PHP_EOL;
				}
			}

			$template = str_replace('*|indexHeaders|*', $replacementHeaders, $template);
			$template = str_replace('*|indexFields|*',  $replacementFields, $template);

		}

		return $template;
	}

	/**
	 * @param $template
	 * @param $fields
	 * @return mixed
     */
	protected function convertFields($template, $fields)
	{
		if (str_contains($template, '*|fields|*')) {

			$replacement = '';
			$tab = '    ';

			foreach($fields as $field) {
				if (!isset($field['displayForm']) || $field['displayForm'] !== false) {
					$replacement .= $tab . '<div class="dvs-form-group">' . PHP_EOL;

					$replacement .= $tab . $tab . $this->getLabel($field) . PHP_EOL;
					$replacement .= $tab . $tab . $this->getField($field) . PHP_EOL;

					$replacement .= $tab . '</div>' . PHP_EOL;
				}
			}

			$template = str_replace('*|fields|*', $replacement, $template);
		}

		return $template;
	}

	/**
	 * @param $field
	 * @return string
     */
	private function getLabelText($field)
	{
		return ucwords( str_replace('_', ' ',
			snake_case($field['name'])
		));
	}

	/**
	 * @param $field
	 * @return string
     */
	private function getLabel($field)
	{
		$labelText = (isset($field['label'])) ?

					$field['label'] :

					$this->getLabelText($field);

		return "<?= Form::label('" . $labelText . "') ?>";
	}

	/**
	 * @param $field
	 * @return string
     */
	private function getField($field)
	{
		$default = isset($field['default']) ? $field['default'] : 'null';
		$options = isset($field['options']) && is_array($field['options']) ? $field['options'] : [];
		$choices = isset($field['choices']) ? $field['choices'] : 'null';
		$type = isset($field['formType']) ? $field['formType'] : $this->getFormTypeFromDataType($field['type']);

		switch($type)
		{
			case 'selectYear':
				return $this->buildSelectYearField($field, $default, $options);
			case 'selectRange':
				return $this->buildSelectRangeField($field, $default, $options);
			break;
			case 'file':
				return $this->buildFileField($field, $options);
			break;
			case 'checkbox' :
				return $this->buildCheckboxField($field, $options, $type);
			break;
			case 'radio' :
				return $this->buildRadioField($field, $options, $type);
			break;
			case 'password' :
				return $this->buildPasswordField($field, $options);
			break;
			case 'image' :
				return $this->buildImageField($field, $options);
				break;
			case 'select' :
				return $this->buildSelectField($field, $default, $options, $choices);
			break;
			default:
				return $this->buildGenericField($field, $default, $options, $type);
			break;
		}
	}

	/**
	 * @param $datatype
	 * @return string
     */
	private function getFormTypeFromDataType($datatype)
	{
		$datatype = is_array($datatype) ? $datatype[0] : $datatype;

		switch($datatype) {
			case 'binary':
				return 'checkbox';
			break;
			case 'enum':
				return 'select';
			break;
			case 'longText':
			case 'text':
				return 'textarea';
			break;
			default:
				return 'text';
			break;
		}
	}

	/**
	 * @param $field
	 * @param $default
	 * @param $options
	 * @return string
     */
	private function buildSelectRangeField($field, $default, $options)
	{
		$begin = is_array($field['begin']) ? $field['begin'] : 'null';
		$end   = is_array($field['end'])   ? $field['end']   : 'null';

		return "<?= Form::selectRange('" . $field['name'] . "', " . $begin . ", " . $end . ", " . $default . ", ".  var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $options
	 * @param $type
	 * @return string
     */
	private function buildRadioField($field, $options, $type)
	{
		$value = is_array($field['value']) ? $field['value'] : 'null';
		$checked = is_array($field['checked']) ? $field['checked'] : 'null';

		return "<?= Form::radio('" . $field['name'] . "', '". $value . "', ". $checked . ", ".  var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $options
	 * @param $type
	 * @return string
     */
	private function buildCheckboxField($field, $options, $type)
	{
		$value = is_array($field['value']) ? $field['value'] : 1;
		$checked = is_array($field['checked']) ? $field['checked'] : 'null';

		return "<?= Form::checkbox('" . $field['name'] . "', '". $value . "', ". $checked . ", ".  var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $options
	 * @return string
     */
	private function buildFileField($field, $options)
	{
		return "<?= Form::file('" . $field['name'] . "', ".  var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $options
	 * @return string
     */
	private function buildPasswordField($field, $options)
	{
		return "<?= Form::password('" . $field['name'] . "', ".  var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $default
	 * @param $options
	 * @param $choices
	 * @return string
     */
	private function buildSelectField($field, $default, $options, $choices)
	{
		return "<?= Form::select('" . $field['name'] . "', " . var_export($choices, true) . ", '" . $default . "', ". var_export($options, true) . ") ?>";
	}

	/**
	 * @param $field
	 * @param $default
	 * @param $options
	 * @param $type
	 * @return string
     */
	private function buildGenericField($field, $default, $options, $type)
	{
		return "<?= Form::" . $type . "('" . $field['name'] . "', '" . $default . "', ".  var_export($options, true) . ") ?>";
	}

	private function buildImageField($field, $default, $options, $type)
	{
		return "<?= Form::" . $type . "('" . $field['name'] . "', '" . $default . "', ".  var_export($options, true) . ") ?>";
	}
}