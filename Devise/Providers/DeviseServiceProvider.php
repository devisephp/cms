<?php

namespace Devise\Providers;

use Devise\Console\Commands\Install;
use Devise\Devise;

use Devise\MotherShip\Migrations;
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

    $this->loadLaravelResources();

    $this->registerMigration();
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

  private function loadLaravelResources()
  {
    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'devise');

    $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'devise');
  }

  /**
   * Register the migrator service.
   *
   * @return void
   */
  protected function registerMigration()
  {
    // The migrator is responsible for actually running and rollback the migration
    // files in the application. We'll pass in our database connection resolver
    // so the migrator can resolve any of these connections when it needs to.
    $this->app->singleton('migrations', function ($app) {
      $repository = $app['migration.repository'];

      return new Migrations($repository, $app['db'], $app['files']);
    });
  }
}