<?php

namespace Devise\Models;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class DvsPage extends Model
{
  use SoftDeletes;
  
  protected $fillable = [
    'site_id',
    'language_id',
    'translated_from_page_id',
    'route_name',
    'title',
    'slug',
    'canonical',
    'head',
    'footer',
    'middleware',
    'ab_testing_enabled'
  ];

  protected $table = 'dvs_pages';


  public function versions()
  {
    return $this->hasMany(DvsPageVersion::class, 'page_id');
  }

  public function currentVersion()
  {
    if (request()->has('version_id'))
    {
      return $this->hasOne(DvsPageVersion::class, 'page_id')
        ->where('id', request()->input('version_id'));
    } else
    {
      return $this->liveVersion();
    }
  }

  public function liveVersion()
  {
    $now = new DateTime;

    return $this->hasOne(DvsPageVersion::class, 'page_id')
      ->where('starts_at', '<', $now)
      ->where(function ($query) use ($now) {
        $query->where('ends_at', '>', $now);
        $query->orWhereNull('ends_at');
      })
      ->orderBy('starts_at', 'DESC');
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
    return $this->belongsTo(DvsSite::class, 'language_id');
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

  public function hasAttribute($key)
  {
    return array_key_exists($key, $this->attributes)
      or $this->hasGetMutator($key)
      or array_key_exists($key, $this->relations)
      or method_exists($this, camel_case($key));
  }

  public function getLiveVersion($now = null)
  {
    $now = $now ?: new DateTime;

    return $this->versions()
      ->where('starts_at', '<', $now)
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
}