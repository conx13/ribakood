<?php
session_start();
//kontrollime kas on aktiivne sessioon

if (isset($_SESSION['kasutaja']))//kontrollin kas on selline muutuja
{
	if(strlen($_SESSION['kasutaja']) && strlen($_SESSION['parool']))//kontrollin kas muutujal on sisu
	{
		include("config.php");
		$pass= sha1 ($_SESSION['parool']);
		$query = "SELECT COUNT(KID) FROM KASUTAJAD WHERE Kasutaja = '" .addslashes($_SESSION['kasutaja']). "' AND Parool = '" .addslashes($pass)."'";
		$result = sqlsrv_query($conn, $query);
		$rida = sqlsrv_fetch_array($result); //kas on tulem suurem kui 1
		//kui nimi ja parool ei klapi
			if($rida["0"]!=1) { //saadame kasutaja logimise lehele
				header("Location:Login.php");
				//echo("<p> Ei ole oige pass </p>");
				exit();
			}
	}
	//juhul kui muutujatel ei ole sisu
	else //Saadame kasutaja logimisele
	{
		header("Location: Login.php");
		exit();
	}
}
else //kui ei ole sellist muutujat
{
	header("Location: Login.php");
	exit();
}
?>

