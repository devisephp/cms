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
        // needed because namespace *could* change sometimes
		$Framework->Config->set('auth.model', 'DvsUser');

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
		return $this->Redirect->to('install/welcome');
	}

	/**
	 * Welcome the installer/admin
	 *
	 * @return View
	 */
	public function getWelcome()
	{
		if(!$this->InstallWizard->checkAssets()){
			return $this->Redirect->to('install/inform-install-assets');
		}

		return $this->View->make('devise::installer.welcome');
	}

	/**
	 * [getInformInstallAssets description]
	 * @return [type]
	 */
	public function getInformInstallAssets()
	{
		return $this->View->make('devise::installer.assets');
	}

	/**
	 * [getAssets description]
	 * @return [type]
	 */
	public function getAssets()
	{
		if(!$this->InstallWizard->checkAssets()){
			$this->InstallWizard->installAssets();
		}
		return $this->Redirect->to('install/welcome');
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
				return $env == 'local' ? $yes : $no;
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
		$this->InstallWizard->saveNewApplicationKey();

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

		return $this->Redirect->to('install/application');
	}

	/**
	 * Sets up the application
	 *
	 * @return Response
	 */
	public function getApplication()
	{
		$appName = $this->Input->old('app_name', env('APP_NAME', 'App'));
        $migrations = $this->Input->old('app_migrations', env('APP_MIGRATIONS'));
        $seeds = $this->Input->old('app_seeds', env('APP_SEEDS'));
        $configsOverride = $this->Input->old('configs_override', env('CONFIGS_OVERRIDE'));
        $checked = function($fieldname, $yes = 'checked', $no = '') use ($migrations, $seeds, $configsOverride)
        {
        	switch ($fieldname)
        	{
        		case 'migrations': return $migrations === 'yes' ? $yes : $no;
        		case 'seeds': return $seeds === 'yes' ? $yes : $no;
        		case 'configs_override': return $configsOverride === 'yes' ? $yes : $no;
        	}

            return $no;
		};

		return $this->View->make('devise::installer.application', compact('appName', 'migrations', 'seeds', 'configsOverride', 'checked'));
	}

	/**
	 * Save the application setup
	 *
	 * @return Redirect
	 */
	public function postApplication()
	{
		$appName = $this->Input->get('app_name', 'App');

        $migrations = $this->Input->get('app_migrations', 'no');

        $seeds = $this->Input->get('app_seeds', 'no');

        $configsOverride = $this->Input->get('configs_override', 'no');

        $this->InstallWizard->saveConfigsOverride($configsOverride);

		$this->InstallWizard->saveApplicationMigrationAndSeedSettings($migrations, $seeds);

		$this->InstallWizard->saveApplicationNamespace($appName);

		return $this->Redirect->to('install/create-user');
	}

	/**
	 * Show the create user page
	 *
	 * @return View
	 */
	public function getCreateUser()
	{
		$email = $this->Input->old('email', env('ADMIN_EMAIL'));
        $username = $this->Input->old('username', env('ADMIN_USERNAME'));

		return $this->View->make('devise::installer.create-user', compact('email', 'username'));
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
        $username = $this->Input->get('username');
        $password = $this->Input->get('password');

		$this->InstallWizard->validateAdminUser($email, $username, $password);

        if ($this->InstallWizard->errors)
        {
            return $this->Redirect
                ->to('install/create-user')
                ->withErrors($this->InstallWizard->errors)
                ->with('message-errors', 'Error')
                ->withInput();
        }

        $this->InstallWizard->installDevise();

        $newUser = $this->InstallWizard->createAdminUser($email, $username, $password);

		$this->Auth->loginUsingId($newUser->id, true);

		return $this->Redirect->to('/admin');
	}
}