<?php
require_once './config/Validaciones.php';

/**
 * Controlador de gestión de usuarios
 */
class ControladorUsuarios
{

	/**
	 * Método que lleva a la página del administrador
	 */
	public function pagina_usuario()
	{
		if(isset($_SESSION['error']) && $_SESSION['error'] != 0) {
			$params['error'] = $_SESSION['error'];
			$_SESSION['error'] = 0;
		} else {
			$params['error'] = 0;
		}
		require './views/pagina_usuario.php';
	}

	/**
	 * Método que comprueba si está registrado el usuario y si lo está muestra el error
	 */
	public function logueo()
	{
		if (isset($_REQUEST['loguear'])) {

			if (!empty($_REQUEST['nick']) and !empty($_REQUEST['contrasena'])) {

				$nick = trim($_REQUEST['nick']);
				$pass = trim($_REQUEST['contrasena']);
				$usuario = new Usuarios();

				if ($usuario->esRegistradoNick($nick)) {

					if ($usuario->esRegistrado($nick, $pass)) { // para loguearse, se comprueba que sea ususario registrado

						$_SESSION['usuario'] = $nick;
						$_SESSION['administrador'] = true;

						// Anulamos el error
						$_SESSION['error'] = 0;

						$destino = "pagina_usuario";

					} else {

						$_SESSION['error'] = 202;
						$destino = "inicio";
					}
				} else {

					$_SESSION['error'] = 201;
					$destino = "inicio";
				}
			}
		}

		if (! headers_sent()) {
			header('Location:' . $destino);
			exit();
		}
	}

}