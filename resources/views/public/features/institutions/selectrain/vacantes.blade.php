@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Creación y administración de vacantes</h1>
		<p class="features-section-header-text">En SelecTrain crear una vacante es tan simple o tan detallado como necesites. Desde nombrar y describir brevemente la vacante, seleccionando formularios predeterminados para que los candidatos completen hasta crear múltiples fases/etapas, agregando tests de psicológicos, de personalidad y habilidades, entre otros. </p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Crea vacantes en 3 pasos: nombra y describe la vacante, 2. Selecciona los formularios para aplicar a la vacante (información básica, académica, etc.). 3. Define el número y tipo de etapas del proceso, el sistema hace el resto.</p>
				</div>
			</div>
		</article>
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">La vacante la podrás compartir por diferentes medios, te facilita la administración de todo el proceso y genera reportes, notificaciones y trazabilidad de todo el proceso.</p>
				</div>
			</div>
		</article>
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>

				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Ademas, toda la información recopilada se puede usar posteriormente tanto para evaluaciones de desempeño como para programas de entrenamiento, todo en una sola herramienta.</p>
				</div>
			</div>
		</article>
		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'perfiles') }}">Páginas de perfiles y búsquedas</a>
				</div>
			</div>
		</div>
	</section>
@stop
