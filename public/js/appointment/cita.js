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

    function generateTimeSlots() {
        for (var hour = 7; hour <= 19; hour++) {
            var collapseId = "collapseHour" + hour;
            var collapseHeader = $("<div class='card-header' data-toggle='collapse' href='#" + collapseId + "'>Hora: " + hour + ":00</div>");
            var collapseBody = $("<div id='" + collapseId + "' class='collapse'></div>");

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
                collapseBody.append(RowUno);
                var collapseWrapper = $("<div class='card'></div>");
                collapseWrapper.append(collapseHeader);
                collapseWrapper.append(collapseBody);

                $("#tbodyUno").append(collapseWrapper);
                $("#tbodyDos").append(RowDos);
            }
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
