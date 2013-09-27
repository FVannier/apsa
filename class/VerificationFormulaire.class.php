<?php

class VerificationFormulaire {

	public function verif_injection($mot)
	{
		$mot = str_replace("<", "", $mot);
		$mot = str_replace(">", "", $mot);
		$mot = str_replace("OR 1 OR", "", $mot);
		$mot = str_replace("'OR 1 OR'", "", $mot);
		$mot = str_replace("''", "", $mot);
		$mot = str_replace("'", "", $mot);
		$mot = str_replace("*", "", $mot);
		$mot = str_replace("/**/", "", $mot);
		$mot = str_replace("/*", "", $mot);
		$mot = str_replace("*/", "", $mot);
		$mot = str_replace("/", "", $mot);
		$mot = str_replace("--", "", $mot);
		return $mot;
	}
	
	public function verification_email($email)
	{
		
		$b = true;
	
		$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   	// Caractères autorisés avant l'arobase
		$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; 	// Caractères autorisés après l'arobase (nom de domaine)
                               
		$regex = '/^' . $atom . '+' .   				// Une ou plusieurs fois les caractères autorisés avant l'arobase
		'(\.' . $atom . '+)*' .         				// Suivis par zéro point ou plus séparés par des caractères autorisés avant l'arobase
		'@' .                           				// Suivis d'un arobase
		'(' . $domain . '{1,63}\.)+' .  				// Suivis par 1 à 63 caractères autorisés pour le nom de domaine séparés par des points
		$domain . '{2,63}$/i';          				// Suivi de 2 à 63 caractères autorisés pour le nom de domaine

		// Test de l'adresse email
		if( !preg_match($regex, $email))
		{
			$b=false;
			echo '<script language="Javascript">alert ("L\' adresse email saisie n\'est pas un mail." )</script>';
		}
		
		return $b;
		
	}


}

?>
