<?php
session_start();
//kontrollime kas on aktiivne sessioon

if (isset($_SESSION['kasutaja']))//kontrollin kas on selline muutuja
{
	if(strlen($_SESSION['kasutaja']) && strlen($_SESSION['parool']))//kontrollin kas muutujal on sisu
	{
		//echo "on olemas nimi ja pass";
		$path=$_SERVER['DOCUMENT_ROOT'];
		include($path ."/config.php");
		$pass= sha1 ($_SESSION['parool']);
		$query = "SELECT COUNT(KID) FROM KASUTAJAD WHERE Kasutaja = '" .addslashes($_SESSION['kasutaja']). "' AND Parool = '" .addslashes($pass)."'";
		$result = sqlsrv_query($conn, $query);
		$rida = sqlsrv_fetch_array($result); //kas on tulem suurem kui 1
		//echo $rida["0"];
		//kui nimi ja parool ei klapi
			if($rida["0"]!=1) { //saadame kasutaja logimise lehele
				header("Location:/login/login.php?Vale_pass");
				echo("<p> Ei ole oige pass </p>");
				exit();
			}
	}
	//juhul kui muutujatel ei ole sisu
	else //Saadame kasutaja logimisele
	{
		//echo ("muutujad on, aga sisu mitte");
		header("Location:/login/Login.php?Tyhi_muutuja");
		exit();
	}
}
else //kui ei ole sellist muutujat
{
	//echo ("ei ole muutujat");
	header("Location:/login/login.php?Puudub_muutuja");
	exit();
}


