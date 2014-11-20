<?php  
$path = $_SERVER['DOCUMENT_ROOT'];
include ($path .'/config.php'); //votame sealt sql andmed
if (isset($conn_tds)){
    $conn=$conn_tds;
}else{
    $conn=$conn_pdo;
};    
if (isset($_GET["mTid"])) {
        try {
            $sql="select 0 as error, enimi, pnimi, ikood, ajagupp, aktiivne ";
            $sql.="from tootajad ";            
            $sql.="where tid=:tid";        
            $tulem=$conn->prepare($sql);
            $tulem->bindParam(':tid', $_GET["mTid"], PDO::PARAM_INT);
            $tulem->execute();
            $result= $tulem->fetch(PDO::FETCH_ASSOC);
            if ($result){
                $data=$result;
            }else{
                $data=array('error'=>'1', 'Text'=>"Tulemust ei leidnud!"); 
            };
          }
        catch(Exception $e){ 
            $data=array('error'=>'1', 'Text'=>$e->getMessage());
            //print_r($e->getMessage()); 
        };
    }else{
        $data=array('error'=>'1', 'Text'=>'Muutujad on valed');
    }
    echo json_encode($data);
?>