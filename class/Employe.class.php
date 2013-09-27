<?php

class Employe {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($login,$mdp,$nom,$prenom,$statut,$permis,$droits) {
		$login = str_replace("'","&#39;", $login);
		$mdp = hash("sha512",$mdp);
		$nom = str_replace("'","&#39;", $nom);
		$prenom = str_replace("'","&#39;", $prenom);

		$sql = "INSERT INTO employe VALUES (NULL,'$login','$mdp','$nom','$prenom','$statut','$permis','$droits')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function liste() {
		$sql = "SELECT * FROM employe";
		$ressql = $this->db->query($sql);
		echo '<option value=""></option>';
		while($current = mysql_fetch_assoc($ressql))
			echo "<option value=".$current['idEmploye'].">".$current['nom']." ".$current['prenom']."</option>";
	}

	public function delete($idEmploye) {
		$sql = "DELETE FROM employe WHERE idEmploye=".$idEmploye;
		$this->db->query($sql);
		return mysql_affected_rows();
	}
	
	public function addEquipe2($idEmploye1,$idEmploye2){
		$date=date('Y-m-d');
		$sql = "INSERT INTO equipe VALUES (NULL,'$date')";
		$this->db->query($sql);
		$idEquipe=mysql_insert_id();
		
		$sql2 = "INSERT INTO equipe_has_employe VALUES ('$idEquipe','$idEmploye1')";
		$this->db->query($sql2);
		mysql_insert_id();
		
		$sql3 = "INSERT INTO equipe_has_employe VALUES ('$idEquipe','$idEmploye2')";
		$this->db->query($sql3);
		mysql_insert_id();
	}
	
	public function addEquipe3($idEmploye1,$idEmploye2,$idEmploye3){
		$date=date('Y-m-d');
		$sql = "INSERT INTO equipe VALUES (NULL,'$date')";
		$this->db->query($sql);
		$idEquipe=mysql_insert_id();
		
		$sql2 = "INSERT INTO equipe_has_employe VALUES ('$idEquipe','$idEmploye1')";
		$this->db->query($sql2);
		mysql_insert_id();
		
		$sql3 = "INSERT INTO equipe_has_employe VALUES ('$idEquipe','$idEmploye2')";
		$this->db->query($sql3);
		mysql_insert_id();
		
		$sql4 = "INSERT INTO equipe_has_employe VALUES ('$idEquipe','$idEmploye3')";
		$this->db->query($sql4);
		mysql_insert_id();
	}
	
	public function equipeDuJour() {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM equipe WHERE dateCreationEquipe='$date'";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "- ";
			$sql2 = "SELECT * FROM equipe_has_employe WHERE Equipe_idEquipe=".$current['idEquipe'];
			$ressql2 = $this->db->query($sql2);
	
			while($current2 = mysql_fetch_assoc($ressql2))
			{
				$sql3 = "SELECT * FROM employe WHERE idEmploye=".$current2['Employe_idEmploye'];
				$ressql3 = $this->db->query($sql3);
				$current3 = mysql_fetch_assoc($ressql3);
			
				echo $current3['prenom']." ";
			}
			echo "<br />";
		}
	}
	
	public function listeEquipeDuJour() {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM equipe WHERE dateCreationEquipe='$date'";
		$ressql = $this->db->query($sql);
		echo '<option value=""></option>';
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<option value=".$current['idEquipe'].">";
			$sql2 = "SELECT * FROM equipe_has_employe WHERE Equipe_idEquipe=".$current['idEquipe'];
			$ressql2 = $this->db->query($sql2);
			
			while($current2 = mysql_fetch_assoc($ressql2))
			{
				$sql3 = "SELECT * FROM employe WHERE idEmploye=".$current2['Employe_idEmploye'];
				$ressql3 = $this->db->query($sql3);
				$current3 = mysql_fetch_assoc($ressql3);
			
				echo " ".$current3['prenom'];
			}
			echo "</option>";
		}
	}
	
	public function interventionEmploye($idEquipe,$idIntervention) {
		$sql = "SELECT * FROM equipe_has_employe WHERE Equipe_idEquipe=".$idEquipe;
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "INSERT INTO intervention_has_employe VALUES ('$idIntervention','".$current['Employe_idEmploye']."')";
			$this->db->query($sql2);
			mysql_insert_id();	
		}
	}
	
	public function interventionPrenom($idIntervention) {
		$sql = "SELECT * FROM intervention_has_employe WHERE Intervention_idIntervention='$idIntervention'";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "SELECT * FROM employe WHERE idEmploye=".$current['Employe_idEmploye'];
			$ressql2 = $this->db->query($sql2);
			$current2 = mysql_fetch_assoc($ressql2);
			echo " ".$current2['prenom'];
		}
	}

}

?>
