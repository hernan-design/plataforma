@extends('layout.landing.layout')
@section('content')
	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.header')

		{{-- main land  --}}
		<div id="main-land" class="main-section">
			<section class="show-for-medium-up">
				<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/banner-new.png" class="full-width" alt="">
				<div class="row">
					<div class="small-6 small-offset-3">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/pgbq7AfQkDk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/services.png" class="center-block img1" alt="">
					</div>
					<div class="small-4 columns">
						<a href="comunidad"><button class="full-width button-1">Asesórate</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/nfnmdbcmGsI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-4 columns">
						<a href="marketplace"><button class="full-width button-2">Intercambia</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/R22N_wnXmj4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-4 columns">
						<a href="convocatoria/cotiza-1"><button class="full-width button-3">Cotiza</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/rkNcgAAQC7k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div  class="small-10 small-offset-1">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/be+part+of.png" class="img2" alt="">
					</div>
				</div>
				<div class="row col-equal-height">
					<div class="small-3 small-offset-1 columns">
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/list.png">
						</div>
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/text.png"><br><br>
							<a href="register" ><button class="full-width button-2">Aquí</button></a>
						</div>
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/mailship.png">
						</div>

					</div>
					<div class="small-7 small-offset-1 right columns">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/section4-destop.png" alt="">
					</div>
				</div>

			</section>
			<section class="show-for-tablet-only">
				<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/banner-new.png" alt="">
				<div class="row">
					<div class="small-8 small-offset-2">
						<iframe width="560" height="300" src="https://www.youtube.com/embed/pgbq7AfQkDk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/services.png" class="center-block img1" alt="">
					</div>
					<div class="small-12 columns">
						<a href="comunidad"><button class="full-width button-1">Asesórate</button></a>
						<iframe width="560" height="380" src="https://www.youtube.com/embed/nfnmdbcmGsI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-12 columns">
						<a href="marketplace"><button class="full-width button-2">Intercambia</button></a>
						<iframe width="560" height="380" src="https://www.youtube.com/embed/R22N_wnXmj4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-12 columns">
						<a href="convocatoria/cotiza-1"><button class="full-width button-3">Cotiza</button></a>
						<iframe width="560" height="380" src="https://www.youtube.com/embed/rkNcgAAQC7k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div  class="small-10 small-offset-1">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/be+part+of.png" class="img2" alt="">
					</div>
				</div>
				<div class="row col-equal-height">
					<div class="small-3 small-offset-1 columns">
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/list.png">
						</div>
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/text.png"><br><br>
							<a href="register" ><button class="full-width button-2">Aquí</button></a>
						</div>
						<div class="small-12">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/mailship.png">
						</div>

					</div>
					<div class="small-7 small-offset-1 right columns">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/section4-destop.png" alt="">
					</div>
				</div>
			</section>
			<section class="show-for-mobile-only">
				<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/section1+mobile.png" alt="">
				<div class="row">
					<div class="mobile-10 mobile-offset-1">
						<iframe width="400" height="200" src="https://www.youtube.com/embed/pgbq7AfQkDk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-12 columns">
						<a href="comunidad"><button class="full-width button-1">Asesórate</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/nfnmdbcmGsI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-12 columns">
						<a href="marketplace"><button class="full-width button-2">Intercambia</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/R22N_wnXmj4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
					<div class="small-12 columns">
						<a href="convocatoria/cotiza-1"><button class="full-width button-3">Cotiza</button></a>
						<iframe width="560" height="200" src="https://www.youtube.com/embed/rkNcgAAQC7k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="full-width" allowfullscreen></iframe>
					</div>
				</div>
				<div class="row col-equal-height">
					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/img1.png" alt="">
					<div class="mobile-2 columns">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/img2.png" alt="">
					</div>
					<div class="mobile-10 columns">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/img3.png" alt="">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/img4.png" alt="">
						<a href="register" ><button class="button-2">Aquí</button></a>
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/compensar/colabora/img5.png" alt="">
					</div>
				</div>
			</section>

		</div>


	</div>
@stop