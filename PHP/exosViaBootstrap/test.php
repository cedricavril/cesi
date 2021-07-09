<?php 
function setMessage($db, $pseudo, $content) {
	$req = $db->prepare('INSERT INTO tchat (content, pseudo) values(:content, :pseudo)');
	$req->bindParam(':pseudo', $pseudo);
	$req->bindParam(':content', $content);
	$req->execute();
	header('Location: test.php');
}
function getMessage($db) {
	// $res = $db->prepare('SELECT pseudo, DATE_FORMAT(created_at, "le %d/%c à %H:%i") as created_at, content FROM tchat ORDER BY id DESC');
	$res = $db->prepare('SELECT pseudo, created_at, content FROM tchat ORDER BY id DESC');
	$res->execute();

	return $res->fetchAll(\PDO::FETCH_OBJ);
}

// à mettre dans un htaccess private deny all
if ($_SERVER["REMOTE_ADDR"]=='127.0.0.1') $db = new \PDO('mysql:host=localhost;dbname=mydb', 'user1', 'pass') or die("plantage");
	else $db = new \PDO('mysql:host=atelierggsgab.mysql.db;dbname=atelierggsgab', 'atelierggsgab', '74R78T695Cc') or die("plantage de la bdd");

$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$db->exec("SET CHARACTER SET utf8");

if (isset($_POST['nick'])) {
	setMessage($db, $_POST['nick'], $_POST['message']);
}

$res = getMessage($db);
include_once 'inc/header.php';
echo "
	<div class='container-fluid pagination-centered'>
		<table class='table-striped table-bordered'>";

	foreach ($res as $value) {
//		print_r(date('H ', strtotime('NOW') - strtotime($value->created_at)));

		$dateTime = new DateTime($value->created_at, new date_timezone('Europe/Paris'));
		$current = new DateTime(null, new date_timezone('Europe/Paris'));

		$diff = $current->diff($dateTime);

// continuer ici en faire une fonction qui retourne selon diff il y a n minutes ou n heures ou l'heure, ou la date
		if ($diff->d > 0) { // plus d'un jour

		}



		var_dump(date('h', strtotime('NOW')));
		var_dump(date('h', strtotime($value->created_at)));
		var_dump(strtotime('NOW'));
		var_dump($value->created_at);

		var_dump(strtotime($value->created_at));

		echo '<tr><td class="badge">'.
		$value->created_at.
		'</td></tr>'.
		'<tr>'.
		"<td>".
		"<b>".$value->pseudo."</b> : ".$value->content.
		"</td>";
//		foreach ($value as $key2 => $value2) echo "<td><b>$key2</b> : $value2&nbsp;</td>";
		echo '</tr>';
	}
?>
		</table>
	</div>
<form method="POST">
	<label>Nick<input type="text" name="nick"></label>
	<label>Message<input type="text" name="message"></label>
	<input type="submit">
</form>
<?php
include 'inc/footer.php';
?>
