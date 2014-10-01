<?php namespace Devise\Encoding\Providers;

use App, Config;
use Devise\Encoding\ZencoderJob;
use Devise\Common\FileDownloader;
use Illuminate\Support\ServiceProvider;

class EncodingServiceProvider extends ServiceProvider
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
        $apiKey = Config::get('devise::zencoder.api-key');
        $notifications = Config::get('devise::zencoder.notifications');
        $encoder = new ZencoderJob($apiKey, $notifications, new FileDownloader);

        App::instance("devise.video.encoder", $encoder);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
