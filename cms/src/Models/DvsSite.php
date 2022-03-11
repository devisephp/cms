<?php

namespace Devise\Models;

use Devise\Languages\LanguageDetector;
use Devise\ModelQueries;
use Devise\Models\Repository as ModelRepository;
use Devise\Sites\SiteDetector;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class DvsSite extends Model
{
    use SoftDeletes;

    public $fillable = array('name', 'domain', 'model_queries', 'settings');

    protected $table = 'dvs_sites';

    protected static $modelQueryData = null;

    protected $attributes = [
        'model_queries' => '{}'
    ];

    public function languages()
    {
        return $this->belongsToMany(DvsLanguage::class, 'dvs_site_language', 'site_id', 'language_id')
            ->withPivot('default');
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
        if (!self::$modelQueryData) {
            self::$modelQueryData = $this->model_queries ? $this->getQueryData($this->model_queries) : [];
        }
        return self::$modelQueryData;
    }

    protected function getQueryData($queries)
    {
        $data = [];

        $keysToSkip = explode(',', config('devise.model_cache_ignores'));
        foreach ($queries as $name => $query) {
            if (config('devise.cache_enabled') && !in_array($name, $keysToSkip)) {
                $ld = App::make(LanguageDetector::class);
                $lang = $ld->current();
                $data[$name] = Cache::rememberForever(
                    $name . '-' . $this->id . '-' . $lang->id,
                    function () use ($query) {
                        return ModelQueries::runQuery($query);
                    }
                );
            } else {
                $data[$name] = ModelQueries::runQuery($query);
            }
        }
        return $data;
    }
}