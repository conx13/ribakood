<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  //Tekitame sql-i
  if (!($_POST["oLeping"]=="") && (!($_POST["oText"]==""))){
    $oLeping=$_POST["oLeping"];
    $oText=$_POST["oText"];
    $params=array($oLeping,$oText,$oText,$oText);
    include ($path .'/config.php'); //votame sealt sql andmed
    $query ="SELECT COUNT(*) FROM ";
    $query .="JOB1 WHERE (LEPNR LIKE ?) AND ((JOB LIKE ?) OR (JID LIKE ?) OR (IKOOD LIKE ?))";
    $result =sqlsrv_query($conn, $query,$params);
    if( $result === false ) {
      die( print_r( sqlsrv_errors(), true));
    };
    if( sqlsrv_fetch( $result ) === false) {
     die( print_r( sqlsrv_errors(), true));
    } 
    $vastus = sqlsrv_get_field( $result, 0);
    sqlsrv_close($conn);
  }else{
    $vastus="Ei ole muutujaid!";
  }
  echo $vastus;
  exit;
?>