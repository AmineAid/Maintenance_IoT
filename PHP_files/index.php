<table width="100%" style="text-align:center;"> 
	<tr style='background:#C3C3C3; height:100px;'>
		<td width="70%" style="font-size:300%; text-align:left; padding-left:100px;"><b><i><a href="index.php" style='text-decoration:none; color:Black;'>Az Predictive</a></i></b></td>
		<td width="15%" style="font-size:150%;"> <a href="add.php" style='text-decoration:none;'>Ajouter</a> </td>
		<td width="15%" style="font-size:150%;"><a href="#" onclick="document.getElementById('motor').submit();"> Modifier</a></td>
	</tr> 
	<tr>
		<td colspan="3" style='text-align:center;padding-top:30px;padding-bottom:20px;'>

			<form id="motor" action="edit.php"> 
			<table width="90%" style='text-align:center'>
				<tr>
				<td width="20%" style="font-size:180%;"><b>Moteur</b></td>
				<td colspan="3" width="60%" style="font-size:180%;"><b> Informations </td>
				<td width="20%" style="text-align:right;font-size:180%;"><b> Alarmes</td>	
				</tr>
			</table>

<?php
$dbc=mysqli_connect("localhost","root","root","Predictive27");
$query="select * from devices";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
{

	



	$errors = array();
	$id_iot=$row['id_iot'];


	$query2="select * from raw_log WHERE device_id='$id_iot'  ORDER by time desc LIMIT 0,1";
	$result2 = mysqli_query($dbc,$query2);
	$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
	$time=$row2['time'];
	$hall_val=$row2['hall_val'];

	if ($hall_val < $row['hall_val_max'] AND $hall_val > $row['hall_val_min']) $etat='<font color="green">On</font>'; else $etat='<font color="RED">OFF</font>';
	$ambiant_temp=$row2['ambiant_temp'];
	$ambiant_h=$row2['ambiant_h'];
	$acx=$row2['acx'];
	$acy=$row2['acy'];
	$acz=$row2['acz'];
	$tmp=$row2['tmp'];
	$gyx=$row2['gyx'];
	$gyy=$row2['gyy'];
	$gyz=$row2['gyz'];
	$motor_temp=$row2['motor_temp'];

	if($ambiant_temp <= $row['ambiant_temp_min']) array_push($errors, "Temperature Ambiante Trop Basse!");
	if($ambiant_temp >= $row['ambiant_temp_max']) array_push($errors, "Temperature Ambiante Trop Haute!");

	if($ambiant_temp <= $row['ambiant_h_min']) array_push($errors, "Humidite Ambiante Trop Basse!");
	if($ambiant_temp >= $row['ambiant_h_max']) array_push($errors, "Humidite Ambiante Trop Haute!");

	if($acx <= $row['acx_min']) array_push($errors, "Vibrations!");
	if($acx >= $row['acx_max']) array_push($errors, "Vibrations!");

	if($acy <= $row['acy_min']) array_push($errors, "Vibrations!");
	if($acy >= $row['acy_max']) array_push($errors, "Vibrations!");

	if($acz <= $row['acz_min']) array_push($errors, "Vibrations!");
	if($acz >= $row['acz_max']) array_push($errors, "Vibrations!");

	if($gyx <= $row['gyx_min']) array_push($errors, "Vibrations!");
	if($gyx >= $row['gyx_max']) array_push($errors, "Vibrations!");

	if($gyy <= $row['gyy_min']) array_push($errors, "Vibrations!");
	if($gyy >= $row['gyy_max']) array_push($errors, "Vibrations!");

	if($gyz <= $row['gyz_min']) array_push($errors, "Vibrations!");
	if($gyz >= $row['gyz_max']) array_push($errors, "Vibrations!");
	
	if($motor_temp <= $row['motor_temp_min']) array_push($errors, "Temperature Du Moteur Trop Haute!!");
	if($motor_temp >= $row['motor_temp_max']) array_push($errors, "Temperature Du Moteur Trop Haute!!");
	


	if (sizeof($errors) > 0 ) {
		$statepic="notok.png"; 
		$error_message="Erreurs : &#013; ";
	for ($i=0; $i < sizeof($errors) ; $i++) { 
		$error_message.=$errors[$i];
		$error_message.=" &#013; ";
	}
	}else{
		$error_message="OK!";
		$statepic="ok.png" ;
	} 
	
	echo '


		<table width="95%" align="center">
			<tr>
				<td><input type="radio" name="motor_id" value="'.$row['id'].'"></td>
				<td width="20%" style="font-size:200%; text-align:left;">
					<img src="motor.jpg" width="70%">
				</td>
				<td width="20%" style="font-size:150%; padding-left:20px;padding-top:30px;">
					Moteur: '. $row['motor_name'] .' <br><br>Model: '. $row['model'] .'  <br><br>Puissance: '. $row['puissance'] .'W <br><br> Trs/mn: '. $row['tr_min'] .' 
				</td>
				<td width="20%" style="font-size:150%; padding-top:30px;">
					Etat: '.$etat.' <br><br>Temperature: '. $motor_temp .'<br><br>Temperature Amb.:  '. $ambiant_temp .' <br><br>Humidite Amb.: '. $ambiant_h .'
				</td>
				<td width="20%" style="font-size:150%;padding-top:30px;">
					MAJ le '.$time.' <br><br>Gyroscope X:'.$gyx.' <br><br>Gyroscope Y: '.$gyy.' <br><br>Gyroscope Z: '.$gyy.'
				</td>
				<td width="20%" style="font-size:150%; text-align:center; "> 
					<img src="'.$statepic.'" width="80%" title="'.$error_message.'"></td>	
			</tr>
		</table>
		<br><br>';

		


}


?>
		</td>
	   </table>