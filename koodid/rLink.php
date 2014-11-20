	<?php 
	$jid="";

	$path = $_SERVER['DOCUMENT_ROOT'];
	if (isset($_GET["oJID"])){
		$jid=$_GET["oJID"];
		$params=array($jid);
		include ($path .'/config.php'); //votame sealt sql andmed
		$query = "SELECT TOOTAJAD.NIMI, RESULT.START, RESULT.STOP, RESULT.RESULT ";
		$query .="FROM RESULT "; 
    	$query .="INNER JOIN TOOTAJAD ON RESULT.TID = TOOTAJAD.TID ";
    	$query .="WHERE(RESULT.JID = ?) ";
    	$query .="ORDER BY START, NIMI";
    	$result =sqlsrv_query($conn, $query,$params);
    	if( $result === false ) {
      		print_r(sqlsrv_errors());
      		sqlsrv_close($conn);
      	die();
    	};
    	if (sqlsrv_has_rows( $result )===false) { //kui tühi tulem
    		$vastus=array("tyhi");
    	}else{
    		$i=0;
      		$data = array();
      		while($row = sqlsrv_fetch_array($result)){
      			 //$data[$i]=array($row["NIMI"], $row["START"], $row["STOP"], $row["RESULT"]);
      			$alg=new DateTime($row["START"]);
				$alg= date_format($alg,"H:i:s d.m.Y");
				$lop=new DateTime($row["STOP"]);
				$lop= date_format($lop,"H:i:s d.m.Y");
				$data[$i]=array('Nimi' => $row["NIMI"], "Algus" =>$alg,"Lopp" =>$lop,"Kokku" => $row["RESULT"]);
        	$i=$i+1;
      		}
      		$vastus=$data;
      		sqlsrv_close($conn);
    	}
	}else{
		$vastus="tyhi";
	};
	echo json_encode($vastus);
	exit;
?>