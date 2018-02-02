<?php

namespace Devise\Providers;

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
    $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
  }
}