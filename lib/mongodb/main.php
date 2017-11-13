<?php 
/************************************************
			      PHP MONGO LIB
					BY ELANIS
************************************************/

class mongoInterface {
	private $manager;

	private function connect($dbURL) {
		if($dbURL==""||!isset($dbURL)) { //Wrong Use !
			echo "DATABASE ERROR: All needed informations are not given !";
			exit();
		}

		if(!extension_loaded("mongodb")) {
			echo "ERROR: MONGO EXTENSION NOT LOADED !";
			die();
		} else {
			try {
				$this->manager = new MongoDB\Driver\Manager($dburl );
			}
			catch (Exception $e) {
			        die('Erreur : ' . $e->getMessage());
			}
		}
	}

	/**
	 * constructor
	 *
	 * @param      string  $dbURL  The database url
	 */
	public function __construct($dbURL) {
		$this->connect($dbURL); //Il faut se connecter à la BDD
    }

	public function getCondContent($db,$doc,$filter) {
		if(is_string($db) && is_string($doc) && is_array($filter)) {
			$query = new MongoDB\Driver\Query($filter);
			$cursor = $this->manager->executeQuery($db.'.'.$doc, $query);

			return $cursor->toArray();
		} else {
			return [];
		}
	}

	public function updateContent() {

	}

	public function addContent($db,$doc,$content) {
		$bulkUsers = new MongoDB\Driver\BulkWrite(['ordered' => true]);
		$bulkUsers->insert($content);

		$manager->executeBulkWrite($db.'.'.$doc, $bulkUsers);
	}

	public function removeContent() {

	}
}