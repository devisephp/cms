<?php namespace Devise\Users;

use Devise\Users\Sessions\SessionsRepository;
use Devise\Users\UserManager;
use Devise\Support\Framework;

/**
 * Response handler takes care of user login/logout, creating,
 * updating, destroying users within /admin/users routes
 */
class UsersResponseHandler
{
    /**
     * SessionsRepository fetches session data
     *
     * @var SessionsRepository
     */
    private $SessionsRepository;

    /**
     * UserManager manages users
     *
     * @var UserManager
     */
    private $UserManager;

     /**
     * Framework components being used from Laravel's framework
     *
     * @var Framework
     */
    private $Framework;

    /**
     * Constructs a new UsersResponseHandler
     *
     * @param SessionsRepository  $SessionsRepository
     * @param UserManager         $UserManager
     * @param Framework           $Framework
     */
    public function __construct(SessionsRepository $SessionsRepository, UserManager $UserManager, Framework $Framework)
    {
        $this->SessionsRepository = $SessionsRepository;
        $this->UserManager = $UserManager;
        $this->Redirect = $Framework->Redirect;
        $this->URL = $Framework->URL;
    }

    /**
     * Executes logout method in SessionsRepository
     *
     * @return Response
     */
    public function executeLogout()
    {
        $this->SessionsRepository->logout();

        return $this->Redirect->route('user-login')
            ->with('message-success', $this->SessionsRepository->message);
    }

    /**
     * Executes login method in SessionsRepository
     *
     * @param  array  $input
     * @return Response
     */
    public function executeLogin($input)
    {
        if ($this->SessionsRepository->login($input))
        {
            if(isset($input['intended'])) {
                return $this->Redirect->to($input['intended']);
            }

            return $this->Redirect->route('dvs-dashboard');
        }

        return $this->Redirect->route('user-login')
            ->withInput()
            ->withErrors($this->SessionsRepository->errors)
            ->with('message-errors', $this->SessionsRepository->message);
    }

    /**
     * Request a new user be created
     *
     * @param  array $input
     * @return Redirector
     */
    public function requestCreateUser($input)
    {
        if ($this->UserManager->createUser($input))
        {
            return $this->Redirect->route('dvs-users')
                ->with('message', 'User successfully created');
        }

        return $this->Redirect->route('dvs-users-create')
                ->withInput()
                ->withErrors($this->UserManager->errors)
                ->with('message', $this->UserManager->message);
    }

    /**
     * Request user be updated with a given input
     *
     * @param  integer $id
     * @param  array   $input
     * @return Redirector
     */
    public function requestUpdateUser($id, $input)
    {
        if ($this->UserManager->updateUser($id, $input))
        {
            return $this->Redirect->route('dvs-users')
                ->with('message', 'User successfully updated');
        }

        return $this->Redirect->route('dvs-users-edit', $id)
            ->withInput()
            ->withErrors($this->UserManager->errors)
            ->with('message', $this->UserManager->message);
    }

    /**
     * Request the user be deleted from database
     *
     * @param  integer $id
     * @return Redirector
     */
	public function requestDestroyUser($id)
    {
        $this->UserManager->destroyUser($id);

        return $this->Redirect->route('dvs-users')->with('message', 'User successfully removed');
	}

    /**
     * Executes recoverPassword method in SessionsRepository
     *
     * @param  array  $input
     * @return Response
     */
    public function executeRecoverPassword($input)
    {
        if ($this->SessionsRepository->recoverPassword($input))
        {
            return $this->Redirect->route('user-recover-password')
                ->with('message',  $this->SessionsRepository->message);
        }

        return $this->Redirect->route('user-recover-password')
            ->withInput()
            ->withErrors($this->SessionsRepository->errors)
            ->with('message-errors', $this->SessionsRepository->message);
    }

    /**
     * Executes resetPassword method in SessionsRepository
     *
     * @param  array  $input
     * @return Response
     */
    public function executeResetPassword($input)
    {
        if ($this->SessionsRepository->resetPassword($input))
        {
            return $this->Redirect->route('user-reset-password')
                ->with('message',  $this->SessionsRepository->message);
        }

        // makes sure token is
        $urlWithToken = $this->URL->route('user-reset-password') . '?token=' . $input['token'];

        return $this->Redirect->to($urlWithToken)
            ->withInput(['token'])
            ->withErrors($this->SessionsRepository->errors)
            ->with('message-errors', $this->SessionsRepository->message);
    }

}