<?php
/* ===============================================
			     PHP LANGUAGE LIB
					BY ELANIS
=============================================== */

/* Include language files */
class Language {
	private $languageList = [
		'fr' => 'Francais',
		'en' => 'English',
		//'de' => 'Deutsch',
		//'ru' => 'русский'
	];
	private $defaultLanguage = "en";
	private $langage = "en";

	/* Construct */
	function __construct() {
		$this->setDefaultLanguage();
		$this->setLanguage();
		$this->importLanguageFiles();
	}
	/* setDefaultLanguage 
	Reglage du language par defaut
	INPUT: -
	OUTPUT: -
	*/
	private function setDefaultLanguage() {
		$clientLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);  //Get Navigator language

		foreach ($this->languageList as $lang_key => $lang_value) {
			if($lang_key==$clientLanguage) { $this->defaultLanguage = $clientLanguage; }
		}
	}
	/* setLanguage 
	Reglage du language courant
	INPUT: -
	OUTPUT: -
	*/
	private function setLanguage() {
<<<<<<< HEAD
		if(isset($_POST['selected-language'])) {
			$lang = $_POST['selected-language'];
		} elseif(isset($_POST['langue'])) {
			$lang = $_POST['langue'];
		} else {
			$lang = $_SESSION['lang'];	
		}
		$find = array_search($lang, $this->languageList);
=======
		$lang = "";
		// Get
		if(isset($_GET["lang"])) {
			$lang = $_GET["lang"];
		}
		$find = array_search($lang, $this->languageList);
		if(!$find) {
			if(isset($this->languageList[$lang])) {
				$lang = $this->languageList[$lang];
			}
			$find = array_search($lang, $this->languageList);
		}
		// POST / SESSION
		if(!$find) {
			if(isset($_POST['selected-language'])) {
				$lang = $_POST['selected-language'];
			} elseif(isset($_POST['langue'])) {
				$lang = $_POST['langue'];
			} elseif(isset($_SESSION['lang'])) {
				$lang = $_SESSION['lang'];	
			} else {
				$lang = "";
			}
			$find = array_search($lang, $this->languageList);
		}
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294

		if(!$find) { $this->language = $this->defaultLanguage; }
		else { $this->language = (string) $find; }

		$_SESSION['lang'] = $this->language;
	}
	/* importLanguageFiles 
	Importation des fichiers de language
	INPUT: -
	OUTPUT: -
	*/
	private function importLanguageFiles() {
		$filesList = scandir('./lib/lang/'.$this->language);
		foreach ($filesList as $file_key => $file_value) {
			$parts = explode(".",$file_value);
			if($parts[1]=="php") {
				require_once('./lib/lang/'.$this->language.'/'.$file_value);
			}
		}
	}
	/* drawLanguageList 
	Afficher le forumulaire de choix des languages
	INPUT: -
	OUTPUT: -
	*/
	public function drawLanguageList() {
<<<<<<< HEAD
		echo '<form action="'.$currentname.'" method="post">
=======
		echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
		<select id="langue" name="langue" size="1" onchange="this.form.submit()">';
		foreach ($this->languageList as $lang_key => $lang_value) {
			echo '<option value="'.$lang_value.'"';
			if($lang_key==$this->language) { echo ' selected '; }
			echo '>'.$lang_value.'</option>';
		}
		echo '</select></form>';
	}
}
?>