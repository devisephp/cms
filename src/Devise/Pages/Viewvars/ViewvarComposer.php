<?php namespace Devise\Pages\Viewvars;

/**
 * View composer here is registered in the
 * Devise\Pages\PagesServiceProvider.php for all
 * views that are contained within the views config
 * file. That is how those views have their data injected
 * into them properly - by running through this view composer.
 */
class ViewvarComposer
{
    /**
     * only run if this is the first view in the stack
     * example: grandchild @extends('child') @extends('layout')
     * grandchild is the 'first view'. this keeps us from composing
     * views that have already been composed previously (say it is
     * included multiple times by a parent view)
     *
     * @var boolean
     */
    private static $firstView = true;

    /**
     * This is a hack to get around the $firstView
     * problem of not loading views after the first
     * view when testing.
     *
     *  $this->call('GET', $url);   // works fine first time
     *  $this->call('GET', $url);   // second time, 500 error
     *                              // because the viewvars are
     *                              // not set below due to $firstView
     * @var boolean
     */
    public static $loadMultipleTimes = false;

    /**
     * DataBuilder constructs the data for our
     * view composer to use
     *
     * @var DataBuilder
     */
    private $DataBuilder;

    /**
     * Only load classes once, we don't
     * want to load them multiple times I guess
     * for performance reasons? (not sure...)
     *
     * @var array
     */
    private $loadedClasses = array();

    /**
     * Create new instance of ViewvarComposer
     *
     * @param DataBuilder $DataBuilder
     */
    public function __construct(DataBuilder $DataBuilder, $Config = null)
    {
        $this->DataBuilder = $DataBuilder;
        $this->Config = $Config ?: \Config::getFacadeRoot();
    }

    /**
     * Injects data from config into the current view
     *
     * @param  Illuminate\View\View $view
     * @return void
     */
    public function compose($view)
    {
        if (!self::$loadMultipleTimes && !self::$firstView)
        {
            return;
        }

        $viewData = $view->getData();
        $viewName = $view->getName();
        $vars = $this->getVars($viewName);

        if(count($vars))
        {
            $this->DataBuilder->setData($viewData);
            $data = $this->DataBuilder->compile($vars);

            foreach ($data as $varName => $value)
            {
                $view->with($varName, $value);
            }
        }

        self::$firstView = false;
    }

    /**
     * Get the variables for this name
     *
     * @param  string $name
     * @return array
     */
    private function getVars($name)
    {
        $config = $this->Config->get('devise.templates');

        $vars = isset($config[$name]['vars']) ? $config[$name]['vars'] : null;
        $parent = isset($config[$name]['extends']) ? $config[$name]['extends'] : null;

        if ($vars || $parent)
        {
            $vars = ($vars) ? $vars : array();

            if ($parent)
            {
                $parentVars = isset($config[$parent]['vars']) ? $config[$parent]['vars'] : [];
                return array_merge($vars, $parentVars);
            }
        }

        return $vars;
    }
}