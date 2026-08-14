@extends('layout.landing.layout')
@section('content')

<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
	{{-- <header id="copo-emprendimiento-header-land" class="fixed header">
		<div class="contain-top-bar sticky-top-menu">
			<nav class="top-bar" data-topbar role="navigation">
			  	<ul class="title-area">
			    	<li class="name">
			    		<h1 class="hide-for-medium-up">
			    			<a class="copo-inst-logo" href="{{ route('home') }}">
			      				<img class="inst-logo-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/copo-emprendimiento-logo.svg" alt="">
			      			</a>
			    		</h1>
			    	</li>
			    	<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
			  	</ul>
			 	<section class="left top-bar-section">
			    	<ul class="inline-list-grid no-spacing clearfix">
			    		<li class="show-for-medium-up">
				    		<div>
				      			<a class="copo-inst-logo" href="{{ route('home') }}">
				      				<img class="inst-logo-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/copo-emprendimiento-logo.svg" alt="">
				      			</a>
				    		</div>
			    		</li>
			    		<li class="copo-menu">
			    			<ul class="copo-menu-list inline-list-grid no-spacing clearfix">
						      	<li class="item-list active">
						      		<a href="#">Sobre nosotros</a>
						      	</li>
						      	<li class="item-list">
						      		<a href="#">Emprendimientos</a>
						      	</li>
						      	<li class="item-list">
						      		<a href="#">Soluciones</a>
						      	</li>
						      	<li class="item-list">
						      		<a href="#">Servicios</a>
						      	</li>
						      	<li class="item-list contact">
						      		<a href="#">Escríbenos</a>
						      	</li>
					    	</ul>
			    		</li>
			    	</ul>
			  	</section>
			</nav>
		</div>
	</header>
 --}}

	{{-- banner --}}
	<section id="copo-emprendimiento-banner">
		<div class="banner-content-main">
			<div class="row">
				<div class="mobile-12 small-6 medium-5 medium-offset-1 large-offset-0 large-6 columns end">
					<div class="banner-content mobile-only-text-center small-only-text-center">
						<a href="{{ route('home') }}">
							<img class="temporal-logo" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/copo-emprendimiento-logo.svg" alt="">
						</a>
						<h2 class="banner-title-1">¡Adiós a la gestión desarticulada!</h2>
						<p class="banner-title-2">Copo software es una plataforma diseñada para impulsar, acompañar y fortalecer las iniciativas de emprendimiento, innovación y desarrollo empresarial de tu compañía.</p>
						<div class="flex-video widescreen copo-emprendimiento-about-video radius ">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/ZwtI4Z-_B-w" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div id="main-land" class="main-section">
		<section id="copo-emprendimiento-form">
			<div class="row">
				<div class="small-12 columns">
					<h2 class="form-title">¡Empieza ahora!</h2>
					<p class="form-subtitle">Regístrate para obtener tu versión de prueba</p>
				</div>
			</div>

			<!-- Begin MailChimp Signup Form -->
			<div id="mc_embed_signup">
				<form action="https://tuproyecto.us11.list-manage.com/subscribe/post?u=8f6560ac7b90e76036e868855&amp;id=851dba960a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					{{-- <div id="mc_embed_signup_scroll"> --}}
					<div class="row">
				    	<div class="mobile-12 tablet-6 large-6 columns">
							<div class="mc-field-group">
								<label for="mce-FNAME">
									<input class="form-copo-input" type="text" value="" name="FNAME" class="required" id="mce-FNAME" placeholder="Nombre">
								</label>
							</div>
							<div class="mc-field-group">
								<label for="mce-EMAIL">
									<input class="form-copo-input" type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email">
								</label>
							</div>
						</div>
				    	<div class="mobile-12 tablet-6 large-6 columns">
							<div class="mc-field-group size1of2">
								<label for="mce-PHONE">
									<input class="form-copo-input" type="text" name="PHONE" class="" value="" id="mce-PHONE" placeholder="Teléfono">
								</label>
							</div>
							<div class="mc-field-group size1of2">
								<label for="mce-COMPANY">
									<input class="form-copo-input" type="text" name="COMPANY" class="" value="" id="mce-COMPANY" placeholder="Empresa">
								</label>
							</div>
							{{-- ERRORES MAILCHIMP --}}
							<div id="mce-responses" class="clear">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
							<div style="position: absolute; left: -5000px;" aria-hidden="true">
						    	<input type="text" name="b_8f6560ac7b90e76036e868855_851dba960a" tabindex="-1" value="">
						    </div>
						</div>
					</div>
					<div class="row">
						<div class="tablet-12 large-8 large-centered columns">
							<div class="legal-form text-center">
								<div>
							      	<input id="checkbox1" class="legal-check" type="checkbox">
							      	<label class="legal-label" for="checkbox1">
							      		<span>Al registrarte, aceptas los <a href="https://coposoftware.com/privacidad" target="_blank">Términos de Uso</a> y las <a href="https://coposoftware.com/privacidad" target="_blank">Políticas de Privacidad</a>, incluyendo el <a href="https://coposoftware.com/privacidad#cookies" target="_blank">Uso de Cookies</a>.
							      		</span>
							  		</label>
					  			</div>
							    <input type="submit" value="ENVIAR" name="subscribe" id="mc-embedded-subscribe" class="copo-form-button">
							</div>
						</div>
					</div>
				</form>
			</div>
			<!--End mc_embed_signup-->
		</section>

		<section id="copo-emprendimiento-tools">
			<div class="row">
				<div class="small-12 text-center columns">
					<span class="our-tools-title">
						Conoce más de nuestras herramientas...
					</span>
				</div>
			</div>
			<div id="tools-convocation">
				<div class="row">
					<div class="mobile-12 small-6 tablet-7 xlarge-6 columns">
						<div class="tools-content-box">
							<h4 id="tools-convocation-title" class="tools-title" data-magellan-destination="tools-convocation-title">En busca de los mejores talentos</h4>
							<p class="tools-head-text">Ofrece experiencias, conocimiento y oportunidades para los emprendedores y empresarios a través de convocatorias y programas de crecimiento.</p>
							<ul class="collapsible no-bullet">
							    <li class="collapsible-list-item active">
								    <div class="collapsible-header active">Pregunta más, conoce más<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Recopila la información de proyectos o empresas.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Pasa al siguiente nivel<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Tus procesos clasificados por etapas.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Diagnósticos a la mano<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Optimiza el recurso humano de tu empresa, evalúa de forma acertada cada proyecto.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Tu red de emprendimientos<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Los proyectos y empresas que hacen parte de tu comunidad en un solo lugar.</span>
								    </div>
							    </li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="tools-autodiagnosis" class="">
				<div class="row">
					<div class="mobile-12 small-7 small-offset-5 columns">
						<div class="diagnosis-content-box">
							<h4 class="tools-title">Mejora la competitividad</h4>
							<p class="tools-head-text">Apoya a los emprendedores y empresarios en el desarrollo de sus fortalezas y competitividad con base en el autodiagnóstico como herramienta de la transformación.</p>
							<div class="row">
								<div class="small-6 tablet-12 columns">
									<ul class="no-bullet user-company-content-list">
										<li>
											<ul class="inline-list-grid align-top">
												<li class="has-image">
													<img class="diagnosis-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/herramientas/svg/icons/copo-profile-icon.svg" alt="">
												</li>
												<li>
													<h5 class="text-md">Emprendedores / empresarios</h5>
													<p class="text-xmd">Evalúa las aptitudes emprendedoras de tus usuarios aplicando encuestas que determinen las habilidades y competencias.</p>
												</li>
											</ul>
										</li>
										<li>
											<ul class="inline-list-grid align-top">
												<li class="has-image">
													<img class="diagnosis-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/herramientas/svg/icons/copo-company-icon.svg" alt="">
												</li>
												<li>
													<h5 class="text-md">Proyectos / empresas</h5>
													<p class="text-xmd">Analiza las áreas claves de los proyectos y empresas, como gestión administrativa, humana, financiera, comercial y producción.</p>
												</li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="small-6 tablet-12 columns">
									<ul class="collapsible no-bullet">
									    <li class="collapsible-list-item active">
										    <div class="collapsible-header active">Analiza gráficamente los resultados<i class="right mdi mdi-chevron-down"></i></div>
										    <div class="collapsible-body">
										    	<span>Conoce el estado actual y el estado óptimo de los proyectos y empresas.</span>
										    </div>
									    </li>
									    <li class="collapsible-list-item">
										    <div class="collapsible-header">Oportunidades de mejora<i class="right mdi mdi-chevron-down"></i></div>
										    <div class="collapsible-body">
										    	<span>Destaca las recomendaciones que le ayudarán a los emprendedores y empresarios  a estar mejor preparados, conectalos con: expertos, cursos, artículos y eventos dentro de tu ecosistema.</span>
										    </div>
									    </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="tools-marketplace" class="">
				<div class="row">
					<div class="mobile-12 small-6 tablet-7 xlarge-6 columns">
						<div class="marketplace-content-box">
							<h4 class="tools-title">Construye negocios en línea</h4>
							<p class="tools-head-text">Vender es una de los tareas más difíciles para los emprendedores, conecta comercialmente a socios, usuarios y aliados por medio de tu marketplace.</p>
							<ul class="collapsible no-bullet">
							    <li class="collapsible-list-item active">
								    <div class="collapsible-header active">Portafolio de productos y servicios<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Tu red de empresas en un solo click.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Siempre en contacto<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Lleva la trazabilidad de los acuerdos de compra y venta entre usuarios.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Tus propias reglas<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Evalúa y aprueba la publicación de los productos y servicios.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Búsqueda instantánea<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Los servicios de tu catálogo organizados por filtros para mejorar la experiencia de usuario.</span>
								    </div>
							    </li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="tools-mentoring" class="">
				<div class="row">
					<div class="mobile-12 small-6 small-offset-6 tablet-7 tablet-offset-5 xlarge-6 xlarge-offset-6 columns">
						<div class="tools-content-box">
							<h4 class="tools-title">Ayuda a tomar mejores decisiones<br><span>¡Aprender de la experiencia!</span></h4>
							<p class="tools-head-text">El 70% de los emprendimientos que cuentan con un proceso de acompañamiento, tienen el doble de posibilidades de tener éxito.</p>
							<ul class="collapsible no-bullet">
							    <li class="collapsible-list-item active">
								    <div class="collapsible-header active">Fuentes de inspiración<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Incorpora a los expertos que pueden cumplir con las expectativas y necesidades de mejora de tus emprendedores y empresarios.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Relaciones valiosas<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Incrementa el networking de tu comunidad, genera vínculos profesionales para impulsar el crecimiento empresarial.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Feedback<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Sigue el desarrollo, evalúa la calidad y los resultados de los procesos de acompañamiento.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Match entre expertos y emprendedores<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Preguntas y respuestas siempre conectadas, enlaza de forma fácil a tus emprendedores con el experto que resolverá sus inquietudes.</span>
								    </div>
							    </li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="tools-learn" class="">
				<div class="row">
					<div class="mobile-12 small-6 tablet-7 xlarge-6 columns">
						<div class="marketplace-content-box">
							<h4 class="tools-title">Promueve la formación virtual<br><span>¡Crecer a partir del conocimiento!</span></h4>
							<p class="tools-head-text">La formación empresarial es una de las claves para reducir las tasas de mortalidad de las empresas y generar un impacto positivo en las ideas de negocio proyectos y empresas.</p>
							<ul class="collapsible no-bullet">
							    <li class="collapsible-list-item active">
								    <div class="collapsible-header active">Impulsa el auto-aprendizaje<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Crea tu propia biblioteca de cursos virtuales.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">Incentiva el aprendizaje colectivo<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Programa charlas en vivo para que líderes y expertos de tu ecosistema compartan sus conocimientos y experiencias a tus emprendedores y empresarios.</span>
								    </div>
							    </li>
							    <li class="collapsible-list-item">
								    <div class="collapsible-header">La conversación fomenta el aprendizaje<i class="right mdi mdi-chevron-down"></i></div>
								    <div class="collapsible-body">
								    	<span>Las interacciones en torno al aprendizaje, responde a comentarios y consultas de tus usuarios en una sola vista.</span>
								    </div>
							    </li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- comunidad  --}}
		<section id="copo-emprendimiento-community">
			<div class="row">
				<div class="small-12 columns">
					<div class="text-center block-vpadding-bottom">
						<h2 class="section-title">Reúne a tu comunidad</h2>
						<h4 class="section-subtitle">¡Tener tu propia red social es posible!</h4>
						<p class="section-header-text">Permite que tu red de usuarios se conecten e interactúen en pro del crecimiento empresarial.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-4 large-4 columns">
					<div class="comunidad-content-item top-items">
						<ul class="inline-list-grid align-top no-bullet comunidad-list">
							<li class="has-image">
								<img class="comunidad-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/comunidad/svg/icons/copo-comunidad-icon-number.svg" alt="">
							</li>
							<li class="comunidad-list-item">
								<h6>Segmenta</h6>
								<p>Crea e identifica los grupos y perfiles de usuarios en función a profesiones, temas de interés y mucho más.</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="show-for-tablet-up tablet-4 large-4 columns text-center">
					<img class="text-center" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/comunidad/svg/pictograms/copo-comunidad-actualizaciones.svg" alt="">
				</div>
				<div class="small-12 tablet-4 large-4 columns">
					<div class="comunidad-content-item top-items">
						<ul class="inline-list-grid align-top no-bullet comunidad-list">
							<li class="has-image">
								<img class="comunidad-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/comunidad/svg/icons/copo-comunidad-icon-upgrade.svg" alt="">
							</li>
							<li class="comunidad-list-item">
								<h6>Capta la atención</h6>
								<p>Actualiza diversa información: cursos, eventos, artículos y foros de interés para tus usuarios.</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-4 tablet-push-2 large-4 large-push-2 columns">
					<div class="comunidad-content-item bottom-items">
						<ul class="inline-list-grid align-top no-bullet comunidad-list">
							<li class="has-image">
								<img class="comunidad-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/comunidad/svg/icons/copo-comunidad-icon-filter.svg" alt="">
							</li>
							<li class="comunidad-list-item">
								<h6>Filtra el contenido y personas</h6>
								<p>Encuentra fácil la información de tu contenido y grupos de personas de tu comunidad.</p>
							</li>
						</ul>
					</div>
				</div>
				<div class="small-12 tablet-4 tablet-pull-2 large-4 large-pull-2 columns">
					<div class="comunidad-content-item bottom-items">
						<ul class="inline-list-grid align-top no-bullet comunidad-list">
							<li class="has-image">
								<img class="comunidad-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/comunidad/svg/icons/copo-comunidad-icon-like.svg" alt="">
							</li>
							<li class="comunidad-list-item">
								<h6>Interacciones</h6>
								<p>Responde y fortalece la relación con tus usuarios.</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		{{-- noticias --}}
		<section id="copo-emprendimiento-news">
			<div class="row">
				<div class="small-12 columns">
					<div class="slick-copo-emprendimiento-news">
						<div class="news-slick-item wrap-img-slider">
							<div class="row">
								<div class="mobile-12 mobile-centered tablet-8 large-6 columns">
									<div class="news-item-content-box text-center">
										<img class="news-pictogram" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/news/pictograms/copo-news-picto-1.svg" alt="">
										<h4 class="news-title">Noticias y consejos</h4>
										<p class="news-text">Fideliza a tu comunidad, comparte artículos y noticias a tus usuarios.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="news-slick-item wrap-img-slider">
							<div class="row">
								<div class="mobile-12 mobile-centered tablet-8 large-6 columns">
									<div class="news-item-content-box text-center">
										<img class="news-pictogram" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/news/pictograms/copo-news-picto-2.svg" alt="">
										<h4 class="news-title">Calendario y eventos</h4>
										<p class="news-text">Siempre en pro del Networking, invita a tus usuarios a participar de eventos internos y externos a tu organización.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="news-slick-item wrap-img-slider">
							<div class="row">
								<div class="mobile-12 mobile-centered tablet-8 large-6 columns">
									<div class="news-item-content-box text-center">
										<img class="news-pictogram" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/news/pictograms/copo-news-picto-3.svg" alt="">
										<h4 class="news-title">Únete a la conversación</h4>
										<p class="news-text">Crea foros para promover el desarrollo del pensamiento crítico de tus usuarios.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- copo services --}}
		<section id="copo-emprendimiento-management">
			<div class="row">
		        <div class="tablet-8 tablet-centered medium-8 large-8 xlarge-8 columns block-vpadding-bottom">
		           <h2 class="management-section-title text-center">No importa qué tan grande o pequeño sea tu programa de emprendimiento, siempre podrás gestionarlo con <span>COPO Software.</span></h2>
		        </div>
		    </div>
			<div class="block-vpadding-bottom">
			    <div class="row">
			    	<div class="medium-12 columns">
				    	<ul class="mobile-block-grid-1 tablet-block-grid-3">
				    		<li class="services-box text-center">
				    			<img class="services-img tools" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-tools.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Soporte técnico</h6>
					    			<p class="services-text">Nuestros desarrollos cuentan con un botón de ayuda donde los usuarios de tu comunidad recibiran respuesta ágil y oportuna a cada inquietud que se presente.</p>
					    		</div>
				    		</li>
				    		<li class="services-box text-center">
				    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-fulltime.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Actualizaciones y mejoras constantes</h6>
					    			<p class="services-text">Estamos en constante evolución, desarrollamos nuevas funcionalidades y actualizaciones, con las últimas tendencias y estándares de experiencia de usuario.</p>
					    		</div>
				    		</li>
				    		<li class="services-box text-center">
				    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-savemoney.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Menor inversión</h6>
					    			<p class="services-text">Obtener un software como servicio te permite reducir  costos de licencia de hardware y software, mantenimiento y soporte.</p>
					    		</div>
				    		</li>
				    		<li class="services-box text-center">
				    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-profile.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Desarrollos adaptables</h6>
					    			<p class="services-text">Operamos en un contexto Cloud que se puede escalar e integrar con otras soluciones de Software as a Service.</p>
					    		</div>
				    		</li>
				    		<li class="services-box text-center">
				    			<img class="services-img" src="	https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-savetime.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Reducción de tiempos</h6>
					    			<p class="services-text">Nuestras plataformas se encuentra configuradas y almacenadas en servidores externos por lo cual te ahorrará tiempo en la fase de instalación y configuración del software.</p>
					    		</div>
				    		</li>
				    		<li class="services-box text-center">
				    			<img class="services-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/copo-manage-icon-intuitiveuse.svg" alt="">
				    			<div class="services-inner-box">
					    			<h6 class="services-title">Uso intuitivo</h6>
					    			<p class="services-text">Diseñamos y desarrollamos espacios digitales basados en la funcionalidad que facilita el uso y manejo de todo tipo de usuario.</p>
					    		</div>
				    		</li>
				    	</ul>
			    	</div>
			    </div>
			</div>
			<div class="management-bottom-section">
				<div class="row">
			        <div class="medium-12 tablet-8 tablet-centered medium-8 xlarge-12 columns block-vpadding-both">
						<div class="management-bottom-content text-center">
			        		<img class="management-bottom-icon" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/management/management-bottom-section-icon.svg" alt="">
				           	<h2 class="management-bottom-title text-center">Mantén el control y mide tus resultados</h2>
				           	<p class="management-bottom-subtitle text-center paragraph-hpadding-both">La plataforma integra un módulo de administrador para el seguimiento de cada uno de tus procesos, análisis y generación de informes. Administra y delega responsabilidades a tu equipo de trabajo limitando el acceso a la información por medio de roles personalizados.</p>
				        </div>
			        </div>
			    </div>
			</div>
		</section>

		{{-- partners --}}
		<section id="copo-emprendimiento-partners" class="block-vpadding-both">
			<div class="row">
				<div class="small-12 columns">
					<h3 class="section-title text-center block-vpadding-top">Contamos con más de cinco años de experiencia fortaleciendo las iniciativas de emprendimiento en Colombia.</h3>
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
		{{-- contact --}}
		<section id="copo-emprendimiento-contact">
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

	</div> {{-- main land --}}
	{{-- Footer --}}
	<footer id="copo-emprendimiento-footer-land" class="footer">
		<div class="copyright-social-footer">
			<div class="row valign-middle">
				<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
					<span class="inst-copyright">Todo el contenido © COPO Software 2017</span>
				</div>
				<div class="mobile-12 tablet-4 columns text-center">
					<a href="#">
	      				<img id="logo-bottom-inst" class="inst-logo-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/copo/emprendimientos/copo-emprendimientos-footer-logo.svg" alt="">
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
</div> {{-- wrapper land --}}

@stop
