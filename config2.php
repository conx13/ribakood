<?php
	$myServer = "HILLAR_PC\SERVER";
	$connection_info = array( "Database"=>"Uus_kood", "UID"=>"Hillar", "PWD"=>"conx13", "ReturnDatesAsStrings"=> "true", 'CharacterSet'=>'UTF-8'); 
	$conn = sqlsrv_connect($myServer, $connection_info)
  		or die("Kahjuks ei saa serveriga ühendust"); 
?>