<?php
class DB {
	
    // Connection parameters 
    var $host           	= '';
    var $user           	= '';
    var $password       	= '';
    var $database			= '';
    var $statement			= '';
    var $connection     	= NULL;           // Database connection handle 
    var $query_result   	= false;          // Query query_result 
    

    // constructor
    function DB( $host, $user, $password, $database){//, $statement){
        $this->host 		= $host;
        $this->user 		= $user;
        $this->password 	= $password;
        $this->database 	= $database;
        //$this->statement	= $statement;
    }

		function connect() {
        // Connect to the MySQL server 
        $this->connection = mysql_connect($this->host, $this->user, $this->password)
									or die("Couldn't connect.");
									
        // Now select the database...
        mysql_select_db($this->database, $this->connection)
									or die("Couldn't select DB.");

        //return true;
    }
    
    function do_query($thisStatement){
        $this->query_result = mysql_query($thisStatement, $this->connection);
	
        //return ($this->query_result);
    }
    
    function numRows(){
        return (mysql_num_rows($this->query_result));
    }
    
    function close(){
        return (mysql_close($this->connection));
    }

    function error(){
        return (mysql_error());
    }

    function affectedRows(){
        return (mysql_affected_rows($this->connection));
    }

    function fetchObject(){
        return (mysql_fetch_object($this->query_result));
    }

    function fetchArray(){
        return (mysql_fetch_array($this->query_result));
    }

    function fetchAssoc(){
        return (mysql_fetch_assoc($this->query_result));
    }

    function freequery_result(){
        return (mysql_free_query_result($this->query_result));
    }
}
?>