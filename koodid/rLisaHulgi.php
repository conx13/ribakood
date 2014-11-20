<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
	//tekitame sql-i

	if (isset($_POST["hText"])) {
		//$params=array();
		$values=$_POST["hText"];
		$data=array();
		//echo($values);
		include ($path .'/config.php'); //votame sealt sql andmed
		$query="INSERT INTO JOB (LEPNR, GID, JOB, Y, KOGUS) ";
		$query.="OUTPUT inserted.JOB, inserted.IKOOD "; //võtame viimati lisatud andmed
		$query.="VALUES $values";
		//$stmt=sqlsrv_execute($conn, $query);
		$result= sqlsrv_query($conn, $query);
		if ($result===false) //kui ei ole tulemust
			{
			if( ($errors = sqlsrv_errors() ) != null)
		      {	
		         foreach( $errors as $error)
		         {
					$data[] =array("Viga!",$error[ 'message'] . $query);
		         }
		      }
			//echo("1212");
			echo json_encode($data);	
			sqlsrv_close($conn);
			die ();
		}else{
			$ridaMuutunud = sqlsrv_rows_affected($result);
			if ($ridaMuutunud==false){ //kui ei tule tulemusi
				$data[] =array("Viga!","Andmeid ei tagastatud!");
			}else{
				$text="Ok!";
				$i=0;
				while($row = sqlsrv_fetch_array($result)) {
					$data[$i]=array($text, $row["JOB"], $row["IKOOD"]);
					$i=$i+1;
				}//while
				sqlsrv_close($conn);
			}
		}
	}else{
		$data[] =array("Viga!","Ei ole kõiki muutujaid!");
	};
	//echo($data);
	echo json_encode($data);
	exit;
?>