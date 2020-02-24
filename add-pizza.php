<?php 


	//connecting to the database:
	require('config/db_connect.php');



	//as we are calling this file(the same file) to handle the data coming from the client-side we need to check here at the top if any data was really sent, so that we can handle that (do some checks on it / store in a database).
	
	//initializing the vars that will hold user submited data:
	$email = '';
	$title = '';
	$ingredients = '';


	//arrays to store input related errors:
	$errors = array('email' => '.', 'title' => '.', 'ingredients' => '.');


	//isset(): test if a var has been set (received a value).

	//$_GET/POST: global array that will store all the data sent in a GET/POST request.
	
	//checks if submit element of the $_POST array has been set. If so we know the data was really sent and we can handle it.


	if(isset($_POST['submit'])){


		//check email:
		if(empty($_POST['email'])){

			$errors['email'] = 'An email is required <br />';

		} else {

			//storing the email passed through the form:
			$email = $_POST['email'];

			//checking if it is really a email with a PHP built-in function:
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){

				$errors['email'] = 'Email must be a valid email address!';

			}else{
				$errors['email'] = '';
			}

		}

		//check title:
		if(empty($_POST['title'])){

			$errors['title'] = 'An title is required <br />';

		} else {

			$title = $_POST['title'];

			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){

				$errors['title'] = 'Title must be letters and spaces only!';

			}else{
				$errors['title'] = '';
			}

		}

		//check email:
		if(empty($_POST['ingredients'])){

			$errors['ingredients'] = 'Ingredients are required <br />';

		} else {

			$ingredients = $_POST['ingredients'];

			if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){

				$errors['ingredients'] = 'Ingredients must be a comma separated list!';

			}else{
				$errors['ingredients'] = '';
			}
		}

	} //end of POST check.


	//we wanna check if the form is all valid. If so we won't send the template below again to the user but we'll redirect him to another page.

	//this function checks all elements of the array: If all of them is evaluated falsy values (e.g, empty string is a falsy value) then it returns false. That's an easy way to check if an array is empty.
	//if(!array_filter($errors)){

		//this function redirects the user to the specified URL:
		//header('Location: index.php');

	//}

	if(!$errors['email'] && !$errors['title'] && !$errors['ingredients']){

		//handling possible SQL injections (i.e, malicious SQL sent by an user in the form):

			$email = mysqli_real_escape_string($connection, $_POST['email']);

			$title = mysqli_real_escape_string($connection, $_POST['title']);

			$ingredients = mysqli_real_escape_string($connection, $_POST['ingredients']);

		//writing query command:

			$sql = "INSERT INTO Pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

		//saving to database:

			//this function takes a reference to the database and the sql command we wanna run on it:
			if(mysqli_query($connection, $sql)){ 
			//if we successfully insert the data into the database this functions will return true:

				//success:
				header('Location: index.php');

			}else{

				//error:
				echo "SQL error! " . sqli_error();
			}



		
	}




?>




<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>


	<section class="container grey-text">
		
		<h4 class="center">Add a Pizza</h4>

 
		<!-- The form tag embraces some inputs to be sent to the server together -->

		<!-- GET: sends the data in the URL of the request -->
		<!-- POST: sends the data inside a header in the request -->

		<!-- action: specifies which file on the server will handle that data  -->
		<form class="white" action="add-pizza.php" method="POST">

			<label>Your Email:</label>
			<!-- Here we set the value of the input to be the one the user entered to hone his experience -->
			<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
			<!-- Here we're outputting any validation errors that might have occurred to let the user aweare  -->
			<div class="red-text"><?php echo $errors['email']; ?></div>


			<label>Pizza Title:</label>
			<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
			<div class="red-text"><?php echo $errors['title']; ?></div>


			<label>Ingredientes (comma separated):</label>
			<input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
			<div class="red-text"><?php echo $errors['ingredients']; ?></div>


			<div class="center">
				<input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
			</div>

		</form>

	</section>



	<?php include('templates/footer.php'); ?>

</html>