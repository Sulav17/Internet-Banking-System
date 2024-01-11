<?php
$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "";
$DB_name = "internetbanking";
try
{
    // Creating a new PDO instance to establish a database connection
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 // Set the error mode to throw exceptions on errors
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    // If an exception (error) occurs during connection, catch and handle it
 $e->getMessage();
}
/*Database Connection Parameters:

$DB_host: The hostname where the MySQL database is running. 
In this case, it's "localhost," indicating that the database is on the same server as the PHP script.
$DB_user: The MySQL username used for the database connection. 
In this case, it's "root."
$DB_pass: The password for the MySQL user. In this example, it's an empty string, 
which means no password is set for the "root" user. For a production environment, 
it's recommended to use a secure passwordbut since this is not no password is added.
$DB_name: The name of the MySQL database to connect to. In this case, it's "internetbanking."
PDO Connection:

The try block attempts to create a new PDO instance, 
which represents a connection to the MySQL database.
The new PDO() constructor takes three parameters:
The DSN (Data Source Name), specifying the database driver, host, and database name.
MySQL username.
MySQL password.
The connection is stored in the variable $DB_con.
Error Handling:

The setAttribute method is used to set the error mode to PDO::ERRMODE_EXCEPTION. 
This means that PDO will throw exceptions when errors occur, allowing for better error handling.
The catch block catches any PDOException that might be thrown during the connection attempt.
If an exception occurs, the getMessage() method is called on the exception object ($e) 
to retrieve the error message, and it is echoed to the screen. */