let $doctor,$date,$specialty,iRadio;
let $hoursMorning, $hoursAfternoon, $titleMorning, $titleAfternoon;

const titleMorning = `
    En la mañana
`;

const titleAfternoon = `
    En la tarde
`;

const noHours = `<h5 class="text-danger">
    No hay horas disponibles.
</h5>`;

$(function(){
    $specialty = $('#specialty');
    $doctor = $('#doctor');
    $date = $('#date');
    $titleMorning = $('#titleMorning');
    $hoursMorning = $('#hoursMorning');
    $titleAfternoon = $('#titleAfternoon');
    $hoursAfternoon = $('#hoursAfternoon');

    $specialty.change(() => {
        const specialtyId =  $specialty.val();
        const url = `/especialidades/${specialtyId}/medicos`;
        $.getJSON(url, onDoctorsLoaded);
    });

    $doctor.change(loadHours);
    $date.change(loadHours);
});

function onDoctorsLoaded(doctors){
    let htmlOptions = '';
    doctors.forEach(doctor => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    $doctor.html(htmlOptions);
}

function loadHours(){
    const selectDate = $date.val();
    const doctorId = $doctor.val();

    const url = `/intervalos/horas?date=${selectDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours);

}

function displayHours(data){

    console.log(JSON.stringify(data));

    let htmlHoursM = '';
    let htmlHoursA = '';

    // Verificar si 'data' está definido y tiene la estructura esperada
    if (data && data.data && data.data.morning && data.data.afternoon) {
        const morningData = data.data.morning;
        const afternoonData = data.data.afternoon;
     
        iRadio = 0;

        if (morningData) {
            morningData.forEach(intervalo => {
                htmlHoursM += getRadioIntervaloHTML(intervalo); 
            });
        }

        if (afternoonData) {
            afternoonData.forEach(intervalo => {
                htmlHoursA += getRadioIntervaloHTML(intervalo); 
            });
        }


    } else {
        // Manejar el caso en el que 'data' no tiene la estructura esperada
        console.error("Los datos no tienen la estructura esperada.");
        console.log(htmlHoursM === "");
        console.log(htmlHoursA === "");
        
        if (!htmlHoursM != ""){
            htmlHoursM += noHours;
        }

        if (!htmlHoursA != "") {
            htmlHoursA += noHours;
        }
    }

    $titleMorning.html(titleMorning);
    $titleAfternoon.html(titleAfternoon);
    $hoursMorning.html(htmlHoursM);
    $hoursAfternoon.html(htmlHoursA);
    
}


function getRadioIntervaloHTML(intervalo) {
    // Separar las horas y los minutos
    const [startHour, startMinute] = intervalo.start.split(':');
    const [endHour, endMinute] = intervalo.end.split(':');

    // Agregar un 0 al principio si son menores que 10
    const formattedStartHour = startHour.padStart(2, '0');
    const formattedStartMinute = startMinute.padStart(2, '0');
    const formattedEndHour = endHour.padStart(2, '0');
    const formattedEndMinute = endMinute.padStart(2, '0');

    // Crear el texto con las horas y minutos formateados
    const text = `${formattedStartHour}:${formattedStartMinute} - ${formattedEndHour}:${formattedEndMinute}`;

    return `<div class="custom-control custom-radio custom-control-inline custom-control-sm mb-2">
        <input type="checkbox" id="interval${iRadio}" name="sheduled_time[]" value="${intervalo.start}" class="custom-control-input">
        <label class="custom-control-label" for="interval${iRadio++}">
            ${text}
        </label>
    </div>`;
}
