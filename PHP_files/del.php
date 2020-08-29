<?php

	if (isset($_GET['motor_id'])){
	$motor_id=$_GET['motor_id'];
	$dbc=mysqli_connect("localhost","root","root","Predictive27");

	if(mysqli_query($dbc,"DELETE FROM devices WHERE id='$motor_id'")){
		?>
		<script>
			location.replace("index.php")
		</script>
		<?php
	}else{
		echo "<h2>Errro ".mysqli_error($dbc)."<br><br>";
		}

	}
?>