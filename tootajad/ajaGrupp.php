<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include ($path .'/config.php'); //votame sealt sql andmed
   if (isset($conn_tds)){
    $conn=$conn_tds;
}else{
    $conn=$conn_pdo;
}; 
    $query="SELECT 0 as error, aid, nimi from ajad";
    try {
        $tulem=$conn->prepare($query);
        $tulem->execute();
        $result=$tulem->fetchAll();
        if ($result) {
            $data=$result;
        }else{
            $data=array('error'=>'1', 'Text'=>"Tulemust ei leidnud!"); 
        };
    } catch(Exception $e) {
        $data=array('error'=>'1', 'Text'=>$e->getMessage());
    };
    echo json_encode($data);
    exit;
?>