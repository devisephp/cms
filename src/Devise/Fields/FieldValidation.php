<?php namespace Devise\Fields;

use Devise\Fields\Exceptions\InvalidFieldKeyException;

class FieldValidation
{
	public function assertValidKey($key, $message = null)
	{
		$message = $message ?: "Invalid key provided " . $key;

		//
		// is this key is valid php?
		//
		if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $key)) return;

		//
		// see if this is a collection field type
		// which is something like collectionName[fieldName]
		//
		$parts = explode('[', $key);

		if (count($parts) > 1)
		{
			$collectionName = array_shift($parts);
			$nextPart = count($parts) > 0 ? explode(']', $parts[0]) : array('#invalid$variableNAME');
			$fieldName = array_shift($nextPart);

			$this->assertValidKey($collectionName, $message);
			$this->assertValidKey($fieldName, $message);

			return;
		}

		throw new InvalidFieldKeyException($message);
	}
}