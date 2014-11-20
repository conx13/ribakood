<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include ($path .'/config.php'); //votame sealt sql andmed
$query="SELECT GGRUPP, NIMI, TID, LEPNR, TOO, GNIMI, START, KOGUS, JRK, RID, JID, Markus, AegKokku FROM wLyhikeTanaTool_Kogus ";//wLyhikeTanaTool_Kogus
$query .="ORDER BY JRK, LEPNR, TOO, START";
//$query = "SELECT * FROM paev ";
//$query .="ORDER BY JRK, LEPNR, TOO, START";
$result =sqlsrv_query($conn, $query);
if( $result === false ) {
      if( ($errors = sqlsrv_errors() ) != null)
        {
           foreach( $errors as $error)
           {
              echo "SQLSTATE: ".$error[ 'SQLSTATE']."\n";
              echo "code: ".$error[ 'code']."\n";
              echo "message: ".$error[ 'message']."\n";
           }
        }

      //print_r(sqlsrv_errors());
      sqlsrv_close($conn);
      die();
    };
$i=0;
$data = array();

while($row = sqlsrv_fetch_array($result)) //kui on miskit, siis täitame tabeli
	{
		$data[$i]=array("Grupp"=>$row["GGRUPP"], "Leping"=>$row["LEPNR"], "Too"=>$row["TOO"], "Nimi"=>$row["NIMI"], "TID"=>$row["TID"],"Start"=>$row["START"], "Kogus"=>$row["KOGUS"], "AegKokku"=>$row["AegKokku"]);
		$i=$i+1;
	} //while
echo json_encode($data);
sqlsrv_close($conn);
?>
