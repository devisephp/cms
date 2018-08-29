<?php

namespace Devise\Models;

use Devise\Devise;
use Devise\Support\Framework;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DvsPageVersion extends Model
{
    use SoftDeletes;

    protected $table = 'dvs_page_versions';

    protected $fillable = [
        'name',
        'layout',
        'starts_at',
        'ends_at',
        'ab_testing_amount',
        'preview_hash'
    ];

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValuesAttribute()
    {
        return json_decode($this->value);
    }

    public function setStartsAtAttribute($value)
    {
        $this->attributes['starts_at'] = $value ? date('Y-m-d H:i:s', strtotime($value)) : null;
    }

    public function setEndsAtAttribute($value)
    {
        $this->attributes['ends_at'] = $value ? date('Y-m-d H:i:s', strtotime($value)) : null;
    }

    /**
     *
     */
    public function page()
    {
        return $this->belongsTo(DvsPage::class, 'page_id');
    }

    /**
     *
     */
    public function slices()
    {
        return $this->hasMany(DvsSliceInstance::class, 'page_version_id')
            ->where('parent_instance_id', 0)
            ->orderBy('position');
    }

    public function registerComponents()
    {
        $user = Auth::user();
        if ($user && $user->hasPermission('access admin'))
        {
            $this->iterateAvailableComponents();
        } else
        {
            $this->iterateComponents($this->slices);
        }
    }

    private function iterateComponents($slices)
    {
        foreach ($slices as $child)
        {
            Devise::addComponent($child);
            $this->iterateComponents($child->slices);
        }
    }

    private function iterateAvailableComponents()
    {
        $files = File::allFiles(resource_path('views/slices'));
        foreach ($files as $file)
        {
            $fileName = $file->getFilename();
            if (strpos($fileName, '.blade.php') !== false)
            {
                $viewname = str_replace('.blade.php', '', $fileName);
                $path = $this->getDothPath($file->getRelativePath()) . '.' . $viewname;
                $slice = new DvsSliceInstance();
                $slice->view = 'slices.' . $path;
                Devise::addComponent($slice);
            }
        }
    }

    private function getDothPath($path)
    {
        $path = str_replace(resource_path('views/slices'), '', $path);

        return str_replace('/', '.', $path);
    }

    private function getName($path)
    {
        $parts = explode('/', $path);

        return $parts[count($parts) - 1];
    }
}
