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

	/**
	 * Update content of a database
	 *
	 * @param      string  $db       The database
	 * @param      <type>  $doc      The document
	 * @param      <type>  $filter   The filter
	 * @param      <type>  $content  The content
	 */
	public function updateContent($db,$doc,$filter,$content) {
		if(is_string($db) && is_string($doc) && is_array($filter) && is_array($content)) {
			$bulkUsers = new MongoDB\Driver\BulkWrite();
			$bulkUsers->update($filter,$content);

			$this->manager->executeBulkWrite($db.'.'.$doc, $bulkUsers);
		}
	}

	/**
	 * Adds content to database
	 *
	 * @param      string  $db       The database name
	 * @param      string  $doc      The document name
	 * @param      array   $content  The content needs to be inserted
	 */
	public function addContent($db,$doc,$content) {
		if(is_string($db) && is_string($doc) && is_array($content)) {
			$bulkUsers = new MongoDB\Driver\BulkWrite(['ordered' => true]);
			$bulkUsers->insert($content);

			$this->manager->executeBulkWrite($db.'.'.$doc, $bulkUsers);
		}
	}

	/**
	 * Removes content from a database
	 *
	 * @param      string  $db      The database
	 * @param      <type>  $doc     The document
	 * @param      <type>  $filter  The filter
	 */
	public function removeContent($db,$doc,$filter) {
		if(is_string($db) && is_string($doc) && is_array($filter)) {
			$bulkUsers = new MongoDB\Driver\BulkWrite();
			$bulkUsers->delete($filter);

			$this->manager->executeBulkWrite($db.'.'.$doc, $bulkUsers);
		} 
	}
}