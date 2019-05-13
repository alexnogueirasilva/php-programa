<?php
include 'def.php';

class Database 
{
	
	public static function connect()
	{
		try		{
			$DB_con = new PDO("mysql:host=". DB_HOST .";dbname=". DB_NAME.";charset=utf8", DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)		{
			echo $e->getMessage();
		}
		return $DB_con;
		mysql_query("SET NAMES 'utf8'");
	}

	public static function disconnect()
	{
		$DB_con = null;
	}

}



?>