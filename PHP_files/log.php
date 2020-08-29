<?php

$dbc=mysqli_connect("localhost","root","root","Predictive27");

if(isset($_GET['device_id']) ){
	$device_id=$_GET['device_id'];
	$HallVal=$_GET['HallVal'];
	$AmbiantTemp=$_GET['AmbiantTemp'];
	$AmbiantH=$_GET['AmbiantH'];
	$AcX=$_GET['AcX'];
	$AcY=$_GET['AcY'];
	$AcZ=$_GET['AcZ'];
	$Tmp=$_GET['Tmp'];
	$GyX=$_GET['GyX'];
	$GyY=$_GET['GyY'];
	$GyZ=$_GET['GyZ'];
	$MotorTemp=$_GET['AmbiantTemp'];

				

				if(mysqli_query($dbc,"INSERT INTO raw_log values(null,null,'$device_id','$HallVal','$AmbiantTemp','$AmbiantH','$AcX','$AcY','$AcZ','$Tmp','$GyX','$GyY','$GyZ','$MotorTemp')")){
					echo "ok Entree Numero:".mysqli_insert_id($dbc)."";
				
				}else{echo "Errro ".mysqli_error($dbc)."";
			}

			}

?>