<?php

class Rupture {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleRupture,$ordreRupture) {
		$intituleRupture = str_replace("'","&#39;",$intituleRupture);

		$sql = "INSERT INTO rupture VALUES (NULL,'$intituleRupture','$ordreRupture')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function addRupture($Rupture_idRupture,$DemandePriseEnCompte_idDemandePriseEnCompte,$dateRupture) {
		if($dateRupture='')
			$sql = "INSERT INTO rupture_has_demandepriseencompte VALUES ('$Rupture_idRupture','$DemandePriseEnCompte_idDemandePriseEnCompte','NULL')";
		else
			$sql = "INSERT INTO rupture_has_demandepriseencompte VALUES ('$Rupture_idRupture','$DemandePriseEnCompte_idDemandePriseEnCompte','$dateRupture')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM rupture ORDER BY ordreRupture ASC";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['idRupture']." >".$current['intituleRupture']."</option>";
		}
	}

}

?>