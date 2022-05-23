<?php

/**
 * Clase Utils para normalizar cadenas
 */
class Utils
{

	/**
	 * Función que se utilizará para normalizar una cadena.
	 *
	 * @param $cadena
	 * @return String
	 */
	public static function normaliza($cadenaOriginal)
	{
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
		ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ?¿-!¡';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
		bsaaaaaaaceeeeiiiidnoooooouuuyybyRr     ';
		$cadena = utf8_decode($cadenaOriginal);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		$cadena = strtolower($cadena);

		return utf8_encode($cadena);
	}

	/**
	 * Eliminamos acentos y tildes de una cadena
	 * 
	 * @param $cadena
	 * @return String
	 */
	function eliminar_acentos($cadena){

		$cadena = utf8_encode($cadena);
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena	);
		
		//Reemplazamos los espacios por '_'
		$cadena = str_replace(
		array(' '),
		array('_'),
		$cadena	);

		return utf8_decode($cadena);
	}
	
		/**
	 * Guardamos la imagen en la carpeta de destino
	 * @param unknown_type $carpetaDestino
	 * @param unknown_type $archivo
	 */
	public static function guardarImagen($carpetaDestino, $archivo) {

		$guardado = false;
		
		# si es un formato de imagen
		if($archivo["type"]=="image/jpeg" || $archivo["type"]=="image/pjpeg" || 
		$archivo["type"]=="image/png")
		{
			# si exsite la carpeta o se ha creado
			if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
			{
				$origen=$archivo["tmp_name"];
				$destino=$carpetaDestino.$archivo["name"];

				# movemos el archivo
				if(@move_uploaded_file($origen, $destino))
				{
					$guardado = true;
				}else{
					
					// Error al mover el archivo
					$_SESSION['error'] = 604;
					$guardado = false;
				}
			}else{
				
				// Error al crear la carpeta
				$_SESSION['error'] = 605;
				$guardado = false;
			}
		}else{
			
			// Error en el formato del fichero
			$_SESSION['error'] = 606;
			$guardado = false;
		}
		
		return $guardado;
	}

}