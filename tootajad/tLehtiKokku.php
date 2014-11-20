<?php
  $path = $_SERVER['DOCUMENT_ROOT'];
  //Tekitame sql-i
	if (isset($_GET['oText'])) {
		$oText='%'.$_GET['oText']."%";
    $params[]=$oText;
    $params[]=$oText;
    include ($path .'/config.php'); //votame sealt sql andmed
    $query ="SELECT 0 AS error, COUNT(*) AS Kokku ";
    $query .="FROM AJAD INNER JOIN TOOTAJAD ON AJAD.AID = TOOTAJAD.AJAGUPP ";
    $query .="WHERE enimi LIKE ? OR pnimi LIKE ?";
    $result =sqlsrv_query($conn, $query,$params);
    if( $result === false ) {
      $errors=sqlsrv_errors(SQLSRV_ERR_ERRORS);
        foreach( $errors as $error ) {
          $eText= $error[ 'message'];
        }
      $data=array('error'=>'1', 'Text'=>$eText);
    }else{
      if (sqlsrv_has_rows($result)) {
        while ($row=sqlsrv_fetch_object($result)) {
          $data[]=$row;
        }
      }else{
        $data=array('error'=>'1', 'Text'=>'Ei leidnud midagi!');
      }
    };
	}else{
		$data=array('error'=>'1', 'Text'=>'Ei ole muutujat!');
	};
    echo json_encode($data);
    sqlsrv_close($conn);
    exit;
?>