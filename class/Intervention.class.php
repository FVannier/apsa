<?php

class Intervention {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function addJourneeIntervention($idVehicule) {
		$date=date('Y-m-d');
		$sql = "INSERT INTO journeeIntervention VALUES (NULL,'$date','','','','$idVehicule')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function addIntervention($dateRdv,$heureRdv,$lieuIntervention,$personne_idPersonne,$demandePriseEnCompte_idDemandePriseEnCompte,$journeeIntervention_idJourneeIntervention) {
		$sql = "INSERT INTO intervention VALUES (NULL,'$dateRdv','$heureRdv','$lieuIntervention',NULL,NULL,'$personne_idPersonne','$demandePriseEnCompte_idDemandePriseEnCompte','$journeeIntervention_idJourneeIntervention')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function updateIntervention($idIntervention,$dureeIntervention,$absence) {
		$sql = "UPDATE intervention SET dureeIntervention='".$dureeIntervention."',absence='".$absence."' WHERE idIntervention=".$idIntervention;
		$this->db->query($sql);
	}
	
	public function testJourneeIntervention($idVehicule) {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM journeeIntervention WHERE dateJourneeIntervention='$date' AND Vehicule_idVehicule=".$idVehicule;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		if($current=='')
			return true;
		else
			return false;
	}
	
	public function idJourneeIntervention($idVehicule) {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM journeeIntervention WHERE dateJourneeIntervention='$date' AND Vehicule_idVehicule=".$idVehicule;
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['idJourneeIntervention'];
	}
	
	public function listeIntervention() {
		include_once("Vehicule.class.php");
		include_once("Personne.class.php");
		include_once("DemandePriseEnCompte.class.php");
		include_once("Employe.class.php");
		
		$vehicule = new Vehicule($this->db);
		$personne = new Personne($this->db);
		$dem = new DemandePriseEnCompte($this->db);
		$employe = new Employe($this->db);
		
		$date=date('Y-m-d');
		$sql = "SELECT * FROM journeeIntervention WHERE dateJourneeIntervention='$date'";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<div class='span5'>";
				echo "<b><center>".$vehicule->nomVehicule($current['Vehicule_idVehicule'])."</center></b>";
				
				echo "<table class='table table-striped table-bordered'>";
                echo "	<thead>
                          <tr>
                          	<th style='text-align:center;background-color:#d9edf7;'>Equipe</th>
                            <th style='text-align:center;background-color:#d9edf7;'>Heure</th>
                            <th style='text-align:center;background-color:#d9edf7;'>Lieu</th>
                            <th style='text-align:center;background-color:#d9edf7;'>Usagers</th>
                            <th style='text-align:center;background-color:#d9edf7;'>Prestations</th>
                          </tr>
                        </thead>
                        <tbody> ";
                        
                $sql2 = "SELECT * FROM intervention WHERE dateRdv='$date' AND absence IS NULL AND JourneeIntervention_idJourneeIntervention=".$current['idJourneeIntervention']." ORDER BY heureRdv ASC";
                $ressql2 = $this->db->query($sql2);
                while($current2 = mysql_fetch_assoc($ressql2))
				{
					echo "<tr class='warning'>";
						echo "<td>";
						$employe->interventionPrenom($current2['idIntervention']);
						echo "</td>";
						$heure = explode(':',$current2['heureRdv']);
						echo "<td>".$heure[0]."H".$heure[1]."</td>";
						echo "<td>".$current2['lieuIntervention']."</td>";
						echo "<td>".$personne->nomReturn($current2['personne_idPersonne'])."</td>";
						echo "<td>";
						$dem->demande($current2['demandePriseEnCompte_idDemandePriseEnCompte']);
						echo "</td>";
					echo "</tr>";
                }   
                echo "</tbody>
                	</table>";
			echo "</div>";
			echo "<div class='span1'></div>";
		}
	}
	
	public function listeRencontre() {
		include_once("Personne.class.php");
		include_once("DemandePriseEnCompte.class.php");
		include_once("Prestation.class.php");
		
		$personne = new Personne($this->db);
		$dem = new DemandePriseEnCompte($this->db);
		$prestation = new Prestation($this->db);
		$date=date('Y-m-d');
		$sql = "SELECT * FROM intervention WHERE dateRdv='$date' AND absence IS NULL ORDER BY heureRdv ASC";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			echo "<label class='radio'>";	
				echo "<input type='radio' name='inter' value='".$current['idIntervention']."' />";
				echo "<b>".$personne->nomReturn($current['personne_idPersonne'])."</b> - ";
						
				$dem->demande($current['demandePriseEnCompte_idDemandePriseEnCompte']);						
			echo "</label>";
			
		}
	}

}

?>
