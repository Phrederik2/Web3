<?php

/**
 * TEST
 */

/**
 * Class de connection a la base de donn�e, il suffit de modifier les valeurs par defaut pour ce connecter a une autre base de donn�e.
 * 
 * @author phred
 *
 */
class Connect {
	private static $PDO=null;
	private static $path = "localhost";
	private static $db = "schedulinggenerator";
	private static $user = "user";
	private static $pwd = "bachelier";
	
	/**
	 * Construit le PDO sur base des variable interne.
	 */
	static function constructPDO() {
		Connect::$PDO = new PDO ( "mysql:host=" . Connect::$path . ";dbname=" . Connect::$db, Connect::$user, Connect::$pwd );
	}
	
	/**
	 * R�cupere le statement et cr�e un tableau du jeux complet r�cuper� en acces Associatif 
	 * @param Statement_PDO $statement 
	 * @return Array[]
	 */
	static function returnTab($statement) {
		if ($statement != false and $statement->rowCount () > 0) {
			return $statement->fetchAll ( PDO::FETCH_ASSOC );
		}
		return null;
	}
	
	/**
	 * Retourne le PDO
	 * @return $PDO
	 */
	static function getPDO() {
		if (Connect::$PDO==null)Connect::constructPDO();
		return Connect::$PDO;
	}

	/**
	 * Retourne un tableau assoc de la Query (l'utilisateur qui veux ce connecter si il existe et si il est actif)
	 * 
	 * @param [String] $name
	 * @param [String] $password
	 * @return Array[]
	 */
	static function verifUser($name, $password) {
		Connect::constructPDO ();
		return Connect::returnTab ( Connect::$PDO->query ( "SELECT *, FE_User.id as UserId from FE_User JOIN FE_Level ON FE_User.level=FE_Level.level where name = '$name' and password='$password'" ) );
	}
	
	/**
	 * 
	 * @return Array[]
	 */
	static function listUser() {
		Connect::constructPDO ();
		return Connect::returnTab ( Connect::$PDO->query ( "SELECT *, FE_User.id as UserId from FE_User JOIN FE_Level ON FE_User.level=FE_Level.level" ) );
	}

	static function returnQuery($sql) {
		Connect::constructPDO ();
		return Connect::returnTab ( Connect::$PDO->query ( $sql ) );
	}
	
}
