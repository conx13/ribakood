<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include ($path .'/config.php'); //votame sealt sql andmed
  $query = "SELECT Count(NIMI) AS KOKKU ";
  $query .= "FROM wLyhikeTanaTool";//wLyhikeTanaTool
  $result =sqlsrv_query($conn, $query);
  if( sqlsrv_fetch( $result ) === false) {
     die( print_r( sqlsrv_errors(), true));
  }
  $name = sqlsrv_get_field( $result, 0);
  echo($name);
  sqlsrv_close($conn);
?>