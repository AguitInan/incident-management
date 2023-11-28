<?php

class Categorie {


private $_ID_Agent;

private $_Nom;
private $_Prenom;
private $_Mail;
private $_Telephone;
private $_Matricule;
private $_Date_Entree_Collectivite;


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
		



			public function Get_ID_Agent(){

									return $this->_ID_Agent;
}



			public function Get_Nom(){

									return $this->_Nom;
}
			public function Get_Prenom(){

									return $this->_Prenom;
}
			public function Get_Mail(){

									return $this->_Mail;
}
			public function Get_Telephone(){

									return $this->_Telephone;
}
			public function Get_Matricule(){

									return $this->_Matricule;
}
			public function Get_Date_Entree_Collectivite(){

									return $this->_Date_Entree_Collectivite;
}



			public function Set_ID_Agent($val){
									$val=(int)$val;
									 $this->_ID_Agent=$val;
}



			public function Set_Nom($val){

									 $this->_Nom=$val;

}
			public function Set_Prenom($val){

									 $this->_Prenom=$val;

}
			public function Set_Mail($val){

									 $this->_Mail=$val;

}
			public function Set_Telephone($val){

									 $this->_Telephone=$val;

}
			public function Set_Matricule($val){

									 $this->_Matricule=$val;

}
			public function Set_Date_Entree_Collectivite($val){

									 $this->_Date_Entree_Collectivite=$val;

}

}
?>