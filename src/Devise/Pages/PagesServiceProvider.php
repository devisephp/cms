<?php namespace Devise\Pages;

use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Devise\Pages\Interpreter\ViewOpener;
use Devise\Pages\Interpreter\DeviseCompiler;
use Devise\Pages\Interpreter\DeviseParser;
use Devise\Pages\Interpreter\BladeEngineCompiler;

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
        $this->registerInterpreter();
        $this->registerPhpBladeExtensions();
        $this->registerDeviseDataContainer();
        $this->registerTemplateComposer();
    }

    /**
     * Registers the extended blade compiler with our application.
     * This takes care not to forget any previously attached extensions
     * of the blade compiler. We are doing so by decorating the old
     * blade compiler and then adding in our functionality on top.
     *
     * @return void
     */
    private function registerInterpreter()
    {
        $app = $this->app;

        $resolver = $this->app['view']->getEngineResolver();

        $compiler = $resolver->resolve('blade')->getCompiler();

        $deviseCompiler = new DeviseCompiler(new ViewOpener);

        $deviseParser = new DeviseParser;

        $resolver->register('blade', function() use ($app, $compiler, $deviseCompiler, $deviseParser)
        {
            $extended = new BladeEngineCompiler($compiler, $deviseCompiler, $deviseParser);

            return new CompilerEngine($extended, $app['files']);
        });
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
    }

    /**
     * The template composer is what manages a view's vars
     * component of devise.
     *
     * @return void
     */
    private function registerTemplateComposer()
    {
        $views = array_keys(config('devise.templates'));
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
        $this->app->instance("dvsPageData", new \Devise\Pages\Interpreter\DvsPageData);
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
