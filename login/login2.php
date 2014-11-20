<?php
//Kui on olemas kasutajanimi ja parool
ini_set('default_charset', 'utf-8');

if(strlen($_POST['kasutaja']) && strlen($_POST['parool']))
{
	$path=$_SERVER['DOCUMENT_ROOT'];
	include($path ."/config.php");
	$pass= sha1 ($_POST['parool']);
	$query = "SELECT COUNT(KID) FROM KASUTAJAD WHERE Kasutaja = '" .addslashes($_POST['kasutaja']). "' AND Parool = '" .addslashes($pass)."'";
	
	$result = sqlsrv_query($conn, $query, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET));
	
	$rida = sqlsrv_fetch_array($result); //kas on tulem suurem kui 1
	$numRows = sqlsrv_num_rows( $result );//loeme kokku mitu rida tuli
	if ($rida["0"]==1) {
		session_start();
		$_SESSION['kasutaja'] = ucfirst($_POST['kasutaja']);
		$_SESSION['parool'] = $_POST['parool'];
		//echo ("Kõik on ok");
		header("Location:/tool/rTool.php");
			exit();	
	}
	else {
		//echo("Vale parool või nimi");
		header("Location:/login/login.php?Vale_nimi_pass");
		exit();
	}
}
else //juhul kui kasutaja on tyhi
{
	//echo("Kui nime või parooli aken oli tyhi");
	header("Location:/login/login.php?Tyhi_nimi");
	exit();
}
