$(document).ready(function () {
    var currentDate = new Date();
    var citasData = $("#citasData").data("citas");
    console.log(citasData);
    function updateCalendar() {
        generateDateHeaders();
        generateTimeSlots();
    }

    function generateDateHeaders() {
        var firstDayOfWeek = new Date(
            currentDate.getFullYear(),
            currentDate.getMonth(),
            currentDate.getDate() - currentDate.getDay()
        );

        for (var i = 1; i <= 7; i++) {
            var dateColumn = $("#date" + i);
            var dateColumna = $("#data" + i);
            dateColumn.text(formatDate(firstDayOfWeek));
            dateColumna.text(formatDate(firstDayOfWeek));
            firstDayOfWeek.setDate(firstDayOfWeek.getDate() + 1);
        }
    }

    /* function generateTimeSlots() {
        for (var hour = 7; hour <= 19; hour++) {
            var collapseId = "collapseHour" + hour;

            for (var minute = 0; minute < 60; minute += 20) {
                var RowUno = $("<tr>");
                var RowDos = $("<tr>");
                var hora44 = formatHourMinute(hour, minute);
                RowUno.append("<td>" + hora44 + "</td>");
                RowDos.append("<td>" + hora44 + "</td>");
                for (var i = 0; i < 7; i++) {
                    var dateColumn = new Date(
                        currentDate.getFullYear(),
                        currentDate.getMonth(),
                        currentDate.getDate() - currentDate.getDay() + i
                    );
                    const fechaFormateada = formatDateToYYYYMMDD(dateColumn);
                    
                    var cellText1 = "";
                    var cellText2 = "";
                    
                    for (let index = 0; index < citasData.length; index++) {
                        
                        
                        
                        var resultado = compararHoras(citasData[index].sheduled_time, formatHourMinute(hour, minute));
                        
                        if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 101) ) {
                            cellText1 = "Dr. "+citasData[index].doctor.name+"<br>Cliente: "
                                        +citasData[index].patient.name
                                        +"<br>";
                            if(citasData[index].status == "Confirmada"){
                                cellText1 += "<span class='text-success'><i class='fas fa-calendar-check'></i> "+citasData[index].status+"</span>";
                            } else if (citasData[index].status === "Reservada") {
                                cellText1 += "<span class='text-info'><i class='far fa-calendar'></i> "+citasData[index].status+"</span>";
                            } else if (citasData[index].status === "Cancelada") {
                                cellText1 += "<span class='text-danger'><i class='fas fa-calendar-times'></i> "+citasData[index].status+"</span>";
                            }
                            cellText2 = "";
                            break;
                        } else if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 102)){
                            cellText2 = "Dr. "+citasData[index].doctor.name+"<br>Cliente: "
                                        +citasData[index].patient.name
                                        +"<br>";
                            if(citasData[index].status == "Confirmada"){
                                cellText2 += "<span class='text-success'><i class='fas fa-calendar-check'></i> "+citasData[index].status+"</span>";
                            } else if (citasData[index].status === "Reservada") {
                                cellText2 += "<span class='text-info'><i class='far fa-calendar'></i> "+citasData[index].status+"</span>";
                            } else if (citasData[index].status === "Cancelada") {
                                cellText2 += "<span class='text-danger'><i class='fas fa-calendar-times'></i> "+citasData[index].status+"</span>";
                            }
                            cellText1 = "";
                            break;
                        }

                                           
                    }
                    
                    RowUno.append("<td>" + cellText1 + "</td>");
                    RowDos.append("<td>" + cellText2 + "</td>");
                }

                $("#tbodyUno").append(RowUno);
                $("#tbodyDos").append(RowDos);
            }
        }
    }  */

    function generateTimeSlots() {
        for (var hour = 7; hour <= 19; hour++) {
          var collapseId = "collapseHour" + hour;
          var Row1 = $("<tr data-toggle='collapse' data-target='#" + collapseId + "'>");
          var Row2 = $("<tr data-toggle='collapse' data-target='#" + collapseId + "'>");
          Row1.append("<td><button type='button' class='btn btn-sm btn-default'>" + formatHourMinute(hour, 0) + "</button></td>");
          Row2.append("<td><button type='button' class='btn btn-sm btn-default'>" + formatHourMinute(hour, 0) + "</button></td>");
      
          for (var minute = 0; minute < 60; minute += 20) {
            var horaIntervalo = formatHourMinute(hour, minute);
            var intervaloCita1 = false;
            var intervaloCita2 = false;
      
            var CollapseRow1 = $("<tr id='" + collapseId + "' class='collapse'>");
            var CollapseRow2 = $("<tr id='" + collapseId + "' class='collapse'>");
            CollapseRow1.append("<td>" + horaIntervalo + "</td>");
            CollapseRow2.append("<td>" + horaIntervalo + "</td>");
      
            for (var i = 0; i < 7; i++) {
              var dateColumn = new Date(
                currentDate.getFullYear(),
                currentDate.getMonth(),
                currentDate.getDate() - currentDate.getDay() + i
              );
              const fechaFormateada = formatDateToYYYYMMDD(dateColumn);
      
              var cellText1 = "";
              var cellText2 = "";
              var intervaloCita1 = false;
              var intervaloCita2 = false;
      
              for (let index = 0; index < citasData.length; index++) {
                var resultado = compararHoras(citasData[index].sheduled_time, horaIntervalo);
      
                if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 101) ) {
                    cellText1 = "Dr. "+citasData[index].doctor.name+"<br>Cliente: "
                                +citasData[index].patient.name
                                +"<br>";
                    if(citasData[index].status == "Confirmada"){
                        cellText1 += "<span class='text-success'><i class='fas fa-calendar-check'></i> "+citasData[index].status+"</span>";
                    } else if (citasData[index].status === "Reservada") {
                        cellText1 += "<span class='text-info'><i class='far fa-calendar'></i> "+citasData[index].status+"</span>";
                    } else if (citasData[index].status === "Cancelada") {
                        cellText1 += "<span class='text-danger'><i class='fas fa-calendar-times'></i> "+citasData[index].status+"</span>";
                    }
                    CollapseRow1.append("<td>" + cellText1 + "</td>");
                    intervaloCita1 = true;
                    cellText2 = "";
                    break;
                } else if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 102)){
                    cellText2 = "Dr. "+citasData[index].doctor.name+"<br>Cliente: "
                                +citasData[index].patient.name
                                +"<br>";
                    if(citasData[index].status == "Confirmada"){
                        cellText2 += "<span class='text-success'><i class='fas fa-calendar-check'></i> "+citasData[index].status+"</span>";
                    } else if (citasData[index].status === "Reservada") {
                        cellText2 += "<span class='text-info'><i class='far fa-calendar'></i> "+citasData[index].status+"</span>";
                    } else if (citasData[index].status === "Cancelada") {
                        cellText2 += "<span class='text-danger'><i class='fas fa-calendar-times'></i> "+citasData[index].status+"</span>";
                    }
                    CollapseRow2.append("<td>" + cellText2 + "</td>");
                    intervaloCita2 = true;
                    cellText1 = "";
                    break;
                }

                
              }
      
              if (!intervaloCita1) {
                CollapseRow1.append("<td></td>");
              }
              if (!intervaloCita2) {
                CollapseRow2.append("<td></td>");
              }
            }
            
            $("#tbodyUno").append(CollapseRow1);
            $("#tbodyDos").append(CollapseRow2);
          }
          $("#tbodyUno").append(Row1);
          $("#tbodyDos").append(Row2);
        }
      }
      
      
      


    function compararHoras(hora1, hora2) {
        var partesHora1 = hora1.split(":");
        var partesHora2 = hora2.split(":");
        var horaMinuto1 = partesHora1[0] + ":" + partesHora1[1];
        var horaMinuto2 = partesHora2[0] + ":" + partesHora2[1];
        return horaMinuto1 === horaMinuto2;
    }
    function formatDateToYYYYMMDD(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0"); // Añadir ceros a la izquierda si es necesario
        const day = String(date.getDate()).padStart(2, "0"); // Añadir ceros a la izquierda si es necesario
        return `${year}-${month}-${day}`;
    }

    function formatDate(date) {
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var year = date.getFullYear();
        return (
            (month < 10 ? "0" : "") +
            month +
            "-" +
            (day < 10 ? "0" : "") +
            day +
            "-" +
            year
        );
    }

    function formatHourMinute(hour, minute) {
        return (
            (hour < 10 ? "0" : "") + hour + ":" + (minute < 10 ? "0" : "") + minute);
    }

    updateCalendar();
});
