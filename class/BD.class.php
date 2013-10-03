<?php

class BD
{

	private $debug;
	
	public function __construct($debug)
	{
		$this->debug = $debug;
		/*
		 * 
		 * Connexion Base de donnée avec hébergement 
		 * 
		 * serveur, identifiant, mdp
		 * mysql_connect("","","");
		 * 
		 * base de donnée
		 * mysql_select_db("");
		 *
		 */
		mysql_connect("localhost","root","thoughtpolice");
		mysql_select_db("apsa");
	}
	
	public function query($sql)
	{
		mysql_query("SET NAMES UTF8");
		$res = mysql_query($sql);
		
		if(mysql_errno()!=0)
		{
			if($this->debug==1)
			{
				die("Problème : $sql <br />".mysql_error());
			}
			else
			{
				die();
			}
		}
		return $res;
	}
}

?>
