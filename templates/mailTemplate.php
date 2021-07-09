<?php
function mailing($email, $sujet, $message_txt, $message_html) {
	$mail = "cavril@franceserv.com";
//	$email_add = "cavril@franceserv.com";
	$email_add = "cedric_avril_pro@hotmail.fr";

	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	    $passage_ligne = "\r\n";
	else $passage_ligne = "\n";

	$boundary = "-----=".md5(rand());
	$boundary_alt = "-----=".md5(rand());

	$header = "From: \"$mail\"<$mail>".$passage_ligne;
	$header.= "Reply-to: \"$email_add\" <$email_add>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
	$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

	$message.= "Content-Type: text/plain; charset=\"utf-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;

	$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;

	 
	$message.= "Content-Type: text/html; charset=\"utf-8\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;

	$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
	 
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	$message = $message;

	mail($email,$sujet,$message,$header);
}