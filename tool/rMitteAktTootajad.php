<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include ($path .'/config.php'); //votame sealt sql andmed
  $query = "SELECT PNIMI +' '+ENIMI AS Nimi, TID ";
  $query .= "FROM TOOTAJAD ";
  $query .= "WHERE Aktiivne='1' and((ENIMI +' '+PNIMI not in (SELECT NIMI FROM wLyhikeTanaTool))) ";  //wLyhikeTanaTool    
  $query .= "ORDER BY NIMI";
  $result =sqlsrv_query($conn, $query);
  $i=0;
    while($row = sqlsrv_fetch_array($result)) //kui on miskit, siis täitame tabeli
      {
      $data[$i]=array("Nimi"=>$row["Nimi"], "TID"=>$row["TID"]);
      $i=$i+1;
      }
  echo json_encode($data);  
  sqlsrv_close($conn);
?>