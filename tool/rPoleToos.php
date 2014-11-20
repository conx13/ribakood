<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  //Tekitame sql-i
  if (!($_GET["oLeping"]=="") && (!($_GET["oGrupp"]==""))){
    $oLeping=$_GET["oLeping"];
    $oText=$_GET["oGrupp"];
    $params=array($oLeping,$oText);
    include ($path .'/config.php'); //votame sealt sql andmed
    $query ="SELECT JOB.LEPNR, JOB.JOB, JOB.KOGUS, GRUPP.GNIMI ";
    $query .="FROM JOB INNER JOIN GRUPP ON JOB.GID = GRUPP.GID ";
    $query .="WHERE ( JID not in (SELECT JID from dbo.RESULT) and (LEPNR like ?) and (GGRUPP like ?)) ";
    $query .="ORDER BY GNIMI, LEPNR, JOB";
    $result =sqlsrv_query($conn, $query,$params);
    if( $result === false ) {
      die( print_r( sqlsrv_errors(), true));
    };
    if (sqlsrv_has_rows( $result )===false) { //kui ei ole andmeid siis näitame hoiatust
      echo json_encode("tyhi"); //näitame errorit js failist.
    }else{
      $i=0;
      while($row = sqlsrv_fetch_array($result)) //kui on miskit, siis täitame tabeli
        {
        $data[$i]=array($row["GNIMI"], $row["LEPNR"], $row["JOB"], $row["KOGUS"]);
        $i=$i+1;
        } //while
      echo json_encode($data);    
    }
    sqlsrv_close($conn);
   
  }else{
    $vastus="Ei ole muutujaid!";
  }
?>