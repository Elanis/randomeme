<?php 
<<<<<<< HEAD
/* =============================================
			       PHP SQL LIB
					BY ELANIS
=============================================== */

class Database {
	private $bd;

	/* Connect
	INPUT: host (string), db (string), id (string), password (string)
	OUTPUT: -
	*/
	private function connect($host,$db,$id,$password) {
=======
/************************************************
			       PHP SQL LIB
					BY ELANIS
************************************************/

class sqlInterface {
	private $bd;

	/**
	 * Connect
	 *
	 * @param      string  $host      The host
	 * @param      string  $db        The database
	 * @param      string  $id        The username
	 * @param      string  $password  The password
	 */
	private function connect($host,$db,$id,$password,$port=3306) {
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
		if($host=="") { $host="localhost"; }

		if($id==""||!isset($id)||$db==""||!isset($db)||$password==""||!isset($password)) { //Wrong Use !
			echo "DATABASE ERROR: All needed informations are not given !";
			exit();
		}

		try {
<<<<<<< HEAD
			$this->bd = new PDO('mysql:host='.$host.';dbname='.$db,$id,$password);
		}
		catch (Exception $e) {
		        die('Erreur : ' . $e->getMessage());
		}
	}

	/* construct
	INPUT: host (string), db (string), id (string), password (string)
	OUTPUT: -
	*/
=======
			$this->bd = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db,$id,$password);
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	/**
	 * constructor
	 *
	 * @param      string  $host      The host
	 * @param      string  $db        The database
	 * @param      string  $id        The username
	 * @param      string  $password  The password
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function __construct($host,$db,$id,$password) {
		$this->connect($host,$db,$id,$password); //Il faut se connecter à la BDD
    }

<<<<<<< HEAD
	/* getContent
	INPUT: table (string), min (int), size (int), order (string)
	OUTPUT: -
	*/
=======
	/**
	 * Gets the content of a table
	 *
	 * @param      table           $table  The table name
	 * @param      integer		   $min    The minimum index
	 * @param      integer         $size   The size
	 * @param      string          $order  The order type
	 *
	 * @return     array           The content.
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function getContent($table,$min=0,$size=1000000,$order="") {
		if(is_string($table)) {
			$query = $this->bd->prepare('SELECT * FROM '.$table.' ORDER BY '.$order.' LIMIT '.$min.', '.$size);
			$query->execute();
			$data = array();
			$i = 0;
			while($data1 = $query->fetch()) {
				$data[$i] = $data1;
				$i++;
			}
			$query->CloseCursor();

			return $data;
		}
		else {
<<<<<<< HEAD
			return;
		}
	}

	/* getCondContent
	INPUT: table (string), where (table)
	OUTPUT: -
	*/
=======
			return [];
		}
	}

	/**
	 * Gets content of a table depends on specified conditions.
	 *
	 * @param      array           $table  The table name
	 * @param      array           $where  The condition
	 * @param      integer		   $min    The minimum index
	 * @param      integer         $size   The size
	 * @param      string          $order  The order type
	 *
	 * @return     array           The condition content.
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function getCondContent($table,$where,$min=0,$size=1000000,$order="id") {
		if(is_string($table)&&is_array($where)) {
			$where_cond = "";

			for($i=0; $i<sizeof($where); $i++) {
				$where_cond .= 'LOWER('.$where[$i][0].') = :'.$where[$i][0];
				if($i!=sizeof($where)-1) {
					$where_cond .= ' AND '; //@ADD : OR/NOT/AND
				}
			}


			$query = $this->bd->prepare('SELECT * FROM '.$table.' WHERE '.$where_cond.' ORDER BY '.$order.' LIMIT '.$min.', '.$size);

			for($i=0; $i<sizeof($where); $i++) {
				if($where[$i][2]=="int") {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$where[$i][0],strtolower($where[$i][1]),PDO::PARAM_STR);
				}
			}

			$query->execute();
			$data = array();
			$i = 0;
			while($data1 = $query->fetch()) {
				$data[$i] = $data1;
				$i++;
			}
			$query->CloseCursor();

			return $data;
		}
		else {
<<<<<<< HEAD
			return;
		}
	}

	/* addContent
	INPUT: table (string), data (table)
	OUTPUT: -
	*/
=======
			return [];
		}
	}

	/**
	 * Adds a content into database
	 *
	 * @param      string  $table  The table
	 * @param      array   $data   The data
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function addContent($table,$data) {

			$content = "(";

			for($i=0; $i<sizeof($data); $i++) {
				$content .= $data[$i][0];
				if($i!=sizeof($data)-1) {
					$content .= ', ';
				}
			}
			$content .= ' ) VALUES ( ';

			for($i=0; $i<sizeof($data); $i++) {
				$content .= ':'.$data[$i][0];
				if($i!=sizeof($data)-1) {
					$content .= ', ';
				}
			}

			$content .= ' )';

			$query = $this->bd->prepare('INSERT INTO '.$table.$content);

			for($i=0; $i<sizeof($data); $i++) {
				if($data[$i][2]=="int") {
					$query->bindValue(':'.$data[$i][0],$data[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$data[$i][0],$data[$i][1],PDO::PARAM_STR);
				}
			}

			$query->execute();
			$query->CloseCursor();
	}

	/* updateContent
	INPUT: table (string), data (table), where (table)
	OUTPUT: -
	*/
<<<<<<< HEAD
=======

	/**
	 * Update database content
	 *
	 * @param      string  $table  The table
	 * @param      array   $data   The data
	 * @param      array   $where  The where
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function updateContent($table,$data,$where) {
		if(is_string($table)&&is_array($data)&&is_array($where)) {

			$where_cond = "";
			for($i=0; $i<sizeof($where); $i++) {
				$where_cond .= $where[$i][0].' = :'.$where[$i][0];
				if($i!=sizeof($where)-1) {
					$where_cond .= ' AND '; //@ADD : OR/NOT/AND
				}
			}

			$set_cond = "";
			for($i=0; $i<sizeof($data); $i++) {
				$set_cond .= $data[$i][0].' = :'.$data[$i][0];
				if($i!=sizeof($data)-1) {
					$set_cond .= ', ';
				}
			}

			$query = $this->bd->prepare('UPDATE '.$table.' SET '.$set_cond.' WHERE '.$where_cond);

			for($i=0; $i<sizeof($data); $i++) {
				if($data[$i][2]=="int") {
					$query->bindValue(':'.$data[$i][0],$data[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$data[$i][0],$data[$i][1],PDO::PARAM_STR);
				}
			}

			for($i=0; $i<sizeof($where); $i++) {
				if($where[$i][2]=="int") {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_STR);
				}
			}

			$query->execute();
			$query->CloseCursor();
		}
	}

<<<<<<< HEAD
=======
	/**
	 * Removes database content
	 *
	 * @param      string  $table  The table
	 * @param      array   $where  The where
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function removeContent($table,$where) {
		if(is_string($table)&&is_array($where)) {

			$where_cond = "";
			for($i=0; $i<sizeof($where); $i++) {
				$where_cond .= $where[$i][0].' = :'.$where[$i][0];
				if($i!=sizeof($where)-1) {
					$where_cond .= ' AND '; //@ADD : OR/NOT/AND
				}
			}

			$query = $this->bd->prepare('DELETE FROM '.$table.' WHERE '.$where_cond);

			for($i=0; $i<sizeof($where); $i++) {
				if($where[$i][2]=="int") {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_STR);
				}
			}

			$query->execute();
			$query->CloseCursor();
		}
	}

<<<<<<< HEAD
	/* drawTableByContent
	INPUT: table (string), min (int), size (int), order (string)
	OUTPUT: -
	*/
=======
	/**
	 * Draws a table by content.
	 *
	 * @param      array    $header  The header
	 * @param      array    $rows    The rows
	 * @param      string   $table   The table
	 * @param      integer  $min     The minimum
	 * @param      integer  $size    The size
	 * @param      string   $order   The order
	 */
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	public function drawTableByContent($header,$rows,$table,$min=0,$size=1000000,$order="") {
		echo "<table><tr>";
		for($i=0; $i<count($header); $i++) {
			echo "<th>".$header[$i]."</th>";
		}
		echo "</tr>";

		foreach ($this->getContent($table,$min,$size,$order) as $data) {
			echo '<tr>';
			for($i=0; $i<count($rows); $i++) {
					echo '<td class="'.$rows[$i].'">';
					echo $data[$rows[$i]];
					echo '</td>';
			}
			echo "</tr>";
		}
	}

<<<<<<< HEAD
	/* count
	Compte le nombre de lignes d'une table
	Parametre : table ( string )
	Retourne : ( int )
	*/
	public function count($table) {
		return $this->bd->query("SELECT COUNT(*) FROM ".$table)->fetchColumn();
	}
=======
	/**
	 * Compte le nombre de lignes d'une table
	 *
	 * @param      array    $table  The table
	 *
	 * @return     integer          compte de lignes
	 */
	public function count($table) {
		return $this->bd->query("SELECT COUNT(*) FROM ".$table)->fetchColumn();
	}

	/**
	 * Query to select with complexe SQL setences
	 *
	 * @param      <type>         $query      The query the sql server will read
	 * @param      <type>         $bindValue  The binded value
	 * @param      boolean        $oneResult  Does we echo only one result ?
	 *
	 * @return     array|boolean  ( description_of_the_return_value )
	 */
	public function selectQuery($query,$bindValue,$oneResult=false) {

		if(is_string($query)&&is_array($bindValue)&&is_bool($oneResult)) {

			$query = $this->bd->prepare($query);

			foreach($bindValue as $name => $value) {
				if(is_int($value) && is_bool($value)) {
					$pdoType = PDO::PARAM_INT;
				} else {
					$pdoType = PDO::PARAM_STR;
				}

				$query->bindValue(':'.$name,$value,$pdoType);
			}

			if($oneResult) {
				$data = $query->fetch();
				$query->CloseCursor();
				return $data;
			} else {
				$query->execute();
				$data = array();
				$i = 0;
				while($data1 = $query->fetch()) {
					$data[$i] = $data1;
					$i++;
				}
				$query->CloseCursor();

				return $data;	
			}
		} else {
			return false;
		}
	}

	/**
	 * Update database content via a custom query
	 *
	 * @param      <type>  $query      The custom query
	 * @param      <type>  $bindValue  The binded value
	 */
	public function updateQuery($query,$bindValue) {
		if(is_string($query)&&is_array($bindValue)) {

			$query = $this->bd->prepare($query);

			foreach($bindValue as $name => $value) {
				if(is_int($value) && is_bool($value)) {
					$pdoType = PDO::PARAM_INT;
				} else {
					$pdoType = PDO::PARAM_STR;
				}

				$query->bindValue(':'.$name,$value,$pdoType);
			}

			$query->execute();
			$query->CloseCursor();
		}
	}
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
}
?>