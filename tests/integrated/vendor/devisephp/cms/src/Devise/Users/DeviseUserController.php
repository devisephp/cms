<?php namespace Devise\Users;

use App, Redirect, View;
use Devise\Users\Sessions\SessionsRepository;
use Devise\Users\UsersRepository;

class DeviseUserController extends \Controller
{
    protected $DvsUser;
    protected $DvsGroup;
    protected $SessionsRepository;
    protected $UsersRepository;
    protected $data;

	public function __construct(DvsUser $DvsUser, DvsGroup $DvsGroup, SessionsRepository $SessionsRepository, UsersRepository $UsersRepository, $App = null, $Redirect = null, $View = null)
	{
        $this->DvsUser = $DvsUser;
        $this->DvsGroup = $DvsGroup;
        $this->SessionsRepository = $SessionsRepository;
        $this->UsersRepository = $UsersRepository;
        $this->App = $App ?: \App::getFacadeRoot();
        $this->Redirect = $Redirect ?: \Redirect::getFacadeRoot();
        $this->View = $View ?: \View::getFacadeRoot();

        $this->data['title'] = 'DeviseUser';
	}

    /**
     * Render users index view
     *
     * @return Void
     */
    public function index()
    {
        $users = $this->DvsUser->get();
        $this->data = array_merge($this->data, compact('users'));
        $this->data['title'] = "Users Index";

        return $this->View->make('devise::users.index', $this->data);
    }

    /**
     * Render user create view
     *
     * @return Void
     */
    public function create()
    {
        $groups = $this->Group->lists('name','id');
        $this->data = array_merge($this->data, compact('groups'));
        $this->data['title'] = "Create User";

        return $this->View->make('devise::users.create', $this->data);
    }

    /**
     * Process user create form data
     *
     * @return Response
     */
    public function store()
    {
        if($this->UsersRepository->store(Input::except('_token'))) {
            return $this->Redirect->back()->with('message', $this->UsersRepository->message);
        } else {
            return $this->Redirect->back()
                ->withInput()
                ->withErrors($this->UsersRepository->errors)
                ->with('message', $this->UsersRepository->message);
        }
    }

    /**
     * Render user "edit" view
     *
     * @param  integer  $userId
     * @return Void
     */
    public function edit($userId)
    {
        $user = $this->UsersRepository->findById($userId);
        $groups = $this->Group->get();

        // get saved groups for current user
        $usersGroups = array();
        foreach($user->groups()->get() as $group) {
            $usersGroups[] = $group->id;
        }

        $this->data = array_merge($this->data, compact('user', 'groups', 'usersGroups', 'userId'));
        $this->data['title'] = "Edit User";

        return $this->View->make('devise::users.edit', $this->data);
    }

    /**
     * Process user edit form data
     *
     * @param  integer  $userId
     * @return Response
     */
    public function update($userId)
    {
        if($this->UsersRepository->update($userId, Input::except('_token'))) {
            return $this->Redirect->action('DeviseUserController@index')->with('message', $this->UsersRepository->message);
        } else {
            return $this->Redirect->back()
                ->withInput()
                ->withErrors($this->UsersRepository->errors)
                ->with('message', $this->UsersRepository->message);
        }
    }

    /**
     * Render user "show" view
     *
     * @param  integer  $userId
     * @return Void
     */
    public function show($userId)
    {
        $user = $this->UsersRepository->findById($userId);
        $userGroups = $user->groups()->get();

        $this->data = array_merge($this->data, compact('user', 'userGroups', 'userId'));
        $this->data['title'] = "User: ".$user->email;

        return $this->View->make('devise::users.show', $this->data);
    }

    /**
     * Render "destroy confirmation" view
     *
     * @param  integer  $userId
     * @return Void
     */
    public function confirmDestroy($userId)
    {
        $user = $this->UsersRepository->findById($userId);
        $this->data = array_merge($this->data, compact('user', 'userId'));
        $this->data['title'] = 'Confirm User Destroy';

        return $this->View->make('devise::users.destroy', $this->data);
    }

    /**
     * Destroy user record
     *
     * @param  integer  $userId
     * @return Void
     */
    public function postDestroy($userId)
    {
        $this->UsersRepository->destroy($userId);
        return $this->Redirect->action('DeviseUserController@index')->with('message', $this->UsersRepository->message);
    }

    /**
     * Render "edit password" form
     *
     * @param  integer  $userId
     * @return Void
     */
    public function editPassword($userId)
    {
        $user = $this->UsersRepository->findById($userId);

        $this->data = array_merge($this->data, compact('user', 'userId'));
        $this->data['title'] = "Edit Password";

        return $this->View->make('devise::users.password.edit', $this->data);
    }

    /**
     * Process edit password form data
     *
     * @param  integer  $userId
     * @return Response
     */
    public function updatePassword($userId)
    {
        if($this->UsersRepository->updatePassword($userId, Input::except('_token'))) {
            return $this->Redirect->back()->with('message', $this->UsersRepository->message);
        } else {
            return $this->Redirect->back()
                ->withInput()
                ->withErrors($this->UsersRepository->errors)
                ->with('message', $this->UsersRepository->message);
        }
    }

    /**
     * Render login view
     *
     * @return Void
     */
    public function login()
    {
        return $this->View->make('devise::users.login');
    }

    /**
     * Process login form data
     *
     * @return Void
     */
    public function postLogin()
    {
        if($this->SessionsRepository->login(Input::all())) {
            return $this->Redirect->action('DeviseUserController@index')->with('message', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->action('DeviseUserController@login')
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message', $this->SessionsRepository->message);
        }
    }

    /**
     * Process user log out
     *
     * @return Void
     */
    public function postLogout()
    {
        $this->SessionsRepository->logout();
        return $this->Redirect->action('DeviseUserController@login')->with('message', $this->SessionsRepository->message);
    }

    /**
     * Render user registration form
     *
     * @return Void
     */
    public function register()
    {
        $groups = $this->Group->lists('name','id');
        $this->data = array_merge($this->data, compact('groups'));

        return $this->View->make('devise::users.register', $this->data);
    }

    /**
     * Process user registration form data
     *
     * @return Response
     */
    public function postRegister()
    {
        if($this->SessionsRepository->register(Input::all())) {
            return $this->Redirect->action('DeviseUserController@register')->with('message', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->action('DeviseUserController@register')
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message', $this->SessionsRepository->message);
        }
    }

    /**
     * Renders forgot password view
     *
     * @return Response
     */
    public function forgotPassword()
    {
        $this->data['title'] = "Forgot Password";
        return $this->View->make('devise::users.password.forgot', $this->data);
    }

    /**
     * Renders resend user activation email
     *
     * @return Response
     */
    public function resendActivation()
    {
        $this->data['title'] = "Resend Activation Email";
        return $this->View->make('devise::users.resend-activation', $this->data);
    }

    /**
     * Handle POST data from resend activation form
     *
     * @return Response
     */
    public function postResendActivation()
    {
        if($this->SessionsRepository->resendActivation(Input::only('email'))) {
            return $this->Redirect->action('DeviseUserController@resendActivation')->with('message', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->action('DeviseUserController@resendActivation')
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message', $this->SessionsRepository->message);
        }
    }

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function remind()
    {
        return $this->View->make('devise::users.password.remind');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postRemind()
    {
        if($this->SessionsRepository->remind(Input::only('email'))) {
            return $this->Redirect->back()->with('message', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->back()
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message', $this->SessionsRepository->message);
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return Response
     */
    public function reset($token = null)
    {
        if(is_null($token)) {
            App::abort(404);
        }

        return $this->View->make('devise::users.password.reset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset()
    {
        if($this->SessionsRepository->reset(Input::only('email', 'password', 'password_confirmation', 'token'))) {
            return $this->Redirect->action('DeviseUserController@index')->with('message', $this->SessionsRepository->message);
        } else {
            return $this->Redirect->back()
                ->withInput()
                ->withErrors($this->SessionsRepository->errors)
                ->with('message', $this->SessionsRepository->message);
        }
    }

    /**
     * Handle activation of user account
     *
     * @param  integer  $userId
     * @param  string  $activateCode
     * @return Response
     */
    public function activate($userId, $activateCode)
    {
        $this->SessionsRepository->activate($userId, $activateCode);
        return $this->Redirect->action('DeviseUserController@index')->with('message', $this->SessionsRepository->message);
    }

    /**
     * Clears records of unactivated users
     *
     * @return Response
     */
    public function clearUnactivatedUsers()
    {
        $this->SessionsRepository->removeUnactivatedUsers();
    }

}