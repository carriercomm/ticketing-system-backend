<?php 

namespace App\Stryve;

use Config;
use DB;

class ConnectOTF {

	/**
	 * The name of the driver.
	 *
	 * @var string $driver
	 */
	protected $driver;

	/**
	 * The name of the host.
	 *
	 * @var string $host
	 */
	protected $host;

	/**
	 * The port number.
	 *
	 * @var int $port
	 */
	protected $port;

	/**
	 * The name of the database.
	 *
	 * @var string $database
	 */
	protected $database;

	/**
	 * The username needed to connect to the database.
	 *
	 * @var string $username
	 */
	protected $username;

	/**
	 * The password needed to connect to the database.
	 *
	 * @var string $password
	 */
	protected $password;

	/**
	 * The database tables prefix, if any.
	 *
	 * @var string $prefix
	 */
	protected $prefix;

	/**
	 * The on the fly database connection.
	 *
	 * @var \Illuminate\Database\Connection
	 */

	protected $connection;
	/**
	 * Create a new on the fly database connection.
	 *
	 * @param  array $options
	 * @return void
	 */

	$options = [
		'driver'	=> 'pgsql', // or 'mysql'
		'host' 		=> $value,
		'port'		=> $value,
		'database' 	=> $value,
		'username'	=> $value,
		'password' 	=> $value,
		'charset' 	=> $value,
		'prefix' 	=> $value,
		'schema'	=> $value
	];

	public function __construct($options = null)
	{
		// set the connection driver
		$this->setConnectionDriver($options);


		// get the connection driver (eg. mysql, pgsql, etc.)
		// $driver = isset($options['driver']) ? $options['driver'] : $this->getDefaultDriver();

		
		// get default connection options based on provided driver
		$default = $this->getDefaultOptions($driver);

		// replace default options with the options provided
		foreach($default as $item => $value)
			$default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];

		// set the temporary connection
		$this->setTemporaryConfig($driver, $default);

		//**********
		//**********
		//**********

		// set connection options
		$this->database = (isset($options['database'])) ? $options['database'] : Config;

		// Set the database
		$database = $options['database'];
		$this->database = $database;

		// Figure out the driver and get the default configuration for the driver
		$driver  = isset($options['driver']) ? $options['driver'] : Config::get("database.default");
		$default = Config::get("database.connections.$driver");

		// Loop through our default array and update options if we have non-defaults
		foreach($default as $item => $value)
		{
			$default[$item] = isset($options[$item]) ? $options[$item] : $default[$item];
		}

		// Set the temporary configuration
		Config::set("database.connections.$database", $default);

		// Create the connection
		$this->connection = DB::connection($database);

	}

	/**
	 * Get the on the fly connection.
	 *
	 * @return \Illuminate\Database\Connection
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * Get the default connection driver.
	 *
	 * @return string
	 */
	public function getDefaultDriver()
	{
		return Config::get('database.default');
	}

	/**
	 * Get the default connection options.
	 *
	 * @param string $driver
	 * @return array
	 */
	public function getDefaultOptions($driver)
	{
		return Config::get('database.connection.' . $driver);
	}

	/**
	 * Sets the connection driver.
	 *
	 * @param array $options
	 * @return void
	 */
	public function setConnectionDriver($options)
	{
		$this->driver = isset($options['driver']) ? $options['driver'] : Config::get('database.default');
	}

	/**
	 * Gets the connection driver.
	 *
	 * @return string
	 */
	public function getConnectionDriver()
	{
		return $this->driver;
	}

	/**
	 * Sets the temporary connection driver.
	 *
	 * @param string $driver
	 * @return void
	 */
	public function setTemporaryConfig($driver)
	{
		$this->temp_config = Config::set('database.connection', $driver);
	}

	/**
	 * Sets the temporary connection options.
	 *
	 * @param string $driver
	 * @return void
	 */
	public function setTemporaryConfig($driver, $default)
	{
		Config::set('database.connection.' . $driver, $default);
	}

	/**
	 * Get a table from the on the fly connection.
	 *
	 * @var    string $table
	 * @return \Illuminate\Database\Query\Builder
	 */
	public function getTable($table = null)
	{
		return $this->getConnection()->table($table);
	}

}