<?php
$kpv= "(" . date('m.d.y');
if(isset($_POST['JID'], $_POST['markus'])) {
 	$path = $_SERVER['DOCUMENT_ROOT'];
	include  ($path .'/config.php'); //võtame sealt sql baasi andmed
	$jid = $_POST['JID'];
	$markus = $_POST['markus'];
	$markus = $kpv . $markus . "<br>";
	// $markus = $kpv . $markus . "\n<br>";
	$params = array($markus, $jid);
	//$vastus=print_r($params);
	$query = "UPDATE JOB ";
	$query .="SET Markus=ISNULL(Markus,'') + ? ";
	$query .="WHERE JID=?";
	$result = sqlsrv_query($conn,$query,$params);
	if( $result === false ) {
     die( print_r( sqlsrv_errors(), true));
    }
    $ridaMuutunud = sqlsrv_rows_affected( $result);
    if ($ridaMuutunud==false){
      $vastus="Midagi läks valesti!" . $params;
    }else{
      $vastus= "Uus märkus on lisatud!";
    }
    sqlsrv_close($conn);

}else{
	$vastus="Ei ole muutujat!";
}
echo $vastus;
?>