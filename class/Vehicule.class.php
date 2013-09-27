<?php

class Vehicule {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleVehicule) {
		$intituleVehicule = str_replace("'","&#39;",$intituleVehicule);

		$sql = "INSERT INTO vehicule VALUES (NULL,'$intituleVehicule')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function delete($idVehicule) {
		$sql = "DELETE FROM vehicule WHERE idVehicule=".$idVehicule;
		$this->db->query($sql);
		return mysql_affected_rows();
	}
	
	public function liste() {
		$sql = "SELECT * FROM vehicule";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['idVehicule'].">".$current['intituleVehicule']."</option>";
		}
	}
	
	public function listeVehicule() {
		$sql = "SELECT * FROM vehicule";
		$ressql = $this->db->query($sql);
		echo "<ul>";
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<li>".$current['intituleVehicule']."</li>";
		}
		echo "</ul>";
	}
	
	public function nomVehicule($idVehicule) {
		$sql = "SELECT * FROM vehicule WHERE idVehicule='$idVehicule'";
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		return $current['intituleVehicule'];
	}

}

?>