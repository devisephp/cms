<?php namespace Devise\Models\Scaffolding;

use Illuminate\Routing\Redirector;
use Response;

use Devise\Models\Scaffolding\Types\CrudScaffolding;


/**
 * Class ScaffoldingResponseHandler
 * @package Devise\Models\Scaffolding
 */
class ScaffoldingResponseHandler {

    /**
     * Redirector is used to redirect traffic
     *
     * @var Illuminate\Routing\Redirector
     */
    private $Redirect;

    /**
     * ScaffoldingManager manages scaffolding creation
     *
     * @var ScaffoldingManager
     */
    private $ScaffoldingManager;


    /**
     * @var CrudScaffolding
     */
    private $CrudScaffolding;

    /**
     * @param ScaffoldingManager $ScaffoldingManager
     * @param CrudScaffolding $CrudScaffolding
     * @param Redirector $Redirect
     */
    public function __construct(ScaffoldingManager $ScaffoldingManager, CrudScaffolding $CrudScaffolding, Redirector $Redirect)
    {
        $this->ScaffoldingManager = $ScaffoldingManager;
        $this->CrudScaffolding = $CrudScaffolding;
        $this->Redirect = $Redirect;
    }


    /**
     * Request a new page be created
     *
     * @param  array $input
     * @return Redirector
     */
    public function requestCreateNewModel($input)
    {
        $scaffolding = $this->ScaffoldingManager->makeScaffolding($input, $this->CrudScaffolding);

        if ($scaffolding)
        {
            return $this->Redirect->route('dvs-dashboard');
        }

        return $this->Redirect->route('dvs-models-create')
            ->withInput()
            ->withErrors($this->ScaffoldingManager->errors)
            ->with('message', $this->ScaffoldingManager->message);
    }

}