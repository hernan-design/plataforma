@extends('layout.landing.layout')
@section('content')
	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		<header id="header-land" class="fixed header" data-magellan-expedition>
			<div class="contain-top-bar sticky-top-menu">
				<nav class="top-bar" data-topbar role="navigation">
				  	<ul class="title-area">
				    	<li class="name">
				    		<h1 class="hide-for-medium-up">
				    			<a class="copo-inst-logo" href="#">
				      				<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-logo-header.svg" alt="">
				      			</a>
				    		</h1>
				    	</li>
				    	<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				  	</ul>
				 	<section class="left top-bar-section">
				    	<ul class="inline-list-grid no-spacing clearfix">
				    		<li class="copo-inst-logo">
								<a href="#">
									<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-logo-header.svg" alt="">
								</a>
				    		</li>
				    		<li class="copo-menu">
				    			<ul class="copo-menu-list inline-list-grid no-spacing clearfix">
							      	{{-- <li class="item-list">
							      		<a href="#">Sobre nosotros</a>
							      	</li> --}}
							      	<li class="has-dropdown item-list">
							        	<a name="productos">Productos</a>
							        	<ul class="dropdown copo-menu-dropdown">
								          	{{-- <li>
								          		<a href="#">SelecTrain</a>
								          	</li>
								          	<li>
								          		<a href="#">VentureManager</a>
								          	</li> --}}
								          	<li>
								          		<a href="{{ route('landingpage', ['category' => 'producto', 'slug' => 'emprendimiento']) }}">Emprendimiento</a>
								          	</li>
								          	{{-- <li>
								          		<a href="#">Innovación</a>
								          	</li>
								          	<li>
								          		<a href="#">Intranet</a>
								          	</li> --}}
							        	</ul>
							      	</li>
							      	<li class="item-list" data-magellan-arrival="main-land">
							      		<a href="#main-land">Soluciones</a>
							      	</li>
							      	<li class="item-list" data-magellan-arrival="copo-study-cases">
							      		<a href="#copo-study-cases">Casos de estudio</a>
							      	</li>
							      {{-- 	<li class="item-list">
							      		<a href="#">Escríbenos</a>
							      	</li> --}}
						    	</ul>
				    		</li>
							<li class="header-social">
								<ul class="header-social-list right">
				    				<li class="item-social">
						          		<a class="item-social-anchor" href="https://www.facebook.com/redestuproyecto/" target="_blank">
						          			<span class="item-social-circle icon-circle small icon-16">
						          				<i class="mdi mdi-facebook"></i>
						          			</span>
						          		</a>
						          	</li>
						          	<li class="item-social">
						          		<a class="item-social-anchor" href="https://twitter.com/tuproyectotweet?lang=es" target="_blank">
						          			<span class="item-social-circle icon-circle small icon-16">
						          				<i class="mdi mdi-close-outline"></i>
						          			</span>
						          		</a>
						          	</li>
						          	<li class="item-social">
						          		<a class="item-social-anchor" href="https://www.youtube.com/channel/UCfXNix2U_XyG9fZZUIBOhAg" target="_blank">
						          			<span class="item-social-circle icon-circle small icon-16">
						          				<i class="mdi mdi-youtube"></i>
						          			</span>
						          		</a>
						          	</li>
								</ul>
							</li>
				      		<li class="header-social-dropdown right text-right">
                                <div class="social-dropdown-container right has-dropdown">
                                    <a class="header-social-share-icon"><i class="mdi mdi-share-variant"></i></a>
                                    <ul class="dropdown header-social-dropdown-list">
                                        <li class="item-social">
                                            <a class="item-social-anchor" href="#">
                                                <span class="item-social-circle icon-circle small icon-18">
                                                    <i class="mdi mdi-facebook"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="item-social">
                                            <a class="item-social-anchor" href="#">
                                                <span class="item-social-circle icon-circle small icon-18">
                                                    <i class="mdi mdi-close-outline"></i>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="item-social">
                                            <a class="item-social-anchor" href="#">
                                                <span class="item-social-circle icon-circle small icon-18">
                                                    <i class="mdi mdi-youtube"></i>
                                                </span>
                                            </a>
                                        </li>
                                        {{-- <li class="item-social">
                                            <a class="item-social-anchor" href="#">
                                                <span class="item-social-circle icon-circle small icon-18">
                                                    <i class="mdi mdi-instagram"></i>
                                                </span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </div>
				      		</li>
				    	</ul>
				  	</section>
				</nav>
			</div>
		</header>
		{{-- header ends here --}}
		{{-- Slider --}}
		<section id="copo-slider">
			<figure class="slick-slider-copo">
				<div class="wrap-img-slider">
					<img class="slider-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-landing-banner.jpg" alt="">
					<div class="slick-slider-content">
						<div class="row align-middle">
							<div class="small-8 columns small-centered">
								<div class="slider-content">
									<H1 class="slick-title-1"><span class="text-overflow-center">TRANSFORMA</span></H1>
									<H5 class="slick-title-2 paragraph-hpadding-both">Ofrecemos servicios de software para llevar tus proyectos de TI al nivel que requiere</H5>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-landing-banner.jpg" alt="">
					<div class="slick-slider-content">
						<div class="row align-middle">
							<div class="small-8 columns small-centered">
								<div class="slider-content">
									<H1 class="slick-title-1"><span class="text-overflow-center">OPTIMIZA</span></H1>
									<H5 class="slick-title-2 paragraph-hpadding-both">Ofrecemos servicios de software para llevar tus proyectos de TI al nivel que requiere</H5>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-landing-banner.jpg" alt="">
					<div class="slick-slider-content">
						<div class="row align-middle">
							<div class="small-8 columns small-centered">
								<div class="slider-content">
									<H1 class="slick-title-1"><span class="text-overflow-center">POTENCIALIZA</span></H1>
									<H5 class="slick-title-2 paragraph-hpadding-both">Ofrecemos servicios de software para llevar tus proyectos de TI al nivel que requiere</H5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</figure>
		</section>
		<div id="main-land" class="main-section" data-stellar-offset-parent="true" data-magellan-destination="main-land">
			{{-- practice areas --}}
			<section id="copo-practice-areas" class="section-land">
				<div class="row">
			        <div class="medium-12 columns">
						<div class="block-vpadding-top">
				            <h2 class="title-section-land text-center black-text" data-magellan-destination="copo-practice-areas">Nuestras áreas de práctica</h2>
				            <a name="copo-practice-areas"></a>
						</div>
			        </div>
			    </div>
				{{-- <div class="practice-areas-rows">
				    <div class="row">
					    <div class="mobile-12 tablet-6 tablet-push-6 columns">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/practice-areas/copo-practice-areas-empleabilidad.png" alt="">
						</div>
						<div class="mobile-12 tablet-6 tablet-pull-6 columns small-only-text-center mobile-only-text-center">
							<div class="practice-areas-text-box">
								<h3 class="title-small practice-areas-title black-text">Empleabilidad</h3>
								<p class="text-paragraph-normal practice-areas-text">Conectamos el trabajo y el talento a través de <span class="selectrain">SelecTrain</span> una plataforma de gestión y selección de recursos humanos ideal para profesionales y empresas. <span class="selectrain">SelecTrain</span> permite que los procesos de contratación se simplifiquen, para que las empresas puedan centrarse en lo que realmente importa: su equipo de trabajo.</p>
							</div>
							<a target="_blank" href="#" class="copo-practice-areas-button button small radius btn-resetc">Ver más</a>
						</div>
					</div>
				</div> --}}
				<div class="practice-areas-rows">
					<div class="row">
						<div class="mobile-12 tablet-6 columns">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/practice-areas/copo-practice-areas-emprendimiento.png" alt="">
						</div>
						<div class="mobile-12 tablet-6 columns small-only-text-center mobile-only-text-center">
							<div class="practice-areas-text-box">
								<h3 class="title-small practice-areas-title black-text">Emprendimiento</h3>
								<p class="text-paragraph-normal practice-areas-text">Las grandes ideas toman vida con nuestra plataforma enfocada 100% en gestionar y administrar iniciativas de emprendimiento empresarial evaluando la viabilidad de los proyectos postulados por la comunidad, para así mismo asignar recursos económicos para su despegue.</p>
							</div>
							<a href="{{ route('landingpage', ['category' => 'producto', 'slug' => 'emprendimiento']) }}" class="copo-practice-areas-button button small radius btn-resetc">Ver más</a>
						</div>
					</div>
				</div>
				<div class="practice-areas-rows">
					<div class="row">
						<div class="mobile-12 tablet-6 tablet-push-6 columns">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/practice-areas/copo-practice-areas-formacion.png" alt="">
						</div>
						<div class="mobile-12 tablet-6 tablet-pull-6 columns small-only-text-center mobile-only-text-center">
							<div class="practice-areas-text-box">
								<h3 class="title-small practice-areas-title black-text">Formación</h3>
								<p class="text-paragraph-normal practice-areas-text">Destaca tus ventajas competitivas con nuestra comunidad de VentureManager una plataforma creada para que mentores se formen y acompañen a empresas y emprendedores en el diseño e implementación de estrategias funcionales y efectivas para su crecimiento.</p>
							</div>
							<a href="{{ route('landingpage', ['category' => 'producto', 'slug' => 'emprendimiento']) }}#tools-learn" class="copo-practice-areas-button button small radius btn-resetc">Ver más</a>
						</div>
					</div>
				</div>
				<div class="practice-areas-rows">
					<div class="row">
						<div class="mobile-12 tablet-6 columns">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/practice-areas/copo-practice-areas-innovacion.png" alt="">
						</div>
						<div class="mobile-12 tablet-6 columns small-only-text-center mobile-only-text-center">
							<div class="practice-areas-text-box">
								<h3 class="title-small practice-areas-title black-text">Innovación</h3>
								<p class="text-paragraph-normal practice-areas-text">Reúne en una sola red las tendencias revolucionarias que cambiaran el mundo. Gestiona programas de innovación de tu compañía u organización interactuando con comunidades de aprendizaje que generen ideas novedosas a partir de la ciencia y tecnología.</p>
							</div>
							<a href="{{ route('landingpage', ['category' => 'producto', 'slug' => 'emprendimiento']) }}#copo-emprendimiento-community" class="copo-practice-areas-button button small radius btn-resetc">Ver más</a>
						</div>
					</div>
				</div>
			</section>
			{{-- copo services --}}
			<section id="copo-services" class="section-land">
				<div class="row">
			        <div class="medium-12 columns">
			            <h2 class="title-section-land text-center black-text block-vpadding-top" data-magellan-destination="copo-services">Por qué adquirir nuestros servicios</h2>
						<a name="copo-services"></a>
			        </div>
			    </div>
				<div class="block-vpadding-bottom">
				    <div class="row">
				    	<div class="medium-12 columns">
					    	<ul class="mobile-block-grid-1 tablet-block-grid-2 medium-block-grid-3">
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-wheel.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Actualizaciones y mejoras constantes</h6>
						    			<p class="services-text">Estamos en constante evolución, desarrollamos nuevas funcionalidades y actualizaciones, con las últimas tendencias y estándares de experiencia de usuario.</p>
						    		</div>
					    		</li>
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-tools.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Soporte técnico</h6>
						    			<p class="services-text">Nuestros desarrollos cuentan con un botón de ayuda donde los usuarios de tu comunidad recibiran respuesta ágil y oportuna a cada inquietud que se presente.</p>
						    		</div>
					    		</li>
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-money.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Menor inversión</h6>
						    			<p class="services-text">Obtener un software como servicio te permite reducir  costos de licencia de hardware y software, mantenimiento y soporte.</p>
						    		</div>
					    		</li>
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-people.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Desarrollos adaptables</h6>
						    			<p class="services-text">Operamos en un contexto Cloud que se puede escalar e integrar con otras soluciones de Software as a Service.</p>
						    		</div>
					    		</li>
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-eye.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Uso intuitivo</h6>
						    			<p class="services-text">Diseñamos y desarrollamos espacios digitales basados en la funcionalidad que facilita el uso y manejo de todo tipo de usuario.</p>
						    		</div>
					    		</li>
					    		<li class="services-box text-center">
					    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/services/copo-services-time.png" alt="">
					    			<div class="services-inner-box">
						    			<h6 class="services-title">Reducción de tiempos</h6>
						    			<p class="services-text">Nuestras plataformas se encuentra configuradas y almacenadas en servidores externos por lo cual te ahorrará tiempo en la fase de instalación y configuración del software.</p>
						    		</div>
					    		</li>
					    	</ul>
				    	</div>
				    </div>
				</div>
			</section>
			{{-- copo testimonial --}}
			<section id="copo-testimonial" class="section-land" data-stellar-background-ratio="0.5">
				<div class="row">
			        <div class="medium-12 columns">
			            <h2 class="title-section-land text-center block-vpadding-bottom white-text block-vpadding-top">Qué dicen nuestros clientes</h2>
			        </div>
			    </div>
			    <div class="row collapse">
					<div class="small-12 columns">
						<div class="content-data-list">
							<div class="tabs-content slick-carousel-content-testimonial-copo copo-testimonial-content">
							  	<div id="alejandrolopez" class="content active text-center">
							  		<div class="small-8 small-centered columns">
								    	<p class="copo-testimonial-text white-text">"La velocidad con la que se implementa un proyecto de gran escala es el factor más relevante de COPO SOFTWARE, te da la capacidad de ejecutar iniciativas del tamaño que requieras en tiempos muy cortos".</p>
								    </div>
							 	</div>
							  	<div id="estebanmancuso" class="content text-center">
							  		<div class="small-8 small-centered columns">
								    	<p class="copo-testimonial-text white-text">"Son un equipo comprometido, creativo y que siempre tiene algo que aportar al cumplimiento de los objetivos que nos planteamos".</p>
								    </div>
							  	</div>
							  	<div id="silviamadrinan" class="content text-center">
							  		<div class="small-8 small-centered columns">
								    	<p class="copo-testimonial-text white-text">"Ha sido una experiencia muy satisfactoria. Contar con el apoyo de un equipo profesional y comprometido que siempre busque aportarte para que tu iniciativa tenga éxito es inviolable.".</p>
								    </div>
							  	</div>
							</div>
							<ul class="tabs slick-carousel-testimonial-copo slick-browse" data-tab>
								<li class="tab-title copo-testimonial-person-item active">
									<a class="testimonial-person-anchor" href="#alejandrolopez" aria-controls="alejandrolopez">
										<div class="text-center copo-testimonial-boxes">
											<div class="img-box">
												<img class="testimonial-person-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/testimonial/alejandro-lopez-r.png" alt="">
											</div>
											<div class="copo-testimonial-person-text-box">
												<h5 class="testimonial-name white-text">Alejandro López R.</h5>
												<span class="company">Medellín Startup City</span>
												<span class="position">Directora general</span>
											</div>

										</div>
									</a>
								</li>
								<li class="tab-title copo-testimonial-person-item">
									<a class="testimonial-person-anchor" href="#estebanmancuso" aria-controls="estebanmancuso">
										<div class="text-center copo-testimonial-boxes">
											<div class="img-box">
												<img class="testimonial-person-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/testimonial/esteban-mancuso-p.png" alt="">
											</div>
											<div class="copo-testimonial-person-text-box">
												<h5 class="testimonial-name white-text">Esteban Mancuso P.</h5>
												<span class="company">LeanStrategy</span>
												<span class="position">Creador de la metodología LeanStrategy</span>
											</div>
										</div>
									</a>
								</li>
								<li class="tab-title copo-testimonial-person-item">
									<a class="testimonial-person-anchor" href="#silviamadrinan" aria-controls="silviamadrinan">
										<div class="text-center copo-testimonial-boxes">
											<div class="img-box">
												<img class="testimonial-person-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/testimonial/silviamadrinan.png" alt="">
											</div>
											<div class="copo-testimonial-person-text-box">
												<h5 class="testimonial-name white-text">Silvia Madriñan</h5>
												<span class="company">Fundación Terpel</span>
												<span class="position">Directora Ejecutiva</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</section>
			{{-- study cases --}}
			<section id="copo-study-cases" class="section-land"  data-magellan-destination="copo-study-cases">
				<div class="row">
			        <div class="medium-12 columns">
			            <h2 class="title-section-land text-center black-text block-vpadding-both">Nuestros casos de estudio</h2>
			            <p class="copo-study-cases-subtitle text-center text-paragraph-large">A continuación encontrarás algunos de los casos en los que nuestra tecnología ha potencializado las iniciativas de nuestros clientes.</p>
			        </div>
			    </div>
			    <div class="block-vpadding-bottom">
				    <div class="row">
				    	<div class="small-12 medium-4 columns">

			    			<div class="study-cases-box">
			    				<a class="study-cases-anchor" href="blog/general/caso-de-estudio-fundacion-bavaria">

				    				<img class="study-cases-mediumup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/study-cases-reb.jpg" alt="">

				    				<img class="study-cases-mobileup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/980x194/study-cases-redbavaria-980x194.jpg" alt="">
				    				<div class="inner-content-box">
				    					<div class="inner-text-box">
											<h5 class="title-small study-cases-company white-text">Bavaria</h5>
											<span class="study-cases-company-program white-text">Destapa Futuro</span>
										</div>
				    				</div>
				    			</a>
				    		</div>
				    	</div>
				    	<div class="small-12 medium-4 columns">

			    			<div class="study-cases-box">

			    				<a class="study-cases-anchor" href="blog/general/caso-de-estudio-fundacion-terpel">

				    				<img class="study-cases-mediumup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/study-cases-terpel.jpg" alt="">
				    				<img class="study-cases-mobileup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/980x194/study-cases-terpel-980x194.jpg" alt="">
				    				<div class="inner-content-box">
				    					<div class="inner-text-box">
											<h5 class="title-small study-cases-company white-text">Terpel</h5>
											<span class="study-cases-company-program white-text">Diseña el cambio</span>
										</div>
				    				</div>
				    			</a>
				    		</div>

			    			<div class="study-cases-box">

			    				<a class="study-cases-anchor" href="blog/general/caso-de-estudio-innpulsa-colombia">

				    				<img class="study-cases-mediumup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/study-cases-innpulsa.jpg" alt="">
				    				<img class="study-cases-mobileup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/980x194/study-cases-innpulsa-980x194.jpg" alt="">
				    				<div class="inner-content-box">
				    					<div class="inner-text-box">
											<h5 class="title-small study-cases-company white-text">INNpulsa Colombia</h5>
											<span class="study-cases-company-program white-text">Programa Aldea</span>
										</div>
				    				</div>
				    			</a>
				    		</div>
				    	</div>
				    	<div class="small-12 medium-4 columns">

			    			<div class="study-cases-box">

			    				<a class="study-cases-anchor" href="blog/general/caso-de-estudio-textiles-lafayette">

				    				<img class="study-cases-mediumup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/study-cases-lafayette.jpg" alt="">
				    				<img class="study-cases-mobileup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/980x194/study-cases-lafayette-980x194.jpg" alt="">
				    				<div class="inner-content-box">
				    					<div class="inner-text-box">
											<h5 class="title-small study-cases-company white-text">Lafayette</h5>
											<span class="study-cases-company-program white-text">Hilando Empresa</span>
										</div>
				    				</div>
				    			</a>
				    		</div>
			    			<div class="study-cases-box">
			    				<a class="study-cases-anchor" href="blog/general/caso-de-estudio-ecopetrol">

				    				<img class="study-cases-mediumup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/study-cases-ecopetrol.jpg" alt="">
				    				<img class="study-cases-mobileup-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/study-cases/980x194/study-cases-ecopetrol-980x194.jpg" alt="">
				    				<div class="inner-content-box">
				    					<div class="inner-text-box">
											<h5 class="title-small study-cases-company white-text">Ecopetrol</h5>
											<span class="study-cases-company-program white-text">Premio a la Innovación</span>
										</div>
				    				</div>
				    			</a>
				    		</div>
				    	</div>
				    </div>
				</div>
			</section>
			{{-- copo partners --}}
			<section id="copo-partners" class="block-vpadding-both section-land">
				<div class="row">
					<div class="small-12 columns">
						<h3 class="title-section-land text-center black-text block-vpadding-both">Contamos con más de cinco años de experiencia fortaleciendo las iniciativas de emprendimiento en Colombia.</h3>
						 <p class="text-center partners-subtitle">Ellos han gestionado sus programas de emprendimiento con COPO software</p>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="slick-copo-emprendimiento-partners block-vpadding-both">
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/innpulsa-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/coomeva-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/terpel-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/creame-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/santiagodecali-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/fundacionbavaria-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/rnai-fundacionbavaria-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/lafayette-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/ecopetrol-logo.png" alt="">
							</div>
							<div class="partners-slick-item wrap-img-slider">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/partners/andifuturo-logo.png" alt="">
							</div>
						</div>
					</div>
				</div>
			</section>

			{{-- contacto --}}
			<section id="copo-contact">
				<div class="row collapse full-width col-equal-height">
					<div class="small-12 tablet-4 columns">
						<div class="contact-box">
							<div class="contact-box-content">
								<h4 class="copo-contact-title white-text">Contáctanos</h4>
								<p class="copo-contact-subtext white-text">Calle 19 No 4 - 74</p>
								<p class="copo-contact-subtext white-text">Edificio Coopava Oficina 1602 - Bogotá</p>
								<p class="copo-contact-subtext white-text">+57 (1) 2435782</p>
								<p class="copo-contact-subtext white-text">comercial@tuproyecto.com</p>
							</div>
						</div>
					</div>
					<div class="small-12 tablet-8 columns">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d826.9271535276769!2d-74.06813512225979!3d4.603419250618028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f99a309d94e65%3A0xea7cc3b111b48df4!2sTorre+Barichara+A!5e0!3m2!1ses!2sco!4v1512157837285" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</section>
		</div>
		{{-- Footer --}}
		<footer class="footer" id="copo-footer-land">
			<div class="copyright-social-footer">
				<div class="row valign-middle">
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
						<span class="inst-copyright">Todo el contenido © COPO Software 2018</span>
					</div>
					<div class="mobile-12 tablet-4 columns text-center">
						<a href="#copo-slider">
		      				<img id="logo-bottom-inst" class="inst-logo-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/copo-logo-header.png" alt="">
		      			</a>
					</div>
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-right">
						<ul class="list-social-footer text-small-right text-mobile-center">
							<li>
								<a href="https://www.facebook.com/redestuproyecto/" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-facebook"></i>
								</a>
							</li>
							<li>
								<a href="https://twitter.com/tuproyectotweet?lang=es" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-close-outline"></i>
								</a>
							</li>
							<li>
								<a href="https://www.youtube.com/channel/UCfXNix2U_XyG9fZZUIBOhAg" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-youtube"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</div>
@stop
