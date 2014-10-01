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
	 * Setup the laravel application and run migrations when we first start
	 */
	static public function setUpBeforeClass()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		static::$application = require __DIR__.'/../bootstrap/start.php';

		// Artisan::call('migrate');
		// Artisan::call('db:seed', ['--class' => 'fixtures\seeder']);
		// Mail::pretend(true);

		return static::$application;
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
}