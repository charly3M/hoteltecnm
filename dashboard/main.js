$(document).ready(function(){
    tablaPersonas = $("#tablaPersonas").DataTable({
       "columnDefs":[{
        "targets": -1,
        "data":null,
        "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btnEditar'>Editar</button><button class='btn btn-danger btnBorrar'>Borrar</button></div></div>"  
       }],
        
    "language": {
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sSearch": "Buscar:",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast":"Último",
                "sNext":"Siguiente",
                "sPrevious": "Anterior"
             },
             "sProcessing":"Procesando...",
        }
    });
    
$("#btnNuevo").click(function(){
    $("#formPersonas").trigger("reset");
    $(".modal-header").css("background-color", "#1cc88a");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Datos de reserva");            
    $("#modalCRUD").modal("show");        
    id=null;
    opcion = 1; //alta
});    
    
var fila; //capturar la fila para editar o borrar el registro
    
//botón EDITAR    
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
    id = parseInt(fila.find('td:eq(0)').text());
    nombre = fila.find('td:eq(1)').text();
    
    fechaentrada = parseInt(fila.find('td:eq(2)').text());
    fechasalida = parseInt(fila.find('td:eq(3)').text());
    telefono = fila.find('td:eq(4)').text();

    domicilio = "";
    ocupacion="";
    cantidad = fila.find('td:eq(5)').text();
    //edad = parseInt(fila.find('td:eq(3)').text());
    
    $("#nombre").val(nombre);
    $("#domicilio").val(domicilio);
    $("#telefono").val(telefono);
    $("#fechaentrada").val(fechaentrada);
    $("#fechasalida").val(fechasalida);
    $("#ocupacion").val(ocupacion);
    $("#cantidad").val(cantidad);
    


    opcion = 2; //editar
    
    $(".modal-header").css("background-color", "#4e73df");
    $(".modal-header").css("color", "white");
    $(".modal-title").text("Editar Persona");            
    $("#modalCRUD").modal("show");  
    
});

//botón BORRAR
$(document).on("click", ".btnBorrar", function(){    
    fila = $(this);
    id = parseInt($(this).closest("tr").find('td:eq(0)').text());
    opcion = 3 //borrar
    var respuesta = confirm("¿Está seguro de eliminar el registro: "+id+"?");
    if(respuesta){
        $.ajax({
            url: "bd/crud.php",
            type: "POST",
            dataType: "json",
            data: {opcion:opcion, id:id},
            success: function(){
                tablaPersonas.row(fila.parents('tr')).remove().draw();
               
    
            }
        });
    }   
});
    
$("#formPersonas").submit(function(e){
    e.preventDefault();   
    
    nombre = $.trim($("#nombre").val());
    console.log(nombre); 

    domicilio = $.trim($("#domicilio").val());
    console.log(domicilio); 

    telefono = $.trim($("#telefono").val());   
    console.log(telefono);  

    fechaentrada = $.trim($("#fechaentrada").val());  
    console.log(fechaentrada); 

    fechasalida = $.trim($("#fechasalida").val());  
    console.log(fechasalida); 

    ocupacion = $.trim($("#ocupacion").val());  
    console.log(ocupacion); 

    cantidad = $.trim($("#cantidad").val());  
    console.log(cantidad); 

    console.log(opcion); 

//
  //  idusuario = "2";  
    //console.log(idusuario); 

    //idhabitacion = "1";  
    //console.log(idhabitacion); 

    
    $.ajax({
        url: "bd/crud.php",
        type: "POST",
        dataType: "json", 
        data: {id:id, nombre:nombre, domicilio:domicilio, telefono:telefono, fechaentrada:fechaentrada, fechasalida:fechasalida, ocupacion:ocupacion, cantidad:cantidad, opcion:opcion},
        
        success: function(data){  
            console.log(data);
            id = data[0].idreserva;            
            nombre = data[0].nombre;
            telefono = data[0].telefono;
            cantidad= data[0].cantidad;
            ocupacion = data[0].ocupacion;
            fechaentrada= data[0].fechaentrada;
            fechasalida= data[0].fechasalida;

            if(opcion == 1){tablaPersonas.row.add([id,nombre,fechaentrada,fechasalida, telefono, cantidad]).draw();}
            else{tablaPersonas.row(fila).data([id,nombre,fechaentrada,fechasalida,telefono,cantidad]).draw();}            
        }        
    });
    $("#modalCRUD").modal("hide");    
    
});    
    
});