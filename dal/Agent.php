<?php
//require('pdo/SPDO.class.php');


class DAL_Agent {


private $_db;
			public function __construct($cnx){
									$this->Set_db($cnx); }


			public function Set_db($cnx){
									$this->_db=$cnx;
									}
					
					
			static function SelectAll (Pdo $db){	
									$tab=array();
									$return= $db->query("Select * from Agent");
									while( $ligne= $return->fetch(PDO::FETCH_ASSOC) )
									{
									foreach($ligne as $key => &$value){
											if(preg_match("/_date/i",$key) || preg_match("/_Date/i",$key))
												{												
												$value=date("d-m-Y", strtotime($value));												
												}									
									}
									$objet= new Agent($ligne);	
									$tab[]=$objet;
									}
									return $tab;
									
			
			
	}
			
			static function inserer(Pdo $db, Agent $objet){ 
							
									$req_prepa=$db->prepare("INSERT INTO Agent (Nom, Prenom, Mail, Telephone, Matricule, Date_Entree_Collectivite) VALUES (:Nom, :Prenom, :Mail, :Telephone, :Matricule, :Date_Entree_Collectivite)");
									$req_prepa->bindParam(':Nom',$objet->Get_Nom());
									$req_prepa->bindParam(':Prenom',$objet->Get_Prenom());
									$req_prepa->bindParam(':Mail',$objet->Get_Mail());
									$req_prepa->bindParam(':Telephone',$objet->Get_Telephone());
									$req_prepa->bindParam(':Matricule',$objet->Get_Matricule());
									$req_prepa->bindParam(':Date_Entree_Collectivite',$objet->Get_Date_Entree_Collectivite());
									$req_prepa->execute();
		
}


			
}


