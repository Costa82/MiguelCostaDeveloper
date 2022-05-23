<?php
require_once 'Defines.php';

/**
 * Definimos los mensajes de error para darles un texto comprensible por el usuario
 *
 * @global type $mensaje
 * @param
 *            $num
 * @return $mensaje[]
 */
function validacion($num)
{
	global $mensaje; // importante la variable global para que reconozca $mensaje de 'DSefines.inc.php'

	switch ($num) {
		case 201:
			return $mensaje[USER_NOEXIS];
			break;
		case 604:
			return $mensaje[ERROR_SUBIDA_IMAGEN_MOVER_ARCHIVO];
			break;
		case 605:
			return $mensaje[ERROR_SUBIDA_IMAGEN_CREACION_CARPETA];
			break;
		case 606:
			return $mensaje[ERROR_SUBIDA_IMAGEN_FORMATO_INCORRECTO];
			break;
		default:
			return $mensaje[ERROR_GENERAL];
			break;
	}
}

/**
 * La esContrasena debe tener al entre 4 y 8 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.
 * No puede tener otros s�mbolos.
 *
 * @param
 *            $pass
 * @return true si cumple con los requisitos
 */
function esContrasena($pass)
{
	/* ("/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{4,8}$/",$pass) */
	if (preg_match("/^\S{4,16}$/", $pass)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Función que valida que el teléfono no sea raro
 *
 * @param
 *            $value
 * @return boolean
 */
function validarTelefono($value)
{
	$expresion = '/^((\+?34([ \t|\-])?)?[9|6|7]((\d{1}([ \t|\-])?[0-9]{3})|(\d{2}([ \t|\-])?[0-9]{2}))([ \t|\-])?[0-9]{2}([ \t|\-])?[0-9]{2})$/';

	if (preg_match($expresion, $value)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Función que compara la dos contraseñas que introduce el usuario por el formulario cuando tiene la opción de
 * modificar la contrasena
 *
 * @param
 *            $passNueva
 * @param
 *            $passRep
 * @return boolean true si ambas coinciden. False si la contrase�a repetida no es igual que la contraseña nueva
 */
function validarContrasena($passNueva, $passRep)
{
	if ($passNueva == $passRep) {
		return true;
	} else {
		return false;
	}
}

/**
 * Se valida el nick que tiene que tener de 4 a 8 caracteres, letras ó números
 *
 * @param
 *            $nick
 */
function esNick($nick)
{
	if (preg_match("/^[A-Z \-áéíóúÁÉÍÓÚñÑ0-9.]{4,8}$/i", $nick)) {
		return true;
	} else {
		return false;
	}
}

/**
 * Un nombre ó apellido es válido si tiene un mímimo de 3 caracteres y un máximo de 20
 * Además, que no empiece por números,puede contener espacios en blanco y que no contenga caracteres especiales
 *
 * @param
 *            $nombre
 * @return boolean true si se cumplen las reglas. False en caso contrario
 */
function esNombreValido($nombre)
{
	/**
	 * Que no empiece por números,puede contener espacios en blanco y que no contenga caracteres especiales,
	 * un mímimo de 3 caracteres y un máximo de 20
	 */
	if (preg_match("/^[A-Z \-áéíóúÁÉÍÓÚñÑ\\s]{3,20}/i", $nombre)) {
		return true;
	} else {

		return false;
	}
}

/**
 * tieneCaracteresEspeciales( $palabra )
 * Una palabra no puede contener caracteres especiales
 *
 * @param
 *            $palabra
 * @return boolean true si se cumplen las reglas. False en caso contrario
 */
function tieneCaracteresEspeciales($palabra)
{
	if (preg_match("/[]{}*=+\-\\/#%_$&|]/", $palabra)) {
		return true;
	} else {
		return false;
	}
	return false;
}

/**
 * Con un filtro validamos la direccion de correo electronico
 *
 * @param
 *            $mail
 * @return boolean true si es valido. False en caso contrario
 */
function esMailValido($mail)
{
	if (filter_var($mail, FILTER_VALIDATE_EMAIL))
	return true;
	return false;
}