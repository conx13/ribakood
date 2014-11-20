<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
  	include ($path .'/config.php'); //votame sealt sql andmed
if (isset($conn_tds)){
    $conn=$conn_tds;
}else{
    $conn=$conn_pdo;
};	
if (isset($_GET['otsi'])) {
		$otsi='%' . $_GET['otsi'] .'%';
	}else{
		$otsi='%%';
	};
	$query="select 0 as error, tootajad.enimi, tootajad.pnimi, ajad.nimi as ajanimi, tootajad.tid, tootajad.aktiivne, tootajad.ajagupp, tootajad.ikood ";
	$query .="from ajad inner join tootajad on ajad.aid = tootajad.ajagupp ";
    $query .="where enimi like :1 or pnimi like :2 or ikood like :3 ";
    $query .="order by aktiivne desc, pnimi";
    try {
        $tulem = $conn->prepare($query);
        $tulem->bindParam(':1',$otsi, PDO::PARAM_STR);
        $tulem->bindParam(':2',$otsi, PDO::PARAM_STR);
        $tulem->bindParam(':3',$otsi, PDO::PARAM_STR);
        $tulem->execute();
        $result= $tulem->fetchAll();
        if ($result){
            $data=$result;
        }else{
            $data=array('error'=>'1', 'Text'=>"Tulemust ei leidnud!"); 
        }        
    }catch(Exception $e) {
        $data=array('error'=>'1', 'Text'=>$e->getMessage());
    };
    echo json_encode($data);
    exit;
?>