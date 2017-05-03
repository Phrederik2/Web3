<?php
session_start ();
/**
 * interface afin d'obliger les meme fonction dans les objects
 */
interface Prelud {
	public function toString();
	public function regex();
}
 
/**
 * class input, impose la base de la plupart des elements de formulaire
 */
class Input implements Prelud {
	private $label = "";
	private $type = "";
	private $name = "";
	private $value = "";
	private $id = "";
	private $placeHolder = "";
	private $regex = "";
	private $regexNOK = "";
	private $parent = "";
	private $visible = true;

	/**
	 * crée un constructeur avec des valeurs par defaut afin de simuler plusieurs constructeur
	 * contient une reference sur le formulaire parent afin d'aller récuperé les infos necessaire
	 * 
	 * @param string $label le label, le nom du champ tel qu'il sera afficher pour le présenter
	 * @param string $name le nom du champ, qui doit etre unique afin de récuperé le POST
	 * @param string $value la valeur par defaut du champ
	 * @param string $placeHolder indice sur la façon d'utiliser le champ (grisé et diparais des que le champ n'est plus null)
	 * @param string $id doit etre unique et par defaut sera le le nom(complet) du champ
	 * @param string $regex defini le regex de verification si necessaire
	 * @param string $regexNOK defini la phrase a ajouter en dessous du champ si le regex n'est pas valide
	 */
	function __construct($label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		$this->setLabel ( $label );
		if (isset ( $name ))
			$this->setName ( $name );
		else
			$this->setName ( $label );
		if (isset ( $value ))
			$this->setValue ( $value );
		if (isset ( $id ))
			$this->setId ( $id );
		else
			$this->setId ( $label );
		if (isset ( $placeHolder ))
			$this->setPlaceHolder ( $placeHolder );
		if (isset ( $regex ))
			$this->setRegex ( $regex );
		if (isset ( $regexNOK ))
			$this->setRegexNOK ( $regexNOK );
	}

	/**
	 * retourne la valeur qui ce trouve en session en fonctions du nom du champ
	 * 
	 * @return void
	 */
	function getSession() {
		return $_SESSION [$this->getName ()];
	}
	
	/**
	 * si le POST correspondant existe, envoi en session la valeur de post afin de la sauvegarder
	 * 
	 * @return void
	 */ 
	function setSession() {
		if (isset ( $_POST [$this->getName ()] ) == true) {
			$_SESSION [$this->getName ()] = $_POST [$this->getName ()];
		}
	}
	
	/**
	 * pour etre conforme a Prelud
	 * 
	 * @return void
	 */ 
	function toString() {
	}

	/**
	 * traitement du regex si la valeur n'est pas vide
	 * 
	 * @return void
	 */
	function regex() {
		if ($this->getRegex () != null && $this->getValue () != null) {
			if (! preg_match ( $this->getRegex (), $this->getValue () )) {
				return $this->getRegexNOK ();
			}
		}
		return "";
	}

	/**
	 * // ensemble de get/set
	 * 
	 * @return void
	 */
	function getLabel() {return $this->label;}
	function setLabel($value) {$this->label = $value;}
	function getType() {return $this->type;}
	function setType($value) {$this->type = $value;}
	
	/**
	 *  concatene le titre parent et nom du champ afin de rendre unique chaque champ, meme avec plusieurs formulaire
	 * 
	 * @return void
	 */
	function getName() {
		return $this->getParent ()->getTitleChild () . "::" . $this->name;
	}
	function setName($value) {$this->name = $value;}

	function getSimpleName() {return $this->name;}

	/**
	 * Decode la valeur qui viens de la DB afin de l'utiliser normalement
	 * 
	 * @return void
	 */
	function getValue() {
		return html_entity_decode ( $this->value );
	}

	/**
	 * protege des insertions sql les valeurs introduite
	 * 
	 * @param string $value
	 * @return void
	 */
	function setValue($value) {
		$this->value = htmlentities ( $value );
	}
	function getId() {return $this->id;}
	function setId($value) {$this->id = $value;}
	function getPlaceHolder() {return $this->placeHolder;}
	function setPlaceHolder($value) {$this->placeHolder = $value;}
	function getRegex() {return $this->regex;}
	function setRegex($value) {$this->regex = $value;}
	function getRegexNOK() {return $this->regexNOK;}
	function setRegexNOK($value) {$this->regexNOK = $value;}
	function getParent() {return $this->parent;}
	function setParent($value) {$this->parent = $value;}
	function getVisible() {return $this->visible;}
	function setVisible($visible) {$this->visible = $visible;}

	/**
	 * si l'elements n'est pas vide, retourne la balise html et sa valeur
	 * 
	 * @return void
	 */
	function showId() {
		if ($this->getId ())
			return " id=\"{$this->getId()}\" ";
	}

	/**
	 * si l'elements n'est pas vide, retourne la balise html et sa valeur
	 * 
	 * @return void
	 */
	function showName() {
		if ($this->getName ())
			return " name=\"{$this->getName()}\" ";
	}

	/**
	 * si l'elements n'est pas vide, retourne la balise html et sa valeur
	 * 
	 * @return void
	 */
	function showValue() {
		if ($this->getvalue ()!=null)
			return " value=\"{$this->getValue()}\" ";
	}

	/**
	 * si l'elements n'est pas vide, retourne la balise html et sa valeur
	 * 
	 * @return void
	 */
	function showPlaceHolder() {
		if ($this->getPlaceHolder ())
			return " placeholder=\"{$this->getPlaceHolder()}\" ";
	}

	/**
	 * si l'elements n'est pas vide, retourne la balise html et sa valeur avec le style demandée par l'utilisateur (par defaut <Legend>)
	 * 
	 * @return void
	 */
	function showLabel() {
		if ($this->getLabel () )

			return "<{$this->getParent()->getStyleOfLabeling()}>{$this->getLabel()}: </{$this->getParent()->getStyleOfLabeling()}>";
	}
}

/**
 * class de base pour création des sous class de type input text
 */
class TextInput extends Input {
	private $startHTML;
	private $endHTML;
	
	/**
	 * Constucteur avec tout les parametre necessaire pour la creation d'un champ input classique
	 * 
	 * @param string $startHTML debut de la balise HTML
	 * @param string $endHTML fin de la balise HTML
	 * @param string $label label ou nom du champ tel qu'il sera affiché
	 * @param string $name nom du champ qui sera concatené avec le titre du form
	 * @param string $value valeur par defaut
	 * @param string $placeHolder aide au remplassage
	 * @param string $id l'id unique utilisable dans du css ou JS
	 * @param string $regex le regex pour verification si necessaire
	 * @param string $regexNOK l'erreur a afficher si regex nok
	 */
	function __construct($startHTML, $endHTML, $label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		$this->setStartHTML ( $startHTML );
		$this->setEndHTML ( $endHTML );
		parent::__construct ( $label, $name, $value, $placeHolder, $id, $regex, $regexNOK );
	}
	function getStartHTML() {return $this->startHTML;}
	function setStartHTML($startHTML) {$this->startHTML = $startHTML;}
	function getEndHTML() {return $this->endHTML;}
	function setEndHTML($endHTML) {$this->endHTML = $endHTML;}
	
	// 
	/**
	 * invoque les balises du champ qui s'additionne si l'element n'est pas vide
	 * 
	 * @return void
	 */
	function toString() {
		$str = $this->showLabel ();
		$str .= $this->getStartHTML ();
		$str .= $this->showId ();
		$str .= $this->showPlaceHolder ();
		$str .= $this->showName ();
		$str .= $this->showValue ();
		$str .= $this->getEndHTML ();
		return $str;
	}
	
	/**
	 * renvoi a la fonction parent
	 * 
	 * @return void
	 */
	function regex() {
		return parent::regex ();
	}
}

/**
 * Class input Text basée sur TextInput
 */
class Text extends TextInput {

	/**
	 * construit le constructeur pour textinput avec les delimitation HTML
	 * 
	 * @param string $label label ou nom du champ tel qu'il sera affiché
	 * @param string $name nom du champ qui sera concatené avec le titre du form
	 * @param string $value valeur par defaut
	 * @param string $placeHolder aide au remplassage
	 * @param string $id l'id unique utilisable dans du css ou JS
	 * @param string $regex le regex pour verification si necessaire
	 * @param string $regexNOK l'erreur a afficher si regex nok
	 */
	function __construct($label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		parent::__construct ( "<input type=\"text\"", ">", $label, $name, $value, $placeHolder, $id, $regex, $regexNOK );
	}
}

/**
 * Class input basée sur TextInput
 */
class Email extends TextInput {
	
	/**
	 * construit le constructeur pour textinput avec les delimitation HTML
	 * 
	 * @param string $label label ou nom du champ tel qu'il sera affiché
	 * @param string $name nom du champ qui sera concatené avec le titre du form
	 * @param string $value valeur par defaut
	 * @param string $placeHolder aide au remplassage
	 * @param string $id l'id unique utilisable dans du css ou JS
	 * @param string $regex le regex pour verification si necessaire
	 * @param string $regexNOK l'erreur a afficher si regex nok
	 */
	function __construct($label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		parent::__construct ( "<input type=\"email\"", ">", $label, $name, $value, $placeHolder, $id, $regex, $regexNOK );
	}
}

/**
 * Class input basée sur TextInput
 */
class Password extends TextInput {
	
	/**
	 * construit le constructeur pour textinput avec les delimitation HTML
	 * 
	 * @param string $label label ou nom du champ tel qu'il sera affiché
	 * @param string $name nom du champ qui sera concatené avec le titre du form
	 * @param string $value valeur par defaut
	 * @param string $placeHolder aide au remplassage
	 * @param string $id l'id unique utilisable dans du css ou JS
	 * @param string $regex le regex pour verification si necessaire
	 * @param string $regexNOK l'erreur a afficher si regex nok
	 */
	function __construct($label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		parent::__construct ( "<input type=\"password\"", ">", $label, $name, $value, $placeHolder, $id, $regex, $regexNOK );
	}
}

/**
 * Class input de text Textarea basé sur Input
 */
class TextArea extends Input {

	/**
	 * construit le constructeur pour input
	 * 
	 * @param string $label label ou nom du champ tel qu'il sera affiché
	 * @param string $name nom du champ qui sera concatené avec le titre du form
	 * @param string $value valeur par defaut
	 * @param string $placeHolder aide au remplassage
	 * @param string $id l'id unique utilisable dans du css ou JS
	 * @param string $regex le regex pour verification si necessaire
	 * @param string $regexNOK l'erreur a afficher si regex nok
	 */
	function __construct($label, $name = null, $value = null, $placeHolder = null, $id = null, $regex = null, $regexNOK = null) {
		$this->setType ( "textarea" );
		parent::__construct ( $label, $name, $value, $placeHolder, $id, $regex, $regexNOK );
	}
	
	/**
	 * invoque les balises du champ qui s'additionne si l'element n'est pas vide
	 * 
	 * @return void
	 */
	function toString() {
		$str = $this->showLabel ();
		$str .= "<" . $this->getType ();
		$str .= $this->showId ();
		$str .= $this->showPlaceHolder ();
		$str .= $this->showName ();
		$str .= ">" . $this->getValue ();
		$str .= "</" . $this->getType () . ">";
		return $str;
	}
	
	/**
	 * renvoi a la fonction parent
	 * 
	 * @return void
	 */
	function regex() {
		return parent::regex ();
	}
}

/**
 * Class input type select, ce compose d'une liste avec les object Option
 */
class Select extends Input {
	private $list = array ();
	private $query;
	private $PDO;
	private $selected = null;
	private $bind = false;

	/**
	 * Constructeur de la class pour construire rapidement l'object'
	 * 
	 * @param string $label le label, le nom de l'object tel qu'il sera afficher
	 * @param string $PDO  le PDO donné en parametre pour acceder a la DB
	 * @param string $query la query necessaire afin de savoir comment récuperé les elements en options
	 * @param string $name le nom unique, sera concatené avec le titre du form
	 * @param string $id l'id pour config CSS ou JS
	 */
	function __construct($label, $PDO = null, $query = null, $name = null, $id = null) {
		$this->setType ( "select" );
		parent::__construct ( $label, $name, null, null, $id );
		// simule la présente d'une valeur pour la verification de valeur de l'object Form
		$this->setValue ( "0" );
		if ($PDO != null)
			$this->setPDO ( $PDO );
		if ($query != null)
			$this->setQuery ( $query );
	}

	function getQuery() {return $this->query;}
	function setQuery($query) {$this->query = $query;}
	function getPDO() {return $this->PDO;}
	function setPDO($PDO) {$this->PDO = $PDO;}

	/**
	 * Permet de crée un bind apres le passage du constructeur si cela est necessaire
	 * 
	 * @param string $PDO l'objet PDO deja crée (reference)
	 * @param string $query la query necessaire afin de savoir comment récuperé les elements en options
	 * @return void
	 */
	function bind($PDO, $query) {
		$this->setPDO ( $pdo );
		$this->setQuery ( $query );
		$this->bind = true;
	}
	
	/**
	 * Ajoute un elements de type Option a la liste des Items
	 * 
	 * @param Option $item
	 * @return void
	 */
	function add(Option $item) {
		$this->list [] = $item;
	}

	/**
	 * si les elements necessaire son présent au bind (PDO et query) alors execution du statement et balayage des lignes pour integré la liste des options
	 * La collone 0 sera la valeur et la collone 1 sera le nom affiché de l'option'
	 * 
	 * @return void
	 */
	function addToList() {
		if ($this->query != null and $this->PDO != null) {
			$statement = $this->PDO->query ( $this->query );
			$array = $statement->fetchAll ();
			foreach ( $array as $item ) {
				$this->add ( new Option ( $item [0], $item [1] ) );
			}
		}
	}
	function setSelected($value) {$this->selected = $value;}

	/**
	 * si le parametre selected et la valeur n'est pas null
	 * alors on balaye la liste des Items (option) afin de trouver celle qui correspond a la valeur rechercher et l'indique comme "Selected"
	 * on cherche dans la valeur comme le label
	 * remet tout les autres elements not selected
	 * 
	 * @return void
	 */
	function selected() {
		if ($this->selected != null and $this->getValue () == null) {
			foreach ( $this->list as $item ) {
				if ($item->getValue () == $this->selected or $item->getLabel () == $this->selected)
					$item->setSelected ( true );
				else
					$item->setSelected ( false );
			}
		}
		
		if ($this->getValue () != null) {
			foreach ( $this->list as $item ) {
				if ($item->getValue () == $this->getValue ())
					$item->setSelected ( true );
				else
					$item->setSelected ( false );
			}
		}
	}
	
	/**
	 * etablis la liste, commence par ajouter les elements et a selectionné ce qui est demander (via clé) ensuite concatene les toString des options dans la liste
	 * 
	 * @return void
	 */
	function readList() {
		$str = "";
		
		$this->addToList ();
		$this->selected ();
		
		foreach ( $this->list as $item ) {
			$str .= $item->toString ();
		}
		return $str;
	}
	
	
	/**
	 * Retourne l'ensemble des elements indispensable a la création d'une liste deroulante
	 * appelle la fonction de lecture dans la db et donc de création et selection des option;
	 * 
	 * @return void
	 */
	function toString() {
		$str = $this->showLabel ();
		$str .= "<" . $this->getType ();
		$str .= $this->showId ();
		$str .= $this->showName ();
		$str .= ">";
		$str .= $this->readList ();
		$str .= "</" . $this->getType () . ">";
		return $str;
	}

	/**
	 * Pas de regex sur les liste
	 * 
	 * @return void
	 */
	function regex() {
	}
}

/**
 * Class d'option associée a Select
 */
class Option extends Input {
	private $selected = false;

	/**
	 * Constructeur de l'objet
	 * 
	 * @param string $value la valeur qui sera transmise dans le POST
	 * @param string $label le label, le nom qui l'identifiera dans la liste 
	 * @param boolean $selected si l'elements est selectionné ou pas
	 */
	function __construct($value, $label = null, $selected = false) {
		if ($label == null)
			$label = $value;
		$this->setType ( "option" );
		$this->selected = $selected;
		parent::__construct ( $label, null, $value );
	}
	
	/**
	 * retourne selected si selected == true
	 * 
	 * @return void
	 */
	function getSelected() {
		if ($this->selected == true)
			return "selected";
	}
	function setSelected($value) {$this->selected = $value;}
	
	/**
	 * renvoi les elements indispensable a une option
	 * 
	 * @return void
	 */
	function toString() {
		$str = "<" . $this->getType ();
		$str .= $this->showValue ();
		$str .= $this->getSelected ();
		$str .= ">";
		$str .= $this->getLabel ();
		$str .= "</" . $this->getType () . ">";
		return $str;
	}
	
	/**
	 * Pas de regex sur une option
	 * 
	 * @return void
	 */
	function regex() {
	}
}

/**
 * Class Chebox basé sur input
 */
class Checkbox extends Input {
	private $isChecked = false;
	private $trueValue = - 1;
	private $falseValue = 0;

	/**
	 * constructeur de la class, permet d'ajout rapide des elements
	 * 
	 * @param string $label le nom qui sera visible dans le formulaire
	 * @param string $name le nom de l'object indispensable pour le lié a la db
	 * @param string $trueValue valeur qui defini une value TRUE (peux etre -1 ou 1 ou true ou totalement difference selon les utilisation -1 par defaut)
	 * @param string $falseValue valeur qui defini une value FALSE (peux etre 0 ou false ou totalement difference selon les utilisation 0 par defaut)
	 * @param boolean $isChecked si l'element est checked ou pas
	 */
	function __construct($label, $name = null, $trueValue = null, $falseValue = null, $isChecked = false) {
		if ($isChecked)
			$this->setIsChecked ( true );
		$this->setType ( "checkbox" );
		if ($isChecked != null)
			$_SESSION [$this->getName ()] = $isChecked;
		if ($trueValue != null)
			$this->trueValue = $trueValue;
		if ($falseValue != null)
			$this->falseValue = $falseValue;
		parent::__construct ( $label, $name );
	}
	function getIsChecked() {return $this->isChecked;}
	function setIsChecked($isChecked) {$this->isChecked = $isChecked;}

	/**
	 * cascade de verification si de l'elements
	 * si il existe des POST pour des elements du formulaire en cours alors on recherche la valeur de notre elements
	 * Si il existe, l'element est donc seletionner, sinon il ne l'est Password
	 * si pas de POST, alors on envoi la valeur par defaut (si elle existe)
	 * 
	 * au final si l'elemnt est selectionné, on return checked
	 * 
	 * @return void
	 */
	function getChecked() {
		if ($this->getParent()->getIsPOSTExist ()) {
			if (isset ( $_POST [$this->getName ()] ) or ($this->isChecked == true and $this->getVisible () == false))
				$this->setValue ( $this->trueValue );
			else
				$this->setValue ( $this->falseValue );
		} elseif ($this->getValue () == "") {
			if ($this->getIsChecked ())
				$this->setValue ( $this->trueValue );
			else
				$this->setValue ( $this->falseValue );
		}
		if ($this->getValue () == $this->trueValue)
			return "checked";
	}

	/**
	 * pas de regex sur checkbox
	 * 
	 * @return void
	 */
	function regex() {
	}
	
	/**
	 * return les elements indispensable pour afficher une checkbox
	 * 
	 * @return void
	 */
	function toString() {
		$str = "<" . $this->getParent()->getStyleOfLabeling () . " for=\"" . $this->getName () . "\">" . $this->getLabel () . "<input type=\"" . $this->getType () . "\"";
		$str .= $this->showName ();
		$str .= $this->showValue ();
		$str .= $this->getChecked ();
		$str .= "</" . $this->getParent()->getStyleOfLabeling () . ">";
		return $str;
	}
}

/**
 * class d'ajout de commentaire, afin d'alimenté les errors et remarks
 */
class Comment {
	private $title = "";
	private $remark = "";
	
	/**
	 * Constucteur de la classe
	 * 
	 * @param string $title le titre de du commentaire
	 * @param string $remark le message proprement dit
	 */
	function __construct($title = null, $remark = null) {
		if ($title != null)
			$this->setTitle ( $title );
		if ($remark != null)
			$this->setRemark ( $remark );
	}
	function getTitle() {return $this->title;}
	function setTitle($title) {$this->title = $title;}
	function getRemark() {return $this->remark;}
	function setRemark($remark) {$this->remark = $remark;}
	
	/**
	 * renvoi les elements d'affiche
	 * si le titre existe renvoi le titre et le message
	 * sinon renvoi le message
	 * 
	 * @return void
	 */
	function toString() {
		if ($this->getTitle () != "")
			return $this->getTitle () . ":" . $this->getRemark ();
		
		return $this->getRemark ();
	}
}

/**
 * crée un formulaire a l'aide d'une liste d'elements, possede un titre et des fonctions de verification'
 */
class Form {
	private $list = array ();
	private $listError = array ();
	private $listRemark = array ();
	private $title = "";
	private $titleChild = "";
	private $regexNOK = 0;
	private $table = "";
	private $where;
	private $PDO;
	private $isFieldSet = 1;
	private $itemInLine = 0;
	private $bind = false;
	private $autorizeEmpty = false;
	private $isPOSTExist = false;
	private $showTitle = true;
	private $styleOfLabeling = "legend";
	
	/**
	 * Constructeur de la 
	 * Ajoute le titre et crée le titrechild qui sera utiliser par tout les enfants
	 * verifie si des POST existe avec le titre du form
	 * 
	 * @param string $title titre du formulaire
	 */
	function __construct($title) {
		$this->title = $title;
		$this->setTitleChild ( $this->Replace ( $this->title, ' ', '_' ) );
		$this->setIsPOSTExist ();
	}
	
	// get/set
	function getTitle() {return $this->title;}
	function setTitle($title) {$this->title = $title;}
	function getTable() {return $this->table;}
	function setTable($table) {$this->table = $table;}
	function setPDO($PDO) {$this->PDO = $PDO;}
	function getPDO() {return $this->PDO;}
	function getIsFieldSet() {return $this->isFieldSet;}

	function setIsFieldSet($isFieldSet) {
		if ($isFieldSet)
			$this->isFieldSet = 1;
		else
			$this->isFieldSet = 0;
	}
	function getItemInLine() {return $this->itemInLine;}
	function setItemInLine($itemInLine) {
		if ($itemInLine)
			$this->itemInLine = 1;
		else
			$this->itemInLine = 0;
			}
	/**
	 * Retourne le dernier elements inseré dans la list d'items
	 * 
	 * @return void
	 */
	function getLastItem() {return $this->getItem ( $this->countItem () - 1 );}
	function getWhere() {return $this->where;}
	function setWhere($where) {$this->where = $where;}
	function getAutorizeEmpty() {return $this->autorizeEmpty;}
	function setAutorizeEmpty($autorizeEmpty) {
		if ($autorizeEmpty)
			$this->autorizeEmpty = 1;
		else
			$this->autorizeEmpty = 0;
	}
	function getTitleChild() {return $this->titleChild;}
	function setTitleChild($titleChild) {$this->titleChild = $titleChild;}
	function getStyleOfLabeling() {return $this->styleOfLabeling;}
	function setStyleOfLabeling($styleOfLabeling) {$this->styleOfLabeling = $styleOfLabeling;}
	
	/**
	 * Crée un binding avec la base de donnée et flag Bind comme True (important car le tout les elements peuvent etre disponible sans forcement vouloir un binding réel)
	 * 
	 * @param PDO $PDO la reference du PDO a utiliser pour la connection
	 * @param string $table la table a laquel ce connecter
	 * @param string $where la clause where eventuel (principalement ID=?)
	 * @return void
	 */
	function bind($PDO, $table, $where) {
		$this->setPDO ( $PDO );
		$this->setTable ( $table );
		$this->SetWhere ( $where );
		$this->bind = true;
	}

	/**
	 * retourne l'item de la liste en fonction de l'index, si il existe sinon retourne null
	 * 
	 * @param int $index
	 * @return void
	 */
	function getItem($index) {
		if (isset ( $this->list [$index] ))
			return $this->list [$index];
		return false;
	}

	/**
	 * retourne le nombre d'item dans la liste
	 * 
	 * @return void
	 */
	function countItem() {
		return count ( $this->list );
	}
	
	/**
	 * return un tableau classique ET un tableau associatif tableau[nom de champ]
	 * 
	 * @return void
	 */
	function getListItem() {
		$list = array ();
		for($i = 0; $i < count ( $this->list ); $i ++) {
			$list [$this->list [$i]->getSimpleName ()] = $this->list [$i];
			$list [$i] = $this->list [$i];
		}
		return $list;
	}

	/**
	 * Determine si il existe des elements de POST qui contient le titre du formulaire
	 * 
	 * @return void
	 */
	function setIsPOSTExist() {
		foreach ( $_POST as $key => $value ) {
			if (strstr ( $key, $this->titleChild ) == true) {
				$this->isPOSTExist = true;
				return;
			}
		}
	}

	function getIsPOSTExist() {
		return $this->isPOSTExist;
	}
	
	/**
	 * ajout d'un elements dans le liste
	 * ajoute une reference de l'objet en cours dans son enfant
	 * lance le setsession de l'enfants
	 * 
	 * @param Input $item
	 * @return void
	 */
	function add(Input $item) {
		$item->setParent ( $this );
		$item->setSession ();
		if (isset ( $_SESSION [$item->getName ()] ))
			$item->setValue ( $item->getSession () );
		$this->list [] = $item;
	}

	/**
	 * Ajoute un commentaire dans la liste des errors
	 * si la liste des errors n'est pas vide, cela invalidera la validation du formulaire
	 * 
	 * @param Comment $Error
	 * @return void
	 */
	function addError(Comment $Error) {
		$this->listError [] = $Error;
	}
	
	/**
	 * Ajoute un commentaire dans la liste des remarques, permet d'ajouter des elements interne ou extene qui serons affichée dans systeme du formulaire
	 * 
	 * @param Comment $Remark
	 * @return void
	 */
	function addRemark(Comment $Remark) {
		$this->listRemark [] = $Remark;
	}
	function getShowTitle() {return $this->showTitle;}
	function setShowTitle($showTitle) {$this->showTitle = $showTitle;}
	
	/**
	 * retourne l'element titre si showtitle == true
	 * 
	 * @return void
	 */
	function showTitle() {
		if ($this->getShowTitle () == true) {
			return "<legend>" . $this->getTitle () . "</legend>";
		}
	}
	
	/**
	 * remplace tout les caractere $search par des caractere $replace
	 * 
	 * @param string $string
	 * @param char $search
	 * @param char $replace
	 * @return void
	 */
	function Replace($string, $search, $replace) {
		$tmp = str_split ( $string );
		for($i = strlen ( $string ) - 1; $i > 0; $i --) {
			if ($tmp [$i] == $search) {
				$tmp [$i] = $replace;
			}
		}
		return implode ( $tmp );
	}

	/**
	 * si les elements du binding sont présent (sans pour autand etre réellment binder) et qu'il n'existe pas de POST pour ce formulaire
	 * alors va chercher les elements de dans la DB et cheque chaque elements de la listes des items sur chaque elements du tableau assos
	 * afin de faire correspondre les valeurs de la table avec les elements du formulaire
	 * verifie la dispo des champ/assos vua strToUpper pour eviter les problemes de cases
	 * 
	 * @return void
	 */
	function bindValue() {
		if ($this->PDO != null and $this->table != null and $this->where != null and $this->getIsPOSTExist () == false) {
			
			$statement = $this->PDO->query ( "SELECT * from $this->table WHERE $this->where" );
			$array = $statement->fetch ( PDO::FETCH_ASSOC );
			if ($statement->rowCount () > 0) {
				foreach ( $this->list as $item ) {
					foreach ( $array as $key => $value ) {
						if (strtoupper ( $item->getSimpleName () ) == strtoupper ( $key ))
							$item->setValue ( $value );
					}
				}
			}
		}
	}

	/**
	 * si isfieldset == true return fieldset
	 * 
	 * @return string
	 */
	function showFieldset() {
		if ($this->getIsFieldSet ())
			return "<fieldset>";
	}
	
	/**
	 * si itemInLine == true return br
	 * 
	 * @return string
	 */
	function showItemInLine() {
		if (! $this->getItemInLine ())
			return "</br>";
	}
	
	// crée un fieldset avec legend et crée le formulaire a l'interieur'
	/**
	 * Crée les elements du du formulaire en y intégrans les sous elements et les verifications
	 * - lance le binding (si actif)
	 * - ajoute le titre et le fieldset (si necessaire)
	 * - ajoute chaque elements avec verification du regex et affichage de l'erreur si necessaire
	 * - termine le formulaire
	 * - Ajoute les erreurs et les remarque
	 * - Effectue les insert si formulaire valide et pas de binding
	 * - Effectue les update si formulaire valide et binding
	 * 
	 * @return str
	 */
	function toString() {
		$this->bindValue ();
		$str = $this->showFieldset ();
		$str .= $this->showTitle ();
		$str .= "<Form method=\"POST\">";
		
		// pour tout les elements de la liste, l'affiche et verifie le regex, si non conforme affiche l'erreur en dessous du champ
		foreach ( $this->list as $tmp ) {
			if ($tmp->getVisible () == true) {
				
				$str .= $tmp->toString ();
				$str .= $this->showItemInLine ();
				$tmpRegex = $tmp->regex ();
				if ($tmpRegex != "") {
					$str .= "<div class=\"FormRegexErreur\">$tmpRegex</div></br>";
					$this->regexNOK ++;
				}
			} else {
				$tmp->toString ();
			}
		}
		$str .= '<input type="submit" name="submit" value="submit">';
		
		// verifie le regex de chaque item et si il n'est pas null.
		$this->validation ();
		
		// si la liste ne contient pas d'erreur, alors on peux ecrire dans la DB
		if (count ( $this->listError ) == 0) {
			$this->writeDB ();
			$this->updateDB ();
		}
		$str .= "</Form>{$this->readComment($this->listError)}{$this->readComment($this->listRemark)}";
		if ($this->getIsFieldSet () == 1)
			$str .= "</fieldset>";
		return $str;
	}
	
	/**
	 * verifie si les valeurs sont bien remplie (non null)
	 * 
	 * @return int
	 */
	function isNotNull() {
		$i = 0;
		foreach ( $this->list as $item ) {
			if ($item->getValue () == null && strlen ( $item->getValue () == 0 ))
				$i ++;
		}
		return $i;
	}
	
	/**
	 * ajout les commentaires de $list
	 * 
	 * @param Remark/Error $list
	 * @return string
	 */
	function readComment($list) {
		$str = "";
		foreach ( $list as $item ) {
			$str .= $item->toString () . "</br>";
		}
		return $str;
	}
	
	// si le form contien le nom de la table, ecris dans la DB le contenu du formulaire
	// seulement si le formulaire ne contien pas d'erreur'.
	/**
	 * Si il existe un Binding et que le formulaire est valide et que il n'y a pas de POST en cours pour ce Form
	 * Alors effectue l'update des elements du formulaire
	 * si l'operation echoue ou que PDO contien une erreur, alors l'erreur sera ajouter a la liste des erreurs
	 * 
	 * @return void
	 */
	function updateDB() {
		if ($this->isPOSTExist == false)
			return;
		if ($this->bind == true) {
			$name = "";
			$value = "";
			$i = 0;
			foreach ( $this->list as $item ) {
				if ($i != 0) {
					$value .= ",";
				}
				$value .= $this->Replace ( $item->getSimpleName (), ' ', '_' ) . "=";
				$value .= "'" . htmlspecialchars ( $item->getvalue (), ENT_QUOTES ) . "'";
				$i ++;
			}
			$sql = "UPDATE {$this->getTable()} SET $value WHERE $this->where";
			if (isset ( $this->PDO )) {
				try {
					$this->PDO->beginTransaction ();
					$this->PDO->exec ( $sql );
					$this->PDO->commit ();
				} catch ( Exeption $e ) {
					$this->PDO->rollBack ();
					$this->addError ( new Comment ( "Connection DB", "Tentative d'update a échoué: $sql" ) );
				} 

				finally{
					// si errorcode n'est pas a 0 alors ajout l'erreurs en dans listeerreur afin de prévenir l'utilisateur
					if ($this->PDO->errorCode () != "00000")
						$this->addError ( new Comment ( "Erreur", $this->PDO->errorInfo () [2] ) );
						// sinon, ajout une remark afin de prévenir de la réussite.
					else {
						$this->addRemark ( new Comment ( "Connection DB", "Enregistrement Modifié dans la DB!" ) );
					}
				}
			}
		}
	}

	/**
	 * Si pas de binding présent (mais elements de bind necessaire présent (pdo et nom de la table)) et pas de POST présent pour ce Form
	 * alors ajoute les elements du formulaire dans la DB
	 * si l'operation echoue ou que PDO contien une erreur, alors l'erreur sera ajouter a la liste des erreurs
	 * 
	 * @return void
	 */
	function writeDB() {
		if ($this->isPOSTExist == false)
			return;
		
		if ($this->getTable () != "" AND $this->getPDO()!=null AND $this->bind == false) {
			$name = "";
			$value = "";
			$i = 0;
			foreach ( $this->list as $item ) {
				if ($i != 0) {
					$name .= ",";
					$value .= ",";
				}
				$name .= $this->Replace ( $item->getSimpleName (), ' ', '_' );
				$value .= "'" . $item->getvalue () . "'";
				$i ++;
			}
			$sql = "INSERT INTO {$this->getTable()} ($name) VALUES ($value)";
			if (isset ( $this->PDO )) {
				try {
					$this->PDO->beginTransaction ();
					$this->PDO->exec ( $sql );
					$this->PDO->commit ();
				} catch ( Exeption $e ) {
					$this->PDO->rollBack ();
					$this->addError ( new Comment ( "Connection DB", "Tentative d'insert a échoué: $sql" ) );
				} 

				finally{
					// si errorcode n'est pas a 0 alors ajout l'erreurs en dans listeerreur afin de prévenir l'utilisateur
					if ($this->PDO->errorCode () != "00000")
						$this->addError ( new Comment ( "Erreur", $this->PDO->errorInfo () [2] ) );
						// sinon, ajout une remark afin de prévenir de la réussite.
					else {
						$this->addRemark ( new Comment ( "Connection DB", "Enregistrement ajouté dans la DB!" ) );
					}
				}
			}
		}
	}

	/**
	 * Réinitialise a null la valeurs de tout les elements de la liste des items
	 * 
	 * @return void
	 */
	function reinit() {
		foreach ( $this->list as $item ) {
			$item->setValue ( null );
		}
	}
	
	/**
	 * Verifie le regex des elements (si présent)
	 * verifie si tout les champs son remplis (si necessaire)
	 * si aucune erreur, valide l'enregistrmement via une remark
	 * 
	 * @return string
	 */
	function validation() {
		$error = 0;
		$str = "";
		// verifie la comformité des elements
		if ($this->regexNOK > 0) {
			$error ++;
			$str = "";
			$str .= "<div class=\"FormRegexErreur\">";
			$str .= "Veuillez redefinir le(s) {$this->regexNOK} champ(s) invalide(s).";
			$str .= "</div>";
			$this->addError ( new Comment ( "Champ(s) invalide(s)", $str ) );
		}
		
		// verifie sis tout les champs sont remplis
		$count = $this->isNotNull ();
		
		if ($count != 0 and $this->autorizeEmpty == false) {
			$error ++;
			$str = "";
			$str .= "<div class=\"FormRegexErreur\">";
			$str .= "Veuillez remplir  le(s) {$count} champ(s) vide(s).";
			$str .= "</div>";
			$this->addError ( new Comment ( "Champ(s) vide(s)", $str ) );
		}
		
		// si il n'y a nis champ vide ni regex nok, alors l'enregistrement est valide
		if ($error == 0 and $this->autorizeEmpty == false) {
			$str = "";
			$str .= "<div class=\"FormRegexGood\">";
			$str .= "Tout les champs sont correctement remplis.</br>";
			$str .= "</div>";
			$this->addRemark ( new Comment ( "[Enregistrement possible]", $str ) );
		}
		
		return $str;
	}
}

/**
 * 
 */
class Display{
	private $array=null;
	private $PDO=null;
	private $query=null;
	private $primaryKey=null;

	function __construct($PDO=null,$primaryKey=null,$query=null){ 
		$this->setPDO($PDO);
		$this->setPrimaryKey($primaryKey);
		$this->setQuery($query);
	}

	function getArray(){return $this->array;}
	function setArray($array){$this->array= $array;}
	function getPDO(){return $this->PDO;}
	function setPDO($PDO){$this->PDO= $PDO;}
	function getQuery(){return $this->query;}
	function setQuery($query){$this->query= strtolower($query);}
	
	function getPrimaryKey(){return $this->primaryKey;}
	function setPrimaryKey($primaryKey){$this->primaryKey= strtolower($primaryKey);}

	private function isbind(){
		if ($this->getPDO()!=null AND $this->getPrimaryKey()!=null AND $this->getQuery()!=null) return true;
		return false;
	}
	private function queryArray(){
		if($this->isBind()){
			$this->array = $this->returnTab($this->PDO->query($this->query));
		}
	}

	private function returnTab($statement) {
		if ($statement != false and $statement->rowCount () > 0) {
			return $statement->fetchAll ( PDO::FETCH_ASSOC );
		}
		return null;
	}

	function toString(){
		$this->queryArray();
		if($this->array==null) return;
		$str = "";

        foreach ($this->array as $key => $value) {
            $id =null;
            $concat="";
           foreach ($value as $key => $item) {
               if($concat!=""){
                   $concat.=" ";
               }
               if($key != $this->getPrimaryKey()){
                    $concat.= $item;
               }
               else {
                   $id=$item;
               }
           }
            if ($id!=null){
                $str.= "<a href=\"index.php?{$this->getPrimaryKey()}=$id\">$concat</a>";
            }
            else{
                $str.=$concat;
            }
            $str.= "</br>";
        }
        return $str;
	}

}

