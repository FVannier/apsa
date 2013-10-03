<?php
    // Test
  header('Content-type: text/html; charset=UTF-8', true);

  require("class/Session.class.php");
  include_once("class/BD.class.php");
  include_once("class/VerificationFormulaire.class.php");
	include_once("class/Situation.class.php");
	
  $Session = new Session();
  $bd      = new BD(true);
  $verif   = new VerificationFormulaire();
  $situation = new Situation($bd);

  if(isset($_POST['connexion']))
  {
    $login = $verif->verif_injection($_POST['login']); 
    $mdp = $verif->verif_injection($_POST['mdp']);

    $sql  = "SELECT * FROM employe WHERE login='".$login."'";
    $res  = $bd->query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    $data = mysql_fetch_assoc($res);

    if( $data['login']==$login )
    {
      if ( $data['mdp']==hash("sha512",$mdp) )
      {
        $_SESSION['idEmploye'] = $data['idEmploye'];
        $_SESSION['login'] = $login;
        $_SESSION['nom'] = $data['nom'];
        $_SESSION['prenom'] = $data['prenom'];
        $_SESSION['statut'] = $data['statut'];
        $_SESSION['droits'] = $data['droits'];

        echo '<script language="Javascript">var t=setTimeout("document.location.replace(\'index.php\')", 0)</script>';
      }
      else
      {
        $Session->setFlash('Mot de passe incorrect.','error');
      }
    }
    else
    {
      $Session->setFlash('Ce login n\'existe pas.','error');
    }
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>Accueil</title>
  
    <meta http-equiv="content-type" content="text/html" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="SIAO - 115 - Equipe de rue" />
    <meta name="Author" content="Maxence Lucas" />
    <meta name="Language" content="fr" />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <style>
      body {
        padding-top: 60px;
      }
    </style>

    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap-responsive.css" />

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">OSIRUS - S.I.A.O. de Lens</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.php">Accueil</a></li>
              <?php
              if(isset($_SESSION['idEmploye']))
              {
              ?>
              <li><a href="appel115.php">Appel 115</a></li>              
              <li><a href="equipe.php">Equipe de rue</a></li>
              <li><a href="usager.php">Usagers et Situations</a></li>
              <li><a href="logement.php">Logements</a></li>
              <li><a href="stats.php">Statistiques</a></li>
              <li><a href="administration.php">Administration</a></li>
              <li><a href="deconnexion.php">[X]</a></li>
              <?php
              }
              ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <br />
      <h1>Accueil</h1>
      <br />

      <?php

      if(isset($_SESSION['idEmploye']))
      {
        $Session->setFlash('Vous êtes connecté en tant que '.$_SESSION['nom'].' '.$_SESSION['prenom'].' - '.$_SESSION['statut'].'.','info');
        $Session->flash();
        $situation->alerte();
      }
      ?>
      <p>OSIRUS, site réservé aux personnels du S.I.A.O de Lens.</p>
      <br />
      <?php
      if(!isset($_SESSION['idEmploye']))
      {
      ?>
      <div class="span6">
        <form action="index.php" method="POST" class="well form-horizontal">
          <fieldset>
            <legend>Connexion</legend>
            <?php
              $Session->flash();
            ?>

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

            <center><input type="submit" name="connexion" value="Se connecter" class="btn btn-success" /></center>
          </fieldset>
        </form>
      </div>
      <?php
      }
      ?>
    </div>

  </body>
</html>