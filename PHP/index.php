<?php
	$tab1 = [12, 8, 4, 22, 44];
	$tab2 = [1,2,3,4,3,2,1,0];

	// retourne un tableau trié dans l'ordre croissant. Un tableau en entrée et un autre optionnel.
	function tri1($tab1, $tab2 = array()) {
		// si tab2 existe, on le fusionne avec tab1
		$tab = array_merge($tab1, $tab2);
		sort($tab);
		// on trie le tableau ainsi créé dans l'ordre croissant et on le retourne
		return $tab;
	};

	// retourne 5 premiers éléments d'un tableau
	function cinqPremiers($tab) {
		return(array_slice($tab, 0, 5));
	};

	// affiche un tableau en utilisant <ul>
	function affichageTab($tab) {
		echo "<ul>";
		foreach ($tab as $key => $value) {
			echo "<li>$value</li>";
		}
		echo "</ul>";
	};
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>exo sur tri de tableaux</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<h1>Les tableau triés</h1>
	<div class="tableaux">

		<div class="blockTablal">
			<h2>Tableau 1 non trié</h2>
			<?php
				affichageTab($tab1);
			?>
		</div>
		<div class="blockTablal">
			<h2>Tableau 2 non trié</h2>
			<?php
				affichageTab($tab2);
			?>
		</div>
		<div class="blockTablal">
			<h2>Tableau 1 trié</h2>
			<?php
				affichageTab(tri1($tab1));
			?>
		</div>
		<div class="blockTablal">
			<h2>Tableau 1 et 2 fusionnés triés</h2>
			<?php
				affichageTab(tri1($tab1, $tab2));
			?>
		</div>
		<div class="blockTablal">
			<h2>Tableau 1 et 2 fusionnés triés : 5 premiers éléments</h2>
			<?php
				affichageTab(cinqPremiers(tri1($tab1, $tab2)));
			?>
		</div>
	</div>
</body>
</html>