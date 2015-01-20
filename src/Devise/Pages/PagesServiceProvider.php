<?php namespace Devise\Pages;

/**
 * Registers the Pages service provider. This allows us to manage our pages
 * within the Devise cms. It also provides the ability to scan blade views
 * and extract out fields and collections which can be loaded in the Devise
 * Sidebar and maintained by the admin.
 *
 */
class PagesServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Loads the route file which allows us to
     * have slugs in the url (set via the dvs_pages database
     * table)
     *
     * @return void
     */
    public function boot()
    {
        require __DIR__. '/routes.php';

        // register these field update bindings
        \Event::listen('devise.video.field.updated', 'Devise\Pages\Fields\VideoFieldUpdated');
        \Event::listen('devise.image.field.updated', 'Devise\Pages\Fields\ImageFieldUpdated');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPhpBladeExtensions();
        $this->registerDeviseDataContainer();
        $this->registerTemplateComposer();
    }

    /**
     * Registers @php and @endphp recognition to blade
     *
     * @return void
     */
    private function registerPhpBladeExtensions()
    {
        \Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createPlainMatcher('php');
            return preg_replace($pattern, "<?php\n", $view);
        });

        \Blade::extend(function($view, $compiler)
        {
            $pattern = $compiler->createPlainMatcher('endphp');
            return preg_replace($pattern, "\n?>", $view);
        });

        \Blade::extend(function($view, $compiler)
        {
            return \App::make('Devise\Pages\Interrupter\DeviseBladeCompiler')->compile($view);
        });
    }

    /**
     * The template composer is what manages a view's vars
     * component of devise.
     *
     * @return void
     */
    private function registerTemplateComposer()
    {
        $views = array_keys(\Config::get('devise::templates'));
        \View::composer($views, 'Devise\Pages\Viewvars\ViewvarComposer');
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
        $this->app->instance("dvsPageData", new \Devise\Pages\Interrupter\DvsPageData);
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
