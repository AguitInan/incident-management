<?php

class Applicatif {


private $_ID_Applicatif;

private $_Libelle;


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
		



			public function Get_ID_Applicatif(){

									return $this->_ID_Applicatif;
}



			public function Get_Libelle(){

									return $this->_Libelle;
}



			public function Set_ID_Applicatif($val){
									$val=(int)$val;
									 $this->_ID_Applicatif=$val;
}



			public function Set_Libelle($val){

									 $this->_Libelle=$val;

}

}
?>