@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Soporte</h1>
		<p class="features-section-header-text">Con un tiempo al aire del 99.9%, una experiencia de usuario intuitiva y fácil de usar el soporte que tu empresa requerirá de SelecTrain va a ser mínimo. Tenemos disponibles varios canales para resolver cualquier duda o inconveniente que se pueda llegar a presentar.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Contamos con un Knowledge-Base, donde se encuentran artículos con explicaciones, GIFs y videos que orientan sobre el uso de todos los módulos de la plataforma online.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Si viendo estos tutoriales aun quedan dudas, los usuarios puede escribir usando el botón de ayuda que siempre esta presente en la plataforma. Para enviar mensajes por este medio se pueden incluir texto e imágenes, lo que facilita explicar cualquier duda o inconveniente.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los diferentes planes tienen diferentes niveles de soporte, según el volumen de procesos o la urgencia de acompañamiento, puedes escoger el plan que mejor se acomode a tus necesidades o expectativas de servicio.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'preentrevistas') }}">Pre-entrevistas por video</a>
				</div>
			</div>
		</div>
	</section>
@stop
