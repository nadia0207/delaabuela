var tabla;

//funcion que se ejecuta al inicio
function init(){
	//llamaremos a la funcion listar para que liste todo los del datatable
	mostrarform(false);
	listar();
   }

//funcion mostrar formulario
function mostrarform(flag)
{
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
	   $("#btnagregar").hide(); // oculta el boton agregar
	   
	}
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
					url: '../ajax/permiso.php?op=listar',
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


init();