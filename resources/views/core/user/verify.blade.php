@extends('layout.core.layout')

@section('content')
	<div id="verify-account-wrapper" class="wrapper-signin">
		<div class="row">
			<div class="mobile-12 columns">
				<div class="card">
					<div class="verify-account-header">
						<div class="verify-account-header-box">
				    		<h3 class="verify-account-title">Verifica tu cuenta</h3>
				    	</div>
				    </div>

				    <div class="verify-account-content">
				    	@if(isset($custom))
				    		@include("core.user.verify.$institution->slug_institucion")
				    	@else
				    		<div class="verify-account-content-box">
								<p>No hemos encontrado ningún metodo de verificación de cuenta activo.</p>
							</div>
				    	@endif
				    </div>
				</div>
			</div>
		</div>
	</div>
@stop
