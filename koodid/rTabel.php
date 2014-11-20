<?php
  $otsi="";
  $path = $_SERVER['DOCUMENT_ROOT'];
  //Tekitame sql-i
  if (isset($_GET["oLeping"], $_GET["oText"], $_GET["oLeht"], $_GET["oRidu"] )){
    $oLeping=$_GET["oLeping"];
    $oText=$_GET["oText"];
    $oLeht=$_GET["oLeht"];
    $oRidu=$_GET["oRidu"];
    if ($oLeht==1){
      $oRalgus=1;
      $oRlopp=$oRidu + 1;
    }else{
      $oRalgus=(($oLeht-1)* $oRidu+1);
      $oRlopp=($oLeht* $oRidu)+1;
    }
    $params=array($oLeping, $oText, $oText, $oText, $oText, $oRalgus, $oRlopp);
    //print_r($params);
    include ($path .'/config.php'); //votame sealt sql andmed
    $query ="SELECT * FROM ";
    $query .="(SELECT Row_Number() OVER (ORDER by JID desc) as RowIndex, LEPNR, GNIMI, JOB, JID, IKOOD, Y, KOGUS, Markus ";
    $query .="FROM JOB1 WHERE (LEPNR LIKE ?) AND ((JOB LIKE ?) OR(GNIMI LIKE ?) OR (JID LIKE ?) OR (IKOOD LIKE ?))) as Sub ";
    $query .="WHERE Sub.RowIndex >= ? and Sub.RowIndex < ?";
    $result =sqlsrv_query($conn, $query,$params);
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
    if (sqlsrv_has_rows( $result )===false) { //kui tühi tulem
      echo json_encode ("tyhi");
    }else{
      $i=0;
      $data = array();
      while($row = sqlsrv_fetch_array($result)) //kui on miskit, siis täitame tabeli
        {
        $data[$i]=array($row["JID"], $row["LEPNR"], $row["GNIMI"], $row["JOB"], $row["IKOOD"], $row["Y"], $row["KOGUS"], $row["Markus"]);
        $i=$i+1;
        } //while
        echo json_encode($data);
  sqlsrv_close($conn);
  }
  }else{
    echo json_encode("err2"); //pole mõnda muutujat
  } //if
exit;
?>