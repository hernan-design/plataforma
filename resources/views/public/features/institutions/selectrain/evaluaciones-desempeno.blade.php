@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Evaluaciones de desempeño</h1>
		<p class="features-section-header-text">Ademas de hacer diagnósticos de personal, SelecTrain permite hacer evaluaciones 360 grados, donde el trabajador evaluado puede completar cierta información y se pueden enviar links de evaluación a los miembros de su equipo, su jefe directo y personas a cargo si es el caso.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Crear la evaluación que debe completar el trabajador es muy sencillo y una vez esta lista se envia el link vía correo electrónico para que el trabajador complete los requerimientos. </p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Posteriormente los otros evaluadores como miembros del equipo, jefe director y personas a cargo según aplique, reciben un link para evaluar al trabajador.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">El sistema computa las diferentes evaluaciones, genera reportes e incluso puede enviar resultados y retroalimentación al trabajador.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'soporte') }}">Soporte</a>
				</div>
			</div>
		</div>
	</section>
@stop
