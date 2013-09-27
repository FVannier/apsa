<?php

class Appel {

	private $db;

	public function __construct($d) {
		require_once("Session.class.php");
		$this->db = $d;
	}
	
	public function add($dateAppel,$heureAppel,$polluant,$directEnregistre,$commentaires) {
		$commentaires = str_replace("'","&#39;",$commentaires);
		$sql = "INSERT INTO appel115 VALUES (NULL,'$dateAppel','$heureAppel','$polluant','$directEnregistre','$commentaires')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function enregistreAppelPolluant($polluant,$commentaires) {
		if($polluant=="1")
		{
			$commentaires = str_replace("'","&#39;",$commentaires);
    		$this->add(date("Y-m-d"),date("H:i:s"),$polluant,0,$commentaires);
    		return true;
    	}
    	return false;
	}
	
	public function enregistreAppelRepondeur($dateAppel,$heureAppel,$polluant,$commentaires) {
		$commentaires = str_replace("'","&#39;",$commentaires);
		list($jour,$mois,$annee) = explode("/",$dateAppel);
    	$newDateAppel = $annee."-".$mois."-".$jour;
		$this->add($newDateAppel,$heureAppel,$polluant,1,$commentaires);
	}
	
	public function nbAppel() {
		$dateAppel=date('Y-m-d');
		$sql = "SELECT COUNT(*) AS nb_appel FROM appel115 WHERE polluant='0' AND dateAppel='$dateAppel'";
		$ressql = $this->db->query($sql);
		echo "Nombre d'appel non polluant du jour : ";
		while($current = mysql_fetch_assoc($ressql))
		{
			echo $current['nb_appel'];
		}
		echo "<br /><br />";
		$sql2 = "SELECT COUNT(*) AS nb_appel FROM appel115 WHERE polluant='1' AND dateAppel='$dateAppel'";
		$ressql2 = $this->db->query($sql2);
		echo "Nombre d'appel polluant du jour : ";
		while($current2 = mysql_fetch_assoc($ressql2))
		{
			echo $current2['nb_appel'];
		}
	}
	
	public function appelRepondeurNonPolluant() {
		$dateAppel=date('Y-m-d');
		$sql = "SELECT * FROM appel115 WHERE polluant='0' AND directEnregistre='1' AND dateAppel='$dateAppel'";
		$ressql = $this->db->query($sql);
		if(mysql_num_rows($ressql)!=0)
		{
			echo "
				<table class='table table-striped table-bordered'>
                	<thead>
						<tr>
                        	<th>Date</th>
                            <th>Heure</th>
                            <th>Commentaires</th>
                        </tr>
                    </thead>
                    <tbody>
                "; 
			while($current = mysql_fetch_assoc($ressql))
			{
				echo "<tr>";
					list($annee,$mois,$jour) = explode("-",$current['dateAppel']);
					$date = $jour."/".$mois."/".$annee;
                	echo "<td>".$date."</td>";
                	list($heure,$minute,$seconde) = explode(":",$current['heureAppel']);
                	$heureAppel = $heure."H".$minute;
                	echo "<td>".$heureAppel."</td>";
                	echo "<td>".$current['commentaires']."</td>";
                echo "</tr>";
			}
			echo "
                    </tbody>
                </table>
                	";
		}
		else
			echo "Aucun appel.";
	}

	public function addAppelDemande($idAppel,$idDemandePriseEnCompte) {
		$sql = "INSERT INTO appel115_has_demandepriseencompte VALUES('$idAppel','$idDemandePriseEnCompte')";
		$this->db->query($sql);
		return mysql_insert_id();
	}

}

?>
