<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
<title>Ribakood 1.0 (Koodi print)</title>

<link href="../bootstrap3/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="../css/PrintKoodid.css"/>

</head>
<body>
    <div class="container"> <!--lehekülje päis-->
      <div class="panel panel-default text-center">
        <div class="panel-body">
        	<h3>Ribakood</h3> 
        </div>
    </div> <!-- lehekülje päis -->

	<?php
	if (isset($_GET["kood"])){
		$jid=$_GET["kood"];
		$path = $_SERVER['DOCUMENT_ROOT'];
		include ($path .'/config.php');
		$query = "SELECT IKOOD, LEPNR, GNIMI, JOB ";
	        $query .= "FROM JOB1 ";
	        $query .= "WHERE (JID='" .$jid. "')";
	        $result=sqlsrv_query($conn, $query);
	        if($result === false ) {
	     		die( print_r( sqlsrv_errors(), true));
			}
			if (sqlsrv_has_rows( $result)==false){
				die ("Pole midagi näidata!");
			}

			while ($row=sqlsrv_fetch_array($result)){
				$rkood=$row["IKOOD"];
				$leping=$row["LEPNR"];
				$grupp=$row["GNIMI"];
				$job=$row["JOB"];
			}//while
			sqlsrv_close($conn) //sulgeme baasi
	?>
		<div class="row col-lg-8 col-lg-offset-2 ">
			<table class="table table-bordered printKood">
				<thead>
					<th width="25%">Kood</th>
					<th width="20%">Lepingu nr</th>
					<th width="20%">Grupp</th>
					<th>Töö nimetus</th>
				</thead>
				<tbody>
					<tr>
						<td id="ribakood"><?php echo $rkood?></td>
						<td><?php echo $leping;?></td>
						<td><?php echo $grupp;?></td>		
						<td><?php echo $job;?></td>
					</tr>
				</tbody>
			</table>		
		<?php
			}else{
			echo $jid . "Kahjuks ei leidnud koodi järgi midagi!";
			}
		?>
		</div> <!-- row span8 -->
	</div> <!-- container -->
</body>
</html>

<script type="text/javascript"> //Avame printimise dialoogi
	window.onload = function() { window.print(); }
</script>