<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\Http\Resources\Api\ReleaseModelResource;
use Devise\MotherShip\Releases;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class ReleasesController extends Controller
{
    use ValidatesRequests;
    /**
     * @var Releases
     */
    private $Releases;


    /**
     * ReleasesController constructor.
     * @param Releases $Releases
     */
    public function __construct(Releases $Releases)
    {
        $this->Releases = $Releases;
    }

    public function all(ApiRequest $request)
    {
        $all = $this->Releases->getForDeviseFlow();

        return ReleaseModelResource::collection($all);
    }

    public function pull(ApiRequest $request, $releaseId)
    {
        $this->checkThatReleaseHasNotAlreadyBeenPulled($releaseId);

        $this->Releases->pull($releaseId);
    }

    public function send(ApiRequest $request)
    {
        $this->validate($request, ['message' => 'required']);

        $this->checkIfUpToDate($request);

        $this->Releases->send($request->get('ids'), $request->get('message'));
    }

    public function init(ApiRequest $request)
    {
        $this->checkIfUpToDate($request);

        $this->checkIfOkToInit();

        $this->Releases->initWithMotherShip();
    }

    public function commitHash(ApiRequest $request)
    {
        return $this->Releases->getCurrentRelease();
    }

    private function checkIfUpToDate(ApiRequest $request)
    {
        $status = trim(shell_exec('git status'));
        if (strpos($status, 'nothing to commit') === false && !$request->get('force'))
        {
            $error = ValidationException::withMessages([
                'force' => ['Uncommitted changes found. "force" flag is required.']
            ]);

            throw $error;
        }
    }

    private function checkThatReleaseHasNotAlreadyBeenPulled($releaseId)
    {
        $exists = $this->Releases->getByMotherShipId($releaseId);

        if ($exists)
        {
            $error = ValidationException::withMessages([
                'release_id' => ['Release has already been pulled from MotherShip.']
            ]);

            throw $error;
        }
    }

    private function checkIfOkToInit()
    {
        $current = $this->Releases->getCurrentRelease();

        if ($current)
        {
            abort(400, 'Project has already been initiated');
        }
    }
}
