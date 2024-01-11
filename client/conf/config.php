<?php
    $dbuser="root";
    $dbpass="";
    $host="localhost";
    $db="internetbanking";
    // Creating a new MySQLi instance to establish a database connection
    $mysqli=new mysqli($host,$dbuser, $dbpass, $db);
/*
Database Connection Parameters:

$dbuser: The MySQL username used for the database connection. In this case, it's "root."
$dbpass: The password for the MySQL user. In this example, it's an empty string,
 which means no password is set for the "root" user. In a production environment, 
 it's recommended to use a secure password.
$host: The hostname where the MySQL database is running. In this case, it's "localhost," 
indicating that the database is on the same server as the PHP script.
$db: The name of the MySQL database to connect to. In this case, it's "internetbanking."
MySQLi Connection:

The new mysqli() constructor is used to create a new MySQLi instance, 
which represents a connection to the MySQL database.
The constructor takes four parameters:
The host.
MySQL username.
MySQL password.
The name of the MySQL database.
The connection is stored in the variable $mysqli. 
*/