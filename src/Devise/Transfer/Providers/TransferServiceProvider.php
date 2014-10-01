<?php namespace Devise\Transfer\Providers;

use Illuminate\Support\ServiceProvider;
use Devise\Transfer\Transfer;

class TransferServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTransfer();
    }

    /**
     * Register the devise form helper instance.
     *
     * @return void
     */
    protected function registerTransfer()
    {
        $this->app->bindShared('devisetransfer', function ($app) {
            $migrator = new Transfer($app);

            return $migrator;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('devisetransfer');
    }

}
