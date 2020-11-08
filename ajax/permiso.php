<?php 
require_once "../modelos/Permiso.php";

$permiso=new Permiso();

switch ($_GET["op"]) {

		case 'listar':
	    $rspta=$permiso->listar();
		//declaramos un array
		$data=Array();

		while ($reg=$rspta->fetch_object()) 
		{
			$data[]=array(
			   	"0"=> $reg->nombre,
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