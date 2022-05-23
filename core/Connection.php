<?php
class Connection {

	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $base="nombre_bd";

	private $conex;
	private static $instancia;

	public static function dameInstancia() {
		if ( !self::$instancia ) {
			self::$instancia = new self();
		}
		return self::$instancia;
	}

	private function __construct() {
		@$this->conex = new mysqli($this->host, $this->username, $this->password,$this->base);
		@$this->conex->set_charset('utf8');
		if ( mysqli_connect_error() ) {
			trigger_error("Fallo en la conexión, error: " . mysqli_connect_error(), E_USER_ERROR);
		}
	}

	private function __clone() { }

	public function dameConexion() {
		return $this->conex;
	}

	public function cierraConexion() {
		$this->conex->close();
	}

}

?>
