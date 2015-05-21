<?php namespace Devise\Media\Encoding;

use Illuminate\Support\ServiceProvider;
use Devise\Media\Files\FileDownloader;
use Devise\Support\Framework;

/**
 * Registers a new devise.video.encoder we can use
 * globally throughout Laravel
 *
 */
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
        // Zencoder callback uses this to tell our server that it is finished encoding a video
        \Route::any('/api/notifications/zencoder', ['uses' => 'Devise\Media\Encoding\ZencoderNotificationsController@store', 'as' => 'dvs-api-notifications-zencoder']);

        $apiKey = $this->app['config']->get('devise.zencoder.api-key');
        $notifications = $this->app['config']->get('devise.zencoder.notifications');
        $encoder = new ZencoderJob($apiKey, $notifications, new FileDownloader, new Framework);

        $this->app->instance("devise.video.encoder", $encoder);
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
