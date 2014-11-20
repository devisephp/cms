<?php namespace Devise\User\Response;

use Devise\User\Repositories\SessionsRepository;
use Illuminate\Routing\Redirector;
use Devise\User\UserManager as Manager;

class UsersResponseHandler
{
    private $Redirect, $Manager, $SessionsRepository;

    /**
     * Construct new response handler
     * @param Redirector $Redirect
     * @param Manager    $Manager
     */
    public function __construct(Redirector $Redirect, Manager $Manager, SessionsRepository $SessionsRepository)
    {
        $this->Manager = $Manager;
        $this->Redirect = $Redirect;
        $this->SessionsRepository = $SessionsRepository;
    }

    /**
     * Executes logout method in SessionsRepository
     *
     * @return Response
     */
    public function executeLogout()
    {
        $this->SessionsRepository->logout();
        return $this->Redirect->route('user-login')->with('message-success', $this->SessionsRepository->message);
    }

    /**
     * Executes login method in SessionsRepository
     *
     * @param  array  $input
     * @return Response
     */
    public function executeLogin($input)
    {
        if($this->SessionsRepository->login($input)) {
            return $this->Redirect->route('dvs-dashboard')->with('message-success', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->route('user-login')
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message-errors', $this->SessionsRepository->message);
        }
    }

    /**
     * Create a new user request
     *
     * @param  array $input
     * @return Redirect
     */
    public function requestCreateUser($input)
    {
        if ($this->Manager->createUser($input)->errors)
        {
            return $this->Redirect->route('dvs-users-create')
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
        }

        return $this->Redirect->route('dvs-users');
    }

    /**
     * Update a user
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirect
     */
    public function requestUpdateUser($id, $input)
    {
        if ($this->Manager->updateUser($id, $input)->errors)
        {
            return $this->Redirect->route('dvs-users-edit', $id)
                ->withInput()
                ->withErrors($this->Manager->errors)
                ->with('message', $this->Manager->message);
        }

        return $this->Redirect->route('dvs-users');
    }

    /**
     * Delete a user
     *
     * @param  integer $id
     * @return Redirect
     */
	public function requestDestroyUser($id)
    {
        $this->Manager->destroyUser($id);

        return $this->Redirect->route('dvs-users')
                ->with('message', 'User successfully removed');
	}
}