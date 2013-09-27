<?php

class Situation {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($dateSituation,$texteSituation,$dateRappelSituation) {
		$texteSituation = str_replace("'","&#39;",$texteSituation);

		$sql = "INSERT INTO situation VALUES (NULL,'$dateSituation','$texteSituation','$dateRappelSituation')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function add2($dateSituation,$texteSituation) {
		$texteSituation = str_replace("'","&#39;",$texteSituation);

		$sql = "INSERT INTO situation VALUES (NULL,'$dateSituation','$texteSituation',NULL)";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function addSituationPersonne($idSituation,$idPersonne) {
		$sql = "INSERT INTO situation_has_personne VALUES ('$idSituation','$idPersonne')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function returnDate() {
		$sql = "SELECT MAX(dateSituation) AS max FROM situation";
		$ressql = $this->db->query($sql);
		$current = mysql_fetch_assoc($ressql);
		
		return $current['max'];
	}
	
	public function afficherSituation($dateSituation) {
		include_once("Personne.class.php");
		
		$personne = new Personne($this->db);
		
		$sql = "SELECT * FROM situation WHERE dateSituation='$dateSituation'";
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "SELECT * FROM situation_has_personne WHERE Situation_idSituation=".$current['idSituation'];
			$ressql2 = $this->db->query($sql2);
			$current2 = mysql_fetch_assoc($ressql2);
			
			if(is_null($current['dateRappelSituation']))
			{
				echo "<tr class='warning'>";
            		echo "<td style='text-align:center;'><a href='usager.php?voir=".$current2['Personne_idPersonne']."' >".$personne->nomReturn($current2['Personne_idPersonne'])."</a></td>";
					echo "<td>".$current['texteSituation']."</td>";
					echo "<td style='text-align:center;'><center>Pas de rappel.</center></td>";
				echo "</tr>";
			}
			else
			{
				$dateRappel = explode("-",$current['dateRappelSituation']);
				$dateRappel2 = $dateRappel[2]."/".$dateRappel[1]."/".$dateRappel[0];
					
				echo "<tr class='error'>";
            		echo "<td style='text-align:center;'><a href='usager.php?voir=".$current2['Personne_idPersonne']."' >".$personne->nomReturn($current2['Personne_idPersonne'])."</a></td>";
					echo "<td>".$current['texteSituation']."</td>";
					echo "<td style='text-align:center;font-weight:bold;'><center>".$dateRappel2."</center></td>";
				echo "</tr>";
			}
		}
	}
	
	public function liste($idPersonne) {
		$sql = "SELECT * FROM situation_has_personne WHERE Personne_idPersonne=".$idPersonne;
		$ressql = $this->db->query($sql);
		while($current = mysql_fetch_assoc($ressql))
		{
			$sql2 = "SELECT * FROM situation WHERE idSituation=".$current['Situation_idSituation'];
			$ressql2 = $this->db->query($sql2);
			
			while($current2 = mysql_fetch_assoc($ressql2))
			{
				$dateDemande = explode("-",$current2['dateSituation']);
				$dateDemande2 = $dateDemande[2]."/".$dateDemande[1]."/".$dateDemande[0];
			
				if(is_null($current2['dateRappelSituation']))
				{
					echo "<tr class='warning'>";
            			echo "<td style='text-align:center;font-weight:bold;'>".$dateDemande2."</td>";
						echo "<td>".$current2['texteSituation']."</td>";
						echo "<td style='text-align:center;font-weight:bold;'><center>Pas de rappel.</center></td>";
					echo "</tr>";
				}
				else
				{
					$dateRappel = explode("-",$current2['dateRappelSituation']);
					$dateRappel2 = $dateRappel[2]."/".$dateRappel[1]."/".$dateRappel[0];
					
					echo "<tr class='error'>";
            			echo "<td style='text-align:center;font-weight:bold;'>".$dateDemande2."</td>";
						echo "<td>".$current2['texteSituation']."</td>";
						echo "<td style='text-align:center;font-weight:bold;'>".$dateRappel2."</td>";
					echo "</tr>";
				}
			}
		}
	}
	
	public function alerte() {
		$date=date('Y-m-d');
		$sql = "SELECT * FROM situation WHERE dateRappelSituation='".$date."'";
		$ressql = $this->db->query($sql);
		if(mysql_num_rows($ressql)!=0)
		{
			echo "<h3 style='color:red;'>Rappel(s)</h3><br />";
			while($current = mysql_fetch_assoc($ressql))
			{
				$sql2 = "SELECT * FROM situation_has_personne WHERE Situation_idSituation=".$current['idSituation'];
				$ressql2 = $this->db->query($sql2);
				$current2 = mysql_fetch_assoc($ressql2);
			
				$sql3 = "SELECT * FROM personne WHERE idPersonne=".$current2['Personne_idPersonne'];
				$ressql3 = $this->db->query($sql3);
				$current3 = mysql_fetch_assoc($ressql3);
				
				echo "<div class='well'>";
					echo "<span style='color:red;'><a href='usager.php?voir=".$current2['Personne_idPersonne']."'>".$current3['nom']." ".$current3['prenom']."</a> : ".$current['texteSituation']."</span>";
				echo "</div>";	
			}
		}
	}
	
	public function ecrireSituation($idPersonne) {
		include_once("Personne.class.php");
  	
  		$personne = new Personne($this->db);
		?>
		<form action="usager.php" method="POST" class="form-horizontal">
    				<?php
    					echo "<input type='hidden' name='id' value='".$idPersonne."' />";
    				?>
          			<fieldset>
          				<legend>Ecrire une situation concernant <?php $personne->nom($idPersonne); ?></legend>
          				<br />
          				<div class="row show-grid">
          					<div class="span8">
          						<div class="control-group">
                        			<label class="control-label"><b>Situation</b></label>
                        			<div class="controls">
                            			<textarea class="span6" rows="13" name="situation"></textarea>
                        			</div>
                    			</div>
                    		</div>
                    		<div class="span3">
                    			<div class="control-group" >
                            		<label class="control-label"><b style="color:red;">Date de rappel</b></label>
                            		<div class="controls">
                            			<input class="input-small" type="text" name="daterappel" placeholder="jj/mm/aaaa" />
                            		</div>
                        		</div>
                        		<br /><br /><br />
                        		
                        		<center><input type="submit" name="enregistrer" value="Enregistrer situation" class="btn btn-primary" /></center>
                        			
                        	</div>
                        </div>
                        
                        <br />
                        
                        <legend>Historique des situations concernant <?php $personne->nom($idPersonne); ?></legend>
                        <br />
                        <table id="table" class="table table-striped table-bordered">
              				<thead>
                				<tr>
                  					<th style="text-align:center;background-color:#d9edf7;">Date de l'écrit</th>
                  					<th style="text-align:center;background-color:#d9edf7;">Situation</th>
                  					<th style="text-align:center;background-color:#d9edf7;">Date de rappel</th>
                				</tr>
              				</thead>
              				<tbody>
                			<?php
                        		$this->liste($idPersonne);
                        	?>
              				</tbody>
          				</table>
          			</fieldset>
          		</form>
          		<?php
	}

}

?>
