<?php 
	
	//we're gonna connect to the database right here.
	
	//So, to communicate with the database we can use: MySQLi(mproved) or PDO (PHP data objects).


	//connecting:
		
		//storing a reference to that database in this var.
		$connection = mysqli_connect('localhost', 'vitor', 'vitor123', 'Ruffos_Pizza');
		//parameters: host name, username, password, database name.

	//checking the connection:

		if(!$connection){

			echo 'Database connection error: ' . mysqli_connect_error();

		}


?>