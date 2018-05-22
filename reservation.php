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
		<h3>Car Reservation:</h3>

		<form class ="car" method="POST" action="reservation.php" onsubmit="checkblank()">

			
			<div class="res"><label>Type of car:	</label>
				<select name="type">
    				<option value="COMPACT">COMPACT</option>
    				<option value="MEDIUM">MEDIUM</option>
    				<option value="LARGE">LARGE</option>
    				<option value="SUV">SUV</option>
    				<option value="TRUCK">TRUCK</option>
    				<option value="VAN">VAN</option>
				</select>  
			</div><br>
			<div class="res"><label> Start Date:	</label><input type='date' name='start' id='start' >
				<label> End Date:	</label><input type='date' name='end' id='end' >
			</div><br>

			<div class="res"><input type="submit" name="submit" value="search Available Cars"></div>

		</form>
		
			<?php 
			
			session_start();


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

				
				$type = $_POST['type'];

				$_SESSION['type'] = $type;

				$start = $_POST['start'];

				$_SESSION['start'] = $start;
				$end = $_POST['end'];

				
				$squery = "select c.car_id,avai_start,avai_end,model,car_type,is_available from car c join availability a ON c.car_id = a.car_id where car_type='$type' and avai_start <='$start' and avai_end >='$end'";



				if($result=mysqli_query($conn,$squery))
				{


				while ($row=mysqli_fetch_row($result)) {

					if(( $start >= $row[1] && $start <= $row[2] ) && ($end >= $row[1] && $end <= $row[2] ) ) 
						{

							$avai_car[] = $row[0];
							$avai_model[] = $row[3];

						}
					else{
						echo "<br><table><tr> Unavailable </tr></table>";
						}
					}

				} 

				$wrate =$drate ='';
				$weekly = "select weekly_rate from car_type where type ='$type'";
				$daily = "select daily_rate from car_type where type ='$type'";
				if($weekrate=mysqli_query($conn,$weekly)){
					while ($wrow=mysqli_fetch_row($weekrate)) 
						{

							$wrate = $wrow[0];
						}
					}
				
				if($dailyrate=mysqli_query($conn,$daily)){
					while ($drow=mysqli_fetch_row($dailyrate)) 
						{

							$drate = $drow[0];
						}
				}
				echo "<br><div class='res'> <label>Weekly Rates:</label>".$wrate."<label>&nbsp &nbspDaily Rates: </label>".$drate."</div>";


			}
			?>

		<form class ="reserve" method="POST" action="reservation.php" onsubmit="checkblank()">

			<br><div class="res">
			
			<label>Available Cars :</label>
			<select name="selmodel">
				<?php 
					foreach ($avai_model as $model):
						echo "<option value'".$model."'>".$model."</option>";
					endforeach;
				?>

			</select>

			
				
				<br><div class="res"><label>Customer Id:	</label><input type="text" id ='cid' name='cid'>  </div> <br>
				<br><div class="res"><label>Weekly / Daily : </label>
										<select name="days">
											<option value="weekly">Weekly</option>
											<option value="daily">Daily</option>
										</select>	</div> <br>
				<div class="res"><label>Number of Days/Weeks </label><input type="text" id="no" name="no"></div> <br>

			<input type = "submit" value="Reserve Car" name="reserve">
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

			if(isset($_POST['reserve']))
				{
					$custid = $_POST['cid'];
					 $smodel = $_POST['selmodel'];

					$wrate =$drate ='';
					
					$type = $_SESSION['type'];
					$start = $_SESSION['start'];

					$weekly = "select weekly_rate from car_type where type ='$type'";
					$daily = "select daily_rate from car_type where type ='$type'";

					if($weekrate=mysqli_query($conn,$weekly)){
						while ($wrow=mysqli_fetch_row($weekrate)) 
							{
								$wrate = $wrow[0];
							}
						}
					
					if($dailyrate=mysqli_query($conn,$daily)){
						while ($drow=mysqli_fetch_row($dailyrate)) 
							{
								$drate = $drow[0];
							}
						}


					$smodel = $smodel;
					$scarid ='';
					$que = "select car_id from car where model='$smodel'";
					if($carid = mysqli_query($conn,$que)){
							while ($scar=mysqli_fetch_row($carid)) 
							{
								$scarid = $scar[0];
							}
					}
					$day = $_POST['days'];
					$no = $_POST['no'];
					$totrate='';

					if($day === 'weekly'){
						$totrate = $no * $wrate;
						$ds = $no*7;
						
						$enddate=date('Y/m/d', strtotime($start. ' + '.$ds.' days'));
						$weekque = "insert into weekly_rental(car_id,custid,weeks,start_date,return_date) values($scarid,$custid,$no,'$start','$enddate')";

						mysqli_query($conn,$weekque);

					}
					if($day === 'daily'){
						$totrate = $no * $drate;

						$enddate=date('Y/m/d', strtotime($start. ' + '.$no.' days'));

						$dailyque = "insert into daily_rental(car_id,custid,days,start_date,return_date) values($scarid,$custid,$no,'$start','$enddate')";
							
						mysqli_query($conn,$dailyque);

					}

					$reser = "insert into reservation(amt_due,car_id,custid) values($totrate,$scarid,$custid)";
					mysqli_query($conn,$reser);

					$upavai = "update availability set avai_start = '$enddate' where car_id='$scarid'";
					mysqli_query($conn,$upavai);

					$resque = "select res_id from reservation where car_id='$scarid'";
					$updis = "update availability set is_available='n' where car_id='$scarid'";
					mysqli_query($conn,$updis);

					if($resid = mysqli_query($conn,$resque)) {
							while ($rid=mysqli_fetch_row($resid)) 
							{
								$idr = $rid[0];								
							}
					}
					echo "<br> Customer ID: ".$custid ."<br>";
					echo "Reservation ID:   ".$idr."<br>";
					echo "Amount Due:".$totrate."<br>";
					echo "Reservation Successful";

				}

				?>
				
		



 </body>
 </html>