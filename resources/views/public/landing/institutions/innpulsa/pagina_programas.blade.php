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

		{{-- miga de pan  --}}

		<div class="full-width" id="banner-impact-page">
			<div class="xlage-8 medium-10 small-12 xlarge-offset-2 medium-offset-1 small-offset-0 columns container-breadcum">
				<h3 class="title-breadcum-impact-page">
					Convocatorias
				</h3>
				<small class="paragraph-breadcum-impact-page">
					Inicio / Convocatorias
				</small>
			</div>
		</div>


		{{-- tabs con imagenes --}}
		<div class="rows" id="container-tabs">
			<div class="tablet-12 large-6 large-offset-3">
				<ul class="tabs" data-tab>
					<li class="small-3 tablet-12 medium-3 columns tab-title active no-padding" role="presentation">
						<a class="button-know-more" href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">
							<div id="tb1" class="block-center"></div>
						</a>
					</li>
					<li class="small-3 tablet-12 medium-3 columns tab-title no-padding" role="presentation" >
						<a class="button-know-more" href="#panel2-2" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">
							<div id="tb2" class="block-center"></div>
						</a>
					</li>
					<li class="small-3 tablet-12 medium-3 columns tab-title no-padding" role="presentation" >
						<a class="button-know-more" href="#panel2-3" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">
							<div id="tb3" class="block-center"></div>
						</a>
					</li>
					<li class="small-3 tablet-12 medium-3 columns tab-title no-padding" role="presentation" >
						<a class="button-know-more" href="#panel2-4" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-4">
							<div id="tb4" class="block-center"></div>
						</a>
					</li>
				</ul>
			</div>
		</div>


		{{-- contenido de tabs --}}

		<div class="tabs-content" id="container-info-tabs">

			{{-- contenedor Emprendimientos de alto impacto --}}

			<section role="tabpanel" aria-hidden="false" class="content no-padding" id="panel2-1">
				<div class="full-width background-logo-red">
					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/logo-aldea-blanco.png" alt="">
				</div>
				<div class="rows bg-fb">
					<h2 id="text-how-do" class="text-center">ALDEA busca el crecimiento de emprendedores para que se conviertan <br> en los grandes empresarios de Colombia por medio de tres etapas en <br> las que pueden superar los obstáculos que les impiden crecer.</h2>
					<div class="video-center">
						<iframe width="62%" height="350" src="https://www.youtube.com/embed/UBwy4PlaQRw"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>
					</div>					
					{{-- Quienes pueden participar --}}
					<div class="container-infoextra-page2 row col-equal-height">
						<div class="small-6 no-padding columns">
							<div class="row">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										¿Quienes pueden participar?
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Emprendimientos con un modelo de negocio innovador y con alto potencial de crecimiento.
										<br><br> ✔ Constituidos como persona jurídica.
										<br><br> ✔ Equipo emprendedor con mínimo dos personas (preferiblemente heterogéneo).  
										<br><br> ✔ Emprendimientos que tengan menos de 7 años de operación comercial. 
										<br><br> ✔ Ventas mínimas de $100.000.000
										<br><br>
									</p>
								</div>
							</div>
						</div>
						<div class="small-6 no-padding columns container-img-people">
							<div class="img-people hide-for-mobile-only"></div>
						</div>
					</div>

					{{-- Beneficios del programa --}}

					<div class="container2-infoextra-page2 row col-equal-height">
						<div class="small-6 no-padding columns">
							<div class="img-benefits hide-for-mobile-only"></div>
						</div>
						<div class="small-6 no-padding columns">
							<div class="row spacing-top-benefits">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										Beneficios del programa
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										<strong>✔ IDENTIFICAR OBSTÁCULOS:</strong> Que impiden el crecimiento. 
										<br><br> <strong>✔ RECIBIR FEEDBACK:</strong> De expertos en el marco del segundo reto del programa.
										<br><br> <strong>✔ RECIBIR LLAVES DE ACCESO:</strong> (voucher) por COP 20, 40 o 60 millones para redimir en asesorías especializadas de nuestro Marketplace.
										<br><br> <strong>✔ RECIBIR ASESORÍA ESPECIALIZADA:</strong> a la medida de las necesidades o brechas encontradas.
										<br><br> <strong>✔ SER PARTE DE LA COMUNIDAD:</strong> de emprendedores de alto impacto del país. 
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="full-width" id="container-button-postulate">
					<button class="center-block radius btn-postulate"><a href="/convocatoria/aldea-20">!POSTÚLATE AHORA!</a></button>
				</div>
			</section>

			{{-- contenedor Acelera Region --}}

			<section role="tabpanel" aria-hidden="false" class="content no-padding" id="panel2-2">
				<div class="full-width background-logo-green">
					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/logo-acelera.png" alt="">
				</div>
				<div class="rows bg-fb">
					<h2 id="text-how-do" class="text-center">Es el programa que busca acelerar el crecimiento de emprendimientos innovadores en etapa temprana en las regiones de Colombia.<br> Se enfoca en emprendimientos con potencial de crecimiento rápido, rentable y sostenido.<br> Esta iniciativa nace bajo el liderazgo del Ministerio de Comercio, Industria y Turismo a través de iNNpulsa Colombia, en alianza con la Cámara de Comercio de Cali<br> para la transferencia metodológica de su programa de emprendimiento: Valle E.</h2>
					<div class="video-center">
						<iframe width="62%" height="350" src="https://www.youtube.com/embed/UBwy4PlaQRw"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>
					</div>
					{{-- Quienes pueden participar --}}
	
					<div class="container-infoextra-page2 row col-equal-height">
						<div class="small-6 columns">
							<div class="row">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										¿Quienes pueden participar?
									</h2>
								</div>
									
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Persona natural o jurídica. <br><br>
										✔ Facturación entre COP 5.000.000  hasta COP 400.000.000 en el último año de operaciones.<br><br>
										✔ Hasta 5 años de haber iniciado operaciones <br><br>
										✔ Modelo de negocio escalable e innovador
									</p>
								</div>
							</div>
						</div>
						<div class="small-6 no-padding columns container-img-people">
							<div class="img-people hide-for-mobile-only"></div>
						</div>
					</div>

					{{-- Beneficios del programa --}}

					<div class="container2-infoextra-page2 row col-equal-height">
						<div class="small-6 no-padding columns">
							<div class="img-benefits hide-for-mobile-only"></div>
						</div>
						<div class="small-6 columns">
							<div class="row spacing-top-benefits">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										Beneficios del programa
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Talleres especializados en temáticas esenciales para el crecimiento tales  como: modelo de negocio, liderazgo y habilidades blandas, alistamiento financiero, estrategia comercial, prototipado y validación, pitch y puesta en escena)
										<br><br> ✔ Acompañamiento transversal a través de consultores especializados.
										<br><br> ✔ Acceso a Demo Day con potenciales aliados estratégicos del ecosistema de emprendimiento nacional.
										<br><br> ✔ Conexiones de valor y visibilidad.
										<br><br> ✔ Si eres de los emprendedores más destacados, podrás desarrollar tu propio plan de crecimiento a un año con un consultor asignado especialmente para ti y ¡muchos beneficios más!
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="full-width" id="container-button-postulate">
					<button class="center-block radius btn-postulate"><a href="{{ URL::route('convocatoria.index') }}">!POSTÚLATE AHORA!</a></button>
				</div>
			</section>

			{{-- contenedor Empodera --}}

			<section role="tabpanel" aria-hidden="false" class="content no-padding" id="panel2-3">
				<div class="full-width background-logo-blue">
					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/logo-empodera.png" alt="">
				</div>
				<div class="rows bg-fb">
					<h2 id="text-how-do" class="text-center">Es el programa que nace bajo el liderazgo del Ministerio de Comercio, Industria y Turismo a través de iNNpulsa Colombia que potencia emprendimientos innovadores,<br> con equipos heterogéneos para el fortalecimiento de capacidades gerenciales de los emprendedores, a través de contenidos especializados enfocados en liderazgo,<br> finanzas, estrategia comercial, negociación y autoconocimiento, que permitirán elevar la participación y el potencial directivo de las mujeres en las empresas y visibilizar<br> el rol que desempeñan dentro de las mismas.</h2>
					<div class="video-center">
						<iframe width="62%" height="350" src="https://www.youtube.com/embed/HlUrUNuzIW8"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>
					</div>
					{{-- Quienes pueden participar --}}
					<div class="container-infoextra-page2 row col-equal-height">
						<div class="small-6 columns">
							<div class="row">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										¿Quienes pueden participar?
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Diferencial en el mercado: empresas que brindan soluciones que transforman y resuelven problemas o generan oportunidades desatendidas. 
										<br><br>
										✔ Equipo líder heterogéneo: contar con un equipo directivo compuesto por al menos dos personas, de las cuales una de ellas debe ser mujer. 
										<br><br>
										✔ Potencial de escala: tener mercado identificado en el que tenga potencial de escalamiento comercial. Es decir, potencial de incrementar rápidamente sus ventas.
										<br><br>
										✔ Validación en el mercado a través de ventas: Tener un producto o servicio que ya genera una frecuencia de ventas.
										<br><br>
										✔ Tener máximo siete años de operación comercial al momento de la presentación de la postulación.
										<br><br>
									</p>
								</div>
							</div>
						</div>
						<div class="small-6 no-padding columns container-img-people">
							<div class="img-people hide-for-mobile-only"></div>
						</div>
					</div>

					{{-- Beneficios del programa --}}
					<div class="container2-infoextra-page2 row col-equal-height">
						<div class="small-6 no-padding columns">
							<div class="img-benefits hide-for-mobile-only"></div>
						</div>
						<div class="small-6 columns">
							<div class="row spacing-top-benefits">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										Beneficios del programa
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Potencializar el liderazgo de equipos directivos donde participan mujeres.
										<br><br>
										✔ Maximiza las habilidades gerenciales para el crecimiento sostenible.
										<br><br>
										✔ Aportamos en el fortalecimiento empresarial, financiero y comercial.
										<br><br>
										✔ Hacemos parte de la misión exploratoria a nivel internacional generando una conexión con ecosistemas internacionales para networking y escalamiento a nuevos mercados.
										<br><br>
										✔ Fortalecimiento de habilidades blandas con los representantes de cada una de las empresas seleccionadas.
										<br><br>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="full-width" id="container-button-postulate">
					<button class="center-block radius btn-postulate"><a href="/convocatoria/innpulsa-empodera-2020">!POSTÚLATE AHORA!</a></button>
				</div>
			</section>

			{{-- contenedor Atipicos --}}

			<section role="tabpanel" aria-hidden="false" class="content no-padding" id="panel2-4">
				<div class="full-width background-logo-yellow">
					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/logo-atipicos.png" alt="">
				</div>
				<div class="rows bg-fb">
					<h2 id="text-how-do" class="text-center">A T Í P I C O S es una comunidad para los Emprendedores en Crecimiento, para aquellos capaces de romper los esquemas tradicionales<br> y cuestionar los límites de lo posible para lograr lo atípico.</h2>
					<div class="video-center">
						<iframe width="62%" height="350" src="https://www.youtube.com/embed/TmjwLzCk0WE"  frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>></iframe>
					</div>	
					{{-- Quienes pueden participar --}}

					<div class="container-infoextra-page2 row col-equal-height">
						<div class="small-6 columns">
							<div class="row">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										¿Quienes pueden participar?
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Emprendedores ya beneficiados por iNNpulsa Colombia.
										<br> <br>
										✔ Visión emprendedora.
										<br> <br>
										✔ ADN Emprendedor ATÍPICO: energía, optimismo, colaboración, pasión, confianza, creatividad, ambición y hacer que las cosas sucedan
										<br> <br>
									</p>
								</div>
							</div>
						</div>
						<div class="small-6 no-padding columns container-img-people">
							<div class="img-people hide-for-mobile-only"></div>
						</div>
					</div>

					{{-- Beneficios del programa --}}

					<div class="container2-infoextra-page2 row col-equal-height">
						<div class="small-6 no-padding columns">
							<div class="img-benefits hide-for-mobile-only"></div>
						</div>
						<div class="small-6 columns">
							<div class="row spacing-top-benefits">
								<div class="small-10 small-offset-1 columns">
									<h2 class="title-infofull1-page2">
										Beneficios del programa
									</h2>
								</div>
								<div class="small-9 small-offset-1 end columns">
									<p class="text-infofull1-page2">
										✔ Tener una Red de crecimiento con Consejos Directivos, Ruedas de Negocio, Conexión con Fuentes de Financiación, Mentoring y más. <br><br>
										✔ Conectar y colaborar con otros emprendedores y explorar oportunidades de negocio. <br><br>
										✔ Detonar el espíritu de liderazgo y colaboración. <br><br>
										✔ Entrenamientos en temas clave para seguir creciendo.
										<br><br>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="full-width" id="container-button-postulate">
					<button class="center-block radius btn-postulate"><a href="{{ URL::route('convocatoria.index') }}">!POSTÚLATE AHORA!</a></button>
				</div>
			</section>
		</div>
	</div>
	{{-- Footer --}}
	@include('public.landing.institutions.innpulsa.footer')
</div>
@stop