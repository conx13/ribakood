<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  include ($path .'/config.php'); //votame sealt sql andmed
  if (isset($_GET["tKood"], $_GET["Leping"])){
    $params=array();
    $params[]=$_GET["Leping"];
    $params[]=$_GET["tKood"];
    //print_r($params);
    $query ="SELECT 0 AS error, JOB.JOB, GRUPP.GNIMI, avg(wM2_job.m2H) AS AVG_m2H, wM2_job.m2 ";
    $query .="FROM TOOTAJAD INNER JOIN RESULT ";
    $query .="ON TOOTAJAD.TID = RESULT.TID INNER JOIN ";
    $query .="JOB ON RESULT.JID = JOB.JID INNER JOIN ";
    $query .="GRUPP ON JOB.GID = GRUPP.GID INNER JOIN ";
    $query .="wM2_job ON JOB.JID = wM2_job.JID ";
    $query .="WHERE ( (wM2_job.m2 > 2) and (job.lepnr like ?) AND tootajad.tid=?) ";
    $query .="GROUP BY GRUPP.GNIMI, job.job, wM2_job.m2 ORDER BY GNIMI, AVG_m2H";
    //echo($query);
    $result =sqlsrv_query($conn, $query, $params);
    if ($result==false) {
      $error=sqlsrv_errors(SQLSRV_ERR_ERRORS);
      $data=array('error'=>'1', 'Text'=>$error);
    }else{
      if (sqlsrv_has_rows($result)) {
        # code...
        while ($row=sqlsrv_fetch_object($result)) {
          # code...
          $data[]=$row;
        }
      }else{
        $data=array('error'=>'1', 'Text'=>'Ei leidnud midagi!');
      }
    };
  }else{
    $data=array('error'=>'1', 'Text'=>'Ei ole muutujat');
  }
  echo json_encode($data);  
  sqlsrv_close($conn);
  exit;
?>