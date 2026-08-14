



@extends('layout.landing.layout')

@section('content')
	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">

		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.institutions.innpulsa.header')

		{{-- main land  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			<div id="header-new-design2" class="rows">
				<div id="gradient-header-new-design2">

				</div>
			</div>

			<h2 id="text-how-do" class="text-center">¿Cómo lo hacemos?</h2>

			{{-- tabs --}}

			<div class="row" id="container-tabs">

				<ul class="tabs" data-tab role="tablist">
					<li class="tab-title active small-3 columns" role="presentation">
						<div class="container-items">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-aldea%402x.png" alt="">
						</div>
						<p class="text-center">
							Acompañamiento a la medida para superar las barreras que frenan tu crecimiento.
						</p>
						<a class="text-center center-block" href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4"">Conoce más</a>
					</li>
					<li class="tab-title small-3 columns" role="presentation">
						<div class="container-items2">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-acelera%402x.png" alt="">
						</div>
						<p class="text-center">
							Habilidades gerenciales, blandas y liderazgo para acelerar tu crecimiento.
						</p>
						<a class="text-center center-block" href="#panel2-2" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">Conoce más</a>
					</li>
					<li class="tab-title small-3 columns" role="presentation">
						<div class="container-items2">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-empodera%402x.png" alt="">
						</div>
						<p class="text-center">
							Herramientas clave para potenciar tu modelo de negocio y desarrollar un plan de crecimiento ganador.
						</p>
						<a class="text-center center-block" href="#panel2-3" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">Conoce más</a>
					</li>
					<li class="tab-title small-3 columns" role="presentation">
						<div class="container-items2">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-atipicos%402x.png" alt="">
						</div>
						<p class="text-center">
							Conexiones de valor para crecer de manera extraordinaria.
						</p>
						<a class="text-center center-block" href="#panel2-4" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">Conoce más</a>
					</li>
				</ul>



			</div>

			{{-- content tabs --}}

			<div class="tabs-content" style="margin-top: 30px;">
				<section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
					<div class="rows">
						<div class="small-7 columns" style="height: 727px;background: url(https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/Mesa+de+trabajo+2.png);background-repeat: no-repeat;background-size: 100%;">
						</div>
						<div class="small-5 columns" style="background: #DD2E37;padding: 22px 50px;">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-aldea-blanco%402x.png" alt="">
							<h2 class="white-text" style="    font-family: 'Montserrat Medium';font-size: 28px;font-weight: bold;line-height: 34px;letter-spacing: 0px;margin-top: 75px;">
								ALDEA busca el crecimiento de emprendedores para que se conviertan en los grandes empresarios de Colombia por medio de  tres etapas en las que pueden superar los obstáculos que les impiden crecer.
							</h2>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Quienes pueden participar
								</h2>
								<p style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 80px;">
									✔ Emprendimientos con un modelo de negocio innovador y con alto potencial de crecimiento. <br><br>  ✔ Equipo emprendedor con mínimo dos personas (preferiblemente heterogéneo).  <br><br>✔ Emprendimientos con potencial de escala. Es decir, que proyectan vender en mercados nacionales e internacionales.  <br><br> ✔ Emprendimientos que tengan menos de 7 años de operación comercial. <br><br> ✔ Emprendimientos con ventas iguales o superiores a COP 100 millones durante el año de la postulación o acumulados en el último año de cierre financiero.
								</p>
							</div>
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Beneficios del programa
								</h2>
								<p   style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 60px 0px 100px;">
									<strong>Recibir Feedback:</strong> De expertos en el marco del segundo reto del programa. <br><br> <strong>Identificar Obstáculos:</strong> Que impiden el crecimiento.
									<br><br> <strong>Recibir llaves de acceso:</strong> (voucher) por COP 20, 40 o 60 millones para redimir en asesorías especializadas de nuestro Marketplace.
									<br><br> <strong>Recibir Asesoría Especializada:</strong> y a la medida de las necesidades o brechas encontradas.
									<br><br> <strong>Ser parte de la comunidad:</strong> de emprendedores de alto impacto del país. <br><br> <strong>Seleccionar el Asesor:</strong> Según el tipo de servicio habilitado.
								</p>
							</div>
						</div>
					</div>
				</section>
				<section role="tabpanel" aria-hidden="false" class="content" id="panel2-2">
					<div class="rows">
						<div class="small-7 columns" style="height: 583px;background: url(https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/Mesa+de+trabajo+3.png);background-repeat: no-repeat;background-size: 100%;">
						</div>
						<div class="small-5 columns" style="background: #DD2E37;padding: 22px 50px;">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-acelera%402x.png" alt="">
							<h2 class="white-text" style="    font-family: 'Montserrat Medium';font-size: 28px;font-weight: bold;line-height: 34px;letter-spacing: 0px;margin-top: 75px;">
								Es el programa que busca acelerar el crecimiento de emprendimientos
								innovadores en etapa temprana en las regiones de Colombia. Se enfoca en emprendimientos con potencial de crecimiento rápido, rentable y sostenido.
							</h2>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Quienes pueden participar
								</h2>
								<p style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 80px;">
									✔ Persona natural o jurídica <br><br>
									✔ Emprendimientos con un máximo de 5 años de
									operación< br><br>
									✔ Ventas de $5M hasta $400M anuales <br><br>
									✔ Deben estar ubicados en una de las regiones
									definidas Quindío, Santander, Bolívar, Tolima, Caldas, Huila, San Andrés-Providencia y Santa Catalina y Valle del Cauca
								</p>
							</div>
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Beneficios del programa
								</h2>
								<p   style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 60px 0px 100px;">
									Alistamiento financiero
									<br><br>Asesoría estratégica en Modelo de negocio
									<br><br> Entrenamiento comercial – Marketing digital
									<br><br> Bootcamps de Prototipado y validación de
									productos y servicios
									<br><br> Entrenamiento: Valientes Liderazgo extremo
								</p>
							</div>
						</div>
					</div>
				</section>
				<section role="tabpanel" aria-hidden="false" class="content" id="panel2-3">
					<div class="rows">

						<div class="small-7 columns" style="height: 550px;background: url(https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/Mesa+de+trabajo+4.png);background-repeat: no-repeat;background-size: 100%;">
						</div>
						<div class="small-5 columns" style="background: #DD2E37;padding: 22px 50px;">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-acelera%402x.png" alt="">
							<h2 class="white-text" style="    font-family: 'Montserrat Medium';font-size: 28px;font-weight: bold;line-height: 34px;letter-spacing: 0px;margin-top: 75px;">
								ALDEA busca el crecimiento de emprendedores para que se conviertan en los grandes empresarios de Colombia por medio de  tres etapas en las que pueden superar los obstáculos que les impiden crecer.
							</h2>
						</div>

						<div class="row">
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Quienes pueden participar
								</h2>
								<p style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 80px;">
									✔ Diferencial en el mercado: Emprendimientos innovadores.
									<br><br>✔ Equipo heterogéneo: Equipo directivo de por lo menos 2 personas. Potencial de escala: Llegar a nuevos mercados.
									<br><br>✔ Tracción Comercial: Tener ventas al momento de postularse.
									<br><br>✔ Tiempo Operación: Máximo 7 años
								</p>
							</div>
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Beneficios del programa
								</h2>
								<p   style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 60px 0px 100px;">
									Potencializar el liderazgo de equipos directivos donde participan mujeres.
									<br><br> conexión con ecosistemas internacionales para networking y escalamiento a nuevos mercados.
									<br><br> Maximiza las habilidades gerenciales y blandas para el crecimiento sostenible.
									<br><br> Aportamos en el fortalecimiento empresarial, financiero y comercial.
								</p>
							</div>
						</div>
					</div>
				</section>
				<section role="tabpanel" aria-hidden="false" class="content" id="panel2-4">
					<div class="rows">
						<div class="small-7 columns" style="height: 516px;background: url(https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/Mesa+de+trabajo+5.png);background-repeat: no-repeat;background-size: 100%;">
						</div>
						<div class="small-5 columns" style="background: #DD2E37;padding: 22px 50px;">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/logo-acelera%402x.png" alt="">
							<h2 class="white-text" style="    font-family: 'Montserrat Medium';font-size: 28px;font-weight: bold;line-height: 34px;letter-spacing: 0px;margin-top: 75px;">
								Comunidad que genera conexiones y conocimiento para apalancar el crecimiento de los emprendedores innovadores en Colombia. La puerta a las conexiones y la colaboración.
							</h2>
						</div>
						<div class="row">
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Quienes pueden participar
								</h2>
								<p style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 80px;">
									Emprendedores ya beneficiados de los programas de la Vicepresidencia de Aceleración de iNNpulsa Colombia con productos y servicios innovadores con diferencial en el mercado.
									<br> <br>

									Visión emprendedora: proyectan un crecimiento sostenido y en aumento para la conquista de mercados nacionales e internacionales.
									<br> <br>

									ADN Emprendedor ATÍPICO: energía, optimismo, colaboración, pasión, confianza, creatividad, ambición y hacer que las cosas sucedan.
									<br> <br>
								</p>
							</div>
							<div class="small-6 columns">
								<h2 style="color: #FF0000;font-family: 'Montserrat Medium';font-size: 30px;margin: 40px 0px;" class="text-center">
									Beneficios del programa
								</h2>
								<p   style="font-family: 'Montserrat Medium';color: #0D2467;font-size: 19px;padding: 0px 60px 0px 100px;">
									Ser parte de espacios de conexión con clientes reales a nivel nacional. <br><br>

									Tener direccionamiento estratégico de expertos <br><br>

									Conectar y colaborar con otros emprendedores y explorar oportunidades de negocio. <br><br>

									Ser parte del portafolio de emprendedores de alto impacto de iNNpulsa Colombia. <br><br>

									Convertirse en un emprendedor líder en la comunidad <br><br>

									Recibir formación es aspectos claves para crecer. <br><br>

									Acceder a conexiones de crecimiento para que alcanzar el máximo potencial de sus emprendimientos.
									<br><br>
								</p>
							</div>
						</div>
					</div>
				</section>
			</div>

			</div>
			{{-- Footer --}}
			<footer class="footer" id="footer-land">
				{{-- Sitemap footer --}}
				@include('public.landing.sitemap')
			</footer>
		</div>
@stop
