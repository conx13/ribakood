<?php
          $aegKogus = (date('n.Y',strtotime("now"))); //- 1 month
          include '../config.php';
          $query= "SELECT KPVN, sum(Kogus) AS KOKKUM2, sum(AegKokku)/60 AS KOKKUH, cast((sum(Kogus))/(sum(AegKokku)/60) AS decimal(3,2)) AS m2H ";
          $query .="FROM Kogus_Kokku ";
          $query .="WHERE KPVN > '2012.07' AND GGRUPP='Elemendiliin' ";
          $query .="GROUP BY KPVN ";
          $query .="ORDER BY KPVN";
          $result =sqlsrv_query($conn, $query);
          $KogusKokku=0;  
          $data[0] = array('Aeg', 'm2/tunnis');    
          $i=1;
        while($rows = sqlsrv_fetch_array($result)){
            $data[$i]=array($rows["KPVN"], (float)$rows["m2H"]);
            $i=$i+1;
        }   
    echo json_encode($data);
          sqlsrv_close($conn);//sulgeme ühenduse
?>