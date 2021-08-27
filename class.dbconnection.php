<?

class DBConnection
{

	static function get()
	{

		$dsn = "XXXXXXXXXXXXXXXXXX";
		$options = array(
			PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
		);

		try
		{
			$pdo = new PDO($dsn, "XXXXXXXXXXXXXXXXXX", "XXXXXXXXXXXXXXXXXX", $options);
		}
		catch(Exception $e)
		{
			// error_log($e->getMessage());
			// exit('DB connection failed'); //something a user can understand
			echo '<pre>';
			//echo $e->getMessage();
			echo 'db server down'; die();
			echo '</pre>';
		}

		return $pdo;

	}










}
?>