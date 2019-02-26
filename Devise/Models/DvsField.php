<?php

namespace Devise\Models;

class DvsField extends Model
{
    protected $table = 'dvs_fields';

    protected $fillable = ['slice_instance_id', 'key', 'json_value', 'content_requested'];

    public function sliceInstance()
    {
        return $this->belongsTo(DvsSliceInstance::class, 'slice_instance_id');
    }

    public function getValueAttribute()
    {
        $json = $this->json_value ?: '{}';

        $value = json_decode($json);

        return ($value) ? $this->simplify($value) : new \stdClass();
    }

    public function simplify($value)
    {
        $value = is_object($value) ? (array)$value : $value;

        if (isset($value['type']))
        {
            $remove = $this->getRemoveList($value['type']);

            return array_except($value, $remove);
        }

        return $value;
    }

    /**
     * image:
     * url, media, enabled, sizes, mode, settings, type
     *
     * text, textarea, wysiwyg, datetime, number:
     * text, enabled, type
     *
     * link:
     * text, url, target, mode, routeName, type, enabled
     *
     * file:
     * url, type, enabled
     *
     * checkbox:
     * checked, type, enabled
     *
     * color:
     * color, type, enabled
     *
     * select:
     * value, enabled
     *
     */
    private function getRemoveList($fieldType)
    {
        switch ($fieldType)
        {
            case 'image':
                $allowed = ['url', 'media', 'sizes', 'mode', 'settings', 'enabled'];
                break;
            case 'text':
            case 'textarea':
            case 'wysiwyg':
            case 'datetime':
            case 'number':
                $allowed = ['text', 'enabled'];
                break;
            case 'link':
                $allowed = ['text', 'url', 'target', 'mode', 'routeName', 'enabled'];
                break;
            case 'file':
                $allowed = ['url', 'enabled'];
                break;
            case 'checkbox':
                $allowed = ['checked', 'enabled'];
                break;
            case 'color':
                $allowed = ['color', 'enabled'];
                break;
            case 'select':
                $allowed = ['value', 'enabled'];
                break;
            default:
                $allowed = [];
                break;
        }

        return array_diff($this->getAllDeviseKeys(), $allowed);
    }

    private function getAllDeviseKeys()
    {
        return [
            'default',
            'id',
            'href',
            'label',
            'text',
            'url',
            'media',
            'enabled',
            'sizes',
            'mode',
            'settings',
            'target',
            'mode',
            'routeName',
            'checked',
            'color',
            'value',
            'enabled',
            'type'
        ];
    }
}