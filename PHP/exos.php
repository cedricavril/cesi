<?php

function testInferieurA20($n) {
	return $n < 20;
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
		var_dump(testInferieurA20(32));
		var_dump(testInferieurA20(2));
	?>
</body>
</html>