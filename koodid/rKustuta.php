<?php
  $otsi="";
  $path = $_SERVER['DOCUMENT_ROOT'];
  //Tekitame sql-i
  if (isset($_POST["rida"])){
    $oRida=$_POST["rida"];
    $params=array($oRida);
    include ($path .'/config.php'); //votame sealt sql andmed
    $query = "DELETE FROM JOB ";
    $query .= "WHERE (JID = ?)";     
    $result =sqlsrv_query($conn, $query, $params);
    if( $result === false ) {
     die( print_r( sqlsrv_errors(), true));
    }
    $ridaKustunud = sqlsrv_rows_affected( $result);
    if ($ridaKustunud==false){
      $vastus="Midagi läks valesti!" . $params;
    }else{
      $vastus= $ridaKustunud ." rida on kustutatud!";
    }
    sqlsrv_close($conn);
  }else{
    $vastus="Ei ole muutujat rea nr-ga!";
  }
  echo $vastus;
  exit;
?>