<?php
//require('pdo/SPDO.class.php');

class DAL_Demande {


private $_db;
	public function __construct($cnx){
		$this->Set_db($cnx);
	}


	public function Set_db($cnx){
		$this->_db=$cnx;
	}
			
			
	static function SelectAll (Pdo $db){
		$tab=array();
		$req="SELECT * FROM Demande";
		$return= $db->query("Select * from Demande");
		while( $ligne= $return->fetch(PDO::FETCH_ASSOC) )
		{
		foreach($ligne as $key => &$value){
				if(preg_match("/_date/i",$key) || preg_match("/_Date/i",$key))
					{												
					$value=date("d-m-Y", strtotime($value));												
					}									
		}
		$objet= new Demande($ligne);
		$tab[]=$objet;

		}
	return $tab;
	}


	static function valid_insc(Pdo $db,$id){
		$sql = "
					INSERT INTO Historique_Etat (ID_Demande,ID_Etat,Date_Etat)
					values ($id,1,now())
				";
		$req_prepa=$db->prepare($sql);
		$req_prepa->execute();				
	}
	
	static function demande_poste(Pdo $db,$id_demande,$poste_libelle){
		$sql = "
				INSERT INTO Demande_Poste (ID_Demande,ID_Poste) 
				SELECT  $id_demande, ID_Poste FROM Poste WHERE VDB = '$poste_libelle'
				";
				
		$req_prepa=$db->prepare($sql);
		$req_prepa->execute();				
	}

	static function inserer_demande(Pdo $db, Demande $objet){
									
		$sql = "INSERT INTO Demande (
			 		Details, 
			 		ID_Etat,
					Matricule_Agent,	
			 		Date_Etat,
			 		Date_Prevision_Inter, 
			 		ID_Categorie,
					ID_Applicatif,
					ID_Service,
					Technicien_ID_Agent) 
				VALUES (
					:Details,
					:ID_Etat,
					:Matricule_Agent,
					:Date_Etat,
					:Date_Prevision_Inter,
					:ID_Categorie,
					:ID_Applicatif,
					:ID_Service,
					:Technicien_ID_Agent
					)";
					
		
		$data = array($objet->Get_Details(),$objet->Get_ID_Etat(),$objet->Get_Matricule_Agent(),$objet->Get_Date_Etat(),$objet->Get_Date_Prevision_Inter(),$objet->Get_ID_Categorie(),$objet->Get_ID_Applicatif(),$objet->Get_ID_Service(),$objet->Get_Technicien_ID_Agent());
		
		$req_prepa=$db->prepare($sql);
		$req_prepa->bindParam(':Details',$data[0]);
		$req_prepa->bindParam(':ID_Etat',$data[1]);
		$req_prepa->bindParam(':Matricule_Agent',$data[2]);
		$req_prepa->bindParam(':Date_Etat',$data[3]);
		$req_prepa->bindParam(':Date_Prevision_Inter',$data[4]);
		$req_prepa->bindParam(':ID_Categorie',$data[5]);
		$req_prepa->bindParam(':ID_Applicatif',$data[6]);
		$req_prepa->bindParam(':ID_Service',$data[7]);
		$req_prepa->bindParam(':Technicien_ID_Agent',$data[8]);
		$req_prepa->execute();
	}
		
			
}
?>