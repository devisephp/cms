<?php namespace Devise\Support\Installer;

use Devise\Support\Framework;
use Devise\Support\Config\SettingsManager;
use Devise\Support\Console\DeviseInstallCommand;
use Devise\Support\Config\EnvironmentFileManager;
use Illuminate\Support\MessageBag;
use DvsUser;
use DvsGroup;

class InstallWizard
{
	/**
	 * [$errors description]
	 * @var [type]
	 */
	public $errors = [];

	/**
	 * [$SettingsManager description]
	 * @var [type]
	 */
	protected $SettingsManager;

	/**
	 * [$EnvironmentFileManager description]
	 * @var [type]
	 */
	protected $EnvironmentFileManager;

	/**
	 * [$Validator description]
	 * @var [type]
	 */
	protected $Validator;

	/**
	 * [$DatabaseCreator description]
	 * @var [type]
	 */
	protected $DatabaseCreator;

	/**
	 * [$DvsUser description]
	 * @var [type]
	 */
	protected $DvsUser;

	/**
	 * Creats a new Install Wizard...
	 *
	 * @param SettingsManager $SettingsManager
	 */
	public function __construct(SettingsManager $SettingsManager, EnvironmentFileManager $EnvironmentFileManager, Framework $Framework, DatabaseCreator $DatabaseCreator, DeviseInstallCommand $DeviseInstallCommand, DvsUser $DvsUser, DvsGroup $DvsGroup)
	{
		$this->SettingsManager = $SettingsManager;
		$this->EnvironmentFileManager = $EnvironmentFileManager;
		$this->Validator = $Framework->Validator;
		$this->Hash = $Framework->Hash;
		$this->basePath = $Framework->Container->basePath();
		$this->DatabaseCreator = $DatabaseCreator;
		$this->DeviseInstallCommand = $DeviseInstallCommand;
		$this->DvsUser = $DvsUser;
		$this->DvsGroup = $DvsGroup;
	}

	/**
	 * Validates the admin user data for us
	 *
	 * @param  string $email
	 * @param  string $password
	 * @param  string $password_confirmation
	 * @return void
	 */
	public function validateAdminUser($email, $password)
	{
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:8'
		];

		$validator = $this->Validator->make(compact('email', 'password'), $rules);

		if ($validator->fails())
		{
			$this->errors = $validator->errors();
		}
	}

	/**
	 * Create the admin user for the installer. This will
	 * create the user with the email and password given
	 * and then it will also put that user into the admin
	 * group
	 *
	 * @param  string $email
	 * @param  string $password
	 * @return \DvsUser
	 */
	public function createAdminUser($email, $password)
	{
		// create the user
		$user = $this->DvsUser->newInstance();
		$user->email = $email;
		$user->password = $this->Hash->make($password);
		$user->save();

		// add the user to the admin group
		$adminGroup = $this->DvsGroup->whereName('Devise Administrator')->firstOrFail();
		$user->groups()->sync([$adminGroup->id]);

		return $user;
	}

	/**
	 * Saves the environment for us
	 *
	 * @param  string $env
	 * @return void
	 */
	public function saveEnvironment($env)
	{
		$validator = $this->Validator->make(['environment' => $env], ['environment' => 'required|alpha']);

		if ($validator->fails())
		{
			$this->errors = $validator->errors();
			return;
		}

		$this->EnvironmentFileManager->merge(['APP_ENV' => $env]);
	}

	/**
	 * Saves the database settings for us
	 *
	 * @param  string $default
	 * @param  string $host
	 * @param  string $name
	 * @param  string $username
	 * @param  string $password
	 * @return
	 */
	public function saveDatabase($default, $host, $name, $username, $password)
	{
		$settings = [
			'DB_DEFAULT' => $default,
			'DB_HOST' => $host,
			'DB_DATABASE' => $name,
			'DB_USERNAME' => $username,
			'DB_PASSWORD' => $password,
		];

		// we will write out to the database config file one time only
		$this->changeDatabaseConfigFile();

		// check to see if this is valid database settings or not
		if ($this->isValidDatabaseSettings($settings))
		{
			return $this->EnvironmentFileManager->merge($settings);
		}

		// attempt to create the database and then try again
		if ($this->createDatabaseWithSettings($settings))
		{
			return $this->EnvironmentFileManager->merge($settings);
		}

		// well... something screwed up so we need to tell the user about it
		$this->errors = new MessageBag(['database' => 'Invalid database settings, could not connect to this database with given username and password!']);
	}

	/**
	 * [installDevise description]
	 * @return void
	 */
	public function installDevise()
	{
		if (\Schema::hasTable('dvs_pages')) return;

		$env = $this->EnvironmentFileManager->get();

		if (!array_key_exists('APP_KEY', $env))
		{
			$this->EnvironmentFileManager->merge('APP_KEY', \Str::random(42));
		}

		$this->DeviseInstallCommand->handle();
	}

	/**
	 * Reloads env settings and also updates the configurations
	 * in Laravel for anything that might change during the install
	 * process. Things like app.key, app.debug, database stuff, mail
	 * stuff, cache and session settings... this is a hack for people
	 * who use php artisan serve ... no one else really needs this
	 * hackery...
	 *
	 * @return void
	 */
	public function refreshEnvironment(array $settings = array())
	{
		\Dotenv::makeMutable();
		\Dotenv::load(base_path(), '.env');
		\Dotenv::makeImmutable();

		$configToEnvMapping = [
			'app.debug' => 'APP_DEBUG',
			'app.key' => 'APP_KEY',
			'cache.default' => 'CACHE_DRIVER',
			'database.default' => 'DB_DEFAULT',
			'database.connections.mysql.host' => 'DB_HOST',
			'database.connections.pgsql.host' => 'DB_HOST',
			'database.connections.sqlsrv.host' => 'DB_HOST',
			'database.connections.mysql.database' => 'DB_DATABASE',
			'database.connections.pgsql.database' => 'DB_DATABASE',
			'database.connections.sqlsrv.database' => 'DB_DATABASE',
			'database.connections.mysql.username' => 'DB_USERNAME',
			'database.connections.pgsql.username' => 'DB_USERNAME',
			'database.connections.sqlsrv.username' => 'DB_USERNAME',
			'database.connections.mysql.password' => 'DB_PASSWORD',
			'database.connections.pgsql.password' => 'DB_PASSWORD',
			'database.connections.sqlsrv.password' => 'DB_PASSWORD',
			'session.driver' => 'SESSION_DRIVER',
		];

		$merged = array_merge([
			'APP_ENV' => env('APP_ENV', 'local'),
			'APP_DEBUG' => env('APP_DEBUG'),
			'APP_KEY' => env('APP_KEY', 'SomeRandomString'),
			'CACHE_DRIVER' => env('CACHE_DRIVER', 'file'),
			'DB_DEFAULT' => env('DB_DEFAULT', 'mysql'),
			'DB_HOST' => env('DB_HOST', 'localhost'),
			'DB_DATABASE' => env('DB_DATABASE', 'forge'),
			'DB_USERNAME' => env('DB_USERNAME', 'forge'),
			'DB_PASSWORD' => env('DB_PASSWORD', ''),
			'SESSION_DRIVER' => env('SESSION_DRIVER', 'file'),
		], $settings);


		foreach ($configToEnvMapping as $config => $env)
		{
			\Config::set($config, $merged[$env]);
		}

		app()['env'] = $merged['APP_ENV'];
	}

	/**
	 * see if we can connect to the database with these settings
	 *
	 * @param  array $settings
	 * @return boolean
	 */
	protected function isValidDatabaseSettings(array $settings)
	{
		$this->refreshEnvironment($settings);

		try { \DB::connection()->getDatabaseName(); }

		catch (\PDOException $e) { return false; }

		return true;
	}

	/**
	 * create the database with given settings, this will attempt
	 * to create the database with the given name. this will work
	 * for users that are using a root level access account to
	 * connect to mysql. won't work for lower level access though.
	 *
	 * @param  array $settings
	 * @return boolean
	 */
	protected function createDatabaseWithSettings(array $settings)
	{
		extract($settings);

		try { $this->DatabaseCreator->createDatabase($DB_DEFAULT, $DB_HOST, $DB_DATABASE, $DB_USERNAME, $DB_PASSWORD); }
		catch (\PDOException $e) { return false; }

		return $this->isValidDatabaseSettings($settings);
	}

	/**
	 * Changes the default out of the box Laravel database
	 * config to include other env() settings that we will
	 * use in Devise such as 'default' and we also update
	 * the sqlite driver stuff
	 *
	 * @return void
	 */
	protected function changeDatabaseConfigFile()
	{
		$databaseConfigFile = $this->basePath . '/config/database.php';

		$contents = file_get_contents($databaseConfigFile);

		$driver = \Config::get('database.default');

		$modified = str_replace("'default' => '{$driver}',", "'default' => env('DB_DEFAULT', 'mysql'),", $contents);

		if ($contents !== $modified) file_put_contents($databaseConfigFile, $modified);
	}
}