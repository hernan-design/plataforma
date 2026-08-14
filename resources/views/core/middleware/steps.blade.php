@extends('layout.core.layout')

@section('content')
<div id="registration-user-wrapper" class="wrapper-signin">
	<div class="row">
		<div class="mobile-12 columns">
			<div class="card">
			    <div class="card-content registration-user-header white-bg">
			      <h3 class="registration-process-title">Crea tu perfil en {{ App\RegistroSesion::institution()->pasos_complementarios_registro ? 'cuatro' : 'dos' }} pasos</h3>
			    </div>
			    <div class="card-tabs registration-process-menu">
			      <ul class="tabs tabs-fixed-width" data-tab>
			        <li class="tab tab-title {{ in_array($step, ['confirmation']) ? 'active' : 'disabled' }}">
			        	<a href="{{ route('step.confirmar') }}" class="registration-menu-item {{ in_array($step, ['confirmation']) ? 'active' : '' }}">
			        		<span class="registration-circle-number icon-circle"><i class="registration-steps-number {{ in_array($step, ['confirmation']) ? 'registration-active' : 'registration-check' }} number-1"></i></span>CONFIRMA TU CORREO
			        	</a>
			        </li>
			        <li class="tab tab-title {{ in_array($step, ['profile']) ? 'active' : 'disabled' }}">
			        	<a href="{{ route('step.perfil') }}" class="registration-menu-item {{ in_array($step, ['profile']) ? 'active' : '' }}">
			        		<span class="registration-circle-number icon-circle"><i class="registration-steps-number {{ in_array($step, ['profile']) ? 'registration-active' : ( in_array($step, ['confirmation']) ? '' : 'registration-check') }} number-2"></i></span>EDITA TU PERFIL
			        	</a>
			        </li>
			        @if( App\RegistroSesion::institution()->pasos_complementarios_registro )
				        <li class="tab tab-title {{ in_array($step, ['entity']) ? 'active' : 'disabled' }}">
				        	<a href="{{ route('step.entidad') }}" class="registration-menu-item {{ in_array($step, ['entity']) ? 'active' : '' }}">
				        		<span class="registration-circle-number icon-circle"><i class="registration-steps-number {{ in_array($step, ['entity']) ? 'registration-active' : ( in_array($step, ['confirmation', 'profile']) ? '' : 'registration-check') }} number-3"></i></span>{{ strtoupper(transtp('steps.entity.title')) }}
				        	</a>
				        </li>
				        <li class="tab tab-title {{ in_array($step, ['channels']) ? 'active' : 'disabled' }}">
				        	<a href="{{ route('step.canales') }}" class="registration-menu-item {{ in_array($step, ['channels']) ? 'active' : '' }}">
				        		<span class="registration-circle-number icon-circle"><i class="registration-steps-number {{ in_array($step, ['channels']) ? 'registration-active' : '' }} number-4"></i></span>ELIGE TUS CANALES
				        	</a>
				        </li>
			        @endif
			      </ul>
			    </div>
			    <div class="card-content registration-user-content tabs-content lighten-4">
			    	@yield('step')
			    </div>
			  </div>
		</div>
	</div>
</div>
@stop
