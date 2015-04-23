<?php namespace Devise\Pages\Fields;

class DvsMagicMode
{
	/**
	 * [$enabled description]
	 * @var boolean
	 */
	protected $enabled = false;

	/**
	 * [enable description]
	 * @param  [type] $shouldEnable
	 * @return [type]
	 */
	public function enable()
	{
		$this->enabled = true;
	}

	/**
	 * [disable description]
	 * @param  boolean $shouldDisable
	 * @return [type]
	 */
	public function disable()
	{
		$this->enabled = false;
	}

	/**
	 * [enabled description]
	 * @return [type]
	 */
	public function enabled()
	{
		return $this->enabled;
	}

	/**
	 * [disabled description]
	 * @return [type]
	 */
	public function disabled()
	{
		return !$this->enabled;
	}

	/**
	 * [live description]
	 * @param  [type] $value
	 * @param  [type] $name
	 * @param  [type] $parent
	 * @return [type]
	 */
	public function live($value, $name, $parent)
	{
		if ($this->disabled() || !$parent) return $value;

		if ($parent instanceof \Devise\Pages\Fields\LiveFieldValue)
		{
			return $this->liveField($value, $name, $parent);
		}

		if ($parent instanceof \Eloquent)
		{
			return $this->liveModel($value, $name, $parent);
		}

		return $value;
	}

	/**
	 * [liveModel description]
	 * @param  [type] $value
	 * @param  [type] $name
	 * @param  [type] $parent
	 * @return [type]
	 */
	protected function liveModel($value, $attribute, $model)
	{
		$type = get_class($model);

		$id = $model->getKey();

		$key = "{$type}-{$id}-{$attribute}";

		\App::make('dvsPageData')->database($key, $value);

		return "###dvsmagic-{$key}###";
	}

	/**
	 * [liveField description]
	 * @param  [type] $value
	 * @param  [type] $name
	 * @param  [type] $parent
	 * @return [type]
	 */
	protected function liveField($value, $name, $parent)
	{
		$value = is_a($value, 'Devise\Pages\Fields\LiveFieldValue') ? '' : $value;

		$key = $parent->__type() . '-' . $parent->__id() . '-' . $name;

		\App::make('dvsPageData')->database($key, $value);

		return "###dvsmagic-{$key}###";
	}

}