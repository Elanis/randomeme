<?php 
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
		if($host=="") { $host="localhost"; }

		if($id==""||!isset($id)||$db==""||!isset($db)||$password==""||!isset($password)) { //Wrong Use !
			echo "DATABASE ERROR: All needed informations are not given !";
			exit();
		}

		try {
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
	public function __construct($host,$db,$id,$password) {
		$this->connect($host,$db,$id,$password); //Il faut se connecter à la BDD
    }

	/* getContent
	INPUT: table (string), min (int), size (int), order (string)
	OUTPUT: -
	*/
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
			return;
		}
	}

	/* getCondContent
	INPUT: table (string), where (table)
	OUTPUT: -
	*/
	public function getCondContent($table,$where,$min=0,$size=1000000,$order="id") {
		if(is_string($table)&&is_array($where)) {
			$where_cond = "";

			for($i=0; $i<sizeof($where); $i++) {
				$where_cond .= $where[$i][0].' = :'.$where[$i][0];
				if($i!=sizeof($where)-1) {
					$where_cond .= ' AND '; //@ADD : OR/NOT/AND
				}
			}


			$query = $this->bd->prepare('SELECT * FROM '.$table.' WHERE '.$where_cond.' ORDER BY '.$order.' LIMIT '.$min.', '.$size);

			for($i=0; $i<sizeof($where); $i++) {
				if($where[$i][2]=="int") {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_INT);

				} else {
					$query->bindValue(':'.$where[$i][0],$where[$i][1],PDO::PARAM_STR);
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
			return;
		}
	}

	/* addContent
	INPUT: table (string), data (table)
	OUTPUT: -
	*/
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
	public function updateContent($table,$data,$where) {
		if(is_string($table)&&is_array($where)) {

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

	/* drawTableByContent
	INPUT: table (string), min (int), size (int), order (string)
	OUTPUT: -
	*/
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

	/* count
	Compte le nombre de lignes d'une table
	Parametre : table ( string )
	Retourne : ( int )
	*/
	public function count($table)
	{
		return $this->bd->query("SELECT COUNT(*) FROM ".$table)->fetchColumn();
	}
}
?>