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
        $this->Password = $Framework->Password;
        $this->Validator = $Framework->Validator;
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
            if($this->Auth->attempt(array('email' => $input['email'], 'password' => $input['password']), $this->getRememberMe($input))) {
                $user = $this->UsersRepository->findByEmail($input['email']);
                $this->message = 'You have been logged in.';
                return $user;
            } else {
                $this->message = 'There were validation errors.';
                $this->errors = 'Incorrect email and/or password. Please try again.';
                return false;
            }
        } catch (UserNotFoundException $e) {
            $this->message = 'User not found.' ;
            return false;
        } catch (UserNotActivatedException $e) {
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
     * Register new user
     *
     * @param  array  $input
     * @return Boolean
    */
    public function register($input)
    {
        $validator = $this->Validator->make($input, $this->DvsUser->registerRules, $this->DvsUser->messages);

        if($validator->fails()) {
            $this->message = 'There were validation errors.';
            $this->errors = $validator->errors()->all();
            return false;
        } else {
            $this->UsersRepository->store(array_except($input, array('_token', 'password_confirmation')));
            $this->message = 'User successfully created, check your email to complete the activation process.';
            return true;
        }
    }

    /**
     * Resends activate email using submitted email address
     *
     * @param  array  $input
     * @return Void
    */
    public function resendActivation($input)
    {
        $validator = $this->Validator->make($input, $this->DvsUser->resendActivationRules, $this->DvsUser->messages);

        if($validator->fails()) {
            $this->message = 'There were validation errors.';
            $this->errors = $validator->errors()->all();
            return false;
        } else {
            $data['user'] = $this->UsersRepository->findByEmail($input['email']);

            // check user has not been activated
            if(!$data['user']->isActivated()) {
                // re-send activation/welcome email
                \Mail::send('devise::emails.welcome', $data, function($message) {
                    $message->to('testing@logicbombmedia.com')->from('info@lbm.co')->subject('Welcome to Devise!');
                });

                $this->message = 'Activation email sent, check your email to complete the activation process.';
                return true;
            } else {
                $this->message = 'User has already been activated. No activation email sent.';
                return false;
            }
        }
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

        switch($response = $this->Password->sendResetLink($input)) {
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
        $response = $this->Password->reset($input, function($user, $password) use (&$resetUser) {
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
     * Process user activation request
     *
     * @param  int  $userId
     * @param  string  $activateCode
     * @return False | DeviseUser
    */
    public function activate($userId, $activateCode)
    {
        $user = $this->UsersRepository->findById($userId);

        if($activateCode === $user->getActivateCode()) {
            $this->UserManager->activate($user); // Set activate & activate_code values

            $this->Auth->login($user); // auto-log newly activated user

            $this->message = 'Account successfully activated.';
            return true;
        }

        $this->message = 'Issues occurred while attempting to activate account. Please contact support.';
        return false;
    }

    /**
     * Removes users which have been awaiting activation (after
     * registering). Currently, default is 30 days outstanding
     *
     * @return Boolean
    */
    public function removeUnactivatedUsers($daysOutstanding = 30)
    {
        $outstandingDate = date("Y-m-d H:i:s", strtotime('now -'.$daysOutstanding.' days'));
        if($this->DvsUser->where('activated','=',false)->where('created_at','<=',$outstandingDate)->forceDelete()) {
                return true;
        }

        return false;
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

}