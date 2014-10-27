<?php namespace Devise\Pages\Providers;

use App;
use Blade;
use Config;
use Event;
use Devise\Pages\Compilers\CompilerEngine;
use Devise\Support\Helpers\DeviseArray;
use Illuminate\Support\ServiceProvider;
use View;

class PagesServiceProvider extends ServiceProvider {

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
        include __DIR__.'/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindCompilers();
        $this->registerCompilerServiceProvider();
        $this->registerPhpBladeExtensions();
        $this->registerTemplateComposer();
        $this->registerDeviseDataContainer();
    }

    /**
     * Binds a dynamic ammount of compilers to the compiler engine
     *
     * @return void
     */
    private function bindCompilers()
    {
        App::bind('compilers', function($app) {
            $compilers = Config::get('devise::compiler.compilers');
            $loaded = array();
            foreach ($compilers as $compilerAlias => $compilerPath) {
                $loaded[ $compilerAlias ] = App::make($compilerPath);
            }
            return $loaded;
        });

        App::bind('Devise\Pages\Compilers\CompilerEngine', function($app) {
            return new CompilerEngine( App::make('compilers') );
        });
    }

    /**
     * Registers the compiler service provider
     *
     * @return void
     */
    private function registerCompilerServiceProvider()
    {
        $provider = new CompilerServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

    /**
     * Registers @php and @endphp recognition to blade
     *
     * @return void
     */
    private function registerPhpBladeExtensions()
    {
        Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createPlainMatcher('php');
            return preg_replace($pattern, "<?php\n", $view);
        });

        Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createPlainMatcher('endphp');
            return preg_replace($pattern, "\n?>", $view);
        });

    }

    private function registerTemplateComposer()
    {
        $views = array_keys(Config::get('devise::view-vars'));
        View::composer($views, 'Devise\Pages\Composers\ViewComposer');
    }

    /**
     * deviseDataJavascriptBindings is a singleton class
     * that holds json values until they are finally needed
     * and output using ->toJSON() method
     *
     * @return void
     */
    private function registerDeviseDataContainer()
    {
        // old page data helpers...
        App::instance("deviseDataJavascriptBindings", new \Devise\Editor\Helpers\PageBindingsContainer);
        App::instance("deviseDataJavascriptCollections", new \Devise\Editor\Helpers\PageCollectionsContainer);

        // new page data helper
        App::instance("dvsPageData", new \Devise\Pages\Helpers\DvsPageData);
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
