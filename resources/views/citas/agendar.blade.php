@extends('layout.core.layout')
@section('content')

    <div id="module-nav-bar" class="wrapper-submenu-section  inst-bgcolor-secondary show-for-large-up">
        <div class="rows">

            <div class="small-12">
                <div class="tabs-container">
                    <ul id="mentor-list-tabs-filter" class="tabs-sub-nav-alt tabs-route text-left" data-tab
                        data-tab-init="is_hover:false">
                        <div class="row" id="container-bar">
                            <div class="small-1 no-padding columns">
                                <li class="left tab-title disabled">
                                    <a class="text-xlg">Citas<i class="mdi mdi-clipboard-plus"></i></a>
                                </li>
                            </div>
                            <div class="small-4 text-right no-padding right columns">
                                <li class="tab-title">
                                    <a href="https://saroa.coposoftware.com/citas" title="Principal">Mis Citas</a>
                                </li>

                                <li class="tab-title active">
                                    <a href="https://saroa.coposoftware.com/citas/agendar" title="Mentores">Agendar
                                        Citar</a>
                                </li>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>


    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="content-data-list" style="text-align: center;">
                    <h3>BIENVENIDO DE NUEVO, {{ strtoupper($name) . " " . strtoupper($last_name) }} </h3>
                    <br>
                    <h4>SOLICITA UNA CITA</h4>
                </div>
            </div>

        </div>
    </div>
    <hr>
    <form action="" id="form-citas" name="form-citas">
        <div class="row">
            <div class="col-xs-12 col-md-12 form-class" id="eqs-treatment-type">
                <label for="eqs-date">Elige un tratamiento</label>
                <select class="form-input tratamiento" id="tratamiento" name="tratamiento" tabindex="-1"
                    aria-hidden="true">
                    <option value="0">Seleccione una opción...</option>
                    @foreach ($treatments as $treatment)
                        <option value="{{ $treatment['id'] . ',' . $treatment['name'] . ',' . $treatment['category'] }}">
                            {{ $treatment['name'] }}</option>
                    @endforeach

                </select>
                <small class="text-danger" id="tratamiento-error" style="color: red;"></small>
            </div>

            <div class="col-xs-12 col-md-6 form-class" id="eqs-mode">
                <label for="eqs-mode">Tipo de cita </label><br>
                <select class="form-input tipo-cita" id="tipo-cita" name="tipo-cita" tabindex="-1" aria-hidden="true">
                    <option value="0">Seleccione una opción...</option>
                    <option value="1">Virtual</option>
                    <option value="2">Presencial</option>
                </select>
                <small class="text-danger" id="tipo-cita-error" style="color: red;"></small>
            </div>

            <div class="col-xs-12 col-md-6 form-class" id="eqs-break">
                <label for="eqs-mode">Sucursal de la cita </label><br>
                <select class="form-input sucursal" "="" id="sucursal" name="sucursal" tabindex="-1" aria-hidden="true">
                            <option value="0">Seleccione una opción...</option>
                  @foreach ($sucursales as $sucursal)
                    <option value="{{ $sucursal['id'] }}">{{ $sucursal['name'] }}</option>
                    @endforeach
                </select>
                <small class="text-danger" id="sucursal-error" style="color: red;"></small>
            </div>

            <div class="col-xs-12 col-md-6 form-class">
                <label for="date">Elige un día</label>
                <input type="date" id="date" name="date" min="{{ date('Y-m-d') }}">
                <small class="text-danger" id="date-error" style="color: red;"></small>
            </div>


            <div class="col-xs-12 col-md-6 form-class horaDiv">
                <label for="eqs-hora">Selecciona la hora</label>
                <select class="form-input browser-default hora" id="hora" name="hora" tabindex="-1"
                    aria-hidden="true">
                    {{-- <option value="0">Seleccione una opción...</option> --}}
                    {{-- <option value="08:00">08:00</option>
				<option value="09:00">09:00</option>
				<option value="10:00">10:00</option>
				<option value="11:00">11:00</option>
				<option value="12:00">12:00</option>
				<option value="13:00">13:00</option>
				<option value="14:00">14:00</option>
				<option value="15:00">15:00</option>
				<option value="16:00">16:00</option>
				<option value="17:00">17:00</option>
				<option value="18:00">18:00</option> --}}
                </select>
                <small class="text-danger" id="hora-error" style="color: red;"></small>
            </div>

            <button type="submit" id="crear-cita">AGENDAR</button>
            <br>
            <small class="text-danger" id="agendar-error" style="color: red;"></small>
        </div>
    </form>

    <script>
        // Obtener la hora actual
        var now = new Date();
        var currentHour = now.getHours();

        // Si la hora actual es mayor o igual a las 18:00 horas, sumar un día
        if (currentHour >= 18) {
            var tomorrow = new Date(now);
            tomorrow.setDate(tomorrow.getDate());

            // Formatear la fecha de mañana como YYYY-MM-DD
            var tomorrowFormatted = tomorrow.toISOString().split('T')[0];

            // Establecer el valor mínimo del input date al día siguiente
            document.getElementById('date').setAttribute('min', tomorrowFormatted);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Función para formatear la fecha en el formato MM-DD-YYYY
            function formatDate(date) {
                var dd = String(date.getDate() + 1).padStart(2, '0');
                var mm = String(date.getMonth() + 1).padStart(2, '0'); // Enero es 0!
                var yyyy = date.getFullYear();

                return mm + '-' + dd + '-' + yyyy;
            }

            function validateSelections() {
                var tratamiento = document.getElementById('tratamiento').value;
                var tipoCita = document.getElementById('tipo-cita').value;
                var sucursal = document.getElementById('sucursal').value;
                var date = document.getElementById('date').value;

                // Reiniciar mensajes de error
                document.getElementById('tratamiento-error').textContent = '';
                document.getElementById('tipo-cita-error').textContent = '';
                document.getElementById('sucursal-error').textContent = '';
                document.getElementById('date-error').textContent = '';

                if (tratamiento == '0') {
                    document.getElementById('tratamiento-error').textContent =
                        'Por favor, seleccione un tratamiento.';
                }
                if (tipoCita == '0') {
                    document.getElementById('tipo-cita-error').textContent =
                        'Por favor, seleccione un tipo de cita.';
                }
                if (sucursal == '0') {
                    document.getElementById('sucursal-error').textContent = 'Por favor, seleccione una sucursal.';
                }
                if (date == '') {
                    document.getElementById('date-error').textContent = 'Por favor, seleccione una fecha.';
                }

                if (tratamiento != '0' && tipoCita != '0' && sucursal != '0' && date != '') {
                    // Se han seleccionado todos los campos, consultar el API de availability
                    var data = {
                        ent: 'e442b5e49ceccc9a4fae477dd124f412',
                        duration: 60, // Duración de la cita en minutos
                        date: formatDate(new Date(date)),
                        category: tratamiento // ID del tratamiento seleccionado
                    };

                    // Realizar la solicitud AJAX
                    $.ajax({
                        type: "POST",
                        url: "https://saroa.coposoftware.com/citas/availability",
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        // contentType: "application/json",
                        success: function(response) {
                            // Parsear la respuesta JSON
                            var availability = response;
                            // Obtener las opciones de hora del objeto de disponibilidad
                            var options = availability.options;
                            // Seleccionar el div que envuelve al select de hora
                            var selectWrapper = document.querySelector(
                                '.horaDiv .select-wrapper .dropdown-content');
                            var select = document.querySelector('.horaDiv select');
                            var firstLi = document.querySelector(
                                '.horaDiv .select-wrapper .dropdown-content li');

                            // Limpiar opciones anteriores
                            select.innerHTML = '';

                            // Crear opciones para cada hora disponible
                            options.forEach(function(option) {
                                // var optionElement = document.createElement('li');
                                // var optionSpan = document.createElement('span');
                                // optionElement.className="";
                                // optionSpan.textContent = option;
                                // optionElement.appendChild(optionSpan);
                                // selectWrapper.appendChild(optionElement);

                                var optionElementS = document.createElement('option');
                                optionElementS.value = option;
                                optionElementS.textContent = option;
                                select.appendChild(optionElementS);
                            });
                            // $('select').formSelect();
                            // Seleccionar automáticamente el primer elemento de la lista de horas
                            //  var firstOption = selectWrapper.querySelector('li');
                            // firstOption.classList.add('active selected');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al consultar el API de availability:', error);
                        }
                    });
                }
            }

            function saveCita() {
                var tratamiento = document.getElementById('tratamiento').value;
                var tratamiento = document.getElementById('tratamiento').value;
                var tipoCita = document.getElementById('tipo-cita').value;
                var sucursal = document.getElementById('sucursal').value;
                var date = document.getElementById('date').value;
                var hora = document.getElementById('hora').value;

                // Reiniciar mensajes de error
                document.getElementById('tratamiento-error').textContent = '';
                document.getElementById('tipo-cita-error').textContent = '';
                document.getElementById('sucursal-error').textContent = '';
                document.getElementById('date-error').textContent = '';
                document.getElementById('hora-error').textContent = '';

                if (tratamiento == '0') {
                    document.getElementById('tratamiento-error').textContent =
                        'Por favor, seleccione un tratamiento.';
                }
                if (tipoCita == '0') {
                    document.getElementById('tipo-cita-error').textContent =
                        'Por favor, seleccione un tipo de cita.';
                }
                if (sucursal == '0') {
                    document.getElementById('sucursal-error').textContent = 'Por favor, seleccione una sucursal.';
                }
                if (date == '') {
                    document.getElementById('date-error').textContent = 'Por favor, seleccione una fecha.';
                }

                if (hora == '') {
                    document.getElementById('hora-error').textContent = 'Por favor, seleccione una hora.';
                }

                if (tratamiento != '0' && tipoCita != '0' && sucursal != '0' && date != '' && hora != '') {
                    // Se han seleccionado todos los campos, consultar el API de availability
                    var data = {
                        date: formatDate(new Date(date)),
                        tratamiento: tratamiento,
                        tipoCita: tipoCita,
                        sucursal: sucursal,
                        date: formatDate(new Date(date)),
                        hora: hora
                    };

                    // Realizar la solicitud AJAX
                    $.ajax({
                        type: "POST",
                        url: "https://saroa.coposoftware.com/citas/save",
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        // contentType: "application/json",
                        success: function(response) {
                            if (response.status == "DISABLED") {
                                //Mostrar debajo del boton de agendar un mensaje
                                document.getElementById('agendar-error').textContent = response.message;
                                // Habilitar nuevamente el botón de agenda
                                document.getElementById('crear-cita').disabled = false;
                            }

                            if (response.status == "OK") {

                                //cambiar el estilo a color verde

                                document.getElementById('agendar-error').style.color = "green";
                                // Mostrar el modal de éxito
                                document.getElementById('agendar-error').textContent =
                                    "La cita ha sido agendada exitosamente";
                                // Habilitar nuevamente el botón de agenda
                                document.getElementById('crear-cita').disabled = false;
                                // Esperar dos segundos antes de redirigir
                                setTimeout(function() {
                                    // Redirigir a la página de citas
                                    window.location.href =
                                        "https://saroa.coposoftware.com/citas";
                                }, 1000);
                                //Redirreccionar a index
                                // window.location.href = "http://localhost/plataforma/public/citas";
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error al consultar el API de availability:', error);
                            // Habilitar nuevamente el botón de agenda
                            document.getElementById('crear-cita').disabled = false;
                        }
                    });
                } else {
                    // Habilitar nuevamente el botón de agenda
                    document.getElementById('crear-cita').disabled = false;
                }

            }

            document.getElementById('date').addEventListener('change', function() {
                validateSelections();
            });

            document.getElementById('crear-cita').addEventListener('click', function(event) {
                event.preventDefault(); // Evitar que el formulario se envíe normalmente
                // Deshabilitar el botón de agenda
                document.getElementById('crear-cita').disabled = true;
                saveCita(); // Validar campos y enviar solicitud AJAX
            });
        });
    </script>

@stop
