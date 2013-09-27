<?php

class categorieAge {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function liste() {
		$sql = "SELECT * FROM categorieage";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['categorieAge']." >".$current['intitule']."</option>";
		}
	}

	public function age($dateNaissance) {
		/* Calcul de l'age de la personne */                           
    	$chiffre = explode('-',$dateNaissance);
    	$time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
    	$seconde_vecu = time() - $time_naissance;
    	$seconde_par_an = (1461*24*60*60)/4;
    	$age = floor(($seconde_vecu / $seconde_par_an));

    	/* Choix de la catégorie d'age */
    	$sqlcategorie = "SELECT * FROM categorieage";
    	$ressqlcategorie = $this->db->query($sqlcategorie);
    	while($currentcategorie = mysql_fetch_assoc($ressqlcategorie))
    	{
      		if($age>=$currentcategorie['ageMin'])
      			$categorieage=$currentcategorie['categorieAge'];
      	}
      	return $categorieage;
	}

}

?>