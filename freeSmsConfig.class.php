<?php

/*
 @nom: Modele
 @auteur: Idleman (idleman@idleman.fr)
 @description:  Modele de classe pour les plugins
 */

//Ce fichier permet de gerer vos donnees en provenance de la base de donnees

//Il faut changer le nom de la classe ici (je sens que vous allez oublier)
class freeSmsConfig extends SQLiteEntity{

	
	protected $id,$identifiant,$password; //Pour rajouter des champs il faut ajouter les variables ici...
	protected $TABLE_NAME = 'freeSms'; 	//Penser a mettre le nom du plugin et de la classe ici
	protected $CLASS_NAME = 'freeSmsConfig';
	protected $object_fields = 
	array( //...Puis dans l'array ici mettre nom du champ => type
		'id'=>'key',
		'identifiant'=>'string',
		'password'=>'string'
	);

	function __construct(){
		parent::__construct();
	}

	function getId(){
		return $this->id;
	}

	function setId($id){
		$this->id = $id;
	}

	function getIdentifiant(){
		return $this->identifiant;
	}

	function setIdentifiant($identifiant){
		$this->identifiant = $identifiant;
	}

	function getPassword(){
		return $this->password;
	}

	function setPassword($password){
		$this->password = $password;
	}
}

?>