@extends('reports.layout-certificate', ['title' => $title, 'type' => 'PDF'])
@section('content')

<img class="img-fondo" src="http://static.tuproyecto.com/images/institutions/propace/certificados/borde-certificado.png">

<div class="container">

	{!! transtp('learn.certificate.title') !!}
	{!! transtp('learn.certificate.to') !!}
    <div class="name-user">
			{{ $userName }}
    </div>
    {!! transtp('learn.certificate.subject', ["course" => $course]) !!}

	<small>{{ $date }}</small>
    <br><br>

		<div class="row">
			{{-- <div class="img-box">
				<img class="img-left" src="http://propace.org/wp-content/uploads/2021/04/propace-logo-2021.png" alt="logo-certificado">
			</div> --}}


			<div class="firm">
				<div class="center ">
					{{-- <img src="{{ App\RegistroSesion::institution()->logo_reporte_institucion ? App\RegistroSesion::institution()->logo_reporte_institucion : App\RegistroSesion::institution()->logo_institucion }}"> --}}
					<img src="http://static.tuproyecto.com/images/institutions/propace/certificados/firma-certificado.png">

					<hr  style="border: 1px solid black; width: 25%; margin-top: 1px">
				</div>
				{{-- {{ transtp('learn.certificate.nameFirm') }} <br> --}}
				{{-- {{ transtp('learn.certificate.occupationFirm') }} --}}
				<p class="line-height-1">MÓNICA SUÁREZ CUARTAS</p>
				<p class="line-height-1">Directora Ejecutiva</p>
			</div>

			<div>
				<img class="img-left" src="http://propace.org/wp-content/uploads/2021/04/propace-logo-2021.png" alt="logo-certificado">
				<img class="img-right" src="http://static.tuproyecto.com/images/institutions/propace/certificados/logo-programa.png" alt="logo-programa">
			</div>
		</div>

</div>
@stop
