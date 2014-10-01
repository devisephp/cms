<?php namespace Devise\Models\Providers;

use Illuminate\Support\ServiceProvider;
use Devise\Models\Helpers\DeviseForm;

class ModelsServiceProvider extends ServiceProvider {

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
    public function boot(){}

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFormBuilder();
    }

    /**
     * Register the devise form helper instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->bindShared('deviseform', function($app)
        {
            $form = new DeviseForm($app['html'], $app['url'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('deviseform');
    }

}
