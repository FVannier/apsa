<?php

  header('Content-type: text/html; charset=UTF-8', true);

  require("class/Session.class.php");
  include_once("class/BD.class.php");
  include_once("class/Personne.class.php");

  $Session = new Session();
  $bd = new BD(true);

  $sql = 'SELECT * FROM personne WHERE nom LIKE \'' . safe( $_GET['q'] ) . '%\' OR prenom LIKE \'' . safe( $_GET['q'] ) . '%\' LIMIT 0,20';
  $ressql = $bd->query($sql);

  if( mysql_num_rows( $ressql ) == 0 )
  {
    echo "<h3 style='text-align:center; margin:10px 0;''>Pas de résultats pour cette recherche.</h3>";

  }
  else
  {
      ?><table class="table table-striped table-bordered">
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
              <tbody><?php
      while($current = mysql_fetch_assoc($ressql))
      {
      ?>
          <div class="article-result">
            
              <?php
                if($current['sexe']!='')
                {
                  echo "<tr class=warning>";
                    echo "<td>".$current['nom']."</td>";
                    echo "<td>".$current['prenom']."</td>";
                    echo "<td style='text-align:center;'>".$current['sexe']."</td>";
                    $date_de_naissance = $current['dateNaissance'];                            
                    $chiffre = explode('-',$date_de_naissance);
                    $time_naissance = mktime(0,0,0,$chiffre[2],$chiffre[1],$chiffre[0]);
                    $seconde_vecu = time() - $time_naissance;
                    $seconde_par_an = (1461*24*60*60)/4;
                    $age = floor(($seconde_vecu / $seconde_par_an));
                    echo "<td style='text-align:center;'>".$age."</td>";
                    echo "<td style='text-align:center;'><a class='btn' href='usager.php?voir=".$current['idPersonne']."'><i class='icon-eye-open'></i></a></td>";
	           		echo "<td style='text-align:center;'><a class='btn' href='usager.php?ecrire=".$current['idPersonne']."'><i class='icon-pencil'></i></a></td>";
            		echo "</tr>";
                }
              ?>
              
          </div>
      <?php
      }
      ?>
      </tbody>
            </table>
            <?php
  }
 
/*****
fonctions
*****/
function safe($var)
{
	$var = mysql_real_escape_string($var);
	$var = addcslashes($var, '%_');
	$var = trim($var);
	$var = htmlspecialchars($var);
	return $var;
}
?>