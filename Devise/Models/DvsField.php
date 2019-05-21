<?php

namespace Devise\Models;

use Devise\Traits\HasJsonImage;

use Illuminate\Support\Facades\Route;

class DvsField extends Model
{
    use HasJsonImage;

    protected $table = 'dvs_fields';

    protected $fillable = ['slice_instance_id', 'key', 'json_value', 'content_requested'];

    protected $touches = ['sliceInstance'];

    public $shouldMutateJson = true;

    public function sliceInstance()
    {
        return $this->belongsTo(DvsSliceInstance::class, 'slice_instance_id');
    }

    public function getValueAttribute()
    {
        $json = $this->json_value ?: '{}';

        $value = json_decode($json);

        if ($value)
        {
            if ($this->shouldMutateJson)
            {
                $this->insertId($value);
                $this->insertHrefForLinks($value);
                $this->updateImageUrlsToStorage($value);
                $this->updateImageAlt($value);

                return $this->simplify($value);
            } else
            {
                return (array)$value;
            }
        }

        return new \stdClass();
    }

    public function getOriginalImageAttribute()
    {
        $value = $this->value;

        return ((isset($value['media']) && isset($value['media']->original))) ? (string)$value['media']->original : (string)$value['url'];
    }

    private function insertId(&$value)
    {
        if (is_object($value))
        {
            $value->id = $this->id;
        }
    }

    private function insertHrefForLinks(&$value)
    {
        if (isset($value->type) && $value->type == 'link')
        {
            if (isset($value->routeName)
                && $value->type == 'link'
                && $value->mode == 'page'
                && Route::has($value->routeName))
            {
                $value->href = route($value->routeName);
            } else if (isset($value->mode)
                // legacy fix
                && $value->mode == 'url'
                && $value->url == ''
                && isset($value->href))
            {
                $value->url = $value->href;
            } else
            {
                $value->href = $value->url;
            }
        }
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
                $allowed = ['url', 'media', 'sizes', 'mode', 'settings', 'alt', 'enabled'];
                break;
            case 'text':
            case 'textarea':
            case 'wysiwyg':
            case 'datetime':
            case 'number':
                $allowed = ['text', 'enabled'];
                break;
            case 'link':
                $allowed = ['href', 'text', 'url', 'target', 'mode', 'routeName', 'rel', 'enabled'];
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
            'type',
            'rel'
        ];
    }
}