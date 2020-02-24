<?php 

	//connecting to the database:
	require('config/db_connect.php');


	//checking if the delete button was pressed (handling the request sent when the delete button was pressed).
	if(isset($_POST['delete'])){

		//before make the query we need to scape any possible SQL characters from user input for security reasons:
		$id_to_delete = mysqli_real_escape_string($connection, $_POST['id_to_delete']);


		//create the query command:
		$sql = "DELETE FROM Pizzas WHERE id = $id_to_delete";

		//make the query:	
		if(mysqli_query($connection, $sql)){

			//success:
			header('Location: index.php');

		}else{

			//failure:
			echo 'Query error: ' . mysqli_error($connection);
		}

	}







	//This page will be requested when we click the button 'More info' on the index.php page.
	//It will be used a GET request by default (anchor tags). 
    //We have the option to pass some info on the URL to specify what thing specifically we want this page to render when that
    //specific anchor tag is clicked.

	//here we check if was passed some data in the URL:
	//Here we handle a GET request to this page (sent when you click 'More info' btn or type its URL directly on the browser) where an id value was sent together with it:
    if(isset($_GET['id'])){

    	//we scape any SQL chars sent by user (by security) and save the result:
    	$id = mysqli_real_escape_string($connection, $_GET['id']);


    	//creating query command:	
    	$sql = "SELECT * FROM Pizzas WHERE id=$id";

    	//making the query:
    	$result = mysqli_query($connection, $sql);

    	//fetching and formatting the result to an associative array:
    	$pizza = mysqli_fetch_assoc($result);


    	//freeing result var memory:
    	mysqli_free_result($result);



   	 	//closing the connection to the database:
    	mysqli_close($connection);

    } 
	



?>





<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>


	<div class="container center">

		<?php if($pizza): ?>

			<h4><?php echo htmlspecialchars($pizza['title']); ?></h4>

			<p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>

			<!--date() convert some date passed into a nicer format-->
			<p><?php echo date($pizza['created_at']); ?></p>

			<h5>Ingredients:</h5>
			<p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>


			<!-- Delete pizza form -->

			<!-- Here we make a Post request for details.php. Two key/value pairs are sent to the server: id_to_delete = $pizza['id'] && delete = Delete. They'll be stored on the global associative array $_POST and we'll be able to access them on the details.php script-->
			<form action="details.php" method="POST">
				<input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>

		<?php else: ?>

			<h5>No such pizza exists!</h5>

		<?php endif; ?>
		
	</div>


	<?php include('templates/footer.php'); ?>

</html>