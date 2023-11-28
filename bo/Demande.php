<?php

class Demande {


private $_ID_Demande;

private $_Details;
private $_ID_Etat;
private $_Matricule_Agent;
private $_Date_Etat;
private $_Date_Prevision_Inter;
private $_ID_Categorie;
private $_ID_Applicatif;
private $_ID_Service;
private $_Technicien_ID_Agent;


			public function __construct(array $donnees)
		{
								$this->hydrate($donnees);
		}
		

				public function hydrate(array $donnees)
		{
			foreach ($donnees as $key => $value)
			{
			$method = 'Set_'.$key;
			
			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
			}						
		
		}
		



			public function Get_ID_Demande(){

									return $this->_ID_Demande;
}



			public function Get_Details(){

									return $this->_Details;
}



			public function Get_ID_Etat(){

									return $this->_ID_Etat;
}

			public function Get_Matricule_Agent(){

									return $this->_Matricule_Agent;
}


			public function Get_Date_Etat(){

									return $this->_Date_Etat;
}



			public function Get_Date_Prevision_Inter(){

									return $this->_Date_Prevision_Inter;
}



			public function Get_ID_Categorie(){

									return $this->_ID_Categorie;
}


			public function Get_ID_Applicatif(){

									return $this->_ID_Applicatif;
}
			public function Get_ID_Service(){

									return $this->_ID_Service;
}



			public function Get_Technicien_ID_Agent(){

									return $this->_Technicien_ID_Agent;
}



			public function Set_ID_Demande($val){
									$val=(int)$val;
									 $this->_ID_Demande=$val;
}



			public function Set_Details($val){

									 $this->_Details=$val;

}

			public function Set_ID_Etat($val){

									 $this->_ID_Etat=$val;

}
			public function Set_Matricule_Agent($val){

									 $this->_Matricule_Agent=$val;

}

			public function Set_Date_Etat($val){

									 $this->_Date_Etat=$val;

}

			public function Set_Date_Prevision_Inter($val){

									 $this->_Date_Prevision_Inter=$val;

}

			public function Set_ID_Categorie($val){

									 $this->_ID_Categorie=$val;

}



			public function Set_ID_Applicatif($val){

									 $this->_ID_Applicatif=$val;

}
			public function Set_ID_Service($val){

									 $this->_ID_Service=$val;

}

			public function Set_Technicien_ID_Agent($val){

									 $this->_Technicien_ID_Agent=$val;

}

}