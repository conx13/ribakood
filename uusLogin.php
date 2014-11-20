<!doctype html>
<html>
	<head>
		<meta charset="ISO 8859-4"/>
		<meta name="HandheldFriendly" content="true" />
		<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes" />
		<title>Ribakood 1.0</title>
		<link rel="stylesheet" href="style.css"/>	
	</head>
<body>
	<h1>
		Uus kasutaja
	</h1>
	<?php if (isset($_POST['submit'])){
		$nimi = $_POST['kasutaja'];
		$parool = sha1($_POST['parool']);
		include 'config.php'; //votame sealt sql andmed
		$query = "INSERT INTO KASUTAJAD (Kasutaja, Parool) VALUES (?, ?)";
		$params = array($nimi, $parool);
		$result = sqlsrv_query($conn, $query, $params);
		if ($result == false) {
			die( print_r( sqlsrv_errors(), true));
		}
		
	}
	?>

	<div class="login">
	<form method = "POST" action = "<?php $_SERVER['PHP_SELF'] ?>">
		<table id = "login">
			<tr>
				<td width = "30%" align = "right">
				Nimi:
				</td>
				<td align = "left">
				<input class="login" type = "text" tabindex = "1" name = "kasutaja">
				</td>
			</tr>
			<tr>
				<td align = "Right">
					Parool:
				</td>
				<td align = "left">
				<input class="login" type="password" name="parool">
				</td>
			</tr>
			<tr id = "loginNupp">
				<td align = "center" colspan = "2">
					<input id="lognup" type = "submit" name="submit" value = "Lisa kasutaja"> 
				</td>
			</tr>
		</table>
	</form>
</div>


</body>
</html>