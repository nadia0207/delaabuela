<?php 
require_once "../modelos/Categoria.php";

$categoria=new Categoria();

// pregunta si existe el objeto LO VALIDARA con metodo LimpiarCadena sino existe :"" mandara una cadena vacia
$idcategoria=isset($_POST["idcategoria"])?limpiarCadena($_POST["idcategoria"]):"";
$v_nombre=isset($_POST["v_nombre"])?limpiarCadena($_POST["v_nombre"]):"";
$descripcion=isset($_POST["descripcion"])?limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idcategoria)) {
			$rspta=$categoria->insertar($v_nombre,$descripcion);
			echo $rspta?"Categoria registrada":"Categoria no se pudo registrar";
		}
		else {
			$rspta=$categoria->editar($idcategoria,$v_nombre,$descripcion);
			echo $rspta?"Categoria actualializada":"Categoria no se pudo actualizar";
		}

	break;
	
	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
		echo $rspta?"Categoria desactivada":"Categoria no se pudo desactivar";
	break;

	case 'activar':
		$rspta=$categoria->activar($idcategoria);
		echo $rspta?"Categoria activada":"Categoria no se pudo activar";
	break;


	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	
	break;

	case 'listar':
	    $rspta=$categoria->listar();
		//declaramos un array
		$data=Array();

		while ($reg=$rspta->fetch_object()) 
		{
			$data[]=array(
			"0"=>($reg->b_estado)? 
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
			      ' <button Class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>'
			      :
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
			      ' <button Class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',
			"1"=> $reg->v_nombre,
			"2"=> $reg->v_descripcion,
			"3"=> ($reg->b_estado)? 
				'<span class="label bg-green">Activado</span>'
			    :
			    '<span class="label bg-red">Desactivado</span>'	
			);
		} 

		$results =array(
			"sEcho"=>1, // informacion para el datatable
			"iTotalRecords"=>count($data), //enviamos el total de registros al datatble
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visulizar
			"aaData"=>$data);
		echo json_encode($results);
	break;
}
 ?>