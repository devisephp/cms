<?php

require_once __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class DeviseTestCase extends Illuminate\Foundation\Testing\TestCase
{
	/**
	 * Setup the application and migrations once
	 * not every time we run a new class
	 *
	 * @var boolean
	 */
	static protected $setup = false;

	/**
	 * Store the application
	 *
	 * @var Container
	 */
	static protected $application;

	/**
	 * Store all the fixtures for this application
	 *
	 * @var array
	 */
	static protected $fixtures;

	/**
	 * Setup the laravel application and run migrations when we first start
	 */
	static public function setUpBeforeClass()
	{
        ini_set('memory_limit', '-1');

		$unitTesting = true;

		$testEnvironment = 'testing';

		if (!static::$setup)
		{
			$loader = require __DIR__ . '/../vendor/autoload.php';

			$loader->setPsr4("App\\", __DIR__ . "/bootstrap/app/");

			static::$application = require __DIR__.'/bootstrap/bootstrap/app.php';

			static::$application->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

			static::setUpFixtures();

			static::runMigrations();

			Artisan::call('db:seed', array('--class' => 'DeviseSeeder'));

			Artisan::call('db:seed', array('--class' => 'DeviseTestsOnlySeeder'));

			static::$setup = true;

			Mail::pretend(true);
		}

		return static::$application;
	}

	/**
	 * Runs the migrations for devise in our sqlite memory db
	 *
	 * @return void
	 */
	static public function runMigrations()
	{
		$migrations = static::$application->make('migration.repository');

		if (! $migrations->repositoryExists()) $migrations->createRepository();

		$migrator = static::$application->make('migrator');

		$migrator->run(__DIR__.'/../src/migrations');
	}

	/**
	 * Setup fixtures for all tests
	 */
	static public function setUpFixtures()
	{
		$fixtures = array();
		$basePath = __DIR__ . '/fixtures';

		static::$fixtures = static::fillArrayWithFileNodes(new DirectoryIterator($basePath));
	}

	/**
	 * Recursively fill up array with files and data
	 *
	 * @param  DirectoryIterator $dir
	 * @return array
	 */
	static public function fillArrayWithFileNodes(DirectoryIterator $dir)
	{
		$data = array();

		foreach ($dir as $node)
		{
			// $ext = $node->getExtension();
			$fullext = ltrim(strstr($node->getBasename(), '.'), '.');
			$filename = $node->getBasename(".{$fullext}");
			$fullpath = $node->getRealPath();

			if ($node->isDir() && !$node->isDot())
			{
				$data[$node->getFilename()] = static::fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()));
			}
			else if ($node->isFile())
			{
                switch ($fullext)
                {
                    case 'php':
                        $data[$filename] = include($fullpath);
                        break;
                    case 'blade.php':
                        $data[$filename] = file_get_contents($fullpath);
                        break;
                    default:
                        $data[$filename] = $fullpath;
                }
			}
		}

		return $data;
	}

	/**
	 * Tear down method. Undo database transactions
	 *
	 * @return void
	 */
	public function tearDown()
	{
		// bug in laravel if we try to rollback
		// when there was no database actions
		// then we will end up with negative
		// transactionLevel so we need to double
		// check this before we try to rollback
		if (DB::transactionLevel() > 0)
		{
			DB::rollback();
		}

		\Mockery::close();
	}

	/**
	 * Use this when we need to reset things (like IoC bindings)
	 * inside of our Laravel application
	 *
	 * @return void
	 */
	public function resetApplication()
	{
		static::$setup = false;

		return static::setUpBeforeClass();
	}

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		DB::beginTransaction();

		return static::$application;
	}

	/**
	 * Returns the fixtures for our testing
	 *
	 * @param  string $name
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function fixture($name, $default = null)
	{
		$branch = static::$fixtures;
		$paths = explode('.', $name);

		foreach ($paths as $path)
		{
			if (!isset($branch[$path])) return $default;
			$branch = $branch[$path];
		}

		return $branch;
	}
}