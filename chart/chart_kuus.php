<?php
          $aegKogus = (date('n.Y',strtotime("now"))); //- 1 month
          include '../config.php';

          $query ="select CAST(YEAR(dbo.RESULT.START) AS varchar)+ '.' + RIGHT('00' + CAST(MONTH(dbo.RESULT.START) AS varchar), 2) AS KPVN, ";
          $query .="(sum(dbo.result.result)/60)as Kogus ";          
          $query .="From dbo.result ";
          $query .="where (CAST(YEAR(dbo.RESULT.START) AS varchar)+ '.' + RIGHT('00' + CAST(MONTH(dbo.RESULT.START) AS varchar), 2)) > '2012.07' ";
          $query .="Group by (CAST(YEAR(dbo.RESULT.START) AS varchar)+ '.' + RIGHT('00' + CAST(MONTH(dbo.RESULT.START) AS varchar), 2)) ";
          $query .="order by KPVN";
          $result =sqlsrv_query($conn, $query);
          $KogusKokku=0;  
          

          $data[0] = array('Aeg', 'tunnid kokku');    
          $i=1;
        while($rows = sqlsrv_fetch_array($result)){
            $data[$i]=array($rows["KPVN"], (int)$rows["Kogus"]);
            $i=$i+1;
        }   
    echo json_encode($data);
          sqlsrv_close($conn);//sulgeme ühenduse
?>