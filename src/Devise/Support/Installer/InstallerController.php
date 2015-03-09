<?php namespace Devise\Support\Installer;

use Devise\Support\Framework;
use Illuminate\Routing\Controller;
use Devise\Support\DeviseValidationException;

class InstallerController extends Controller
{
	/**
	 * [__construct description]
	 * @param Framework     $Framework
	 * @param InstallWizard $InstallWizard
	 */
	public function __construct(Framework $Framework, InstallWizard $InstallWizard)
	{
		$this->InstallWizard = $InstallWizard;
        $this->Auth = $Framework->Auth;
		$this->Input = $Framework->Input;
        $this->Redirect = $Framework->Redirect;
        $this->View = $Framework->View;
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return Redirect
	 */
	public function getIndex()
	{
		$this->InstallWizard->checkAssets();

		return $this->Redirect->to('install/welcome');
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return View
	 */
	public function getWelcome()
	{
		return $this->View->make('devise::installer.welcome');
	}

	/**
	 * Show environment page
	 *
	 * @return View
	 */
	public function getEnvironment()
	{
		$environment = $this->Input->old('environment', env('APP_ENV'));

		$environment = $environment === 'custom' ? $this->Input->old('custom_environment', 'myenv') : $environment;

		$selectedEnvironment = function($env, $yes = 'selected', $no = '') use ($environment)
		{
			if (!in_array($environment, [ 'local', 'staging', 'production' ]))
			{
				return $env == 'custom' ? $yes : $no;
			}

			return $env == $environment ? $yes : $no;
		};

		return $this->View->make('devise::installer.environment', compact('environment', 'selectedEnvironment'));
	}

	/**
	 * Save the environment
	 *
	 * @return Redirect
	 */
	public function postEnvironment()
	{
		$environment = $this->Input->get('environment') === 'custom' ? $this->Input->get('custom_environment') : $this->Input->get('environment');

		$this->InstallWizard->saveEnvironment($environment);

		if ($this->InstallWizard->errors)
		{
			return $this->Redirect
						->to('install/environment')
						->withErrors($this->InstallWizard->errors)
            			->with('message-errors', 'Error')
						->withInput();
		}

		return $this->Redirect->to('install/database');
	}

	/**
	 * Show the database page
	 *
	 * @return View
	 */
	public function getDatabase()
	{
		$database = new \StdClass;
		$database->type = $this->Input->old('database_default', env('DB_DEFAULT'));
		$database->host = $this->Input->old('database_host', env('DB_HOST'));
		$database->name = $this->Input->old('database_name', env('DB_DATABASE'));
		$database->username = $this->Input->old('database_username', env('DB_USERNAME'));
		$database->password = $this->Input->old('database_password', env('DB_PASSWORD'));

		$selected = function($type, $yes = 'selected', $no = '') use ($database)
		{
			return $type == $database->type ? $yes : $no;
		};

		return $this->View->make('devise::installer.database', compact('database', 'selected'));
	}

	/**
	 * Save the database
	 *
	 * @return Redirect
	 */
	public function postDatabase()
	{
		$type = $this->Input->get('database_default');
		$host = $this->Input->get('database_host');
		$name = $this->Input->get('database_name');
		$username = $this->Input->get('database_username');
		$password = $this->Input->get('database_password');

		$this->InstallWizard->saveDatabase($type, $host, $name, $username, $password);

		if ($this->InstallWizard->errors)
		{
			return $this->Redirect
						->to('install/database')
						->withErrors($this->InstallWizard->errors)
            			->with('message-errors', 'Error')
            			->withInput();
		}

		return $this->Redirect->to('install/create-user');
	}

	/**
	 * Show the create user page
	 *
	 * @return View
	 */
	public function getCreateUser()
	{
		$email = $this->Input->old('email');

		return $this->View->make('devise::installer.create-user', compact('email', 'password'));
	}

	/**
	 * Save the new user and redirect them to the
	 * settings wizard
	 *
	 * @return Redirect
	 */
	public function postCreateUser()
	{
		$email = $this->Input->get('email');

		$password = $this->Input->get('password');

		$this->InstallWizard->validateAdminUser($email, $password);

		if ($this->InstallWizard->errors)
		{
			return $this->Redirect
						->to('install/create-user')
						->withErrors($this->InstallWizard->errors)
            			->with('message-errors', 'Error')
						->withInput();
		}

		$this->InstallWizard->installDevise();

		$newUser = $this->InstallWizard->createAdminUser($email, $password);

		$this->Auth->loginUsingId($newUser->id, true);

		return $this->Redirect->to('admin/installed');
	}
}