<?php namespace Devise\Http\Controllers;

use Devise\Media\Directories\Manager;

use Devise\Media\Files\Repository;
use Devise\Support\Framework;
use Illuminate\Http\Request;

/**
 * Class ResponseHandler handles the controller side
 * of managing categories. These methods are likely
 * referenced in dvs_pages table
 *
 * @package Devise\Media\Directories
 */
class MediaDirectoriesController
{
    /**
     * @var Manager
     */
    protected $Manager;

    /**
     * Construct a new response handler for categories
     *
     * @param Manager $Manager
     */
    public function __construct(Manager $Manager, Repository $Repository, Framework $Framework)
    {
        $this->Manager = $Manager;
        $this->Repository = $Repository;
        $this->Redirect = $Framework->Redirect;
    }

    public function all(Request $request, $folderPath = '')
    {
        $input = $request->all();

        $input['category'] = $folderPath;

        $results = $this->Repository->getIndex($input, ['categories']);

        return $results['categories'];
    }

    /**
     * Request a category be stored
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $dir = $this->Manager->dotToServerPath($request->get('directory'));
        if (Manager::dirPermitted($dir, 'write')) {
            $this->Manager->storeNewCategory($request->all());
        } else {
            abort(403, 'Action Not Permitted');
        }
    }

    /**
     * Request a category be destroyed
     *
     * @param Request $request
     * @return mixed
     */
    public function remove(Request $request)
    {
        $dir = $this->Manager->dotToServerPath($request->get('directory'));
        if (Manager::dirPermitted($dir, 'write')) {
            $this->Manager->destroyCategory($request->all());
        } else {
            abort(403, 'Action Not Permitted');
        }
    }
}