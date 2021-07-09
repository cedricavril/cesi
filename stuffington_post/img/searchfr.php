<?php
// tests occurences effectués
// Ne gère pas les espaces finaux de $search (i.e. de l'occurence saisie par l'utilisateur).
function creationLien($lien, $id) {
	// paramètres correspondant à $Ts['lien'], $Ts['id']. Génère le lien ou l'ancre voulu(e) selon qu'on ait lien inissant par -.html ou non. 
	$lienFormatte = preg_replace("/-\.html/", "-".$id.".html", $lien);
	if ($lien == $lienFormatte) {
		$lienFormatte = $lien."#$id";
	}
	return $lienFormatte;
}


function affichageFormatte($format, $texte, $search, $max, $formatFort = false) {

	// si on a un format fort, il faudra éventuellement faire du troncage, sinon on garde le $texte en entier.
	if ($formatFort) {
		// les preg_quote seront corrigés plus loin par autant de stripslashes imbriqués que nécessaires
		$searching = preg_quote(preg_quote($search)); // doublage indispensable à cause des histoires à la con du genre précompilation
		$searching = preg_replace("/\//", "\\\/", $searching);
		$source = preg_quote($texte);

		// on crée un tableau contenant tous les segments de part et d'autre des occurences trouvées, sans les occurences.
		$tabSource = preg_split("/$searching/i", $source);
		$tabResult = array();

		// pour le format de parcours fort, affixe vaut "..." si $max est dépassé vers la gauche ou vers la droite puis on l'ajoute à result qu'on aura tronqué si dépassé 
		for($i=0; $i < count($tabSource); $i++) { 
			$affixe = "";
			if (strlen($tabSource[$i]) > $max) $affixe = "...";
			if ($formatFort) 
				$result = "&#x21E8;	$affixe".stripslashes(substr($tabSource[$i], -$max)).stripslashes(stripslashes($searching));
			else
				$result = stripslashes($tabSource[$i]).stripslashes(stripslashes($searching));
			if (array_key_exists($i+1, $tabSource)) {
				$affixe = "";
				if (strlen($tabSource[$i+1]) > $max) $affixe = "...";
				if ($formatFort) 
					$result .=  stripslashes(substr($tabSource[$i+1], 0, $max)).$affixe;
				else
					$result .=  stripslashes($tabSource[$i+1]);
			}
			array_push($tabResult, $result);
		}
		// virer le dernier qui fout le bordel
		array_pop($tabResult);

		// virer les doublons
		$tabResult = array_unique($tabResult);

		// et voilà le travail
		$resultFinal = join($tabResult,"<br/><br/>");

	} else $resultFinal = $texte;

	// si l'occurence ne s'y trouve pas et qu'on a du gros texte (format fort), on affiche quand même les $max premiers caractères. Sinon on affiche tout même si parcours faible.
	if($resultFinal == '' and $formatFort) $texteRenvoye = $format[0].preg_replace("/(.{".$max."}).+/", "$1...", $texte).$format[1].'<br/>';
	elseif ($resultFinal == '') $texteRenvoye = $format[0].$texte.$format[1].'<br/>';
	// Mais si l'occurence s'y trouve, FOR 1 : on stocke chaque mot trouvé avec leurs casses dans un tableau, FOR 2 : dans le texte à renvoyer (dont les occurences trouvées ont été rendues tout en minuscule par la regex utilisant /i aupravant) on remplace chaque occurence par celles dont les casses sont inaltérées (stockées dans le tableau du FOR 1)
	else {
		// FOR 1
		$count = 0;
		$motTrouveAvecCasse = '';
		$TmotsTrouvesAvecCasse = array();
		for($i = 0; $i<strlen($texte); $i++) {
			while($count < strlen($search) and ($i + $count) < strlen($texte) and strtolower($texte[$i + $count]) == strtolower($search[$count]))
			{
				$motTrouveAvecCasse .= $texte[$i + $count];
				$count++;
			}
			if ($count == strlen($search)) {
				$count = 0;
				$TmotsTrouvesAvecCasse[] = $motTrouveAvecCasse;
			}
			$count = 0;
			$motTrouveAvecCasse = '';
		}
		// FOR 2
		$indice = 0;
		for($i = 0; $i<strlen($resultFinal); $i++) {
			while($count < strlen($search) and $i + $count < strlen($resultFinal) and strtolower($resultFinal[$i + $count]) == strtolower($search[$count])) {
				$count++;
				if ($count == strlen($search)) {
					$resultFinal = substr_replace($resultFinal,"<mark>",$i,0);
					$i += 6;

					for($count = 0; $count<strlen($search); $count++)
						$resultFinal[$i + $count] = $TmotsTrouvesAvecCasse[$indice][$count];
					$resultFinal = substr_replace($resultFinal,"</mark>",$i + $count,0);
					$indice++;
				}
			}
			$count = 0;
		}
		$texteRenvoye = $format[0].$resultFinal.$format[1].'<br/>';
	}

	return $texteRenvoye;
}
	require("private/PDO connexion locale ou serveur.php");

	$max = 500; // NOMBRE A METTRE PEUT ÊTRE AILLEURS GENRE DANS CONFIG OU APP.XML (VOIR A LE RECUPERER DANS BACKCONTROLLER GENERAL). Nbre maximum de caractères à afficher pour un "=>".
  	$search = $_GET['occurence'];
	$requete = connexionBdd('mysql:host=mysql51-72.pro;dbname=vspropoo');
  	$requete->exec("SET CHARACTER SET utf8");
  	$affichageResultat = "";
	// les array correspondent à ce qu'on veut avoir au début et à la fin de l'affichage du contenu de la colonne. L'éventuel true informe qu'on doit faire un parcours fort de cette colonne. Pour l'enlever, ne pas mettre false, mais l'enlever simplement. Si ajout d'un autre type de parcours, cette facilité ne sera plus possible (e.g. mettre 0, 1, 2 ou 'faible', 'moyen', 'fort').
	$formattageAffichage = array(
		'nom' => array('<h3 style="display: inline"><u>Nom</u> : </h3><strong>', '</strong>'),
		'titre' => array('<h3 style="display: inline"><u>Titre</u> : </h3><strong>', '</strong>'),
		'auteur' => array('<h3 style="display: inline"><u>Auteur</u> : </h3><strong>', '</strong>'),
		'url' => array('<h3 style="display: inline"><u>URL</u> : </h3><strong>','</strong>'),
		'description' => array('<h3><u>Description</u> : </h3><p>','</p>', true),
		'com' => array('<h3><u>Note</u> : </h3><p>','</p>', true),
		'dateAjout' => array('<h3 style="display: inline"><u>Date de l\'ajout</u> : </h3><strong>','</strong>'),
		'dateModif' => array('<h3 style="display: inline"><u>Date de la modif</u> : </h3><strong>','</strong>'),
		'dateCreation' => array('<h3 style="display: inline"><u>Date de création</u> : </h3><strong>','</strong>'),
		'contenu' => array('<h3><u>Contenu</u> : </h3><p>','</p>', true),
		'notice' => array('<h3><u>Notice</u> : </h3><p>','</p>', true),
		);


	$sql = array();


  	// variable recensant les tables à parcourir, avec les colonnes à parcourir pour chaque table, réparties en fonction du type de parcours à faire. Parcours fort et faible sont différents en ce que les affixes '...' sont prises en charge slt pour les parcours fort (Cf. affichageformatte()). le order by DESC est appliqué aux deux premières lignes "parcours".
  	$tables = array(
  		'softs' => array(
  			'titre' => '<i>Oeuvres </i>&#x21E2;<i> Applications de bureau</i>',
	  		'lien' => 'oeuvres-soft.php', 
	  		'parcours' => array('dateCreation', 'nom', 'description', 'notice', 'url'),
	  		'idLien' => '#nom'),
  		'sites' => array(
  			'titre' => '<i>Oeuvres </i>&#x21E2;<i> Applications Web</i>',
	  		'lien' => 'oeuvres-web.php',
	  		'parcours' => array('dateCreation', 'nom', 'description', 'url'),
	  		'idLien' => '#nom'),
  		'news' => array(
  			'titre' => '<i>Public </i>&#x21E2;<i> News</i> (News)',
  			'lien' => 'public-news-.html',
  			'parcours' => array('dateModif', 'dateAjout', 'auteur', 'titre', 'contenu'),
  			'idLien' => 'id'),
  		'com' => array(
  			'titre' => '<i>Public </i>&#x21E2;<i> Livre d\'or</i>',
	  		'lien' => 'public-livredor.php',
	  		'parcours' => array('dateAjout', 'auteur', 'com'),
  			'idLien' => ''),
  		'comments' => array(
  			'titre' => '<i>Public </i>&#x21E2;<i> News</i> (commentaires)',
	  		'lien' => 'public-news-.html',
	  		'parcours' => array('dateModif', 'dateAjout', 'auteur', 'contenu'),
  			'idLien' => 'idNews')
  	);

?><h3><u>Résultats de la recherche pour "<mark><?php echo $search?></mark>" dans la base de données : </u></h3><?php

	$search = preg_replace('/\\\/','\\\\\\\\\\', $search); // ligne nécessaire pour le like qui a du mal à trouver les éventuels "\" peut être présents dans la requête de recherche de l'user

	$where = '';
	foreach ($tables as $table => $tableContent) {
		foreach ($tableContent['parcours'] as $colonneAParcourir) {
			if ($where != '') $where .= ' or ';
			$where .= "$colonneAParcourir LIKE '%$search%'";
// on occulte AND publie = TRUE (pour com et comments) dans where afin de montrer pratiquement tout dans la base de données.
		}
		$tables[$table]['parcours'] = "SELECT * FROM $table WHERE $where ORDER BY ".$tables[$table]['parcours'][0]." DESC, ".$tables[$table]['parcours'][1]." DESC";
		$where = '';
	}

  	$search = $_GET['occurence'];
if ($search != "") {
?>

<?php

	foreach ($tables as $Ts) {
		$result = $requete->prepare($Ts['parcours']);
		$result->execute();

		$preAffichage = '<h2 style="text-align: center; margin-bottom: 50px;">'.$Ts['titre'].'</h2>';

		foreach ($result->fetchall(PDO::FETCH_ASSOC) as $T) {
			echo "<br />";

			$affichage = '';
			foreach ($T as $key => $value) {
				// on fait correspondre les colonnes de la base avec les clés du tableau pour pouvoir afficher chaque ligne de la base en fonction de chaque ligne, de même clé, du tableau. T correspond à la bdd.
				// continuer ici pour le lien.
				if (array_key_exists(preg_replace('/^#/', '', $Ts['idLien']), $T)) {
					$id = $T[preg_replace('/^#/', '', $Ts['idLien'])]; 
				} else {
					$id = '';
				}
				if (array_key_exists($key, $formattageAffichage)) 
					$affichage .= '<a class="lienSearch" href="'.
						creationLien($Ts['lien'], $id).
						'">'.
						affichageFormatte($formattageAffichage[$key], htmlspecialchars($T[$key]), $search, $max, array_key_exists(2, $formattageAffichage[$key])).
						'</a>';
			}
			$affichage .= '<hr style="margin-top: 20px"/>';

			echo $preAffichage."<div class='resultContainer'>".$affichage."</div>";
			$preAffichage = '';
		}
	}

?>
<hr style="margin : 10px;"/>
<?php

}
else { ?>
	<h3><u>Aucun résultat.</u></h3><br/>
<?php }
?>

<h3><u>Si vous n'avez pas trouvé ce que vous cherchez, effectuez une recherche de "<mark><?php echo $search?></mark>" sur tout le site</u><a href="https://www.google.fr/#safe=off&q=<?php echo $search ?> site:naytheet.fr" target="_blank"> par ce lien</a>.</h3>
