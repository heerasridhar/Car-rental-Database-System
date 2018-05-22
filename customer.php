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
		<h3> customer Details:</h3>

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
			$name=$_POST['name'];
			$emailid=isset($_POST["email"]);
			$emailid = $_POST['email'];
			$phone=$_POST['phone'];

			$query = "insert into customer(name,phone,email) values('$name','$phone','$emailid')";
			$result=mysqli_query($conn,$query);
			mysqli_close($conn);
		}
?>


		<form class="customer" method="POST" action="customer.php" onsubmit="checkblank()">
			<div class = 'customer'>

				<label>Customer Name:    </label><input type="text" name="name" placeholder="Enter Customer name" id="name">	
			</div><br>
			<div class = 'customer'>

				<label>Customer phone:    </label><input type="number" name="phone" placeholder="Enter phone number" id="phone">	
			</div><br>

			<div class = 'customer'>

				<label>Customer Email:    </label><input type="email" name="email" placeholder="Enter Customer email" id="email">	
			</div> <br>
			<div class = 'customer'>

				<input type="submit" name="submit" value="submit">
			</div>
		</form>




</body>

</html>