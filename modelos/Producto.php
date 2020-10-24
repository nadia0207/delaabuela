<?php 
// incluimos la conexion a la base de datos

require "../config/conexion.php";

Class Producto
{
	// implementar el constructos
	public function __construct()
	{

	}

	//implementar un metodo para insertar registros
	public function insertar($idcategoria,$stock,$descripcion,$imagen)
	{
		$sql="INSERT INTO producto(idcategoria,i_stock,v_descripcion,v_imagen,b_estado) 
		VALUES ('$idcategoria','$stock','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}	

	public function editar($idproducto,$idcategoria,$stock,$descripcion,$imagen)
	{
		$sql="UPDATE producto SET idcategoria='$idcategoria',i_stock='$stock',v_descripcion='$descripcion',
		             v_imagen='$imagen' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idproducto)
	{
  		$sql="UPDATE producto SET b_estado='0' WHERE idproducto='$idproducto'";
  		return ejecutarConsulta($sql);

	}

	public function activar($idproducto)
	{
  		$sql="UPDATE producto SET b_estado='1' WHERE idproducto='$idproducto'";
  		return ejecutarConsulta($sql);

	}
    
    //implementar un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idproducto)
    {
    	$sql="SELECT * FROM producto WHERE idproducto='$idproducto'";
    	return ejecutarConsultaSimpleFila($sql);
    }

    public function listar()
    {
    	$sql=" SELECT p.idproducto,p.idcategoria,c.v_nombre as categoria, p.v_descripcion,p.i_stock, p.v_imagen,p.b_estado FROM producto p LEFT JOIN categoria c ON p.idcategoria=c.idcategoria";
    	return ejecutarConsulta($sql);
    }

}

 ?>