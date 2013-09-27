<?php

class Motif {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleMotif,$ordreMotif) {
		$intituleMotif = str_replace("'","&#39;",$intituleMotif);

		$sql = "INSERT INTO motif VALUES (NULL,'$intituleMotif','$ordreMotif')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function addMotifDemande($idMotif,$idDemandePriseEnCompte) {
		$sql = "INSERT INTO motif_has_demandepriseencompte VALUES('$idMotif','$idDemandePriseEnCompte')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM motif ORDER BY ordreMotif ASC";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<label class='checkbox'>";
				echo "<input type='checkbox' onclick=prest(this.value) name='motif[]' value='".$current['idMotif']."' />".$current['intituleMotif'];
            echo "</label>";
		}
	}

}

?>