<?php 
// incluimos la conexion a la base de datos

require "../config/conexion.php";

Class Permiso
{
	// implementar el constructos
	public function __construct()
	{

	}

   
      public function listar()
    {
    	$sql="SELECT * FROM permiso";
    	return ejecutarConsulta($sql);
    }


}

 ?>