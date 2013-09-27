 <?php
                            /*
                              if($usager=="femme")
                              {
                              ?>
                                <div class="control-group">
                                  <label class="control-label"><b>Enceinte</b></label>
                                    <div class="controls">
                                      <label class="radio inline">
                                        <input type="radio" onchange="bebe(this.value)" name="enceinte" id="enceinte" value="1" />Oui
                                      </label>
                                      <label class="radio inline">
                                        <input type="radio" onchange="bebe(this.value)" name="enceinte" id="enceinte" value="0" checked />Non
                                      </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                  <label class="control-label"><b>+ de 3 mois</b></label>
                                    <div class="controls">
                                      <label class="radio inline">
                                        <input type="radio" name="mois" id="mois1" value="1" disabled />Oui
                                      </label>
                                      <label class="radio inline">
                                        <input type="radio" name="mois" id="mois2" value="0" disabled />Non
                                      </label>
                                    </div>
                                </div>
                            <?php
                              }*/
                            ?>


function supprimerUtilisateur() {
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
						        			//$employe->liste();
						        		?>
										</select>
						            </div>
						        </div>

					            <center><input type="submit" name="supprimer" value="Supprimer" class="btn btn-success" /></center>
				        	</fieldset>
				        </form>
	<?php
	}