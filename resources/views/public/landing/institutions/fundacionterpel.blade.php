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
		@include('public.landing.header')
	<!-- slider -->
		<section id="terpel-slider">
			<figure class="slick-slider-terpel">
				<div class="wrap-img-slider">
					<div class="slider-img img-1920x650-large" id="banner-lanzamiento">
						<a class="button" href="convocatoria/disena-el-cambio-2020">Regístrate</a>
					</div>
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/tablet.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/mobile.png" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-7-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-7-1200x650.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-7-480x650.jpg" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-2-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-2-1200x650.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-2-480x650.jpg" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-3-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-3-1200x650.jpg" alt="">

					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-3-480x650.jpg" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-4-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-4-1200x650.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-4-480x650.jpg" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-5-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-5-1200x650.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-5-480x650.jpg" alt="">
				</div>
				<div class="wrap-img-slider">
					<img class="slider-img img-1920x650-large" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1920x650/terpel-disenaelcambio-slider-6-1920x650.jpg" alt="">
					<img class="slider-img img-1200x650-medium" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/1200x650/terpel-disenaelcambio-slider-6-1200x650.jpg" alt="">
					<img class="slider-img img-480x650-mobile" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/slider/480x650/terpel-disenaelcambio-slider-6-480x650.jpg" alt="">
				</div>
			</figure>
		</section>
		{{-- terpel-about-designforchange --}}
		<section id="terpel-about-designforchange" class="section-land block-vpadding-both">
			<div class="row">
				<div class="medium-12 columns">
					<div class="terpel-dfc-about-head-box text-center">
						<a target="_blank" href="http://www.dfcworld.com">
							<img class="terpel-dfc-logo-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/terpel-designforchange-logo.png" alt="Terpel Design for Change">
						</a>
						<h1 class="title-section-land">HABLEMOS DE <span>DISEÑA EL CAMBIO</span></h1>
					</div>
				</div>
			</div>
			<div class="terpel-dfc-about-content-box">
				<div class="row">
					<div class="mobile-12 tablet-6 tablet-push-6 columns small-only-text-center mobile-only-text-center">
						<p class="title-small about-text">Es el movimiento mundial más grande de estudiantes y  profesores que está transformando el mundo con ideas innovadoras para ayudar a los demás. Surgió en la India en el año <span>2006</span> y hoy está presente en más de <span>65 países</span>.</p>
						<p class="title-small about-text">Gracias a la Fundación Terpel, niños y jóvenes de Instituciones Educativas oficiales, convencidos del poder que les otorga las palabras <span>¡YO PUEDO!</span> han hecho el cambio en sus comunidades para mejorar el bienestar y ayudar a que Colombia sea un mejor país para todos.</p>
						<p class="text-sm about-text">Para mayor información descarga la cartilla docente:</p>
						<a href="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/plegable+fundacion+terpel2019+final.pdf" target="_blank" class="button small sky-blue radius terpel-download-button"><i class="mdi mdi-download gutter-right v-center"></i>CARTILLA DOCENTE</a>
					</div>
					<div class="mobile-12 tablet-6 tablet-pull-6 columns small-only-text-center mobile-only-text-center">
						<div class="flex-video widescreen vimeo about-video">
							<iframe width="560" height="315" src="https://www.youtube.com/embed/6NnhtRjKh2Y?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- terpel-designforchange-program --}}
		<section id="terpel-designforchange-program" class="section-land block-vpadding-both">
			<div class="row">
				<div class="medium-12 columns">
					<div class="terpel-dfc-program-head-box text-center">
						<h1 class="title-section-land">RETO DISEÑA EL CAMBIO 2020</h1>
						<p class="designforchange-program-dates">Fecha de inicio: <span>06 de marzo</span> - Fecha de cierre: <span>16 de octubre</span></p>
						<p class="designforchange-program-text">Invitamos a estudiantes y profesores a compartir su experiencia de diseñar el cambio en su institución, barrio, vereda o ciudad. <span>Participa siguiendo estos 3 pasos:</span></p>
					</div>
				</div>
			</div>
			<div class="block-vpadding-bottom">
				<div class="row">
					<div class="mobile-12 tablet-12 medium-4 columns">
						<ul class="inline-list-grid align-center designforchange-steps-list">
							<li class="has-image">
								<img class="designforchange-steps-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/program-designforchange/designforchange-program-step1.png">
							</li>
							<li>
								<div class="designforchange-steps-text-box step-1-box">
									<span class="dfc-steps-text step-1">Inicia sesión o crea tu cuenta <span>(si no te has registrado)</span></span>
								</div>
							</li>
						</ul>
					</div>
					<div class="mobile-12 tablet-12 medium-4 columns">
						<ul class="inline-list-grid align-center designforchange-steps-list">
							<li class="has-image">
								<img class="designforchange-steps-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/program-designforchange/designforchange-program-step2.png">
							</li>
							<li>
								<div class="designforchange-steps-text-box">
									<span class="dfc-steps-text step-2">Haz clic en el botón <span>"Postula tu proyecto"</span></span>
								</div>
							</li>
						</ul>
					</div>
					<div class="mobile-12 tablet-12 medium-4 columns">
						<ul class="inline-list-grid align-center designforchange-steps-list">
							<li class="has-image">
								<img class="designforchange-steps-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/program-designforchange/designforchange-program-step3.png">
							</li>
							<li>
								<div class="designforchange-steps-text-box">
									<span class="dfc-steps-text step-3">Diligencia 100% el <span>formulario de aplicación</span></span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="terpel-dfc-button-box">
				<div class="row">
					<div class="medium-12 columns">
						<div class="text-center">
							<a target="_blank" href="https://disenaelcambio.fundacionterpel.org/blog/general/como-aplicar-a-disena-el-cambio-2019" class="button medium radius btn-lowerc designforchange-program-button">Ver cómo aplicar</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- stages-designforchange --}}
		<section id="stages-design-for-change" class="section-land block-vpadding-both">
			<div class="row">
				<div class="mobile-12 small-10 medium-9 small-centered columns">
					<div class="text-center stages-dfc-head-box">
						<h2 class="title-section-land">FASES DE LA CONVOCATORIA</h2>
						<p class="stages-designforchange-header-text text-center">Transforma la realidad de tu comunidad y crea un mundo más humano en 4 pasos. ¡Anímate!</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns">
					<ul class="inline-list-grid align-center designforchange-stages-list">
						<li class="has-image">
							<img class="dfc-stages-img-1" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step1-feel.png">
							<img class="dfc-stages-img-2" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step1-feel-2.png">
						</li>
						<li>
							<div class="designforchange-stages-text-box">
								<h4 class="designforchange-stages-head-title stage-1">Siente</h4>
								<p class="designforchange-stages-subtitle">Piensa con el corazón cómo ayudar a los demás</p>
								<p class="designforchange-stages-text">Para poder avanzar es preciso que identifiques qué quieres cambiar y encontrar alternativas de solución.</p>
								<a href="http://disenaelcambio.fundacionterpel.org/blog/general/siente" class="designforchange-stages-link text-left stage1-link">Ver más</a>
							</div>
						</li>
					</ul>
					<ul class="inline-list-grid align-center designforchange-stages-list">
						<li class="has-image">
							<img class="dfc-stages-img-1" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step2-imagine.png">
							<img class="dfc-stages-img-2" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step2-imagine-2.png">
						</li>
						<li>
							<div class="designforchange-stages-text-box">
								<h4 class="designforchange-stages-head-title stage-2">Imagina</h4>
								<p class="designforchange-stages-subtitle">Sueña con un futuro mejor para ti y tu comunidad</p>
								<p class="designforchange-stages-text">Usa el poder más grande que tienes, deja volar tu imaginación.</p>
								<a href="http://disenaelcambio.fundacionterpel.org/blog/general/imagina " class="designforchange-stages-link text-left stage2-link">Ver video</a>
							</div>
						</li>
					</ul>
					<ul class="inline-list-grid align-center designforchange-stages-list">
						<li class="has-image">
							<img class="dfc-stages-img-1" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step3-do.png">
							<img class="dfc-stages-img-2" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step3-do-2.png">
						</li>
						<li>
							<div class="designforchange-stages-text-box">
								<h4 class="designforchange-stages-head-title stage-3">Haz</h4>
								<p class="designforchange-stages-subtitle">Demuestra que todo es posible si lo quieres con el corazón</p>
								<p class="designforchange-stages-text">Trabaja en equipo, consigue apoyo y materializa lo que pensaste.</p>
								<a href="http://disenaelcambio.fundacionterpel.org/blog/general/haz" class="designforchange-stages-link text-left stage3-link">Ver más</a>
							</div>
						</li>
					</ul>
					<ul class="inline-list-grid align-center designforchange-stages-list">
						<li class="has-image">
							<img class="dfc-stages-img-1" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step4-share.png">
							<img class="dfc-stages-img-2" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/stages-designforchange/designforchange-stages-step4-share-2.png">
						</li>
						<li>
							<div class="designforchange-stages-text-box">
								<h4 class="designforchange-stages-head-title stage-4">Comparte</h4>
								<p class="designforchange-stages-subtitle">Contagia a otros con tu entusiasmo: ¡Si yo puedo, tú puedes!</p>
								<p class="designforchange-stages-text">Inspira a otros con tu experiencia, comparte tu historia para que muchos otros digan ¡YO PUEDO!</p>
								<a href="http://disenaelcambio.fundacionterpel.org/blog/general/comparte" class="designforchange-stages-link text-left stage4-link">Ver más</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		{{-- terpel successful projects --}}
		<section id="terpel-successful-projects" class="section-land">
			<div class="row">
				<div class="medium-12 columns">
					<div class="text-center successful-dfc-head-box">
						<h2 class="title-section-land text-center">INSPÍRATE</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="mobile-12 tablet-12 large-6 columns small-only-text-center mobile-only-text-center" style="padding: 0rem 1rem;">
					<div class="flex-video widescreen vimeo dfc-successful-projects-video">
						<img src="" alt="">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/S7G22TOdcxg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
					<h4 class="white-text dfc-successful-projects-text-title">Energía solar eólica como fuentes renovables alternativas</h4>
					<p class="darkgrey-text paragraph-video">Institucion Educativa la Herradura. <br>
						Almaguer, Cauca.</p>
				</div>
				<div id="galery-video" class="mobile-8 mobile-offset-2 tablet-8 tablet-offset-2 large-6 large-offset-0 columns small-only-text-center mobile-only-text-center">
					<div class="">
						<h5 class="subtitle-inspirate" style="margin-bottom: 2rem;">proyectos destacados en la convocatoria 2019</h5>
					</div>
					<div class="row">
						<div class="large-6 columns ">
							<div class="flex-video widescreen vimeo dfc-successful-projects-video">
								<iframe width="200" height="150" src="https://www.youtube.com/embed/m332v_IuTP8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="large-6 columns ">
							<h4 class="white-text dfc-successful-projects-text-title-mini">A qué huele el arte de Maria</h4>
							<p class="darkgrey-text paragraph-video">Institución Educativa para Poblaciones Especiales.<br>
								Sincelejo, Sucre. <br>
								2019.</p>
						</div>
					</div>
					<div class="row">
						<div class="large-6 columns  ">
							<div class="flex-video widescreen vimeo dfc-successful-projects-video">
								<iframe width="200" height="150" src="https://www.youtube.com/embed/GH4fDs2F34o" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="large-6 columns ">
							<h4 class="white-text dfc-successful-projects-text-title-mini">smartplantic</h4>
							<p class="darkgrey-text paragraph-video">Institución Educativa Distrital El Campito <br>
								Barranquilla, Atlántico <br>
								2019</p>
						</div>
					</div>
					<div class="row">
						<div class="large-6 columns">
							<div class="flex-video widescreen vimeo dfc-successful-projects-video">
								<iframe width="200" height="150" src="https://www.youtube.com/embed/IPhoVKM2RBo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="large-6 columns">
							<h4 class="white-text dfc-successful-projects-text-title-mini">empledesepan</h4>
							<p class="darkgrey-text paragraph-video">Institución Educativa San Rafael <br>
								Buenaventura <br>
								2019</p>
						</div>
					</div>


				</div>
			</div>
		</section>
		{{-- terpel designforchange faq --}}
		<section id="terpel-designforchange-faq" class="section-land block-vpadding-both">
			<div class="row">
				<div class="medium-6 columns">
					<div class="terpel-dfc-faq-box">
						<h2 class="title-section-land text-left">PREGUNTAS FRECUENTES</h2>
						<p class="dfc-faq-text title-small">¿Tienes dudas con el reto <span>Diseña el Cambio 2020</span> y el uso de nuestra plataforma?</p>
						<p class="dfc-faq-text title-small">Aquí podrás resolver cada una de ellas.</p>
						<p class="dfc-faq-text title-small">Si tienes una duda o inquietud adicional, escríbenos por el <span><a target="_blank" href="http://ayudadisenaelcambio.coposoftware.com/">botón de ayuda.</a></span></p>
					</div>
				</div>
				<div class="medium-6 columns">
					<div>
						<a href="http://disenaelcambio.fundacionterpel.org/blog/conoce-reto/terminos-y-condiciones" class="dfc-faq-boxes box-arrow program-terms">
							<p class="black-text">¿cuáles son los términos y condiciones de la convocatoria?</p>
						</a>
					</div>
					<div>
						<a href="http://disenaelcambio.fundacionterpel.org/blog/conoce-reto/reconocimientos-y-premios" class="dfc-faq-boxes box-arrow project-evidence">
							<p class="black-text">¿Cuáles son los premios y reconocimientos de la convocatoria?</p>
						</a>
					</div>
					<div>
						<a href="http://disenaelcambio.fundacionterpel.org/aprende/cursos/arte-y-diseno/como-subir-las-evidencias-a-mi-proyecto" class="dfc-faq-boxes box-arrow program-prizes">
							<p class="black-text">¿Cómo subir las evidencias a mi proyecto?</p>
						</a>
					</div>
					<div>
						<a href="http://disenaelcambio.fundacionterpel.org/aprende/cursos/arte-y-diseno/como-subir-el-video-de-mi-proyecto-a-youtube" class="dfc-faq-boxes box-arrow project-upload-video">
							<p class="black-text">¿Cómo subir el video de mi proyecto a YouTube?</p>
						</a>
					</div>
				</div>
			</div>
		</section>
		{{-- terpel stats numbers --}}
		<section id="terpel-stats-numbers" class="section-land">
			<div class="row">
				<div class="medium-12 columns">
					<div class="text-center stats-dfc-head-box">
						<h2 class="title-section-land text-center white-text">DISEÑA EL CAMBIO EN COLOMBIA</h2>
						<p class="title-small head-text">Durante estos 7 años hemos contribuido a un cambio positivo en las diferentes comunidades de Colombia, los niños y jóvenes se han convertido en personas líderes, brindando soluciones de desarrollo e innovación a diferentes problemáticas de su entorno.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
					<ul class="mobile-block-grid-1 tablet-block-grid-2 medium-block-grid-4">
						<li>
							<div class="dfc-colombia-stats-boxes icon-mapmarker">
								<h6 class="dfc-colombia-stats-number white-text">32</h6>
								<span class="dfc-colombia-stats-item white-text text-center">DEPARTAMENTOS</span>
							</div>
						</li>
						<li>
							<div class="dfc-colombia-stats-boxes icon-projectsboard">
								<h6 class="dfc-colombia-stats-number white-text">723</h6>
								<span class="dfc-colombia-stats-item white-text text-center">PROYECTOS<br> IMPLEMENTADOS</span>
							</div>
						</li>
						<li>
							<div class="dfc-colombia-stats-boxes icon-teaching">
								<h6 class="dfc-colombia-stats-number white-text">10.547</h6>
								<span class="dfc-colombia-stats-item white-text text-center">DOCENTES</span>
							</div>
						</li>
						<li>
							<div class="dfc-colombia-stats-boxes icon-study">
								<h6 class="dfc-colombia-stats-number white-text">334.241</h6>
								<span class="dfc-colombia-stats-item white-text text-center">ESTUDIANTES</span>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</section>
		{{-- Objetivo diseña el cambio --}}
		<section id="terpel-dfc-objective" class="section-land block-vpadding-both">
			<div class="block-vpadding-top">
				<div class="row">
					<div class="medium-6 medium-centered columns">
						<div class="text-center block-vpadding-top">
							<h2 class="title-section-land">DISEÑA EL CAMBIO</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="medium-10 medium-centered columns">
						<div class="text-center">
							<h3 class="dfc-objective-subtitle text-center">COMPROMETIDO CON LOS OBJETIVOS DEL DESARROLLO SOSTENIBLE</h3>
							<a target="_blank" href="http://www.un.org/sustainabledevelopment/es/objetivos-de-desarrollo-sostenible/">
								<img class="text-center" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/terpel/disenaelcambio-2018/dfc-desarrollo-sostenible-logo.png" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		{{-- Footer --}}
		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.sitemap')
			{{-- Social and copyright footer --}}
			<div class="copyright-social-footer">
				<div class="row valign-middle">
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
						<span class="inst-copyright">Todo el contenido &copy; {{ $institution->nombre_institucion }} {{ date('Y') }}</span>
					</div>
					<div class="mobile-12 tablet-4 columns text-center">
						{!! HTML::image((isset($parameters['imagen_footer']) ? $parameters['imagen_footer'] : Config::get('tuproyecto.logo')), 'Logo', array('id' => 'logo-bottom-inst')) !!}
					</div>
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-right">
						<ul class="list-social-footer text-small-right text-mobile-center">
							<li>
								<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
									<i class="mdi mdi-facebook"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
									<i class="mdi mdi-close-outline"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
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

