<?php

namespace Devise\Models;

use Devise\Models\Repository as ModelRepository;
use Devise\Sites\SiteDetector;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class DvsSite extends Model
{
    use SoftDeletes;

    public $fillable = array('name', 'domain', 'model_queries', 'settings');

    protected $table = 'dvs_sites';

    protected $attributes = [
        'model_queries' => '{}'
    ];

    public function languages()
    {
        return $this->morphedByMany(DvsLanguage::class, 'element', 'dvs_site_element', 'site_id')
            ->withPivot('default');
    }

    public function media()
    {
        return $this->morphedByMany(DvsMedia::class, 'element', 'dvs_site_element', 'site_id');
    }

    public function getModelQueriesAttribute($value)
    {
        return json_decode($value);
    }

    public function setModelQueriesAttribute($value)
    {
        $this->attributes['model_queries'] = ($value) ? json_encode($value) : '{}';
    }

    public function getCurrentAttribute()
    {
        $detector = App::make(SiteDetector::class);

        $site = $detector->current();

        return ($site->id === $this->id);
    }

    public function getDefaultLanguageAttribute()
    {
        return $this->languages()
            ->wherePivot('default', 1)
            ->first();
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value);
    }

    public function getUrlAttribute()
    {
        $scheme = (request()->serure) ? 'https' : 'http';

        return $scheme . '://' . $this->domain;
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = ($value) ? json_encode($value) : '{}';
    }

    public function getDataAttribute()
    {
        $data = [];
        $queries = $this->model_queries;
        if ($queries)
        {
            $repository = App::make(ModelRepository::class);

            foreach ($queries as $name => $config)
            {
                parse_str($config, $input);

                $records = $repository
                    ->runQuery($input);

                $data[$name] = $records;
            }
        }

        return $data;
    }
}