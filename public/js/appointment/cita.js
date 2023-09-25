$(document).ready(function () {
    var currentDate = new Date();
    var citasData = $("#citasData").data("citas");

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
                    //console.log(fechaFormateada);
                    //console.log(fechaFormateada+" "+formatHourMinute(hour, minute));
                    
                    var cellText1 = "";
                    var cellText2 = "";
                    
                    for (let index = 0; index < citasData.length; index++) {
                        //citasData[index].scheduled_date
                        var resultado = compararHoras(citasData[index].sheduled_time, formatHourMinute(hour, minute));
                        //console.log(citasData[index].scheduled_date);
                        if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 101) ) {
                            cellText1 = citasData[index].status+"<br>Ocupado<br>"+citasData[index].modulo;
                            cellText2 = "";
                            break;
                        } else if (resultado && (citasData[index].scheduled_date == fechaFormateada && citasData[index].modulo == 102)){
                            cellText2 = citasData[index].status+"<br>Ocupado<br>"+citasData[index].modulo;
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
    }

    function sonMismoDia(fecha1, fecha2) {
        return (
            fecha1.getFullYear() === fecha2.getFullYear() &&
            fecha1.getMonth() === fecha2.getMonth() &&
            fecha1.getDate() === fecha2.getDate()
        );
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
