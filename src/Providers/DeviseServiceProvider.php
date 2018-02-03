<?php

namespace Devise\Providers;

use Devise\Pages\PageData;
use Illuminate\Support\ServiceProvider;

class DeviseServiceProvider extends ServiceProvider
{
  /**
   * Perform post-registration booting of services.
   *
   * @return void
   */
  public function boot()
  {
    $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
  }

  public function register()
  {
    if (!class_exists('Devise'))
    {
      class_alias(PageData::class, 'Devise');
    }
  }
}