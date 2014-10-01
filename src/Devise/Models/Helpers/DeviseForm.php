<?php namespace Devise\Models\Helpers;

use Illuminate\Html\FormBuilder;
use DeviseArray;
use Event;

/**
 * Class DeviseForm
 * @package Devise\Devise\Helpers
 */
class DeviseForm extends FormBuilder {

    /**
     * @var
     */
    private $convertNames = true;

    /**
     * @var
     */
    private $originalName;

    /**
     * @var
     */
    private $value;

    /**
     * Create a new model based form builder.
     *
     * @param  mixed  $model
     * @param  array  $options
     * @return string
     */
    public function model($model, array $options = array())
    {
        $model = ($model) ? $model->toArray() : array();
        if(isset($options['convert_names']) && $options['convert_names'] === false){
            $this->convertNames = false;
        }
        return parent::model($model, $options);
    }

    /**
     * Open up a new HTML form.
     *
     * @param  array   $options
     * @return string
     */
    public function open(array $options = array())
    {
        Event::fire('form.open', array($options));
        if(isset($options['convert_names']) && $options['convert_names'] === false){
            $this->convertNames = false;
        }
        return parent::open($options);
    }

    /**
     * Close the current form.
     *
     * @return string
     */
    public function close($options = array())
    {
        $result = Event::fire('form.close');
        return parent::close();
    }

    /**
     * @param string $type
     * @param string $name
     * @param null $value
     * @param array $options
     * @return string
     */
    public function input($type, $name, $value = null, $options = array())
    {
        Event::fire('form.input', array(array('type' => $type, 'name' => $name, 'options' => $options)));
        $this->originalName = $name;
        $this->value = $value;

        $name = $this->processName($name);

        return parent::input($type, $name, $value, $options);
    }

    /**
     * @param string $name
     * @param null $value
     * @param array $options
     * @return string
     */
    public function secure($name, $value = null, $options = array())
    {
        Event::fire('form.input', array(array('type' => 'secure', 'name' => $name, 'value' => $value)));
        $this->originalName = $name;
        $this->value = $value;

        $name = $this->processName($name);

        return parent::input('hidden', $name, $value, $options);
    }

    /**
     * Create a textarea input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function textarea($name, $value = null, $options = array())
    {
        Event::fire('form.input', array(array('type' => 'textarea', 'name' => $name)));
        $this->originalName = $name;
        $this->value = $value;

        $name = $this->processName($name);

        return parent::textarea($name, $value, $options);
    }

    /**
     * Create a select box field.
     *
     * @param  string  $name
     * @param  array   $list
     * @param  string  $selected
     * @param  array   $options
     * @return string
     */
    public function select($name, $list = array(), $selected = null, $options = array())
    {
        Event::fire('form.input', array(array('type' => 'select', 'name' => $name)));
        $this->originalName = $name;
        $this->value = $selected;

        $name = $this->processName($name);

        return parent::select($name, $list, $selected, $options);
    }

    /**
     * @param string $name
     * @return mixed|string
     */
    private function processName($name)
    {
        if($this->convertNames){
            $newName = $name;

            if (strpos($name, '.') !== false )
            {
                $nameParts = explode('.', $name);
                $model = array_shift($nameParts);
                $field = array_pop($nameParts);
                $newName = $model;

                if (count($nameParts) > 0)
                {
                    $relations = $nameParts;

                    foreach($relations as $relation)
                    {
                        $newName .= $this->checkPartForArray($relation);
                    }
                }

                $newName .= $this->checkPartForArray($field);
            }

            return $newName;
        } else {
            return $name;
        }
    }

    /**
     * Create a checkable input field.
     *
     * @param  string  $type
     * @param  string  $name
     * @param  mixed   $value
     * @param  bool    $checked
     * @param  array   $options
     * @return string
     */
    protected function checkable($type, $name, $value, $checked, $options)
    {
        $this->value = $value;
        $name = $this->processName($name);
        return parent::checkable($type, $name, $value, $checked, $options);
    }

    /**
     * @param $part
     * @return mixed|string
     */
    private function checkPartForArray($part)
    {
        if (strpos($part, '[') !== false && strpos($part, ']') !== false)
        {
            return preg_replace('/(.*)[\[](.*)[\]]/', '[$1][$2]', $part);
        }

        return '['.$part.']';
    }

    /**
     * Get the model value that should be assigned to the field.
     *
     * @param  string  $name
     * @return string
     */
    protected function getModelValueAttribute($name)
    {
        if (isset($this->model)) {
            if (preg_match('/\[(.*?)\]/', $name)) {
                preg_match_all('/\[(.*?)\]/', $name, $matches);

                $value = $this->getModelValue($this->model, $matches[1]);

                return $value;
            } elseif (is_object($this->model)) {
                return object_get($this->model, $this->transformKey($name));
            } elseif (is_array($this->model)) {
                return array_get($this->model, $this->transformKey($name));
            }
        }
    }

    /**
     * @param $arr
     * @param $keys
     * @param int $index
     * @return bool|string
     */
    private function getModelValue($arr, $keys, $index = 0)
    {
        if (count($keys) == 0 || !isset($arr[$keys[$index]])) {
            if (is_array($arr) && count(DeviseArray::numericKeys($arr)) > 0)
            {
                foreach($arr as $key => $record)
                {
                    if ($record['id'] == $this->value)
                    {
                        return true;
                    }
                }
            }
            return '';
        }

        if (count($keys) > 0 && is_array($arr[$keys[$index]])) {
            return $this->getModelValue($arr[$keys[$index]], $keys, ++$index);
        }

        return $arr[$keys[$index]];
    }
}