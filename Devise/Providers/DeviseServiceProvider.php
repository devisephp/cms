<?php

namespace Devise\Providers;

use Devise\Console\Commands\Install;
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
    $this->setCommands();

    $this->setPublishables();

    $this->setRoutes();

    $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

    $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'devise');
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

  private function setCommands()
  {
    if ($this->app->runningInConsole())
    {
      $this->commands([
        Install::class,
      ]);
    }
  }

  private function setPublishables()
  {
    $this->publishes([
      __DIR__ . '/../../vue/dist' => public_path('devise'),
    ], 'devise-public');

    $this->publishes([
      __DIR__ . '/../../vue/src' => resource_path('assets/devise-dev'),
    ], 'devise-assets');
  }

  private function setRoutes()
  {
    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

    $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
  }
}