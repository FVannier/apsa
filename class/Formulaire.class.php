<?php

class Formulaire {

	function appelPolluant() {
		?>
		<form action="appel115.php" method="GET" class="well form-horizontal">
                		<fieldset>
                  			<legend>Appel polluant ?</legend>
                
                  			<div class="control-group" style="float:left;">
                      			<label class="control-label"><b>Polluant</b></label>
                      			<div class="controls">
                      				<label class="radio">
                          				<input type="radio" name="polluant" id="polluant" value="0" required checked/>Non
                        			</label>
                        			<label class="radio">
                          				<input type="radio" name="polluant" id="polluant" value="1" required />Oui
                        			</label>
                      			</div>
                  			</div>

                  			<div class="control-group" style="float:left;padding-top:20px">
                    			<label class="control-label"><b>Commentaires</b></label>
                    			<div class="controls">
                      				<textarea class="span4" rows="6" name="commentaires"></textarea>
                    			</div>
                  			</div>

                  			<div class="clearfix"></div>
                  			
                  			<center><input type="submit" name="checkpolluantappel" class="btn btn-primary" /></center>
                		</fieldset>
              		</form>
        <?php
	}
	
	function choixTypologie() {
	?>
	<form action="appel115.php" method="GET" class="well form-horizontal">
                		<fieldset>
                  			<legend>Typologie Usager</legend>

                  			<div class="control-group">
                    			<label class="control-label"><b>Usager</b></label>
                      			<div class="controls">
                        			<label class="radio inline">
                          				<input type="radio" name="usager" value="homme" required />Homme
                        			</label>
                        			<label class="radio inline">
                          				<input type="radio" name="usager" value="femme" required />Femme
                        			</label>
                        			<label class="radio inline">
                          				<input type="radio" name="usager" value="couple" required />Couple
                        			</label>
                      			</div>
                  			</div>

                  			<div class="control-group">
                    			<label class="control-label"><b>Nombre d'enfant(s)</b></label>
                      <div class="controls">
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="0" required checked/>0
                        </label>
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="1" required />1
                        </label>
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="2" required />2
                        </label>
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="3" required />3
                        </label>
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="4" required />4
                        </label>
                        <label class="radio inline">
                          <input onchange="enfant(this.value)" type="radio" name="nb_enfant" id="nb_enfant" value="5" required />Autres
                        </label>
                        <input class="input-small" type="text" name="autre_enfant" id="autre_enfant" disabled/>
                      </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label"><b>Animal</b></label>
                      <div class="controls">
                        <label class="radio inline">
                          <input onchange="animaux(this.value)" type="radio" name="animal" id="animal" value="0" required checked/>Non
                        </label>
                        <label class="radio inline">
                          <input onchange="animaux(this.value)" type="radio" name="animal" id="animal" value="1" required />Oui
                        </label>
                        
                        <input class="input-small" type="text" name="autre_animal" id="autre_animal" disabled/>
                        
                      </div>
                  </div>

                  <div class="clearfix"></div>
                  <center><input type="submit" name="typo" class="btn btn-primary" /></center>
                </fieldset>
              </form>
              <?php
	}
	
	function appelRepondeur() {
	?>
		<form action="appel115.php" method="POST" class="well form-horizontal">
    		<fieldset>
            	<legend>Répondeur 115</legend>

                <div style="float:left;margin-top:20px;">
                  	<div class="control-group">
                    	<label class="control-label"><b>Date</b></label>
                    	<div class="controls">
                      		<input type="text" name="dateAppel" required placeholder="jj/mm/aaaa"/>
                    	</div>
                  	</div>

                  	<div class="control-group">
                    	<label class="control-label"><b>Heure</b></label>
                    	<div class="controls">
                      		<input type="text" name="heureAppel" required placeholder="hh:mm"/>
                    	</div>
                  	</div>
                  
                  	<div class="control-group">
                    	<label class="control-label"><b>Polluant</b></label>
                    	<div class="controls">
                      		<label class="radio">
                        		<input type="radio" name="polluant2" id="polluant" value="1" required>Oui
                      		</label>
                      		<label class="radio">
                        		<input type="radio" name="polluant2" id="polluant" value="0" required>Non
                      		</label>
                		</div>
               		</div>
                </div>

                <div class="control-group" style="float:left;margin-top:20px;">
                  	<label class="control-label"><b>Commentaires</b></label>
                  	<div class="controls">
                    	<textarea class="span4" rows="6" name="commentaires"></textarea>
                  	</div>
                </div>

                <div class="clearfix"></div>
                
                <center><input type="submit" name="checkpolluantrepondeur" class="btn btn-primary" /></center>
			</fieldset>
		</form>
	<?php
	}
	
	function appel115($usager,$res,$typo,$idappel) {
	
	include_once("class/BD.class.php");
	include_once("Initiativedemande.class.php");
	include_once("Motif.class.php");
	include_once("Prestation.class.php");
	include_once("class/Ressource.class.php");
	include_once("class/Origine.class.php");
	include_once("class/Rupture.class.php");
	include_once("class/Orientation.class.php");
	
	$bd = new BD(true);
	$initiativedemande = new Initiativedemande($bd);
	$motif = new Motif($bd);
	$prestation = new Prestation($bd);
	$ressource = new Ressource($bd);
	$origine = new Origine($bd);
	$rupture = new Rupture($bd);
	$orientation = new Orientation($bd);

	?>
		
		<form action="appel115.php" method="POST" class="well form-horizontal">
        <?php
        	echo "<input type='hidden' name='usager' value='".$usager."' />";
            echo "<input type='hidden' name='enfant' value='".$res."' />";
            echo "<input type='hidden' name='typo' value='".$typo."' />";
            echo "<input type='hidden' name='idappel' value='".$idappel."' />";
        ?> 
			<fieldset>
                <div class="control-group">
                	<label class="control-label"><b>Initiative de la demande</b></label>
                    <div class="controls">
                    	<select name="initiative">
                        <?php
                        	$initiativedemande->liste();
                        ?>                    
                        </select>
                    </div>
                </div>

                <div class="row show-grid">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label"><b>Motif de l'appel</b></label>
                            <div class="controls">
                            <?php
                                $motif->liste();
                            ?>
                            </div>
                        </div>
                    </div>
                    
					<div class="span1"></div>
					
                    <div class="span5">
                        <div id="prestation" class="control-group" style="display:none;">
                            <label class="control-label"><b>Prestations</b></label>
                            <div class="controls">
                            <?php
                            	$prestation->liste();
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row show-grid">
                	<div class="span5">
						<legend>Usager</legend>
						
						<div class="control-group">
                            <label class="control-label"><b>Nom</b></label>
                            	<div class="controls">
                                	<input type="text" name="nom1" required="required" />
                              	</div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><b>Prénom</b></label>
                            <div class="controls">
                            	<input type="text" name="prenom1" required />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><b>Date de naissance</b></label>
                            <div class="controls">
                            	<input type="text" name="datenaissance1" placeholder="jj/mm/aaaa" required />
                            </div>
                        </div>
                        
                        <div class="control-group">
                        	<label class="control-label"><b>Sexe</b></label>
                        	<div class="controls">
                        	<?php
                        		if($usager=="homme"){
                        	?>	
                            	<label class="radio inline">
                                	<input type="radio" name="sexe1" value="homme" required checked/>Homme
                                </label>
                                <label class="radio inline">
                                	<input type="radio" name="sexe1" value="femme" required />Femme
                                </label>
                            <?php
                            	}
                            	else
                            	{
                            		if($usager=="femme"){
                            		?>
                            		<label class="radio inline">
                                		<input type="radio" name="sexe1" value="homme" required />Homme
                                	</label>
                                	<label class="radio inline">
                                		<input type="radio" name="sexe1" value="femme" required checked />Femme
                                	</label>
                            		<?php
                            		}
                            		else 
                            		{
                            		?>
                            		<label class="radio inline">
                                		<input type="radio" name="sexe1" value="homme" required />Homme
                                	</label>
                                	<label class="radio inline">
                                		<input type="radio" name="sexe1" value="femme" required />Femme
                                	</label>
                            		<?php
                            		}
                            	}
                            ?>
                            </div>
                        </div>

                        <div class="control-group">
                        	<label class="control-label"><b>Téléphone</b></label>
                            <div class="controls">
                                <input type="text" name="tel1" />
                            </div>
                        </div>

                        <div class="control-group">
                        	<label class="control-label"><b>Ressources déclarées</b></label>
                            <div class="controls">
                            <?php
                                $ressource->listeCouple1();
                            ?>
                            </div>
                        </div>
					</div>
					
					<div class="span1"></div>
					
                    <div class="span5">
                    <?php
                    	if($usager=="couple")
                    	{
                    ?>
                    	<legend>Conjoint</legend>
						
						<div class="control-group">
                            <label class="control-label"><b>Nom</b></label>
                            	<div class="controls">
                                	<input type="text" name="nom2" required />
                              	</div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><b>Prénom</b></label>
                            <div class="controls">
                            	<input type="text" name="prenom2" required />
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><b>Date de naissance</b></label>
                            <div class="controls">
                            	<input type="text" name="datenaissance2" placeholder="jj/mm/aaaa" required />
                            </div>
                        </div>
                        
                        <div class="control-group">
                        	<label class="control-label"><b>Sexe</b></label>
                        	<div class="controls">
                        		<label class="radio inline">
                                	<input type="radio" name="sexe2" value="homme" required />Homme
                                </label>
                                <label class="radio inline">
                                	<input type="radio" name="sexe2" value="femme" required />Femme
                                </label>
                            </div>
                        </div>

                        <div class="control-group">
                        	<label class="control-label"><b>Téléphone</b></label>
                            <div class="controls">
                                <input type="text" name="tel2" />
                            </div>
                        </div>

                        <div class="control-group">
                        	<label class="control-label"><b>Ressources déclarées</b></label>
                            <div class="controls">
                            <?php
                                $ressource->listeCouple2();
                            ?>
                            </div>
                        </div>
                    <?php
                    	}
                    ?>
                    </div>
                </div>
                	<div class="span11">
                    <div class="row show-grid">
                    <?php
						if(isset($res))
                        {
                            if($res!=0)
                                echo "<legend>Enfant</legend>";
                              
                            for($i=1;$i<=$res;$i++)
                            { 
                            ?>
                            	<div class="span5">
                                    <b><?php echo "Enfant ".$i; ?></b>
                                    <div class="control-group">
                                    	<label class="control-label"><b>Nom</b></label>
                                        <div class="controls">
                                        <?php
                                        	echo "<input type='text' name='nom_enfant_".$i."' required />";
                                        ?>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                    	<label class="control-label"><b>Prénom</b></label>
                                        <div class="controls">
                                        <?php
                                        	echo "<input type='text' name='prenom_enfant_".$i."' required />";
                                        ?>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                      	<label class="control-label"><b>Date de naissance</b></label>
                                        <div class="controls">
                                    	<?php
                                        	echo "<input type='text' name='datenaissance_enfant_".$i."' placeholder='jj/mm/aaaa' required />";
                                        ?>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                      	<label class="control-label"><b>L'appelant est-il le responsable légal de l'enfant ?</b></label>
                                        <div class="controls">
                                        <?php
                                        	echo "<label class='radio inline'>";
                                            	echo "<input type='radio' name='responsable1_enfant_".$i."' value='1' required />Oui";
                                          	echo "</label>";
                                          	echo "<label class='radio inline'>";
                                            	echo "<input type='radio' name='responsable1_enfant_".$i."' value='0' required />Non";
                                          	echo "</label>";
                                        ?>
                                        </div>
                                    </div>

									<?php
										if($usager=="couple")
										{
									?>
                                    <div class="control-group">
                                      	<label class="control-label"><b>Le conjoint est-il le responsable légal de l'enfant ?</b></label>
                                        <div class="controls">
                                        <?php
                                        	echo "<label class='radio inline'>";
                                            	echo "<input type='radio' name='responsable2_enfant_".$i."' value='1' required />Oui";
                                          	echo "</label>";
                                          	echo "<label class='radio inline'>";
                                            	echo "<input type='radio' name='responsable2_enfant_".$i."' value='0' required />Non";
                                          	echo "</label>";
                                        ?>
                                    	</div>
                                    </div>
                                    <?php
                                    	}
                                    ?>
                                </div>
                                
                                <div class="span1"></div>
                                  
                                <?php
                                }
                            }

                            ?>

                        </div>

                    
                    <legend> </legend>
					</div>
                 	<div class="control-group" style="margin-left:25%">
                    	<label class="control-label"><b>Origine</b></label>
                        <div class="controls">
                            <select name="origine">
                            <?php
                            	$origine->liste();
                            ?>                    
                            </select>
                        </div>
                    </div>

                	<div class="control-group" style="margin-left:25%">
                        <label class="control-label"><b>Rupture d'hébergement lié à</b></label>
                        <div class="controls">
                        	<select name="rupture">
                            <?php
                            	$rupture->liste();
                            ?>                    
                            </select>
                        </div>
                    </div>

                    <div class="control-group" style="margin-left:25%">
                        <label class="control-label"><b>Depuis combien de temps ?</b></label>
                        <div class="controls">
                            <input type="text" name="dateRupture" placeholder="jj/mm/aaaa" />
                        </div>
                    </div>

                	<div class="control-group" style="margin-left:25%">
                        <label class="control-label"><b>Orientation</b></label>
                        <div class="controls">
                        <?php
                        	$orientation->liste();
                        ?>
                        </div>
                    </div>

                    <div class="control-group" style="margin-left:25%">
                        <label class="control-label"><b>Notes sur la personne</b></label>
                        <div class="controls">
                            <textarea class="span4" rows="6" name="notes"></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <center><input type="submit" name="appel" class="btn btn-primary" /></center>
				</div>
			</fieldset>
		</form>
	<?php
	}
	
	function ajouterUtilisateur() {
	?>
		<form action="administration.php" method="post" class="well form-horizontal">
				          	<fieldset>
					            <legend>Ajouter un utilisateur</legend>

					            <div class="control-group">
						            <label class="control-label"><b>Login</b></label>
						            <div class="controls">
						            	<input type="text" name="login" required />
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Mot de passe</b></label>
						            <div class="controls">
						            	<input type="password" name="mdp" required />
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Nom</b></label>
						            <div class="controls">
						            	<input type="text" name="nom" required />
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Prénom</b></label>
						            <div class="controls">
						            	<input type="text" name="prenom" required />
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Statut</b></label>
						            <div class="controls">
						            	<select name="statut">
											<option value="Directeur">Directeur</option>
											<option value="Chef de service">Chef de service</option>
											<option value="Secrétaire">Secrétaire</option>
											<option value="Travailleur social">Travailleur social</option>
											<option value="Veilleur">Veilleur</option>
											<option value="Infirmier">Infirmier</option>
											<option value="Stagiaire">Stagiaire</option>
										</select>
						            </div>
						        </div>
						        
						        <div class="control-group">
						            <label class="control-label"><b>Permis</b></label>
						            <div class="controls">
						            	<label class="radio inline">
                          					<input type="radio" name="permis" value="1" required />Oui
                        				</label>
                        				<label class="radio inline">
                          					<input type="radio" name="permis" value="0" required />Non
                        				</label>
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Droits</b></label>
						            <div class="controls">
						            	<select name="droits">
						            		<option value="0">Utilisateur simple</option>
											<option value="1">Administrateur</option>					
										</select>
						            </div>
						        </div>

					            <center><input type="submit" name="ajouter" value="Ajouter" class="btn btn-success" /></center>
				        	</fieldset>
				        </form>
	<?php
	}
	
	function modifierUtilisateur() {
		include_once("class/BD.class.php");
  		include_once("class/Employe.class.php");
  	
  		$bd = new BD(true);
  		$employe = new Employe($bd);
	?>
		<form action="administration.php" method="post" class="well form-horizontal">
				          	<fieldset>
					            <legend>Modifier un utilisateur</legend>
					            
					            <div class="control-group">
						            <label class="control-label"><b>Choisir employé(e)</b></label>
						            <div class="controls">
						            	<select name="idEmploye">
						            	<?php
						        			$employe->liste();
						        		?>
										</select>
						            </div>
						        </div>
						        
						        <div class="control-group">
						            <label class="control-label"><b>Mot de passe</b></label>
						            <div class="controls">
						            	<input type="password" name="mdp" />
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Statut</b></label>
						            <div class="controls">
						            	<select name="statut">
											<option value="Directeur">Directeur</option>
											<option value="Chef de service">Chef de service</option>
											<option value="Secrétaire">Secrétaire</option>
											<option value="Travailleur social">Travailleur social</option>
											<option value="Veilleur">Veilleur</option>
											<option value="Infirmier">Infirmier</option>
											<option value="Stagiaire">Stagiaire</option>
										</select>
						            </div>
						        </div>
						        
						        <div class="control-group">
						            <label class="control-label"><b>Permis</b></label>
						            <div class="controls">
						            	<label class="radio inline">
                          					<input type="radio" name="permis" value="1" required />Oui
                        				</label>
                        				<label class="radio inline">
                          					<input type="radio" name="permis" value="0" required />Non
                        				</label>
						            </div>
						        </div>

						        <div class="control-group">
						            <label class="control-label"><b>Droits</b></label>
						            <div class="controls">
						            	<select name="droits">
						            		<option value="0">Utilisateur simple</option>
											<option value="1">Administrateur</option>					
										</select>
						            </div>
						        </div>
					            <center><input type="submit" name="modifier" value="Modifier" class="btn btn-success" /></center>
				        	</fieldset>
				        </form>
	<?php
	}
	
	function supprimerUtilisateur() {
		include_once("class/BD.class.php");
  		include_once("class/Employe.class.php");
  	
  		$bd = new BD(true);
  		$employe = new Employe($bd);
	?>
		<form action="administration.php" method="post" class="well form-horizontal">
				          	<fieldset>
					            <legend>Supprimer un utilisateur</legend>
					            
					            <div class="control-group">
						            <label class="control-label"><b>Choisir employé(e) à supprimer</b></label>
						            <div class="controls">
						            	<select name="idEmploye">
						            	<?php
						        			$employe->liste();
						        		?>
										</select>
						            </div>
						        </div>

					            <center><input type="submit" name="supprimer" value="Supprimer" class="btn btn-success" /></center>
				        	</fieldset>
				        </form>
	<?php
	}
	
	function ajouterVehicule() {
		include_once("class/BD.class.php");
  		include_once("class/Vehicule.class.php");
  	
  		$bd = new BD(true);
  		$vehicule = new Vehicule($bd);
	?>
		<form action="administration.php" method="post" class="well form-horizontal">
			<fieldset>
				<legend>Ajouter un véhicule</legend>
					            
				<div class="control-group">
					<label class="control-label"><b>Entrer le nom du nouveau véhicule</b></label>
					<div class="controls">
						<input type="text" name="intituleVehicule" />
					</div>
				</div>

				<center><input type="submit" name="ajoutervehicule" value="Ajouter" class="btn btn-success" /></center>
			</fieldset>
		</form>
	<?php
		
	}
	
	function supprimerVehicule() {
		include_once("class/BD.class.php");
  		include_once("class/Vehicule.class.php");
  	
  		$bd = new BD(true);
  		$vehicule = new Vehicule($bd);
	?>
		<form action="administration.php" method="post" class="well form-horizontal">
			<fieldset>
				<legend>Supprimer un véhicule</legend>
					            
				<div class="control-group">
					<label class="control-label"><b>Choisir le véhicule à supprimer</b></label>
					<div class="controls">
						<select name="idVehicule">
						<?php
							$vehicule->liste();
						?>
						</select>
					</div>
				</div>

				<center><input type="submit" name="supprimervehicule" value="Supprimer" class="btn btn-success" /></center>
			</fieldset>
		</form>
	<?php
	}
	
	function voirUsager() {
		include_once("class/BD.class.php");
  		include_once("class/Personne.class.php");
  	
  		$bd = new BD(true);
  		$personne = new Personne($bd);
	?>
		<form class="ajax form-search well" action="usager.php" method="GET">
        				<fieldset>
              				<legend>Rechercher un usager</legend>
              				<br />
              				<div class="control-group">
              					<div style="margin-left:5%" class="input-prepend">
              						<span class="add-on"><i class="icon-search"></i></span>
              						<input type="text" name="q" id="q" />
            					</div>
                			</div>
            				<legend>Liste des usagers</legend>
            				<table id="table" class="table table-bordered">
              					<thead>
                					<tr>
                  						<th style="text-align:center;background-color:#d9edf7;">Nom</th>
                  						<th style="text-align:center;background-color:#d9edf7;">Prénom</th>
                  						<th style="text-align:center;background-color:#d9edf7;">Sexe</th>
                  						<th style="text-align:center;background-color:#d9edf7;">Age</th>
                  						<th style="text-align:center;background-color:#d9edf7;">Voir la fiche détaillée</th>
                  						<th style="text-align:center;background-color:#d9edf7;">Ecrire une situation</th>
                					</tr>
              					</thead>
              					<tbody>
                				<?php
                  					$personne->liste();
                				?>
              					</tbody>
          					</table>

          					<div id="results"></div>
            			</fieldset>
          			</form>
	<?php
	}

}

?>