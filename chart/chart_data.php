<?php
    include '../config.php'; //võtame sealt sql baasi andmed    
    $query = "select KPVN, sum(Kogus) AS KOKKU ";
    $query .="FROM Kogus_Kokku ";
    $query .="WHERE KPVN > '2012.07'";
    $query .="group by kpvn ";
    $query .="ORDER BY KPVN";	
    $result =sqlsrv_query($conn, $query);
    $num = sqlsrv_query($conn, $query, array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));

# set heading	
    $data[0] = array('Kuu','m2');		
    $i=1;
        while($rows = sqlsrv_fetch_array($result)){
            $data[$i]=array($rows["KPVN"],(int)$rows["KOKKU"]);
            $i=$i+1;
        }   
    echo json_encode($data);
    sqlsrv_close($conn);//sulgeme ühenduse
?>