<?php
//==============================fonctions=================================//
include("mailTemplate.php");

//==============================initialisation=================================//
//$URLadmin = dirname($_SERVER['SERVER_PROTOCOL'])."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI'])."/admin";
//$URLuser = dirname($_SERVER['SERVER_PROTOCOL'])."://".$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);

// $message = $_POST['message'];

$signature_texte = "";
$signature = "";
$sujet = "Sujet test";

//===============================pdo connexion==================================//
/*if ($_SERVER["REMOTE_ADDR"]=='127.0.0.1') $db = new \PDO('mysql:host=localhost;dbname=odile', 'user1', 'pass') or die("plantage");
else $db = new \PDO('mysql:host=sql.franceserv.fr;dbname=cavril_db1', 'cavril', 'pGZEn6WH');

$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$db->exec("SET CHARACTER SET utf8");*/

//===================================corps======================================//
/*$requete = $db->prepare("INSERT INTO livreOr (date, nick, message, email) VALUES (NOW(), :nick, :message, :email)") or die ("plantage 2");
$requete->bindParam(':nick', $nick);
$requete->bindParam(':message', $message);
$requete->bindParam(':email', $email);

$requete->execute();
$id = $db->lastInsertId();*/

$message_txt = $message;
$message_html = $message;

//mailing('odilebigot213@free.fr',$sujet,$message_txt,$message_html);
//mailing('cedric_avril_pro@hotmail.fr',$sujet,$message_txt,$message_html);
mailing('cedric_avril_pro@hotmail.fr',$sujet,$message_txt,$message_html);
//mailing('gabrielbernal@hotmail.fr',$sujet,$message_txt,$message_html);
//mailing('lascombes.mickael@gmail.com',$sujet,$message_txt,$message_html);
?>