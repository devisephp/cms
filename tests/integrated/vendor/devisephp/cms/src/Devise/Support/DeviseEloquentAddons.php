<?php namespace Devise\Support;

trait DeviseEloquentAddons
{
	/**
	 * Lets us get a new instance populated with old input
	 * if there is any input
	 *
	 * @return EloquentModel
	 */
	public function newInstanceWithOldInput()
	{
		$instance = new static;
		foreach (\Input::old() as $key => $value)
		{
			if (\Schema::hasColumn($instance->getTable(), $key))
			{
				$instance->$key = $value;
			}
		}
		return $instance;
	}
}