<?php namespace Devise\Pages;

use Illuminate\Routing\Redirector;
use Response;

/**
 * Response handler takes care of creating,updating, destroying
 */
class ApiPagesResponseHandler
{
    /**
     * ApiPagesManager manages api
     *
     * @var ApiPagesManager
     */
    private $ApiPagesManager;

    /**
     * Redirector is used to redirect traffic
     *
     * @var Illuminate\Routing\Redirector
     */
    private $Redirect;

    /**
     * Construct a new PageResponseHandler
     *
     * @param ApiPagesManager        $ApiPagesManager
     * @param PagesRepository    $PagesRepository
     * @param PageVersionManager $PageVersionManager
     * @param Redirector         $Redirect
     */
    public function __construct(ApiPagesManager $ApiPagesManager, Redirector $Redirect)
    {
        $this->ApiPagesManager = $ApiPagesManager;
        $this->Redirect = $Redirect;
    }

    /**
     * Request a new page be created
     *
     * @param  array $input
     * @return Redirector
     */
    public function requestCreateNewPage($input)
    {
        if(isset($input['response_class']) && isset($input['response_method'])){
            $input['response_path'] = $input['response_class'] .'.'. $input['response_method'];
        }
        $page = $this->ApiPagesManager->createNewPage($input);

        if ($page)
        {
            return $this->Redirect->route('dvs-api');
        }

        return $this->Redirect->route('dvs-api-create')
            ->withInput()
            ->withErrors($this->ApiPagesManager->errors)
            ->with('message', $this->ApiPagesManager->message);
    }

    /**
     * Request page be updated with given input
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirector
     */
    public function requestUpdatePage($id, $input)
    {
        if(isset($input['response_class']) && isset($input['response_method'])){
            $input['response_path'] = $input['response_class'] .'.'. $input['response_method'];
        }
        $page = $this->ApiPagesManager->updatePage($id, $input);

        if ($page)
        {
            return $this->Redirect->route('dvs-api');
        }

        return $this->Redirect->route('dvs-api-edit', $id)
            ->withInput()
            ->withErrors($this->ApiPagesManager->errors)
            ->with('message', $this->ApiPagesManager->message);
    }

    /**
     * Request the page be deleted from database
     *
     * @param  integer $id
     * @return Redirector
     */
    public function requestDestroyPage($id)
    {
        $page = $this->ApiPagesManager->destroyPage($id);

        if ($page)
        {
            return $this->Redirect->route('dvs-api')
                ->with('message', 'Request successfully removed');
        }

        return $this->Redirect->route('dvs-api')
            ->withInput()
            ->withErrors($this->ApiPagesManager->errors)
            ->with('message', $this->ApiPagesManager->message);
    }
}