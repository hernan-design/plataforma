@extends('layout.core.layout')
@section('content')

<div id="module-nav-bar" class="wrapper-submenu-section inst-bgcolor-secondary show-for-large-up">
	<div class="rows">
		<div class="small-12">
			<div class="tabs-container">
				<ul id="mentor-list-tabs-filter" class="tabs-sub-nav-alt tabs-route text-left" data-tab data-tab-init="is_hover:false">
					<div class="row" id="container-bar">
						<div class="small-1 no-padding columns">
							<li class="left tab-title disabled">
								<a class="text-xlg">Citas<i class="mdi mdi-clipboard-plus"></i></a>
							</li>
						</div>
						<div class="small-4 text-right no-padding right columns">
							<li class="tab-title active">
								<a href="https://saroa.coposoftware.com/citas" title="Principal">Mis Citas</a>
							</li>
							<li class="tab-title">
								<a href="https://saroa.coposoftware.com/citas/agendar" title="Mentores">Agendar Cita</a>
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
			<h3>BIENVENIDO DE NUEVO, {{ strtoupper($userData["name"]) . " " . strtoupper($userData["last_name"]) }} </h3>
<br>
			<h4>CITAS</h4>
		</div>
	</div>

</div>
</div>
<hr>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ref</th>
                        <th>Fecha</th>
                        <th>Especialidad</th>
                        <th>Dirección</th>
						<th>Tipo</th>
						<th>Estado</th>
                    </tr>
                </thead>
                <tbody>
					@if (count($historialCitas) > 0)
						@foreach ($historialCitas as $cita)

						<tr>
							<td>{{$cita['id']}}</td>
							<td>{{$cita['ref']}}</td>
							<td>{{$cita['date']}}</td>
							<td>{{$cita['service']}}</td>
							<td>{{$cita['address']}}</td>
							<td>{{$cita['mode'] == 2 ? "Presencial" : "Virtual" }}</td>
							<td>{{$cita['status']}}</td>
						</tr>

					@endforeach


					@else

					<tr>
						<td colspan="7" style="text-align: center;" >No tiene citas</td>
					</tr>

					@endif

                    {{-- <tr>
                        <td>1</td>
                        <td>2024-03-20</td>
                        <td>10:00 AM</td>
                        <td>Juan Pérez</td>
                        <td>Dr. García</td>
                        <td>Confirmada</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>2024-03-22</td>
                        <td>02:30 PM</td>
                        <td>María López</td>
                        <td>Dra. Martínez</td>
                        <td>Pendiente</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>2024-03-25</td>
                        <td>09:15 AM</td>
                        <td>Carlos Rodríguez</td>
                        <td>Dr. Sánchez</td>
                        <td>Confirmada</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop
