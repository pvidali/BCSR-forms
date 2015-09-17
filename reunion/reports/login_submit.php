<?php
ini_set("display_errors","On");
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));

/*** begin our session ***/
session_start();

$add_fail_link = true;
/*** check if the users is already logged in ***/
if(isset( $_SESSION['user_id'] ))
{
    $message = 'Users is already logged in';
}
/*** check that both the username, password have been submitted ***/
if(!isset( $_POST['phpro_username'], $_POST['phpro_password']))
{
    $message = 'Please enter a valid username and password';
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
    
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/DB.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/define-connect.php";
	$db = new DB(HOST,USER,PASSWORD,DATABASE);
	$db->connect();

    /*** connect to database ***/
    /*** mysql hostname ***/
    $mysql_hostname = HOST;

    /*** mysql username ***/
    $mysql_username = USER;

    /*** mysql password ***/
    $mysql_password = PASSWORD;

    /*** database name ***/
    $mysql_dbname = 'phpro_auth';


	$sql = "SELECT phpro_user_id, phpro_username, phpro_password FROM phpro_users WHERE phpro_username = '$phpro_username' AND phpro_password = '$phpro_password'";
	$db->do_query($sql);
	$user_id = $db->fetchObject();

	/*** if we have no result then fail boat ***/
	if($user_id == false)
	{
			$message = 'Login Failed';
	}
	/*** if we do have a result, all is well ***/
	else
	{
			/*** set the session user_id variable ***/
			$_SESSION['user_id'] = $user_id;
			
			$add_fail_link = false;

			/*** tell the user we are logged in ***/
			$message = '<p>You are now logged in.</p>';
			if($phpro_username == 'fwstats'){
				$message .= '<a href="overall/index.php">View the stats</a>';
			}
			else{
				$message .= '<a href="overall/index.php">View the overall stats</a><br />';
				$message .= '<a href="detailed/index.php">View the detailed stats</a><br />';
			}
			header("Location: index.php");
	}	

}
?>

<html>
<head>
<title>Login</title>
</head>
<body>
<p><?php echo $message; ?></p>
<?php
if($add_fail_link){
	echo '<p><a href="login.php">Back to login page</a></p>	';
}
?>

</body>
</html>
