<?php

class Ressource {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($typeRessource,$ordreRessource) {
		$typeRessource = str_replace("'","&#39;",$typeRessource);

		$sql = "INSERT INTO ressource VALUES (NULL,'$typeRessource','$ordreRessource')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function addRessourcePersonne($idPersonne,$idRessource,$montant) {
		$sql = "INSERT INTO personne_has_ressource VALUES('$idPersonne','$idRessource','$montant')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

	public function listeCouple1() {
		$sql = "SELECT * FROM ressource ORDER BY ordreRessource ASC";
		$ressql = $this->db->query($sql);

		echo '<div class="row show-grid">';
		while($current = mysql_fetch_assoc($ressql))
		{	
        	echo '<div class="span2">';
				echo '<label class="checkbox">';
					echo '<input type="checkbox" name="ressource_1_[]" value='.$current['idRessource'].'>'.$current['typeRessource'];
				echo '</label>';
			echo '</div>';

			echo '<div class="span1" style=margin-bottom:5px;>';
			if ($current['idRessource']>2)
			{
				echo '<div class="input-append">';
					echo '<b>Montant </b><input class="input-small" type="text" name="montant_1_[]" />';
					echo '<span class="add-on">€</span>';
				echo '</div>';
			}
			echo '</div>'; 
		}
		echo '</div>';
	}
	
	public function listeCouple2() {
		$sql = "SELECT * FROM ressource ORDER BY ordreRessource ASC";
		$ressql = $this->db->query($sql);

		echo '<div class="row show-grid">';
		while($current = mysql_fetch_assoc($ressql))
		{	
        	echo '<div class="span2">';
				echo '<label class="checkbox">';
					echo '<input type="checkbox" name="ressource_2_[]" value='.$current['idRessource'].'>'.$current['typeRessource'];
				echo '</label>';
			echo '</div>';

			echo '<div class="span1" style=margin-bottom:5px;>';
			if ($current['idRessource']>2)
			{
				echo '<div class="input-append">';
					echo '<b>Montant </b><input class="input-small" type="text" name="montant_2_[]" />';
					echo '<span class="add-on">€</span>';
				echo '</div>';
			}
			echo '</div>'; 
		}
		echo '</div>';
	}

}

?>