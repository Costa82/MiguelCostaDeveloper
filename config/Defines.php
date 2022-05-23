<?php

// Validaciones Usuario
define("USER_NOEXIS", 201); //El usuario no está registrado

// Error ficheros
define("ERROR_SUBIDA_IMAGEN_MOVER_ARCHIVO", 604); //Error al mover el archivo.
define("ERROR_SUBIDA_IMAGEN_CREACION_CARPETA", 605); //Error al crear la carpeta.
define("ERROR_SUBIDA_IMAGEN_FORMATO_INCORRECTO", 606); //Imagen con formato incorrecto.

// Error general
define("ERROR_GENERAL", 1000); //Error General

// Definiciones
$mensaje[USER_NOEXIS] = "El usuario no está registrado.";

$mensaje[ERROR_SUBIDA_IMAGEN_MOVER_ARCHIVO] = "Error al mover el archivo.";
$mensaje[ERROR_SUBIDA_IMAGEN_CREACION_CARPETA] = "Error al crear la carpeta.";
$mensaje[ERROR_SUBIDA_IMAGEN_FORMATO_INCORRECTO] = "Imagen con formato incorrecto.";

$mensaje[ERROR_GENERAL] = "Error General.";
?>
