<?php

class Origine {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleOrigine) {
		$intituleOrigine = str_replace("'","&#39;",$intituleOrigine);

		$sql = "INSERT INTO origine VALUES (NULL,'$intituleOrigine')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function liste() {
		$sql = "SELECT * FROM origine";
		$ressql = $this->db->query($sql);

		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['idOrigine']." >".$current['intituleOrigine']."</option>";
		}
	}

}

?>