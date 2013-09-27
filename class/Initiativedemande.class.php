<?php

class Initiativedemande {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleDemande,$ordreDemande) {
		$intituleDemande = str_replace("'","&#39;",$intituleDemande);

		$sql = "INSERT INTO initiativedemande VALUES (NULL,'$intituleDemande','$ordreDemande')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM initiativedemande ORDER BY ordreDemande ASC";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['initiativeDemande']." >".$current['intituleDemande']."</option>";
		}
	}

}

?>