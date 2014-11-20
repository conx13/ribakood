<?php
//phpinfo();    
$path = $_SERVER['DOCUMENT_ROOT'];
include ($path .'/config.php'); //votame sealt sql andmed
if (isset($conn_tds)){
    $conn=$conn_tds;
}else{
    $conn=$conn_pdo;
};
error_reporting();
    if (isset($_POST["muudatKood"], $_POST["muudaEnimi"],  $_POST["muudaPnimi"], $_POST["muudaIkood"], $_POST["muudaAeg"])) {
        if (isset($_POST["muudaAkt"])) {
            $muudaAkt=1;
        }else{
            $muudaAkt=0;
        };
        $params=array(':enimi'=>$_POST["muudaEnimi"], ':pnimi'=>$_POST["muudaPnimi"], 'ikood'=>$_POST["muudaIkood"], 'aeg'=>$_POST["muudaAeg"], 'akt'=>$muudaAkt, 'tid'=>$_POST["muudatKood"]);
        try {
            $sql="update tootajad set enimi=:enimi, pnimi=:pnimi, ikood=:ikood, ajagupp=:aeg, aktiivne=:akt ";
            $sql.="where tid=:tid";        
            $tulem=$conn->prepare($sql,array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $tulem->execute($params);
            $kokku=$tulem->rowCount();
            if ($kokku>0){
                $data=array('error'=>'0', 'Text'=>"Andmed on muudetud!");    
            }else{
                $data=array('error'=>'1', 'Text'=>"Andmeid ei muudetud!");    
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