<?php

namespace Devise\Traits;

use Devise\Sites\SiteDetector;

use Illuminate\Support\Facades\App;

/**
 * Trait Sortable
 * @package App\Traits
 */
trait HasPermissions
{
    protected $appends = [
        'permissions_list'
    ];

    public function getPermissionsListAttribute()
    {
        $detector = App::make(SiteDetector::class);
        $site = $detector->current();

        $default = config('devise.permissions.default', []);
        $config = config('devise.permissions', []);

        $all = (isset($config[$this->email])) ? $config[$this->email] : [];

        if (isset($config[$site->domain]))
        {
            $all = (isset($config[$site->domain][$this->email])) ? $config[$site->domain][$this->email] : $all;
        }

        return $all ?: $default;
    }

    public function hasPermission($permission)
    {
        $all = $this->permissions_list;

        return in_array($permission, $all);
    }
}