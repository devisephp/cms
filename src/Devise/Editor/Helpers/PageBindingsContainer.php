<?php namespace Devise\Editor\Helpers;

/**
 * Purpose of this class is to hold on json
 * values for data-devise bindings in the IoC
 * container... those will be spit out in
 * the devise::scripts view...
 *
 */
class PageBindingsContainer extends JsonContainer
{

	/**
	 * Make sure that there are no duplicated keys in
	 * this data now
	 *
	 * @return void
	 */
	protected function assertValidData($data)
	{
		$keys = $this->keysFor($this->data);
		$newKeys = $this->keysFor($data);
		$this->assertNoDuplicateKeys($keys, $newKeys);
	}
}