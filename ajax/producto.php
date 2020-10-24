<?php 
require_once "../modelos/Producto.php";

$producto=new Producto();

// pregunta si existe el objeto LO VALIDARA con metodo LimpiarCadena sino existe :"" mandara una cadena vacia
$idproducto=isset($_POST["idproducto"])?limpiarCadena($_POST["idproducto"]):"";
$idcategoria=isset($_POST["idcategoria"])?limpiarCadena($_POST["idcategoria"]):"";
$i_stock=isset($_POST["i_stock"])?limpiarCadena($_POST["i_stock"]):"";
$v_descripcion=isset($_POST["v_descripcion"])?limpiarCadena($_POST["v_descripcion"]):"";
$v_imagen=isset($_POST["v_imagen"])?limpiarCadena($_POST["v_imagen"]):"";


switch ($_GET["op"]) {
	case 'guardaryeditar':
        
        //si no a sido cargadoo ninguno archivo dentros objeto imagen o
		if(!file_exists($_FILES['v_imagen']['tmp_name']) || !is_uploaded_file($_FILES['v_imagen']['tmp_name']))
		{
			$v_imagen=$_POST["imagenactual"];
		}
		else {
			//validara que los archivos sean de tipo imagen
			$ext=explode(".",$_FILES["v_imagen"]["name"]);
			if ($_FILES['v_imagen']['type']=="image/jpg" || $_FILES['v_imagen']['type']=="image/jpeg" || $_FILES['v_imagen']['type']=="image/png")
			{
				$v_imagen=round(microtime(true)).'.'.end($ext); //renombramos la imagen para no tener repeditas
				move_uploaded_file($_FILES["v_imagen"]["tmp_name"],"../files/articulos/".$v_imagen);// cargaremos al proyecto la imagen que estamos subiendo atraves del sistema
			}

		}

		if (empty($idproducto)) {
			$rspta=$producto->insertar($idcategoria,$i_stock,$v_descripcion,$v_imagen);
			echo $rspta?"Producto registrado":"Producto no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$idcategoria,$i_stock,$v_descripcion,$v_imagen);
			echo $rspta?"Producto actualializado":"Producto no se pudo actualizar";
		}

	break;
	
	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
		echo $rspta?"Producto desactivado":"Producto no se pudo desactivar";
	break;

	case 'activar':
		$rspta=$producto->activar($idproducto);
		echo $rspta?"Producto activado":"Producto no se pudo activar";
	break;


	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	
	break;

	case 'listar':
	    $rspta=$producto->listar();
		//declaramos un array
		$data=Array();

		while ($reg=$rspta->fetch_object()) 
		{
			$data[]=array(
			"0"=>($reg->b_estado)? 
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
			      ' <button Class="btn btn-danger" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>'
			      :
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
			      ' <button Class="btn btn-primary" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>',
			
			"1"=> $reg->categoria,
			"2"=> $reg->v_descripcion,
			"3"=> $reg->i_stock,
			"4"=> "<img src='../files/articulos/".$reg->v_imagen."' height='50px' width='50px'>",
			"5"=> ($reg->b_estado)? 
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

	case 'selectCategoria':
		require_once "../modelos/Categoria.php";
		$categoria=new Categoria();

		$rspta=$categoria->select();

		while ($reg= $rspta->fetch_object()) 
		{
		   echo '<option value='.$reg->idcategoria.'>'.$reg->v_nombre.'</option>';	
		}

	break;
}
 ?>