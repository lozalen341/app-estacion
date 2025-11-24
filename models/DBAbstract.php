<?php 

	class DBAbstract {

		private $db;

		public function __construct() {
			$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
			if ($this->db->connect_error) {
				die("Error de conexión a la base de datos: " . $this->db->connect_error);
			}
		}

		// Para consultas SELECT
		public function consultar($sql) {
			$result = $this->db->query($sql);
			if(!$result) {
				die("Error en la consulta: " . $this->db->error);
			}
			return $result->fetch_all(MYSQLI_ASSOC);
		}

		// Para INSERT, UPDATE o DELETE
		public function ejecutar($sql) {
			if(!$this->db->query($sql)) {
				die("Error al ejecutar la consulta: " . $this->db->error);
			}
			return true;
		}
	}

?>
