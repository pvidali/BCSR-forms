<?php
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

/*** begin our session ***/
session_start();

/*** first check that both the username, password and form token have been sent ***/
if(!isset( $_POST['phpro_username'], $_POST['phpro_password'], $_POST['form_token']))
{
    $message = 'Please enter a valid username and password';
}
/*** check the form token is valid ***/
elseif( $_POST['form_token'] != $_SESSION['form_token'])
{
    $message = 'Invalid form submission';
}
/*** check the username is the correct length ***/
elseif (strlen( $_POST['phpro_username']) > 20 || strlen($_POST['phpro_username']) < 4)
{
    $message = 'Incorrect Length for Username';
}
/*** check the password is the correct length ***/
elseif (strlen( $_POST['phpro_password']) > 20 || strlen($_POST['phpro_password']) < 4)
{
    $message = 'Incorrect Length for Password';
}
/*** check the username has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['phpro_username']) != true)
{
    /*** if there is no match ***/
    $message = "Username must be alpha numeric";
}
/*** check the password has only alpha numeric characters ***/
elseif (ctype_alnum($_POST['phpro_password']) != true)
{
        /*** if there is no match ***/
        $message = "Password must be alpha numeric";
}
else
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $phpro_username = trim($_POST['phpro_username']);
    $phpro_password = trim($_POST['phpro_password']);

    /*** now we can encrypt the password ***/
    $phpro_password = sha1( $phpro_password );
    
    /*** connect to database ***/
    /*** mysql hostname ***/
    $mysql_hostname = 'localhost';

    /*** mysql username ***/
    $mysql_username = 'webuser';

    /*** mysql password ***/
    $mysql_password = 'bab020211f';

    /*** database name ***/
    $mysql_dbname = 'phpro_auth';


	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();
	
	$sql = "INSERT INTO phpro_users (phpro_username, phpro_password ) VALUES ('$phpro_username', '$phpro_password' )";
	$db->do_query($sql);
	unset( $_SESSION['form_token'] );
	$message = 'New user added';
}

?>

<html>
<head>
<title>Add User</title>
</head>
<body>
<p><?php echo $message; ?>
</body>
</html>
