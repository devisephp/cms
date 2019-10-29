<?php

namespace Devise\Models;

use Devise\Devise;
use Devise\Models\Repository as ModelRepository;
use Devise\Traits\Filterable;
use Devise\Traits\Sortable;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class DvsPage extends Model
{
    use SoftDeletes, Filterable, Sortable;

    protected $fillable = [
        'site_id',
        'language_id',
        'translated_from_page_id',
        'route_name',
        'title',
        'slug',
        'meta_title',
        'canonical',
        'head',
        'footer',
        'middleware',
        'ab_testing_enabled',
        'ab_testing_amount'
    ];

    protected $table = 'dvs_pages';

    public function versions()
    {
        return $this->hasMany(DvsPageVersion::class, 'page_id');
    }

    public function currentVersion()
    {
        if (request()->has('version_id') && Auth::check())
        {
            $user = Auth::user();
            if ($user->hasPermission('manage pages'))
            {
                return $this->versionById(request()->get('version_id'));
            }
        }

        return $this->liveVersion();
    }

    public function liveVersion()
    {
        if ($this->ab_testing_enabled) return $this->livePageVersionByAB();

        return $this->livePageVersionByDate();
    }

    public function livePageVersionByDate()
    {
        $now = Devise::currentDateTime();

        return $this->hasOne(DvsPageVersion::class, 'page_id')
            ->where('starts_at', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->orderBy('starts_at', 'DESC');
    }

    public function abEnabledLiveVersions()
    {
        $now = Devise::currentDateTime();

        return $this->hasMany(DvsPageVersion::class, 'page_id')
            ->where('ab_testing_amount', '>', 0)
            ->where('starts_at', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->orderBy('starts_at', 'DESC');
    }

    public function livePageVersionByAB()
    {
        $liveVersion = $this->livePageVersionByCookie();

        if ($liveVersion) return $liveVersion;

        $liveVersion = $this->livePageVersionByDiceRoll();

        if ($liveVersion) return $liveVersion;

        return $this->livePageVersionByDate();
    }

    public function versionById($id)
    {
        return $this->hasOne(DvsPageVersion::class, 'page_id')
            ->where('id', $id);
    }

    public function livePageVersionByCookie()
    {
        $pageVersionId = request()->cookie('dvs-ab-testing-' . $this->id);

        if (!$pageVersionId) return null;

        $liveVersion = $this->versionById($pageVersionId);

        if ($liveVersion) return $liveVersion;

        return null;
    }

    public function livePageVersionByDiceRoll()
    {
        $liveVersion = null;

        $versions = $this->abEnabledLiveVersions();

        $diceroll = array();

        foreach ($versions as $index => $version)
        {
            $diceroll = array_merge(array_fill(0, $version->ab_testing_amount, $index), $diceroll);
        }

        if (count($diceroll) == 0) return null;

        $diceroll = $diceroll[array_rand($diceroll)];

        if (isset($versions[$diceroll]))
        {
            $liveVersion = $versions[$diceroll];
            $this->Cookie->queue('dvs-ab-testing-' . $this->id, $liveVersion->id);
        }

        return $this->versionById($liveVersion->id);
    }

    public function localizedPages()
    {
        return $this->hasMany(DvsPage::class, 'translated_from_page_id');
    }

    public function metas()
    {
        return $this->hasMany(DvsPageMeta::class, 'page_id');
    }

    public function translatedFromPage()
    {
        return $this->belongsTo(DvsPage::class, 'translated_from_page_id');
    }

    public function language()
    {
        return $this->belongsTo(DvsLanguage::class, 'language_id');
    }

    public function site()
    {
        return $this->belongsTo(DvsSite::class, 'site_id');
    }

    public function getResponseClassAttribute()
    {
        $parts = explode('.', $this->attributes['response_path']);

        return (isset($parts[0])) ? $parts[0] : '';
    }

    public function getResponseMethodAttribute()
    {
        $parts = explode('.', $this->attributes['response_path']);

        return (isset($parts[1])) ? $parts[1] : '';
    }

    public function getResponseParamsArrayAttribute()
    {
        return explode(',', $this->attributes['response_params']);
    }

    public function getPermalinkAttribute()
    {
        if (Route::getRoutes()->hasNamedRoute($this->route_name))
        {
            return URL::route($this->route_name);
        }

        return '#';
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes)
            or $this->hasGetMutator($key)
            or array_key_exists($key, $this->relations)
            or method_exists($this, Str::camel($key));
    }

    public function getLiveVersion($now = null)
    {
        $now = $now ?: Devise::currentDateTime();

        return $this->versions()
            ->where('starts_at', '<=', $now)
            ->where(function ($query) use ($now) {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->orderBy('starts_at', 'DESC')
            ->first();
    }

    public function setIsAdminAttribute($value)
    {
        if ($value === 'on' || $value === true || $value === 1)
        {
            $this->attributes['is_admin'] = 1;
        } else
        {
            $this->attributes['is_admin'] = 0;
        }
    }

    public function getSlugHasParametersAttribute()
    {
        if (strpos($this->slug, "{"))
        {
            return true;
        }

        return false;
    }

    public function getAllMetaAttribute()
    {
        $globalMeta = Cache::rememberForever('', function () {
            return DvsPageMeta::where('page_id', 0)
                ->where('site_id', $this->site_id)->get();
        });

        return $this->metas->merge($globalMeta);
    }
}