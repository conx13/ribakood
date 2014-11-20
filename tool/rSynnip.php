<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  // nopime välja sünnipäevalised
  $aasta=date("Y");
  echo (strtotime(time()));
  $tana=date("md");//tänane kpv
  //$tana="0129"; //test
  include ($path .'/config.php'); //võtame sealt sql baasi andmed
  $query = "SELECT ENIMI +' '+PNIMI AS Nimi, IKOOD ";
  $query .= "FROM TOOTAJAD ";
  $query .= "WHERE ((IKOOD like '___".$tana."____') AND (Aktiivne='1'))";      
  $query .= "ORDER BY NIMI";
  $result =sqlsrv_query($conn, $query);
  $i=0;
  if (sqlsrv_has_rows( $result )===false) { //kui ei ole andmeid siis näitame hoiatust
    echo json_encode("tyhi"); //näitame errorit js failist.
  }else{
    while($rows = sqlsrv_fetch_array($result)){
      $ikood=19 .substr($rows["IKOOD"],1,2);
      $ikood=$aasta-$ikood;
      $data[$i]=array($rows["Nimi"], $ikood);
      $i=$i+1;
    } //while
  echo json_encode($data);
  }//if
  sqlsrv_close($conn);//sulgeme ühenduse
?>