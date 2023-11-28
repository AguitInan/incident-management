<?php
//require('pdo/SPDO.class.php');


class DAL_Categorie {


private $_db;
			public function __construct($cnx){
									$this->Set_db($cnx); }


			public function Set_db($cnx){
									$this->_db=$cnx;
									}
					
					
			static function SelectAll (Pdo $db){	
									$tab=array();
									$req="SELECT * FROM Categorie";
									$return= $db->query("Select * from Categorie");
									while( $ligne= $return->fetch(PDO::FETCH_ASSOC) )
									{
									foreach($ligne as $key => &$value){
											if(preg_match("/_date/i",$key) || preg_match("/_Date/i",$key))
												{												
												$value=date("d-m-Y", strtotime($value));												
												}									
									}
									$objet= new Categorie($ligne);	
									$tab[]=$objet;
									}
									return $tab;
									
			
			
	}
			
			static function inserer(Pdo $db, Categorie $objet){ 
							
									$req_prepa=$db->prepare("INSERT INTO Categorie ( Libelle) VALUES (:Libelle)");
									$req_prepa->bindParam(':Libelle',$objet->Get_Libelle());
									$req_prepa->execute();
		
}


			
}


