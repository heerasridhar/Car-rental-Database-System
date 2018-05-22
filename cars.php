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

		<h3> Car Details:</h3>


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
			
	if(isset($_POST['submit']))
		{
			$car_id=$_POST['id'];
			$model=$_POST['model'];
			$year = $_POST['year'];
			$owner=$_POST['owner'];
			$car_type=$_POST['type'];

			$startdate = date("Y/m/d");
			
			$enddate=date('Y/m/d', strtotime("+365 days"));


			


			$query = "insert into car(car_id,model,year,owner,car_type) values($car_id,'$model',$year,'$owner','$car_type')";
			$result=mysqli_query($conn,$query);

			$query2 = " insert into availability(car_id,is_available,avai_start,avai_end) values($car_id,'y','$startdate','$enddate')";
			$result2=mysqli_query($conn,$query2);

			echo "Car Information has been added succesfully";
			mysqli_close($conn);

			
		}


?>

		<form class ="car" method="POST" action="cars.php" onsubmit="checkblank()">

			<div class = 'car'> <label>Car Id: </label><input type="text" name="id" placeholder="Enter Car Id" id="id"></div><br>
			<div class = 'car'><label>Car Model: </label><input type="text" name="model" placeholder="Enter Car Model" id="model"></div> <br>
			<div class = 'car'><label>Car Type: </label>
			<select name="type">
					<option value="COMPACT">COMPACT</option>
    				<option value="MEDIUM">MEDIUM</option>
    				<option value="LARGE">LARGE</option>
    				<option value="SUV">SUV</option>
    				<option value="TRUCK">TRUCK</option>
    				<option value="VAN">VAN</option>	
			</select></div> <br>
			<div class = 'car'><label>Car Owner: </label><input type="text" name="owner" placeholder="Enter Car owner" id="owner"> </div><br>

			<div class = 'car'><label>Manufacturing Year: </label><input type="number" name="year" placeholder="Car Manufacture year" id="year"> </div><br>

			<div class = 'car'> <input type="submit" name="submit" value="submit"> </div>

		</form>
	
	</body>
	</html>
