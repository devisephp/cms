<?php

namespace Devise\Traits;

use Illuminate\Support\Str;

trait Sliceable
{
    use Filterable, Sortable;

    private $sliceInstance;

    public function getSliceData($sliceInstance)
    {
        $this->sliceInstance = $sliceInstance;

        $data['metadata'] = [
            'instance_id' => 0,
            'name'        => $sliceInstance->component_name,
            'label'       => $sliceInstance->label,
            'view'        => $sliceInstance->view,
            'model_query' => $sliceInstance->model_query,
            'placeholder' => false,
        ];

        $sliceAccessors = $this->getSliceAccessors();

        foreach ($sliceAccessors as $accessorName)
        {
            $modelFieldName = $this->accessorNameToModelField($accessorName);
            $sliceFieldName = $this->modelFieldToSliceField($modelFieldName);

            $data[$sliceFieldName] = $this->$modelFieldName;
        }

        return $data;
    }

    private function sliceText($text, $options = [])
    {
        $data = [
            'text' => $text
        ];

        return array_merge($data, $options);
    }

    private function sliceTextarea($text, $options = [])
    {
        return $this->sliceText($text, $options);
    }

    private function sliceWysiwgy($text, $options = [])
    {
        return $this->sliceText($text, $options);
    }

    private function sliceImage($image, $options = [])
    {
        if (is_object($image))
        {
            $data = (array)$image;
        } else if (is_array($image))
        {
            $data = $image;
        } else
        {
            $data = ['url' => $image];
        }

        return array_merge($data, $options);
    }

    private function sliceColor($color, $options = [])
    {
        $data = ['color' => $color];

        return array_merge($data, $options);
    }

    private function sliceLink($text, $url, $options = [])
    {
        $data = ['text' => $text, 'href' => $url, '_target' => '_blank'];

        return array_merge($data, $options);
    }

    private function sliceSelect($value, $options = [])
    {
        $data = ['value' => $value];

        return array_merge($data, $options);
    }

    private function sliceCheckbox($value, $options = [])
    {
        $data = ['checked' => $value];

        return array_merge($data, $options);
    }

    private function sliceDatetime($value, $options = [])
    {
        $data = ['text' => $value];

        return array_merge($data, $options);
    }

    private function getSliceAccessors()
    {
        $all = get_class_methods($this);

        $filtered = array_filter(
            $all,
            function ($value) {
                return fnmatch('getSlice*Attribute', $value);
            }
        );

        return $filtered;
    }

    private function accessorNameToModelField($accessorName)
    {
        $accessorName = str_replace('get', '', $accessorName);
        $accessorName = str_replace('Attribute', '', $accessorName);

        return Str::snake($accessorName);
    }

    private function modelFieldToSliceField($modelField)
    {
        $modelField = str_replace('slice_', '', $modelField);

        return lcfirst(Str::studly($modelField));
    }
}