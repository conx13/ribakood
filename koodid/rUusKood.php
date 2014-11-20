<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	//tekitame sql-i

	if (isset($_POST["uLeping"], $_POST["uGrupp"], $_POST["uJob"])) {
		$params=array();
		$params[]=$_POST["uLeping"];
		$params[]=$_POST["uGrupp"];
		$params[]=$_POST["uJob"];
		
		if ($_POST["uYhik"] =="") {
			$params[]=NULL;
			$params[]=NULL;
		}else{
			$params[]=$_POST["uYhik"];
			$params[]=$_POST["uKogus"];
		}

		//print_r ($params);
		include ($path .'/config.php'); //votame sealt sql andmed
		$query="INSERT INTO JOB (LEPNR, GID, JOB, Y, KOGUS) ";
		$query.="VALUES (?,?,?,?,?)";
		$result= sqlsrv_query($conn, $query, $params);
		if ($result===false) {
			die (print_r(sqlsrv_errors(),true));
		}
		$ridaMuutunud = sqlsrv_rows_affected($result);
		if ($ridaMuutunud==false){
			$vastus="Midagi läks lisamisega valesti! Rida ei lisatud! " .$params;  
		}else{
			$vastus=$ridaMuutunud . " rida on lisatud!";
		}
		sqlsrv_close($conn);

	}else{
		$vastus = "Ei ole kõiki muutujaid!";
	};
	echo ($vastus);
	exit;
?>