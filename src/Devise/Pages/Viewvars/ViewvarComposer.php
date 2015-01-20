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
        if (!self::$firstView)
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
        $vars = isset($this->Config->get('devise::templates')[$name]['vars']) ? $this->Config->get('devise::templates')[$name]['vars'] : null;
        $parent = isset($this->Config->get('devise::templates')[$name]['extends']) ? $this->Config->get('devise::templates')[$name]['extends'] : null;

        if ($vars || $parent)
        {
            $vars = ($vars) ? $vars : array();
            if ($parent)
            {
                $parentArr = $this->Config->get('devise::templates.' . $parent);
                $parentVars = array_get($parentArr, 'vars', array());
                return array_merge($vars, $parentVars);
            }

            return $vars;
        }

        return array();
    }
}