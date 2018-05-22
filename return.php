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
		<h3>Return A CAR:</h3>

		<form class ="return" method="POST" action="return.php" onsubmit="checkblank()">

			<div class="ret"><label>Cutomer ID:	</label><input type="text" name="cid" id="cid"></div><br>
			<div class="ret"><label>Reservation Number:	</label><input type="text" name="rid" id="rid"></div><br>
			<div class="ret"><input type="submit" name="return" value="RETURN CAR"></div> <br>
		</form>

	
</body>
</html>


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
			
	if(isset($_POST['return']))
		{

	$startdate = date("Y/m/d");
	$custid = $_POST['cid'];
	$resid = $_POST['rid'];
	$carid='';
	$getcarid = "select car_id from reservation where res_id =$resid";
		
					if($gcarid = mysqli_query($conn,$getcarid)) 
						{		
							while ($rid=mysqli_fetch_row($gcarid)) 
							{
								$carid = $rid[0];
							}
						}

	

	$ret = "update availability set avai_start ='$startdate',is_available = 'y' where car_id= '$carid'";
	$tot = "select amt_due from reservation where res_id =$resid";

	if($tot1=mysqli_query($conn,$tot)){
						while ($x=mysqli_fetch_row($tot1)) 
							{
								$totamtdue = $x[0];
							}
						}
	echo "<br>Amount Due :".$totamtdue."<br>";

	mysqli_query($conn,$ret);

	echo "Car return succesful";

}

?>