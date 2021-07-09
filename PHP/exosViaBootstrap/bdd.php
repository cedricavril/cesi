<?php 
include 'inc/header.php';

function connexionBdd() {
	try {

		// Create connection
		$conn = new PDO("mysql:host=localhost;dbname=mydb","user1","pass");

		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "connected successfully<br/>";

		// Check connection
		if ($conn->connect_error) {
		    return("Connection failed: " . $conn->connect_error);
		}
	}
	catch(PDOEXCEPTION $e) {
		return('erreur');
	}
	return $conn;
}
function tableUsersPermissions($conn) {
	$stmt2 = $conn->prepare("SELECT users.id, users.pseudo, permissions.name FROM users
							INNER JOIN permissions_has_users ON permissions_has_users.users_id = users.id
							INNER JOIN permissions ON permissions_has_users.permissions_id = permissions.id");
	$stmt2->execute();
	$stmt2->setFetchMode(PDO::FETCH_ASSOC);
	return $stmt2->fetchAll();
}
function tableUsersNombreUsers($conn) {
	$stmt = $conn->prepare("SELECT count(*) as nombreUsers FROM users");
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);

	return $stmt->fetch()['nombreUsers'];
}

$conn = connexionBdd();
echo "<h1 style='color: blue;'>Les <u>".tableUsersNombreUsers($conn)."</u> users</h1>";
?>



<table>
	<thead>
		<th>id</th><th>pseudal</th><th>permission</th>
	</thead>
	<tbody>
		<?php
		foreach(tableUsersPermissions($conn) as $value) {
			echo "<tr>";
			foreach ($value as $value2) echo "<td>$value2</td>";
			echo "</tr>";
		}?>
	</tbody>
</table>

<?php
include 'inc/footer.php';
?>