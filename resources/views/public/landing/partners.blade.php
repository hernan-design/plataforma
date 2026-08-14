@if(isset($partners) && count($partners) > 0)
	<section id="partners-land" class="section-land partners-logos block-vpadding-both">

		@if(isset($parameters['title_aliados']))
			<div class="row">
				<div class="small-12 columns">
					<div class="strip-title-white">
						<h2 class="title-section-land">{{{ $parameters['title_aliados'] }}}</h2>
					</div>
				</div>
			</div>
		@endif
		<div class="row">
			<div class="small-12 columns">
				<ul class="list-partners">
					@if(isset($partners))
						@foreach ($partners as $partner)
							<li>
								@if($partner->url_aliado)
									<a href="{{{ $partner->url_aliado }}}" title="{{{ $partner->nombre_aliado }}}" target="_blank">
										{!! HTML::image(($partner->logo_aliado ? $partner->logo_aliado : Config::get('tuproyecto.logo')), $partner->nombre_aliado) !!}
									</a>
								@else
									{!! HTML::image(($partner->logo_aliado ? $partner->logo_aliado : Config::get('tuproyecto.logo')), $partner->nombre_aliado) !!}
								@endif
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</section>
@endif
