<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	//tekitame sql-i

	if (isset($_POST["nJID"], $_POST["nLeping"], $_POST["nGrupp"], $_POST["nJob"])) {
		$params=array();
		$params[]=$_POST["nLeping"];
		$params[]=$_POST["nGrupp"];
		$params[]=$_POST["nJob"];
		
		if ($_POST["nYhik"] =="") {
			$params[]=NULL;
			$params[]=NULL;
		}else{
			$params[]=$_POST["nYhik"];
			$params[]=$_POST["nKogus"];
		}
		$params[]=$_POST["nJID"];

		//print_r ($params);
		include ($path .'/config.php'); //votame sealt sql andmed
		$query="UPDATE JOB SET LEPNR=?, GID=?, JOB=?, Y=?, KOGUS=? ";
		$query.="WHERE JID=?";
		$result= sqlsrv_query($conn, $query, $params);
		if ($result===false) {
			die (print_r(sqlsrv_errors(),true));
		}
		$ridaMuutunud = sqlsrv_rows_affected($result);
		if ($ridaMuutunud==false){
			$vastus="Midagi läks muutmisega valesti! Rida ei muudetud! " .$params;  
		}else{
			$vastus=$ridaMuutunud . " rida on muudetud!";
		}
		sqlsrv_close($conn);

	}else{
		$vastus = "Ei ole kõiki muutujaid!";
	};
	echo ($vastus);
	exit;
?>

