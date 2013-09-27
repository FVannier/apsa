<?php

class Prestation {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($typePrestation,$ordrePrestation) {
		$typePrestation = str_replace("'","&#39;",$typePrestation);

		$sql = "INSERT INTO prestation VALUES (NULL,'$typePrestation','$ordrePrestation')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function addPrestationDemande($idPrestation,$idDemandePriseEnCompte) {
		$sql = "INSERT INTO prestation_has_demandepriseencompte VALUES('$idPrestation','$idDemandePriseEnCompte')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM prestation ORDER BY ordrePrestation ASC";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<label class='checkbox'>";
			echo "<input type='checkbox' name='prestation[]' value=".$current['idPrestation'].">".$current['typePrestation'];
            echo "</label>";
		}
	}
	
	public function listeRencontre($idIntervention) {
		$sql = "SELECT * FROM intervention WHERE idIntervention=".$idIntervention;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		$sql2 = "SELECT * FROM prestation_has_demandepriseencompte WHERE DemandePriseEnCompte_idDemandePriseEnCompte=".$current['demandePriseEnCompte_idDemandePriseEnCompte'];
		$ressql2 = $this->db->query($sql2);

		while($current2 = mysql_fetch_assoc($ressql2))
		{
			$sql3 = "SELECT * FROM prestation WHERE idPrestation<>".$current2['Prestation_idPrestation']." ORDER BY ordrePrestation ASC ";
			$ressql3 = $this->db->query($sql3);

			while($current3 = mysql_fetch_assoc($ressql3))
			{
				echo "<label class='checkbox'>";
					echo "<input type='checkbox' name='prestation[]' value=".$current3['idPrestation'].">".$current3['typePrestation'];
            	echo "</label>";
            }
		}
	}
	
}

?>