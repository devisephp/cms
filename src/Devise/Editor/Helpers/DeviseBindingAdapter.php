<?php namespace Devise\Editor\Helpers;

use Devise\Fields\FieldValidation;

/**
 * Purpose of this class is to scan and change things in the view
 * where it finds the string data-devise="..."
 *
 */
class DeviseBindingAdapter
{
	protected $FieldValidation;

	public function __construct(FieldValidation $FieldValidation)
	{
		$this->FieldValidation = $FieldValidation;
	}

	/**
	 * Compile a blade view for the data-devise html data bindings
	 *
	 * @param  string $view
	 * @return string
	 */
	public function compile($view)
	{
		$matches = $this->findMatches($view);

		// if there are no matches then don't do anything else
		if (count($matches) > 0)
		{
			$this->assertKeysAreValid($matches, $view);
			$view = $this->replaceDataDeviseTags($matches, $view);
			$view = $this->injectDeviseBindings($matches, $view);
			$view = $this->injectDeviseCollections($matches, $view);
		}

		return $view;
	}

    /**
     * Assert that these keys are valid
     *
     * @param $matches
     * @param $view
     * @throws \Devise\Fields\Exceptions\InvalidFieldKeyException
     * @internal param $ [type] $matches [description]
     * @internal param $ [type] $view    [description]
     * @return void [type]          [description]
     */
	protected function assertKeysAreValid($matches, $view)
	{
		foreach ($matches as $match)
		{
			// get the line number in the string to help the developer quickly
			// find where the error occurred at...
			$content_before_string = strstr($view, $match['key'], true);
			$lineNumber = count(explode(PHP_EOL, $content_before_string));
			$this->FieldValidation->assertValidKey($match['key'], "Invalid key {$match['key']} provided to data-devise around line {$lineNumber}");
		}
	}

	/**
	 * Adds the javascript helper function to the view
	 * so we can work with variables on this page
	 *
	 * @param array  $matches
	 * @param string $view
	 * @return  string
	 */
	protected function injectDeviseBindings($matches, $view)
	{
		$json = '';

		foreach ($matches as $replacement => $values)
		{
			if (!$this->isCollectionKey($values['key']))
			{
				$json .= $json ? ',' . json_encode($values): json_encode($values);
			}
		}

		$json = str_replace("'", "\'", $json);

		$registerIocSingleton = "<?php App::make(\"deviseDataJavascriptBindings\")->merge('[{$json}]'); ?>";

		return $view . PHP_EOL . $registerIocSingleton . PHP_EOL;
	}

	/**
	 * Adds the javascript helper function to the view
	 * so we can work with variables on this page
	 *
	 * @param array  $matches
	 * @param string $view
	 * @return  string
	 */
	protected function injectDeviseCollections($matches, $view)
	{
		$json = array();

		foreach ($matches as $replacement => $values)
		{
			if ($this->isCollectionKey($values['key']))
			{
				list($collectionName, $fieldName) = $this->getCollectionKeys($values['key']);

				$json[$collectionName] = isset($json[$collectionName]) ? $json[$collectionName] : array();

				$values['key'] = $fieldName;

				$json[$collectionName][] = $values;
			}
		}

		$json = json_encode($json);
		$json = str_replace("'", "\'", $json);

		$registerIocSingleton = "<?php App::make(\"deviseDataJavascriptCollections\")->merge('{$json}'); ?>";

		return $view . PHP_EOL . $registerIocSingleton . PHP_EOL;
	}

	/**
	 * [getCollectionKey description]
	 *
	 * @param  [type] $key [description]
	 *
	 * @return array [type]      [description]
	 */
	protected function getCollectionKeys($key)
	{
		$parts = explode('[', $key);
		$collectionName = array_shift($parts);
		$nextPart = explode(']', $parts[0]);
		$fieldName = array_shift($nextPart);

		return array($collectionName, $fieldName);
	}

	/**
	 * Is this key a special type of key called a collection key
	 * collection keys look like this: 'someName[fieldName]' where
	 * normal keys look like this: 'fieldName'
	 *
	 * @param  string  $key
	 * @return boolean
	 */
	protected function isCollectionKey($key)
	{
		return strpos($key, '[') !== false && strpos($key, ']') === strlen($key) - 1;
	}

	/**
	 * Replace data-devise="..." tags with the data-dvs-keyname-id="keyname"
	 *
	 * @param  array $matches
	 * @param  string $view
	 * @return string
	 */
//	protected function replaceDataDeviseTags($matches, $view)
//	{
//		foreach ($matches as $replacement => $match)
//		{
//			$key = str_replace('[', '-', $match['key']);
//			$key = str_replace(']', '', $key);
//   			$view = str_replace($replacement, " data-dvs-{$key}-id=\"{$key}\"", $view);
//		}
//
//		return $view;
//	}

	protected function replaceDataDeviseTags($matches, $view)
	{

		foreach ($matches as $replacement => $match)
		{
			$key = $match['key'];


            $collectionName = '';
			if ($this->isCollectionKey($key)) {
				$pattern = '/(.*)\[(.*)\]/';
				preg_match($pattern, $key, $collectionMatch);
                $collectionName = $collectionMatch[1];
				$key = $collectionMatch[2];
			}


			$view = str_replace($replacement, " data-dvs-".strtolower($key)."-id=\"{$collectionName}{$key}\"", $view);
		}


		return $view;
	}

	/**
	 * Find the matches where we have data-devise attributes
	 *
	 * @param   string $view
	 * @return  array
	 */
	protected function findMatches($view)
	{
		$merged = array();

		$pattern = "/ data-devise(-[0-9]+)?=[\"|']([^\"']*)[\"|']/";
		preg_match_all($pattern, $view, $matches);

		foreach ($matches[0] as $index => $match)
		{
			$csv = $matches[2][$index];
			$merged[$match] = $this->parseFieldParameters($csv);
		}

		return $merged;
	}

	/**
	 * Converts the csvParams from csv format into an
	 * array of key/value pairs for structured data
	 *
	 * @param  string $csvParams
	 * @return array
	 */
	protected function parseFieldParameters($csvParams)
	{
		$params = str_getcsv($csvParams, ',', '\'');

		foreach ($params as $index => $param)
		{
			$params[$index] =  str_replace("'", "\'", trim($params[$index]));
		}

		$organized = array();
		$organized['key'] = $params[0];
		$organized['type'] = $params[1];
		$organized['humanName'] = isset($params[2]) && $params[2] && $params[2] !== 'null' ? $params[2] : ucfirst($params[1]);
		$organized['group'] = isset($params[3]) && $params[3] && $params[3] !== 'null' ? $params[3] : null;
		$organized['category'] = isset($params[4]) && $params[4] && $params[4] !== 'null' ? $params[4] : null;
		$organized['alternateTarget'] = isset($params[5]) && $params[5] && $params[5] !== 'null' ? $params[5] : null;

		return $organized;
	}
}