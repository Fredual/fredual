$(document).ready(function() {
   $('.datepicker').datepicker();

   $('.datepicker').on('changeDate', function() {
     $(this).datepicker('hide');
   });


   //Agregar evento click al botón #botonEnviar
   $("#botonEnviar").click(function() {
     var valorSeleccionado = $('#miSelect').val();
     var fechaInicio = $('#fechaInicio').val();
     var fechaFin = $('#fechaFin').val();

     if (valorSeleccionado === "") {
       // Cambia el borde del contenedor a rojo
       $("#miSelect").css("border", "1px solid red");
     } else if (fechaInicio === "" || fechaFin === "") {
       $("#miSelect").css("border", "1px solid green");
       $("#cuadroFechas").css("border", "1px solid red");
     } else {
       // Restaura el borde del contenedor al estilo original
       $("#cuadroFechas").css("border", "1px solid green");
       $("#miSelect").css("border", "1px solid green");

       // Realiza las validaciones de fechas aquí
       var fechaInicioObj = new Date(fechaInicio);
       var fechaFinObj = new Date(fechaFin);
       var diferencia = (fechaFinObj - fechaInicioObj) / (1000 * 60 * 60 * 24);

       if (fechaInicioObj > fechaFinObj) {
         mostrarAlerta("La fecha inicial no puede ser superior a la fecha final.");
         return;
         
       } else if (diferencia > 30) {

         console.log(diferencia);
         mostrarAlerta("El rango de fechas no puede ser superior a 30 días.");
         return;

       } else {

         $('#vistaLaravel').empty();

         $.ajax({
           url: horarioViewUrl,
           type: "POST",
           data: {
                   id: valorSeleccionado,
                   inicio: fechaInicio,
                   fin: fechaFin,
                   _token: csrf_token
                 },
           dataType: "html",
                   success: function(response) {
                   $("#vistaLaravel").html(response);
                 },
                   error: function(xhr, status, error) {
                     console.log("Error en la solicitud AJAX:");
                     console.log("Status:", status);
                     console.log("Error:", error);
                 }
       });
       }
     }
   });
   function mostrarAlerta(mensaje) {
     var alerta = $("#alerta");
     alerta.html(mensaje);
     alerta.show();

     setTimeout(function() {
       alerta.hide();
     }, 1000);
   }
 });