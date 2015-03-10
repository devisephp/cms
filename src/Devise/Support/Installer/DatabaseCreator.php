<?php namespace Devise\Support\Installer;

class DatabaseCreator
{
	/**
	 * For mocking...
	 *     ...you suck connection...
	 *        ...see...
	 *               ... I mock you!
	 *
	 * @var \PDO
	 */
	protected $connection;

	/**
	 * Create a new database creator
	 *
	 * @param \PDO $connection
	 */
	public function __construct(\PDO $connection = null)
	{
		$this->connection = $connection;
	}

	/**
	 * Create a new database from given settings
	 *
	 * @param  string $driver
	 * @param  string $host
	 * @param  string $database
	 * @param  string $username
	 * @param  string $password
	 * @return void
	 */
	public function createDatabase($driver, $host, $database, $username, $password)
	{
		$connection = $this->connection($driver, $host, $username, $password);

		$connection->exec("CREATE DATABASE `{$database}`;");
	}

	/**
	 * Creates a new connection for given driver and also constructs a generic dsn
	 *
	 * @param  string $driver
	 * @param  string $host
	 * @param  string $username
	 * @param  string $password
	 * @return \PDO
	 */
	protected function connection($driver, $host, $username, $password)
	{
		$connection = $this->findPdoConnection($driver, $host, $username, $password);

		$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return $connection;
	}

	/**
	 * Creates a PDO connection for us
	 *
	 * @param  string $driver
	 * @param  string $host
	 * @param  string $username
	 * @param  string $password
	 * @return \PDO
	 */
	protected function findPdoConnection($driver, $host, $username, $password)
	{
		if (! is_null($this->connection)) return $this->connection;

		switch ($driver)
		{
			case 'sqlite':
			case 'mysql':
			case 'psgql':
			case 'sqlsrv':
				return new \PDO("{$driver}:host={$host}", $username, $password);
		}

		throw new \Exception("Could not create connection for driver " . $driver);
	}
}