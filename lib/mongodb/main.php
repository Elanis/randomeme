<?php 
/************************************************
			      PHP MONGO LIB
					BY ELANIS
************************************************/

class mongoInterface {
	private $manager;

	/**
	 * Connect to a database
	 *
	 * @param      string  $dbURL  The database url
	 */
	private function connect($dbURL) {
		if(!isset($dbURL)||$dbURL=="") { //Wrong Use !
			echo "DATABASE ERROR: All needed informations are not given !";
			die();
		}

		if(!extension_loaded("mongodb")) {
			echo "ERROR: MONGO EXTENSION NOT LOADED !";
			die();
		} else {
			try {
				$this->manager = new MongoDB\Driver\Manager($dbURL);
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

	/**
	 * Gets the content depends on a condition
	 *
	 * @param      string  $db      The database name
	 * @param      string  $doc     The document name
	 * @param      string  $filter  The filter
	 *
	 * @return     array   Query return
	 */
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

	/**
	 * Adds content to database
	 *
	 * @param      string  $db       The database name
	 * @param      string  $doc      The document name
	 * @param      array   $content  The content needs to be inserted
	 */
	public function addContent($db,$doc,$content) {
		$bulkUsers = new MongoDB\Driver\BulkWrite(['ordered' => true]);
		$bulkUsers->insert($content);

		$manager->executeBulkWrite($db.'.'.$doc, $bulkUsers);
	}

	public function removeContent() {

	}
}