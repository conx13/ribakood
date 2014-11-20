<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login...</title>
		<link rel="stylesheet" href="../style.css"/>	
	</head>
<body>

	<div class= "login">
		<div class= "joon">
				Kasutaja
		</div>
	<form method = "post" action ="/login/login2.php">
		<table id = "login"  >
			<tr class="login">
				<td width = "30%" align = "right">
				Nimi:
				</td>
				<td align = "left">
				<input class="login" type = "text" tabindex = "1" autofocus = "autofocus" name = "kasutaja" placeholder="Kasutaja nimi">
				</td>
			</tr>
			<tr>
				<td align = "Right">
					Parool:
				</td>
				<td align = "left">
				<input class="login" type="password" name="parool" placeholder="Parool">
				</td>
			</tr>
			<tr>
				<td align = "center" colspan = "2">
					<input id="lognup" type = "submit" value = "Logi sisse"> 
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>