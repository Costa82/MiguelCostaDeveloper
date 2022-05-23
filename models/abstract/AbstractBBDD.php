<?php
require_once './core/Connection.php';

abstract class AbstractBBDD {

	abstract protected function __construct();

	/**
	 * Consultamos por id
	 * 
	 * @param String $id Identificativo de la tabla
	 */
	abstract protected function getById($id);

	/************ METODOS COMUNES ************/

	/**
	 * Ejecutamos la query de consulta
	 * 
	 * @param String $consulta Consulta a realizar.
	 */
	public function ejecutarQuery($consulta) {
		
		$conexion = $this->c;
			
		$resultado = $conexion->query($consulta);

		if ($resultado->num_rows != 0) {
			while ($row = $resultado->fetch_assoc()) {
				$rows[] = $row;
			}
			$datos = array(
	                'numero' => $resultado->num_rows,
	                'filas_consulta' => $rows
			);
			return $datos;
		} else {
			return $datos = array(
	                'numero' => 0
			);
		}
	}

	/**
	 * Sacamos todos los valores de la tabla
	 */
	public function getAll()
	{
		$consulta = "SELECT * FROM " . $this->tabla . "";
		return AbstractBBDD::ejecutarQuery($consulta);
	}

	/**
	 * Buscamos todos los resultados por columna y valor
	 * 
	 * @param String $column Columna a filtrar.
	 * @param String $value Valor de la columna a filtrar.
	 */
	public function getBy($column, $value)
	{
		$sql = "SELECT * FROM " . $this->tabla . " WHERE " . $column . " = '" . $value . "'";

		$conexion = $this->c;
		
		if ($conexion->real_query($sql)) {
			if ($resul = $conexion->store_result()) {
				if ($resul->num_rows > 0) {
					return $resul->fetch_assoc();
				}
			}
		}
	}
	
    /**
     * Buscamos un campo específico de la tabla por columna y valor
     * 
     * @param String $campo Campo buscado en la consulta
     * @param String $column Columna a filtrar
     * @param String $value Valor de la columna a filtrar
     */
    public function getCampoBy($campo, $column, $value)
    {
        $sql = "SELECT " . $campo . " FROM " . $this->tabla . " WHERE " . $column . " = '" . $value . "' and estado = 'ACTV'";
        
        $conexion = $this->c;
        
        if ($conexion->real_query($sql)) {
            if ($resul = $conexion->store_result()) {
                $mostrar = $resul->fetch_assoc();
                
                return $mostrar[$campo];
            }
        } else {
            echo $conexion->errno . " -> " . $conexion->error;
        }
    }

}
