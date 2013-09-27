<?php

class Orientation {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleOrientation,$ordreOrientation) {
		$intituleOrientation = str_replace("'","&#39;",$intituleOrientation);

		$sql = "INSERT INTO orientation VALUES (NULL,'$intituleOrientation','$ordreOrientation')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function addOrientationDemande($idOrientation,$idDemandePriseEnCompte) {
		$sql = "INSERT INTO orientation_has_demandepriseencompte VALUES('$idOrientation','$idDemandePriseEnCompte')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM orientation ORDER BY ordreOrientation ASC";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<label class='checkbox'>";
				echo "<input type='checkbox' name='orientation[]' value=".$current['idOrientation'].">".$current['intituleOrientation'];
            echo "</label>";
		}
	}

}

?>