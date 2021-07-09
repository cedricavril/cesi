<?php

function maFonction() {
	return 5+10;
};

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>exos</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<?php 
		echo "Bonjour le monde<hr>";
		echo "5+10 = ".maFonction();
	?>
</body>
</html>