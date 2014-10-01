<?php namespace Devise\Cms;

use App;
use Blade;
use Devise\Data\Providers\DataServiceProvider;
use Devise\Indexer\Providers\IndexerServiceProvider;
use Devise\Events\Providers\DeviseEventServiceProvider;
use Devise\Models\Providers\ModelsServiceProvider;
use Devise\Transfer\Providers\TransferServiceProvider;
use Devise\Pages\Providers\PagesServiceProvider;
use Devise\Support\Providers\SupportServiceProvider;
use Devise\User\Providers\UserServiceProvider;
use Devise\Sortable\Providers\SortableServiceProvider;
use Devise\Encoding\Providers\EncodingServiceProvider;
use Devise\Fields\Providers\FieldsServiceProvider;
use Illuminate\Support\ServiceProvider;

class DeviseServiceProvider extends ServiceProvider {

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
        $this->package('devise/cms', 'devise');

	    $this->registerEvents();
	    $this->registerData();
	    $this->registerIndexer();
	    $this->registerMigrator();
	    $this->registerModels();
	    $this->registerPages();
	    $this->registerSupport();
	    $this->registerUser();
	    $this->registerSortable();
        $this->registerEncoding();
        $this->registerFields();

	    require __DIR__ . '/../../macros/macros.php';
	    require __DIR__ . '/../../blade/extensions.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDeviseCms();
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

    /**
     * Registers the data service provider
     *
     * @return void
     */
    private function registerData()
    {
        $provider = new DataServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Registers the indexer service provider
     *
     * @return void
     */
    private function registerIndexer()
    {
        $provider = new IndexerServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Registers the models service provider
     *
     * @return void
     */
    private function registerEvents()
    {
        $provider = new DeviseEventServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Registers the models service provider
     *
     * @return void
     */
    private function registerModels()
    {
        $provider = new ModelsServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Registers the pages service provider
     *
     * @return void
     */
    private function registerPages()
    {
        $provider = new PagesServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Register support service provider
     *
     * @return array
     */
    public function registerSupport()
    {
        $provider = new SupportServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Register user service provider
     *
     * @return array
     */
    public function registerUser()
    {
        $UserProvider = new UserServiceProvider($this->app);
        $this->app->register($UserProvider);
        $UserProvider->boot();
    }

    /**
     * Register user service provider
     *
     * @return array
     */
    public function registerMigrator()
    {
        $TransferProvider = new TransferServiceProvider($this->app);
        $this->app->register($TransferProvider);
        $TransferProvider->boot();
    }

	/**
	 * Register user service provider
	 *
	 * @return array
	 */
	public function registerSortable()
	{
		$SortableProvider = new SortableServiceProvider($this->app);
		$this->app->register($SortableProvider);
		$SortableProvider->boot();
	}

    /**
     * Register encoding service provider
     *
     * @return array
     */
    public function registerEncoding()
    {
        $EncodingProvider = new EncodingServiceProvider($this->app);
        $this->app->register($EncodingProvider);
        $EncodingProvider->boot();
    }

    /**
     * Register fields service provider
     *
     * @return array
     */
    public function registerFields()
    {
        $FieldsProvider = new FieldsServiceProvider($this->app);
        $this->app->register($FieldsProvider);
        $FieldsProvider->boot();
    }

    /**
     * Register the DeviseCMS (used by Devise facade too)
     *
     * @return void
     */
    public function registerDeviseCms()
    {
        $this->app->bind('devisecms', function()
        {
            return new DeviseCms(new \Devise\Fields\FieldHelper);
        });
    }
}
