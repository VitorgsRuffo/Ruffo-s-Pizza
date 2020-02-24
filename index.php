<?php 

	//connect to the database:
	require('config/db_connect.php');

	//getting data from database: query commands.

		//constructing the query:
		$sql = 'SELECT title, ingredients, id FROM Pizzas';


		//make the query:
		$result = mysqli_query($connection, $sql);

 
		//fetch the results (rows) from the query as an associative array:
		$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

		//print_r($pizzas);


		//freeing $result var memory as we'not using it anymore:
		mysqli_free_result($result);

		//closing the connection to the database as we already got the data we needed:
		mysqli_close($connection);


?>




<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<h4 class="center grey-text">Pizzas Menu:</h4>

	<div class="container">
		<div class="row">

			<!-- $pizzas array:    
				
				$pizzas = [
					['title' => 'House's Style', 'ingredients' => 'Chesse, Tomato, Potato, Ham', 'id' =>  '1'],
					['title' => 'Ruffo's Best', 'ingredients' => 'SFDFDS, fsdf, sdfds', 'id' =>  '2']
				]

			-->
			
			<!-- Notice we're using an alternative syntax that helps us visualize better where the foreach ends -->
			<!-- Instead of the duo foreach(){ //code }; , we use foreach():   endforeach;  -->
			<?php foreach($pizzas as $piz): ?>

				<div class="col s6 md3">
					<div class="card z-depth-0">
						<div class="card-content center">

							<!-- NEVER trust data sent by the user. We have to make sure we handle possible malicious code that might has been sent to the server before render it to the browse. If there's a script tag in there and we echo it to the browser, it may interpret it as HTML and run a possible bad JS code inside that tag. For that end we use htmlspecialchars function on the data to get rid of html special char (e.g, < >). -->

							<h6><?php echo htmlspecialchars($piz['title']); ?></h6>

							<ul>
								<!-- explode: takes a char and a string. Splits that string where there is that char. Returns each substring inside an array  -->
								<?php foreach(explode(',', $piz['ingredients']) as $ingredients): ?>

									<li><?php echo htmlspecialchars($ingredients); ?></li>

								<?php endforeach; ?>
							</ul>

							<div class="card-action right-align">

								<!-- When we click this anchor tag we're implicitly making a GET request and sending along some data (in the URL), in this case the id of the pizza clicked  -->
								<a class="brand-text" href="details.php?id=<?php echo $piz['id']; ?>">More info</a>
							</div>

						</div>
					</div>
				</div>

			<?php endforeach; ?>

			<!-- Notice we're using an alternative syntax that helps us visualize better where the if statement ends -->
			<!-- Instead of the duo if(){code}else{code}; , we use if(): code else: code endif; -->
			
			<!--
			<?php if(count($pizzas) >= 2): ?>
				<p>There are two or more pizzas!</p>
			<?php else: ?>
				<p>There is less than 2 pizzas!</p>
			<?php endif; ?>
			-->

		</div>
	</div>


	<?php include('templates/footer.php'); ?>

</html>