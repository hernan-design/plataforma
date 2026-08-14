@extends('layout.core.layout')

@section('content')

	<section id="evaluation-project-wrapper">

		<section id="evaluation-project-content" class="evaluation-project-content clearfix">
			{{-- Content dinamic content  --}}
			@yield('evaluator.content')
		</section>

	</section>

	{{-- Templates edit forms --}}
	@include('core.evaluator.form.templates')

	{{-- include survey templates --}}
	@include('public.surveytemplates')

	{{-- Confirm window by evaluation return stage --}}
	<script type="text/template" id="return-evaluation-confirm-tpl">
		<p>¿Esta seguro de que quiere devolver este proyecto? Tenga en cuenta que si devuelve este proyecto quedara bloqueado por 3 meses a partir de su aceptación, el usuario sera notificado de esta acción una ves confirmada.</p>
	</script>
@stop
