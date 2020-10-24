<?php 
// incluimos la conexion a la base de datos

require "../config/conexion.php";

Class Categoria
{
	// implementar el constructos
	public function __construct()
	{

	}

	//implementar un metodo para insertar registros
	public function insertar($nombre,$descripcion)
	{
		$sql="INSERT INTO categoria(v_nombre,v_descripcion,b_estado) 
		VALUES ('$nombre','$descripcion','1')";
		return ejecutarConsulta($sql);
	}	

	public function editar($idcategoria,$nombre,$descripcion)
	{
		$sql="UPDATE categoria SET v_nombre='$nombre',v_descripcion='$descripcion' 
		WHERE idcategoria='$idcategoria' ";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idcategoria)
	{
  		$sql="UPDATE categoria SET b_estado='0' WHERE idcategoria='$idcategoria'";
  		return ejecutarConsulta($sql);

	}

	public function activar($idcategoria)
	{
  		$sql="UPDATE categoria SET b_estado='1' WHERE idcategoria='$idcategoria'";
  		return ejecutarConsulta($sql);

	}
    
    //implementar un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idcategoria)
    {
    	$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
    	return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
    	$sql="SELECT * FROM categoria";
    	return ejecutarConsulta($sql);
    }

    public function select()
    {
    	$sql="SELECT * FROM categoria WHERE b_estado=1";
    	return ejecutarConsulta($sql);
    }



}

 ?>