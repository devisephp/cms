<?php

require_once __DIR__ . '/../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class DeviseTestCase extends Illuminate\Foundation\Testing\TestCase
{
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
		$unitTesting = true;

		$testEnvironment = 'testing';

		static::$application = require __DIR__.'/bootstrap/bootstrap/start.php';

		static::setUpFixtures();

		// Artisan::call('migrate');
		// Artisan::call('db:seed', ['--class' => 'fixtures\seeder']);
		// Mail::pretend(true);

		return static::$application;
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
				$data[$filename] = $fullext == 'php' ? include($fullpath) : file_get_contents($fullpath);
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
		// DB::rollback();
	}

	/**
	 * Use this when we need to reset things (like IoC bindings)
	 * inside of our Laravel application
	 *
	 * @return void
	 */
	public function resetApplication()
	{
		return static::setUpBeforeClass();
	}

	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		// DB::beginTransaction();

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