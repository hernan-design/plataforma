@extends('layout.core.layout')

@section('content')
<section id="pricing-wrapper">
	<section id="pricing-main">
		<div class="row">
			<div class="small-12 columns">
				<h4 class="pricing-title">{!! transtp('pricing.title') !!}</h4>

				<!-- pricing large devices -->
				<div class="pricing-large-devices">
					<div class="panel-content radius">
						<div class="row collapse">
							<div class="small-12 columns">
								<div class="text-center white-text block-vpadding-bottom">
									<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/colabora/bloqueo-100.png" />
								</div>
								<h3 class="text-center price-number">{!! transtp('reserve.subtitle', ['url' => "https://propace.us6.list-manage.com/subscribe?u=b7fd1bccc91ec1b815cd8bafa&id=ed39b89766" ]) !!}</h3>
							</div>
						</div>
					</div>
				</div>

				<!-- pricing medium-small devices -->
				<div class="pricing-ms-devices">
					<div class="row">
						<div class="small-12 columns">
							<div class="text-center white-text block-vpadding-bottom">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/colabora/bloqueo-100.png" />
							</div>
							<h3 class="text-center price-number">{!! transtp('reserve.subtitle', ['url' => "https://propace.us6.list-manage.com/subscribe?u=b7fd1bccc91ec1b815cd8bafa&id=ed39b89766" ]) !!}</h3>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</section>
@stop
