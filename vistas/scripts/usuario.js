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

		 $("#imagenmuestra").hide();

		 //Mostramos los permisos
		 $.post("../ajax/usuario.php?op=permisos&id=",function(r){
			$("#permisos").html(r);

		 });

}


//funcion limpiar
function limpiar(){
 $("#nombre").val("");	
 $("#num_documento").val("");
 $("#direccion").val("");
 $("#telefono").val("");
 $("#email").val("");
 $("#cargo").val("");
 $("#login").val("");
 $("#clave").val("");
 $("#imagenmuestra").attr("src","");
 $("#imagenactual").val("");
  $("#idusuario").val("");

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
	   $("#btnagregar").hide(); // oculta el boton agregar
	}
	else
	{
		// es verdad que se muestra el formulario
	   $("#listadoregistros").show(); // mostrara el listado	
	   $("#formularioregistros").hide(); // no mostrara el formulario
	   $("#btnagregar").show(); //mostrar el boton agregar

	   
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
					url: '../ajax/usuario.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
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
		url:"../ajax/usuario.php?op=guardaryeditar",
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

function mostrar(idusuario)
{
	//$.post("../ajax/usuario.php?op=mostrar",{idusuario:idusuario},function(data,status)
	$.post("../ajax/usuario.php?op=mostrar",{idusuario:idusuario},function(data,status)

	{
		data=JSON.parse(data); //objeto data que covirerte a onjeto javascrip
		mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        $("#clave").val(data.clave);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idusuario").val(data.idusuario); //
             
        
	});

	$.post("../ajax/usuario.php?op=permisos&id="+idusuario,function(r){
		$("#permisos").html(r);

	 });
}

function desactivar(idusuario)
{
	bootbox.confirm("¿Está seguro de descativar el usuario?",function(result){
		if(result)
		{
			//$.post("../ajax/usuario.php?op=desactivar",{idusuario:idusuario},function(e){
			$.post("../ajax/usuario.php?op=desactivar",{idusuario:idusuario},function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})

}

function activar(idusuario)
{
	bootbox.confirm("¿Está seguro de activar el usuario?",function(result){
		if(result)
		{
			//$.post("../ajax/usuario.php?op=activar",{idusuario:idusuario},function(e){
			$.post("../ajax/usuario.php?op=activar",{idusuario:idusuario},function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})

}

init();