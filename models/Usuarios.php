<?php
require_once 'abstract/AbstractBBDD.php';
require_once './config/Utils.php';

class Usuarios extends AbstractBBDD {

	// Propiedades de la tabla de la BBDD
	public $nick;
	public $nombre;
	public $apellidos;
	public $telefono;
	public $email;
	public $password;
	public $fecha_registro;
	public $fecha_ultima_actualizacion;
	public $tipo_usuario;
	public $estado;

	protected $c;
	protected $tabla;

	public function __construct()
	{
		$bd = Connection::dameInstancia();
		$this->c = $bd->dameConexion();
		$this->tabla = "usuarios";
	}

	// Getters y Setters
	public function getNick() {
		return $this->nick;
	}

	public function setNick($nick) {
		$this->nick = $nick;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function setNombre($nombre) {
		$this->nombre = $nombre;
	}

	public function getApellidos() {
		return $this->apellidos;
	}

	public function setApellidos($apellidos) {
		$this->apellidos = $apellidos;
	}

	public function getTelefono() {
		return $this->telefono;
	}

	public function setTelefono($telefono) {
		$this->telefono = $telefono;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getFecha_registro() {
		return $this->fecha_registro;
	}

	public function setFecha_registro($fecha_registro) {
		$this->fecha_registro = $fecha_registro;
	}

	public function getFecha_ultima_actualizacion() {
		return $this->fecha_ultima_actualizacion;
	}

	public function setFecha_ultima_actualizacion($fecha_ultima_actualizacion) {
		$this->fecha_ultima_actualizacion = $fecha_ultima_actualizacion;
	}

	public function getTipo_usuario() {
		return $this->tipo_usuario;
	}

	public function setTipo_usuario($tipo_usuario) {
		$this->tipo_usuario = $tipo_usuario;
	}

	public function getEstado() {
		return $this->estado;
	}

	public function setEstado($estado) {
		$this->estado = $estado;
	}

	public function getById($id) {
			
		$sql = "SELECT * FROM " . $this->tabla . " WHERE nick = " . $id . "";

		if ($this->c->real_query($sql)) {
			if ($resul = $this->c->store_result()) {
				if ($resul->num_rows > 0) {
					return $resul->fetch_assoc();
				}
			}
		}
	}
	
	/**
	 * Recupera todos los usuarios de la tabla por nombre
	 */
	public function mostrarUsuariosPorNombreEnTabla()
	{
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE estado = 'ACTV' AND tipo_usuario = 'USU' ORDER BY nombre ASC";
		$resultados = Usuarios::ejecutarQuery($consulta);
		
		// Pintamos los resultados
		Usuarios::mostrarResultadosUsuarios($resultados);
	}
		
	/**
	 * Recupera todos los usuarios de la tabla por fecha actualización
	 */
	public function mostrarUsuariosPorFechaEnTabla()
	{
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE estado = 'ACTV' AND tipo_usuario = 'USU' ORDER BY fecha_ultima_actualizacion DESC";
		$resultados = Usuarios::ejecutarQuery($consulta);

		// Pintamos los resultados
		Usuarios::mostrarResultadosUsuarios($resultados);
	}

	/**
	 * Insertamos un usuario en BBDD
	 */
	public function saveUsuario() {

		$save = false;
		$fecha_actual = date('d-m-Y');

		$registrado = Usuarios::esRegistradoMail($this->email);

		// Si ya está registrado actualizamos su fecha_ultima_actualizacion
		if ($registrado) {

			$query = "UPDATE " . $this->tabla . "
						SET fecha_ultima_actualizacion = '" . $fecha_actual . "', ultima_accion = '" . $this->ultima_accion . "'
						WHERE email = '" . $this->email . "';";

		} else {

			$query = "INSERT INTO " . $this->tabla . " (nick, nombre, apellidos, telefono,
						email, password, fecha_registro, fecha_ultima_actualizacion, tipo_usuario, estado)
	                	VALUES('" . $this->nick . "',
	                       '" . $this->nombre . "',
	                       '" . $this->apellidos . "',
	                       '" . $this->telefono . "',
	                       '" . $this->email . "',
	                       '" . $this->password . "',
	                       '" . $fecha_actual . "',
	                       '" . $fecha_actual . "',
	                       '" . $this->tipo_usuario . "',
	                       '" . $this->estado . "');";
		}

		$save = $this->c->query($query);

		return $save;
	}

	/**
	 * Método que se utiliza para comprobar si un usuario está registrado y poder loguearse.
	 *
	 * @param String $nick
	 * @param String $pass
	 * @return boolean
	 */
	public function esRegistrado($nick, $pass)
	{
		$resultado = false;

		$passMD5 = md5($pass);
		$consulta = "SELECT * FROM " . $this->tabla . " WHERE UPPER(nick) = UPPER('$nick') AND password = '$passMD5' AND tipo_usuario = 'ADM' AND estado = 'ACTV'";

		$resultados = Usuarios::ejecutarQuery($consulta);

		if ($resultados == 0 || $resultados['numero'] == 0) {
			// No hay datos para mostrar
		} else {
			$resultado = true;
		}

		return $resultado;
	}

	/**
	 * Método que se utiliza para comprobar si un usuario está registrado y poder loguearse.
	 *
	 * @param String $nick
	 * @return boolean
	 */
	public function esRegistradoNick($nick)
	{
		$resultado = false;

		$consulta = "SELECT * FROM " . $this->tabla . " WHERE UPPER(nick) = UPPER('$nick') AND tipo_usuario = 'ADM' AND estado = 'ACTV'";
		$resultados = Usuarios::ejecutarQuery($consulta);

		if ($resultados == 0 || $resultados['numero'] == 0) {
			// No hay datos para mostrar
		} else {
			$resultado = true;
		}

		return $resultado;
	}

	/**
	 * Método que se utiliza para comprobar si un usuario está registrado por su mail.
	 *
	 * @param String $mail
	 * @return boolean
	 */
	public function esRegistradoMail($mail)
	{
		$resultado = false;

		$consulta = "SELECT * FROM " . $this->tabla . " WHERE email = '" . $mail . "' AND estado = 'ACTV'";
		$resultados = Usuarios::ejecutarQuery($consulta);

		if ($resultados == 0 || $resultados['numero'] == 0) {
			// No hay datos para mostrar
		} else {
			$resultado = true;
		}

		return $resultado;
	}
}