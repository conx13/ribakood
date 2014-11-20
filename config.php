<?php
	//$myServer = "84.50.247.98:2100";
	$myServer = "HILLAR_PC\SERVER";
    $database = "Ribakood";
    $kasutaja= "Hillar";
    $pass="conx13";
	$connection_info = array( "Database"=>"Ribakood", "UID"=>"Hillar", "PWD"=>"conx13", "ReturnDatesAsStrings"=> "true", 'CharacterSet'=>'UTF-8'); 
	//$conn = mssql_connect($myServer,"Hillar", "conx13")
	$conn = sqlsrv_connect($myServer, $connection_info)
  		or die("Kahjuks ei saa serveriga ühendust");

    try {
        $conn_pdo= new PDO("sqlsrv:server=$myServer; Database=$database",$kasutaja, $pass );
        $conn_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){ 
    die( print_r($e->getMessage())); 
    };
?>