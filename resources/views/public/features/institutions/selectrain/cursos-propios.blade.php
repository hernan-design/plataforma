@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Cursos online propios</h1>
		<p class="features-section-header-text">Crea o sube cursos de tu organización fácilmente. Utilizando la plataforma de administradores puedes incluir videos, archivos adjuntos, quizes y crear foros. Esta es una herramienta valiosa para darle una introducción sobre la empresa, sus productos/servicios, entre otros a candidatos o nuevos empleados, con la posibilidad de seleccionar a quien se da acceso. También se puede dar acceso a estos cursos en una etapa del proceso de selección.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los usuarios administradores pueden crear los cursos completando un formulario sencillo. Es tan facil como dar un titulo, clasificar el curso, definir y nombrar los temas que se van a tratar y cargar diferentes tipos de recursos como videos, presentaciones o quizes. </p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Se puede incluir cualquier número de temas para cada curso y no se necesita tener habilidades o conocimientos técnicos para subir la información ya que el modulo es intuitivo y muy fácil de usar.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'evaluaciones-desempeno') }}">Evaluaciones de desempeño </a>
				</div>
			</div>
		</div>
	</section>
@stop
