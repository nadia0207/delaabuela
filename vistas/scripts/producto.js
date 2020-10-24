var tabla;

//funcion que se ejecuta al inicio
function init(){
	//llamaremos a la funcion listar para que liste todo los del datatable
	mostrarform(false);
	listar();
    
    // jquery preguntara si del formukario se activa el evento sumbit llamara a la funcion guardar y editar
	$("#formulario").on("submit",function(e)
	   {
		guardaryeditar(e);

		})

		//cargamos los items al select categoria
	$.post("../ajax/producto.php?op=selectCategoria",function(r){
			$("#idcategoria").html(r);
			$('#idcategoria').selectpicker('refresh');

		});
	 $("#imagenmuestra").hide();

}

//funcion limpiar
function limpiar(){
 $("#v_descripcion").val("");
 $("#i_stock").val("");

}

//funcion mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag){
		// es verdad que se muestra el formulario
	   $("#listadoregistros").hide(); // estara oculto	
	   $("#formularioregistros").show(); // mostrara el formulario
	   $("#btnGuardar").prop("disabled",false);//el boton estara activo
	}
	else
	{
		// es verdad que se muestra el formulario
	   $("#listadoregistros").show(); // mostrara el listado	
	   $("#formularioregistros").hide(); // no mostrara el formulario
	   
	}
}

//funcion cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//funcion que llama al AJAX 
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/producto.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//funcion para guaradar y editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activara la accion predeterminada del evento
	$("#btnGuardar").prop("disabled",true); //al dar click en el boton guardar va deshabilitar
	var formData=new FormData($("#formulario")[0]); //se obtiene los datos de todo el formulario y se envia a formData

	$.ajax({
		url:"../ajax/producto.php?op=guardaryeditar",
		type:"POST",
		data: formData, //los datos que voy a enviar lo obtendre de formData
		contentType: false, 
		processData: false, 

		//la siguiente funcion es si se ejecuta de manera correcta se enviara un alert
		success: function(datos)
		{
			bootbox.alert(datos);
			mostrarform(false);
			tabla.ajax.reload();
		}
	});
	limpiar();
}

function mostrar(idproducto)
{
	$.post("../ajax/producto.php?op=mostrar",{idproducto:idproducto},function(data,status)
	{
		data=JSON.parse(data); //objeto data que covirerte a onjeto javascrip
		mostrarform(true);

		$("#idcategoria").val(data.idcategoria);
		$("#idcategoria").selectpicker('refresh');
		$("#v_descripcion").val(data.v_descripcion);
		$("#i_stock").val(data.i_stock);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/articulos/"+ data.v_imagen);
		$("#imagenactual").val(data.v_imagen);
		$("#idproducto").val(data.idproducto);
	})
}

function desactivar(idproducto)
{
	bootbox.confirm("¿Está seguro de descativar el producto?",function(result){
		if(result)
		{
			$.post("../ajax/producto.php?op=desactivar",{idproducto:idproducto},function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})

}

function activar(idproducto)
{
	bootbox.confirm("¿Está seguro de activar el producto?",function(result){
		if(result)
		{
			$.post("../ajax/producto.php?op=activar",{idproducto:idproducto},function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})

}
init();