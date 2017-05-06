<?

	session_start();
	//$lastlogin =  date('d-F-Y h:i:s A', time());
	setcookie ("user", "", time()-604800); 
	$_SESSION['username'] = '';
	 
	session_destroy();
	
	header('LOCATION: index.php');
	exit();
	
	 
?>