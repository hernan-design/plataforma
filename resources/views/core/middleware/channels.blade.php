@extends('core.middleware.steps', ['step' => 'channels'])

@section('step')

	<section id="social-community-channels" class="content active">
		<div class="row col-equal-height">
			<div class="small-12 tablet-4 columns">
				<div class="registration-process-border">
					<div class="reg-process-info-box">
						<small class="reg-process-info-steps">PASO 4 DE 4</small>
						<h5 class="reg-process-info-title">Elige los círculos de tu interés</h5>
						<p class="reg-process-info-text">{{ transtp('steps.channels.description') }}</p>
					</div>
				</div>
			</div>
			<div id="social-community-channels-form" class="small-12 tablet-8 columns">
				{!! Form::open(['route' => null, 'data-abide' => '', 'id' => 'form-user-channels']) !!}
					<div class="reg-content-box">
						<div class="medium-12 columns">
							@if(isset($categories))
								@foreach($categories as $category)
									@php $catchannels = $channels->where('codigo_categoria_canal', $category->codigo_categoria_canal); @endphp
									@if(isset($catchannels) && count($catchannels) > 0)
										<h6 class="channels-list-heading">{{ $category->nombre_categoria_canal }}</h6>
										<ul class="mobile-block-grid-1 tablet-block-grid-1 medium-block-grid-2 channels-list-group">
										@foreach($catchannels as $channel)
											<li>
												<div class="channel-item-box">
													<input type="checkbox" name="channel_{{ $channel->codigo_canal }}" id="channel_{{ $channel->codigo_canal }}" {{ in_array($channel->codigo_canal, $suggestions) ? 'checked': '' }}>
													<label for="channel_{{ $channel->codigo_canal }}">{{ $channel->nombre_canal }}</label>
												</div>
											</li>
										@endforeach
										</ul>
									@endif
								@endforeach
							@endif

							{{-- Others --}}
							@php $catchannels = $channels->where('codigo_categoria_canal', null); @endphp
							@if(isset($catchannels) && count($catchannels) > 0)
								<h6 class="channels-list-heading">Otros</h6>
								<ul class="mobile-block-grid-1 tablet-block-grid-1 medium-block-grid-2 channels-list-group">
								@foreach($catchannels as $channel)
									<li>
										<div class="channel-item-box">
											<input type="checkbox" name="channel_{{ $channel->codigo_canal }}" id="channel_{{ $channel->codigo_canal }}" {{ in_array($channel->codigo_canal, $suggestions) ? 'checked': '' }}>
											<label for="channel_{{ $channel->codigo_canal }}">{{ $channel->nombre_canal }}</label>
										</div>
									</li>
								@endforeach
							@endif
						</div>

						<div class="row">
							<div class="small-12 columns">
								<input type="submit" class="registration-next-email-button right button small radius btn-resetc" value="FINALIZAR">
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop