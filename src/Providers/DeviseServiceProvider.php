<?php

namespace Devise\Providers;

use Devise\Devise;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class DeviseServiceProvider extends ServiceProvider
{
  /**
   * Perform post-registration booting of services.
   *
   * @return void
   */
  public function boot(BladeCompiler $blade)
  {
    $blade->doubleEncode();

    $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
  }

  public function register()
  {
    if (!class_exists('Devise'))
    {
      class_alias(Devise::class, 'Devise');
    }
  }
}