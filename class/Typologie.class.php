<?php

class Typologie {
	
	private $db;

	public function __construct($d) {
		$this->db = $d;
	}
	
	public function add($intituleTypologie) {
		$sql = "INSERT INTO typologie VALUES (NULL,'$intituleTypologie')";
		$this->db->query($sql);
		return mysql_insert_id();
	}
	
	public function search($intituleTypologie) {
		$sql = "SELECT * FROM typologie WHERE intituleTypologie = '$intituleTypologie'";
        $ressql = $this->db->query($sql);
        $current = mysql_fetch_assoc($ressql);

		if($current=='')
        {
            $id=$this->add($intituleTypologie);
            
            $sql2 = "SELECT * FROM typologie WHERE idTypologie = '$id'";
         	$ressql2 = $this->db->query($sql2);
         	$current2 = mysql_fetch_assoc($ressql2);
            return $current2['idTypologie'];
        }
        
        return $current['idTypologie'];
    }
}

?>