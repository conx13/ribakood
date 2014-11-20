<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $aegKogus = (date('n.Y',strtotime("now"))); //- 1 month
    include ($path.'/config.php');
    $query ="SELECT GNIMI,CAST(sum(KOGUS) AS INT) AS Kogus ";
    $query .= "FROM Kogus_Kokku ";
    $query .= "WHERE KPV='" .$aegKogus. "' ";
    $query .= "GROUP BY GNIMI";
    $result =sqlsrv_query($conn, $query);
    $KogusKokku=0;
    $nr=0;  
    $i=0;
    while($row = sqlsrv_fetch_array($result)){
        $data[$i]=array($row["GNIMI"], $row["Kogus"]);
        $i=$i+1;
    }
    echo json_encode($data); 
    sqlsrv_close($conn);//sulgeme ühenduse
?>