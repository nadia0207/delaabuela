<?php 

session_start();

require_once "../modelos/Usuario.php";

$usuario=new Usuario();

// pregunta si existe el objeto LO VALIDARA con metodo LimpiarCadena sino existe :"" mandara una cadena vacia
$idusuario=isset($_POST["idusuario"])?limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])?limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])?limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])?limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])?limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])?limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])?limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])?limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])?limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])?limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])?limpiarCadena($_POST["imagen"]):"";

// $nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen,$condicion

switch ($_GET["op"]) {
	case 'guardaryeditar':
        
        //si no a sido cargadoo ninguno archivo dentros objeto imagen o
		if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else {
			//validara que los archivos sean de tipo imagen
			$ext=explode(".",$_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png")
			{
				$imagen=round(microtime(true)).'.'.end($ext); //renombramos la imagen para no tener repeditas
				move_uploaded_file($_FILES["imagen"]["tmp_name"],"../files/usuarios/".$imagen);// cargaremos al proyecto la imagen que estamos subiendo atraves del sistema
			}

		}

		//Hash SHA256 en la constraseña

		$clavehash=hash("SHA256",$clave);

		if (empty($idusuario)) {
			$rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,
			$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $rspta?"Usuario registrado":"No se pudieron registrar todos los datos del usuario";
		}
		else {
			$rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,
			$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $rspta?"Usuario actualializado":"Usuario no se pudo actualizar";
		}

	break;
	
	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
		echo $rspta?"Usuario desactivado":"Usuario no se pudo desactivar";
	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
		echo $rspta?"Usuario activado":"Usuario no se pudo activar";
	break;


	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
		//Codificar el resultado utilizando json
		echo json_encode($rspta);
	
	break;

	case 'listar':
	    $rspta=$usuario->listar();
		//declaramos un array
		$data=Array();

		while ($reg=$rspta->fetch_object()) 
		{
			$data[]=array(
			"0"=>($reg->condicion)? 
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
			      ' <button Class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>'
			      :
			      '<button Class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
                  ' <button Class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
                  // $direccion,,$cargo,$clave
			"1"=> $reg->nombre,
			"2"=> $reg->tipo_documento,
            "3"=> $reg->num_documento,
            "4"=> $reg->telefono,
            "5"=> $reg->email,
            "6"=> $reg->login,
			"7"=> "<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
			"8"=> ($reg->condicion)? 
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

	case 'permisos':
		//Obtenemos todos los permisos de la tabla permisos
		require_once "../modelos/Permiso.php";
		$permiso=new Permiso();
		$rspta=$permiso->listar();

		//Obtener los permisos asignados al usuarios para poder modificar
		$id=$_GET['id'];
		$marcados=$usuario->listarmarcados($id);
		

		//declaramos un Array para almacenar todo los permisos marcados
		$valores=array();

		//Almacenar los permiso asignado al usuario en el Array
		while ($per=$marcados->fetch_object()) 
		{
			// en el array valores guardare lo que se recorre
			array_push($valores,$per->idpermiso);
		}


		
		//Mostramos la lista de permisos en la vista y si estan o no marcados
		while ($reg = $rspta->fetch_object())
	    	{
				// si el usuario tiene asignado el permiso mostrare el checked sino no mostrara nada
				$sw=in_array($reg->idpermiso,$valores)?'checked':'';
				// <li> lista
               echo'<li> <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.'</li>';
			}
	break;

	case 'verificar':
		$logina=$_POST['logina'];
		$clavea=$_POST['clavea'];

		//Hash SHA256 en la contreña
		$clavehash=hash("SHA256",$clavea);

		$rspta=$usuario->verificar($logina,$clavehash);
		$fetch=$rspta->fetch_object();

		//si el objeto $fetch no esta vacio
		if(isset($fetch))
		{
			//Declaramos las variables de sesion
			$_SESSION['idusuario']=$fetch->idusuario;
			$_SESSION['nombre']=$fetch->nombre;
			$_SESSION['imagen']=$fetch->imagen;
			$_SESSION['login']=$fetch->login;

			//OBTENEMOS LOS PERMISOS
			$marcados=$usuario->listarmarcados($fetch->idusuario);

			//decalaramos array para almacenas todo los permisos marcados
			$valores=array();

			while($per=$marcados->fetch_object())
			{
				array_push($valores,$per->idpermiso);
			}

			//determinamos los accesos de los usuarios
			in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
			in_array(2,$valores)?$_SESSION['almacen']=1:$_SESSION['almacen']=0;
			in_array(3,$valores)?$_SESSION['compras']=1:$_SESSION['compras']=0;
			in_array(4,$valores)?$_SESSION['ventas']=1:$_SESSION['ventas']=0;
			in_array(5,$valores)?$_SESSION['acceso']=1:$_SESSION['acceso']=0;
			in_array(6,$valores)?$_SESSION['consultasc']=1:$_SESSION['consultasc']=0;
			in_array(7,$valores)?$_SESSION['consultasv']=1:$_SESSION['consultasv']=0;

		}
		echo json_encode($fetch);
	break;
	
	case'salir':
		//limpiamos la svariables de session
		session_unset();

		//destruimos la sesion
		session_destroy();

		//redirecciona al login
		header("Location: ../index.php");

	break;

}
 ?>