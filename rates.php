<!DOCTYPE html>
<html>
<head lang="en">
	<title> Car Rentals</title>
	<meta charset="utf-8">	
	<link rel="stylesheet" href="css/rentals.css" />
</head>
<body>
				
		<h1>Car Rental System</h1>
		<nav>
				<ul style="list-style: none;">
						<li><a href="customer.php"><b>Customer</b></a></li>
						<li><a href ="cars.php"><b>Cars</b></a></li>
						<li><a href ="reservation.php"><b>Reservation</b></a></li>
						<li><a href ="return.php"><b>Return</b></a></li>
						<li><a href ="rates.php"><b>Rates</b></a></li>							
				</ul>
			</nav>
		<h3>Update Rental Fare:</h3>


		<form class ="rates" method="POST" action="rates.php" onsubmit="checkblank()">
		<div class="rate">
		<label>Choose Car Type : </label>
			<select name="type">
					<option value="COMPACT">COMPACT</option>
    				<option value="MEDIUM">MEDIUM</option>
    				<option value="LARGE">LARGE</option>
    				<option value="SUV">SUV</option>
    				<option value="TRUCK">TRUCK</option>
    				<option value="VAN">VAN</option>	
			</select>
		</div><br>
		<div class="rate">
			<label> Days : </label>
			<select name="days">
					<option value="WEEKLY">WEEKLY</option>
    				<option value="DAILY">DAILY</option>	
			</select>
		</div><br>
		<div class="rate">
			<label>Rates : </label> <input type="text" name="price" id="price">
		</div><br>
		<div class="rate">
			<input type="submit" name="update" id="update" value="Update Fares">
		</div>

		</form>

		<?php 

			$host = "localhost";
			$username = "root";
			$password = "";
			$db = "rentals";
			$conn= mysqli_connect($host, $username, $password, $db); 
			
			$error = mysqli_connect_error();

			if($error != null){
				$output = "<p>Unable to connect<p>" . $error;
				exit($output);
			}
				
	if(isset($_POST['update']))
		{

			$day = $_POST['days'];
			$price = $_POST['price'];
			$type =$_POST['type'];

	if($day === 'WEEKLY')
		{
			$updfare = "update car_type set weekly_rate = $price where type='$type'";
			mysqli_query($conn,$updfare);
			echo "Fares Updated successfully";
		}

	if($day === 'DAILY')
		{
			$updfare = "update car_type set daily_rate = $price where type='$type'";
			mysqli_query($conn,$updfare);
			echo "Fares Updated successfully";
		}


		}


		?>

	</body>
</html>
