<?
if(!isset($_SESSION)){ session_start(); }
error_reporting(E_ALL ^ E_NOTICE);

// set the default timezone to use. Available since PHP 5.1
date_default_timezone_set('Asia/Kolkata'); // We are in India ;)


// DATABASE CREDENTIALS
$server = "localhost"; // Define Server
$user = "root"; // Define user "root" or "system"
$password = ""; // password if you have put
$dbName = "faculty"; //database name
 
 // Default User Registrations
 $DefaultRegistration ="user";
  $DefaultUserStatus ="inactive";
 
 
// Our connection to database start here, insert update, delete can be done directly calling this file later.
$conn = mysqli_connect($server,$user,$password,$dbName)
	or die("There was a problem connecting to MySQL. Please try again later.");
	
		/*   if (!@mysqli_select_db($dbName, $conn))
		{
			die ("There was a db problem connecting to the database. Please try again later.");
		}   */
		return $conn;  
?>