<?php namespace Devise\User\Repositories;

use Auth;
use DvsUser;
use Exception;
use Hash;
use Lang;
use Mail;
use Password;
use Validator;

class SessionsRepository {
    protected $DvsUser;
    protected $UsersRepository;
    public $message;
    public $errors;

    public function __construct(DvsUser $DvsUser, UsersRepository $UsersRepository)
    {
        $this->DvsUser = $DvsUser;
        $this->UsersRepository = $UsersRepository;
    }

    /**
     * Login user
     *
     * @param  array  $input
     * @return User
    */
    public function login($input)
    {
        try {
            if(Auth::attempt(array('email' => $input['email'], 'password' => $input['password']), $this->getRememberMe($input))) {
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
        Auth::logout();

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
        $validator = Validator::make($input, $this->DvsUser->registerRules, $this->DvsUser->messages);

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
        $validator = Validator::make($input, $this->DvsUser->resendActivationRules, $this->DvsUser->messages);

        if($validator->fails()) {
            $this->message = 'There were validation errors.';
            $this->errors = $validator->errors()->all();
            return false;
        } else {
            $data['user'] = $this->UsersRepository->findByEmail($input['email']);

            // check user has not been activated
            if(!$data['user']->isActivated()) {
                // re-send activation/welcome email
                Mail::send('devise::emails.welcome', $data, function($message) {
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
    * Handle a POST request for "remind password"
    *
    * @param  array  $input
    * @return Response
    */
    public function remind($input)
    {
        switch($response = Password::remind($input)) {
            case Password::INVALID_USER:
                $this->message = 'There were validation errors.';
                $this->errors = Lang::get($response);
                return false;
                break;

            case Password::REMINDER_SENT:
                $this->message = 'Email has been sent.';
                return true;
                break;
        }
    }

    /**
    * Handle POST data from reset (change) password form
    *
    * @param  array $credentials
    * @return Response
    */
    public function reset($credentials)
    {
        $resetUser = null;
        $response = Password::reset($credentials, function($user, $password) use (&$resetUser) {
            $user->password = Hash::make($password);
            $user->save();
            $resetUser = $user;
        });

        switch($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                $this->message = 'There were validation errors.';
                $this->errors = Lang::get($response);
                return false;
                break;

            case Password::PASSWORD_RESET:
                // login user after successful password change
                Auth::login($resetUser);

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
            // Set activate & activate_code values
            $this->UsersRepository->activate($user);

            // auto-log newly activated user into system
            Auth::login($user);

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
        return Auth::validate($credentials);
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
