# php-db-connection-class
This class initially creates a connection to the specified database and has methods for displaying error and querying the database by just passing an SQL string.

# Db($host,$user,$pass,$db)
This class is named Db() and has a constructor function which initialises everything

## __constructor()
The constructor function takes four arguments passed when initialing the object i.e $host, $user, $pass, $db. These are used to initialise a database connection.
The constructor function creates two properties $this->error and $this->conn,
### $this->error
$this->error is used to store error messages if any, the constructor initialises it with null.
### $this->conn
$this->conn is the database connection object the constructor uses to connect to the database using the given parameters.

## get_row($sql)
This method takes an SQL query as parameter and returns the row specified by a parameter in the query from the database as an associative array.

## get_rows($sql)
This method takes an SQL query as parameter and returns all the rows from the database as a numeric two dimensional array.

## insert($sql)
This method takes an SQL query as parameter and setts the $this->error property to the error if an error occurs.
It can be used to insert, update, delete, alter, drop and truncate tables and rows.
