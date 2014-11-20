<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include ($path .'/config.php'); //votame sealt sql andmed
    $query="SELECT GID, GNIMI FROM GRUPP ";
    $query .="ORDER BY GNIMI";
    $result=sqlsrv_query($conn, $query);
    if ($result==false) {
    	die (print_r(sqlsrv_errors(), true));
    }else{
    	$i=0;
    	while ($row = sqlsrv_fetch_array($result)) {
    		$data[$i]=array((int)$row['GID'],$row["GNIMI"]);
    		$i=$i+1;
    	};
    }
    sqlsrv_close($conn);
    echo json_encode($data);
    exit;
?>