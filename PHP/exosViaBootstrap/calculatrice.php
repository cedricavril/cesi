<?php
//Création de deux champs input de type "number", un select avec les opérateurs et d'un bouton HTML.
/*
L'internaute doit pouvoir effectuer des calculs simples (+, -, x et /) entre ces deux 
valeurs renseignées quand il clique sur le bouton.

Pour chaque calcul il faudra afficher :

Le résultat
Le résultat arrondi à l'inférieur
Le résultat puissance 2
Un chiffre totalement aléatoire sans décimale

Le nombre de décimales doit être limité à 2 dans tous les résultats obtenus


Au premier chargement de la page, le client veut un message de bienvenue (juste un echo)
*/
    if(!isset($_SESSION['connected'])) $message = "bonjour";
    else {
        $val1 = $_POST['val1'];
        $val2 = $_POST['val2'];
        switch ($_POST["operation"]) {
            case '+':
                $resultat = $val1 + $val2;
                break;
            case '-':
                $resultat = $val1 - $val2;
                break;
            case '*':
                $resultat = $val1 * $val2;
                break;
            case '/':
                $resultat = $val1 / $val2;
                break;
            default:
                $resultat = "bonjour";
                break;
        }
        if ($message != "bonjour") {
            $resultat = round($resultat,2);

            $message = $resultat;
            $message .= "<br/>".ceil($resultat);
            $message .= "<br/>".round($resultat * $resultat, 2);
            $message .= "<br/>".rand();
        }
    }
    $_SESSION['connected'] = "connected";
    