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
    $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

    $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'devise');

    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

    $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
  }

  public function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/../../config/devise.php', 'devise'
    );

    if (!class_exists('Devise'))
    {
      class_alias(Devise::class, 'Devise');
    }
  }
}