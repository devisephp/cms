<?php namespace Devise\Users\Sessions;

use Devise\Support\Framework;
use Devise\Users\UserManager;
use Devise\Users\UsersRepository;

/**
 * Class SessionsRepository is used to search and retrieve current DvsUser in session
 * and things in context of a DvsUser/DvsGroup.
 *
 * @package Devise\Users\Sessions
 */
class SessionsRepository
{
    /**
     * DvsUser model to fetch database records
     *
     * @var DvsUser
     */
    protected $DvsUser;

    /**
     * UserManager manages users
     *
     * @var UserManager
     */
    protected $UserManager;

    /**
     * UsersRepository fetches users and related data
     *
     * @var UsersRepository
     */
    protected $UsersRepository;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var Devise\Support\Framework
     */
    protected $Framework;

    /**
     * Errors are kept in an array and can be used later
     * if validation fails and we want to know why
     *
     * @var array
     */
    public $errors;

    /**
     * This is a message that we can store why validation failed
     *
     * @var string
     */
    public $message;

    /**
     * Create a new SessionsRepository instance.
     *
     * @param \DvsUser $DvsUser
     * @param UserManager  $UserManager
     * @param UsersRepository  $UsersRepository
     * @param Framework  $Framework
     */
    public function __construct(\DvsUser $DvsUser, UserManager $UserManager, UsersRepository $UsersRepository, Framework $Framework)
    {
        $this->DvsUser = $DvsUser;
        $this->UserManager = $UserManager;
        $this->UsersRepository = $UsersRepository;
        $this->Auth = $Framework->Auth;
        $this->Hash = $Framework->Hash;
        $this->Lang = $Framework->Lang;
        $this->Validator = $Framework->Validator;
        $this->Framework = $Framework;
    }

    /**
     * Attempty to login a user
     *
     * @param  array  $input
     * @return User
    */
    public function login($input)
    {
        try {
            if($user = $this->attemptUserLogin($input)) {
                $this->message = 'You have been logged in.';
                return $user;
            }

            $this->message = 'There were validation errors.';
            $this->errors = 'Incorrect user credentials.';
            return false;
        }
        catch (UserNotFoundException $e)
        {
            $this->message = 'User not found.' ;
            return false;
        }
        catch (UserNotActivatedException $e)
        {
            $this->message = 'User has not been activated.' ;
            return false;
        }
    }

    /**
     * Log user out
     *
     * @return Boolean
    */
    public function logout()
    {
        $this->Auth->logout();

        $this->message = 'You have been logged out.';
        return true;
    }

    /**
    * Handle a POST request to recover password
    *
    * @param  array  $input
    * @return Response
    */
    public function recoverPassword($input)
    {
        $input = array_except($input, '_token');

        $response = $this->Framework->Password->sendResetLink($input);
        switch($response) {
            case \Password::INVALID_USER:
                $this->message = 'There were validation errors.';
                $this->errors = $this->Lang->get($response);
                return false;

            case \Password::REMINDER_SENT:
                $this->message = 'Recovery email has been sent.';
                break;
        }
    }

    /**
    * Handle POST data from reset (change) password form
    *
    * @param  array  $input
    * @return Response
    */
    public function resetPassword($input)
    {
        $input = array_except($input, '_token');

        $resetUser = null;
        $response = $this->Framework->Password->reset($input, function($user, $password) use (&$resetUser) {
            $user->password = $this->Hash->make($password);
            $user->save();
            $resetUser = $user;
        });

        switch($response) {
            case \Password::INVALID_PASSWORD:
            case \Password::INVALID_TOKEN:
            case \Password::INVALID_USER:
                $this->message = 'There were validation errors.';
                $this->errors = $this->Lang->get($response);
                return false;
                break;

            case \Password::PASSWORD_RESET:
                $this->Auth->login($resetUser);
                $this->message = 'Password successfully changed.';
                return true;
                break;
        }
    }

    /**
     * Process user activation request.
     *
     * @param  integer  $userId
     * @param  string   $activateCode
     * @return False | DeviseUser
    */
    public function activate($userId, $activateCode)
    {
        $user = $this->UsersRepository->findById($userId);

        if($activateCode === $user->activate_code) {
            $this->UserManager->activate($user); // activate the user

            $this->Auth->login($user); // auto-login newly activated user

            $this->message = 'Account successfully activated.';
            return true;
        }

        $this->message = 'Issues occurred while attempting to activate account. Please contact support.';
        return false;
    }

    /**
     * Send activation email.
     *
     * @param  DvsUser  $user
     * @return Void
    */
    public function sendActivationEmail($user)
    {
        if($user->activated != true) // check user has not been activated
        {
            $data['user'] = $user; // sets user variable in welcome blade

            $this->Framework->Mail->send('devise::emails.welcome', $data, function($message) use ($data) {
                $message->to($data['user']->email)
                    ->from('noreply@devisephp.com')
                    ->subject('Welcome to Devise!');
            });

            $this->message = 'Activation email sent, check your email to complete the activation process.';
            return true;
        }
        else
        {
            $this->message = 'User has already been activated. No activation email sent.';
            return false;
        }
    }

    /**
     * Validate user credentials (without logging user into system)
     *
     * @return Boolean
     */
    public function validateCredentials($credentials)
    {
        return $this->Auth->validate($credentials);
    }

    /**
     * Get "remember_me" field value
     *
     * @return Boolean
     */
    public function getRememberMe($input)
    {
        return (in_array('remember_me', array_keys($input))) ? true : false;
    }

    /**
     * Iterates through an array of username/email fields in the
     * users table and attempts to authenticate an instance of DvsUser
     *
     * @param  array  $input
     * @return DvsUser | false
     */
    protected function attemptUserLogin($input)
    {
        // fieldnames in order or precedence
        $fieldnames = ['username', 'email'];

        foreach($fieldnames as $fieldname)
        {
            if($this->Auth->attempt(array(
                $fieldname => $input['uname_or_email'],
                'password' => $input['password']),
                $this->getRememberMe($input)
            )) {

                return $this->retrieveUserFindMethodByField($fieldname, $input['uname_or_email']);

            }
        }

        return false;
    }

    /**
     * Gets the proper UsersRepository find method for a user
     * based on the fieldname being passed in.
     *
     * @param  string  $fieldname
     * @param  string  $value
     * @return DvsUser
     */
    protected function retrieveUserFindMethodByField($fieldname, $value)
    {
        switch($fieldname)  {
            case "username":
                return $this->UsersRepository->findByUsername($value);

            case "email":
                return $this->UsersRepository->findByEmail($value);
        }
    }

}