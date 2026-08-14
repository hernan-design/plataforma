@extends('public.help.help')

@section('help.content')

	<div class="help-banner">
		<div class="row">
			<div class="mobile-12 small-6 columns">
				<h3 class="help-title mobile-only-text-center small-only-text-center">Preguntas frecuentes</h3>
				<p class="mobile-only-text-center small-only-text-center">Resuelve tus dudas en este espacio</p>
			</div>
			<div class="mobile-12 small-6 columns">
				<div class="text-center">

					<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/coomeva/help/help-banner-img.png" alt="">
				</div>
			</div>
		</div>
	</div>
	<div class="help-menu">
		<div class="row">
			<div class="mobile-12 columns">
				<div class="help-tabs-answers-container">
					<div id="help-submenu-tabs" class="clearfix">
						<ul id="help-tabs-filter" class="tabs-sub-nav tabs inline-list-items mobile-only-text-center small-only-text-center" data-tab>
							<li class="tab-title active">
								<a href="#help-content">Contenido</a>
							</li>
							<li class="tab-title">
								<a href="#help-platform">Plataforma</a>
							</li>
						</ul>
					</div>
					<div class="text-center tablet-text-right help-answers-action">
						<ul class="inline-list-grid vcenter">
							<li class="text-sm">¿No has encontrado la solución a tus preguntas?</li>
							<li>
								<a href="http://www.coomeva.com.co/ss/coomeva/digital/contactenos.html" class="button sky-blue xtiny expand radius btn-clean-margin">Contáctanos aquí</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tabs-content">
		<div id="help-content" class="content help-answers active">
			{{-- <div class="row">
				<div class="small-12 columns">
					<p class="block-text-medium">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
				</div>
			</div> --}}
			<div class="row">
				<div class="small-12 columns">
					<ul class="collapsible no-bullet" data-collapsible="accordion">
						<li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Comunidad
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item active">
												<div class="collapsible-header">¿Cómo me suscribo a algún círculo de profesionales?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Para suscribirte a alguno de los círculos de profesionales debes seguir estos pasos:</p><p>1. Ingresar a Red de profesionales Coomeva.</p><p>2. En el módulo Comunidad ubícate en la parte izquierda superior y elige el círculo de profesionales al cual perteneces o de los cuáles desees recibir información.</p><p>3. Suscríbete haciendo click.</p><p>4. Del mismo modo puedes retirarte del círculo escogido haciendo click.</p><p>¡Feliz día!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿A cuántos círculos me puedo suscribir?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Lo Ideal es que selecciones el círculo de tu preferencia sobre el cual te interese recibir información permanente. Sin embargo actualmente la plataforma te permite realizar la suscripción a los círculos que desees.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo hago para dejar de pertenecer a un círculo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Para dejar de pertenecer a alguno de los círculos de profesionales debes seguir estos pasos:</p><p>1. Ingresa a Red Coomeva.</p><p>2. En el módulo Comunidad ubícate en la parte superior izquierda y elige el círculo al cual no deseas pertenecer. </p><p>3. Suscríbete o cancela tu suscripción haciendo clic. Quedamos pendientes, recuerda que estamos aquí para ayudarte.¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo accedo a los módulos de Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Si quieres acceder a los módulos de Red Coomeva, sigue estos pasos:</p><p>1. Ingresa a www.redcoomeva.com.</p><p>2. Desde el Módulo Comunidad, en la parte superior derecha  encontrarás un ícono de 3 líneas, dando clic en este podrás acceder a los diferentes módulos de Red Coomeva. ¿Qué esperas para empezar a disfrutar?</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo publico en el módulo Comunidad de Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Para publicar en el módulo de Comunidad, debes:</p><p>1.Ser asociado a Coomeva.</p><p>2. Iniciar sesión en la plataforma.</p><p>3. En la parte superior de columna del medio del módulo Comunidad encontrarás la posibilidad de publicar un post, una foto o un evento y compartirlo con tus pares.</p><p>¡Asóciate y empieza a disfrutar de este y muchos más beneficios para ti y tu familia! Feliz tarde.</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué puedo publicar en el módulo Comunidad de Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Para nosotros es un gusto poder contar con tu presencia en  Red Coomeva. Te informamos que en el módulo Comunidad puedes publicar información útil para los asociados que hacen parte de tu círculo de profesionales, realizar preguntas o compartir tu conocimiento, también puedes dar tu opinión de forma respetuosa, ofrecer tus productos o servicios.</p><p>Esperamos haber aclarado tu pregunta. ¡Feliz tarde! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué encuentro en el módulo Comunidad de Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Déjanos contarte que en el módulo Comunidad podrás encontrar un poco de todos los módulos que componen la plataforma, tales como el Foro, El Blog y algunos de los Eventos programados de acuerdo al círculo al cual has elegido pertenecer. Desde este módulo puedes publicar para tus pares, ofrecer tus productos o servicios, entre otros.</p><p>¡Feliz día! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Quién puede comentar sobre lo que yo escribo en Comunidad?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Te informamos que los asociados pertenecientes al  círculo al que indicaste pertenecer o de los que indicaste desear recibir información, pueden comentar sobre lo que escribes en la red.</p><p>¡Feliz tarde! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Dónde puedo leer las normas o reglas para saber cómo comportarme en la Red?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Ingresa en el siguiente enlace <a href="https://redcoomeva.com/terminos">https://redcoomeva.com/terminos</a> y conoce los Términos y Condiciones de Uso de la plataforma. Recuerda que si te surgen más preguntas aquí estamos para ayudarte a resolverlas.</p><p>¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué tipo de temas puedo tocar en este espacio, tengo alguna restricción?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Tal como lo manifestamos en nuestros Términos y Condiciones de uso de la plataforma <a href="https://redcoomeva.com/terminos">https://redcoomeva.com/terminos</a>no se permite tocar temas relacionados con política, sexualidad o religión, dañen el buen nombre de una persona, o que de una u otra forma generen controversia entre los asociados.</p><p>Esperamos haberte aclarado tu pregunta.</p><p>¡Feliz tarde! </p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Eventos
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿A dónde puedo dirigirme para averiguar sobre el descuento en los eventos en caso de no quedarme claro?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola!, Comúnicate a la Línea fija nacional: 01 8000 950123 o desde tu móvil #464 donde podrás recibir asesoría completa del descuento de cada uno de los Eventos que se encuentran en Red Coomeva y así puedas actualizarte profesionalmente. Recuerda que si surge alguna otra pregunta, estamos aquí para ayudarte a responderla.</p><p>¡Feliz día! </p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué hago si por algún motivo cancelan alguno de los Eventos y ya pagué, a dónde me dirijo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>En caso de alguno de los Eventos publicados en Red Coomeva sea cancelado de forma inesperada y previamente pagado por ti, debes comunicarte con Línea fija nacional: 01 8000 950123 o  desde tu móvil: #464  donde recibirás toda la información necesaria para ayudarte a resolver tu situación.</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Puedo dar mi opinión sobre el Evento?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Claro que sí, nos encanta conocer tu opinión, ya que sabemos que nos ayuda a mejorar cada vez más. Puedes proporcionárnosla en el espacio de Comentarios que encuentras en el Módulo Eventos de Red de profesionales Coomeva.</p><p>¡Feliz día!</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Convocatorias
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué tipo de Convocatorias puedo encontrar en Red de profesionales Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>

												<div class="collapsible-body">
													<p>¡Hola! Diferentes convocatorias de interés profesional y empresarial por lo que los invitamos a estar atentos a la actividad de este modulo.</p><p>¡Feliz día!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Como asociado que usa la plataforma puedo crear una Convocatoria?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que al momento las Convocatorias solo son creadas por el equipo de Red Coomeva y no se encuentran abiertas a ser creadas por los asociados.</p><p>¡Feliz día!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuántas categorías de empresas hay para participar en Galardón?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que al momento Galardón Coomeva maneja ocho categorías de empresas bajo las cuales puedes postular la tuya. ¡No te quedes sin participar!</p><p>Feliz día.</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Proyectos
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Solo puedo estructurar mi proyecto o idea de negocio con base en el modelo Canvas que ustedes proponen?
													<i class="right mdi mdi-chevron-right"></i>
												</div>

												<div class="collapsible-body">
													<p>¡Hola! Despues de probar varias herremientas para diseño de modelos de negocio, hemos encontrado que el Modelo Canvas es el mas sencillo y practico, lo cual caracteriza nuestros procesos. Por ello es el Modelo recomendado por nosotros. ¡Empieza ahora y descubre cómo hacerlo realidad!</p><p>Feliz día.</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué tipo de proyectos NO puedo poner en este módulo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que el Grupo Coomeva se abstiene de apoyar proyectos relacionados con compra y venta de licores, bares o establecimientos de placer como moteles, entre otros.</p><p>¡Feliz tarde!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué tipo de idea de negocio puedo poner en este módulo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! En el módulo de proyectos es posible visibilizar todos aquellos proyectos o ideas de negocio que no estén relacionados con negocios de lenocinio, bares, ventas de licores o establecimeintos de placer, tipo moteles. Para mayor información puede consultar nuestros Términos de uso y Polítics  de la Plataforma ingresando en el siguiente enlace: <a href="https://redcoomeva.com/terminos">https://redcoomeva.com/terminos</a></p><p>¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué requisitos debo cumplir para tener un proyecto en Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Para hacer realidad tu idea de negocio o tu proyecto, debes como requisito mínimo hacer parte de la Cooperativa de Coomeva, de este modo podrás recibir  Mentorías de especialistas, los cuales están comprometidos en guiarte y aclarar tus dudas, en la fase que este se encuentre. ¡No dejes pasar esta oportunidad! Comunícate con alguno de nuestros asesores para que te vincules a Línea fija nacional: 01 8000 950123 Desde tu móvil: #464</p><p>Feliz día. :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué personas pueden leer mi proyecto?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Queremos informarte que solo los usuarios tienen acceso al modulo "Proyectos",  ellos tendran la posibilidad de ingresar y ver informacion referente a los proyectos creados por los demas miembros de la comunidad .</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Mi proyecto corre peligro de ser copiado por algún usuario o tercero inescrupuloso?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Al momento de iniciar el proceso de creación de tu proyecto o idea de negocio en el Modulo Crear Entidad y visibilizarlo por medio del Módulo Proyectos es importante haberlo registrado como propio en :</p><p>1. La dirección nacional de derechos de autor: <a href="http://derechodeautor.gov.co/registro-de-obras1">http://derechodeautor.gov.co/registro-de-obras1</a> </p><p>2. Superintendencia de Industria y Comercio: <a href="http://www.sic.gov.co/marcas">http://www.sic.gov.co/marcas</a> De acuerdo a la naturaleza de tu idea de proyecto o negocio registralo antes de iniciar el proceso y evita que sea copiado por algún tercero inescrupuloso. Recuerda que si tienes alguna pregunta, aquí estamos para ayudarte a responderla.</p><p>¡Feliz tarde! :)</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Foro
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Para qué sirve el Foro de Red de de profesionales Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>

												<div class="collapsible-body">
													<p>¡Hola! El espacio del Foro de Red de profesionales Coomeva es un espacio que invita al diálogo e intercambio de ideas sobre distintos temas. Aquí podrás dar tu opinión o responder de acuerdo a tu conocimiento o experiencia, hacer recomendaciones, entre otras, siempre y cuando estas se realicen en el marco del respeto para con los demás asociados.</p><p>¡Feliz día!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué tipo de temas se manejan en el Foro de Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Al momento los dos principales ejes temáticos que pueden encontrarse en el Foro de Red Coomeva, giran entorno a Desarrollo empresarial en Colombia.Tú también puedes proponer temas que puedan desarrollarse entre los asociados en este espacio.</p><p>¡Feliz día!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué está permitido decir y qué no?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! En el Foro de Red  Coomeva, es posible tratar temas de interés para ti y para  los demás asociados, los cuáles sean capaces de generar conversación y arrojen claridad conceptual. No está permitido tocar temas políticos, de orden sexual o religioso que susciten polémicas. ¡Anímate a compartir tus preguntas o temas este espacio especialmente creado para ti!</p><p>Feliz día. :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo puedo participar en el Foro?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Para participar en el Modulo Foro debes ser asociado a Coomeva. Por otro lado debse ingresar al menu en  donde tendras la oportunidad de parcipar comentando temas previamente creados por otros usuarios, podrás visualizar los temas de tu interes filtrando las diferentes categorias con las que cuenta el modulo, también podrás crear temas de discucion ingresando en el botón "Crear un tema" en la parte superior del modulo, debes crear un título para el tema una descripción, seleccionar la categoria a la cual se va a dirigir etc, para finalizar tendras la opcion de colocar tags al tema creado.</p><p>¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Se pueden vender cosas o poner avisos comerciales en el Foro?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Queremos informarte que el Modulo Foro fue creado con el objetivo que los asociados que ingresan a la plataforma puedan crear temas de discusión o participar en ellos, la estructura del modulo y creacion de temas no se adapta para la creacion de productos u ofertas, sin embargo los usuarios asociados al tener la oportunidad de crear temas es posible que creen uno anunciando un producto o realizando algun tipo de publicidad.</p><p>¡Feliz tarde! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué hago si hay algún usuario grosero o acosador?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te invitamos a que ingreses en el siguiente enlace donde podrás compartirnos tus Peticiones, Quejas, Reclamos y Sugerencias: Línea fija nacional: 01 8000 950123</p><p>Desde tu móvil: #464</p><p>Te ayudaremos agestionar la situación. </p><p>¡Feliz día!</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Aprende
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuántas veces puedo acceder a los cursos on line, conferencias o webinars?
													<i class="right mdi mdi-chevron-right"></i>
												</div>

												<div class="collapsible-body">
													<p>¡Hola! Puedes acceder a los artículos especializados, cursos online, y conferencias, cuantas veces desees, siempre y cuando se encuentren dentro de Red Coomeva o dentro de la plataforma Unipymes. Todos aquellos Talleres o Cursos que se encuentren fuera de la plataforma o sean modo presencial no tienen libre acceso y se encuentran sujetos a cambios por el organizador. Esperamos haberte ayudado a responder tu pregunta.</p><p>¡Feliz día! </p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Cada cuánto sacan nuevos cursos?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Permanentemente en la plataforma podrás encontrar nuevos programas de interés. Te invitamos a que permanezcas muy atento.</p><p>¡Feliz tarde! :)</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Puedo parar una conferencia y verla luego en Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Claro que sí, puedes empezar una Conferencia dentro de Red Coomeva y detenerla de ser necesario ya que está pensada como virtual para que seas tú quien decida el tiempo que puede dedicarle. Es importante que puedas retomarla hasta terminarla y de este modo puedas tener completamente claros los temas y nosotros podamos garantizar tu formación.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Quién me puede dar información sobre horarios, fechas y lugar de Conferencias,Talleres Cortos o Diplomados, que enlazan a otro sitio web?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola Te informamos que para recibir información ampliada sobre horarios, fechas y lugar de las Conferencias, Talleres Cortos o Diplomados que se enlazan con otros sitios web, debes comunicarte a Línea fija nacional: 01 8000 950123</p><p>Desde tu móvil: #464</p><p>¡Feliz tarde! </p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Crear Entidad
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo puedo acceder a una consultoria empresarial?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Debes realizar tu solicitud a través de nuestro formulario web  http://fundacion.coomeva.com.co/publicaciones.php?id=43771, o acercandote a nuestras oficinas Coomeva Fundación, para iniciar todo tu estudio de crédito.</p><p>¡Hazlo ahora!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿ La consultoria empresarial tiene algún costo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Sí, y se calcula conforme a las necesidades de intervención en cada uno de los procesos de consultoria.</p><p>¡Solicita tu cotización ahora!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuáles son las ventajas de adquirir una consultoria?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! A continuación te compartimos nuestros principales compromisos:</p><p>1.  Ofrecer a nuestros asociados servicios orientados a procesos de cambio para el mejoramiento de las organizaciones en uno o varios campos de la actividad empresarial.</p><p>2.Calidad en la prestación del servicio, gracias al profesionalismo de nuestros consultores.</p><p>3.Confidencialidad de la información entregada por nuestros empresarios.</p><p>4.Trabajo en equipo con nuestros emprendedores para el desarrollo de ideas nuevas e innovadoras que permitan llevar a las empresas a un mejor futuro.</p><p>5.Objetividad y claridad en las recomendaciones ya que aportamos una visión imparcial y externa de tu empresa.</p><p>6.Encontramos respuesta a cuestiones que el día a día no deja tiempo para analizar y resolver. ¡Solicita ahora tu consultoría y fortalece tu negocio! </p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿En qué etapa puedo adquirir un proceso de consultoria?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Nuestro servicio de Consultoría Empresarial está diseñado a la medida de tus necesidades, para realizar modelos de empresa e identificar oportunidades de mejora de la mano de nuestros consultores empresariales, con asesorías personalizadas y apropiadas para cada etapa de tu empresa. ¡Pregúntanos por la tuya ahora!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿ Qué tipo de especialidad tienen los consultores?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Queremos contarte que nuestros consultores empresariales cuentan con experticia en áreas tales como: Administración, Mercadeo, RRHH, Comercial, Financiera, Operativa, Jurídica, entre otras.</p><p>¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿ El consultor podrá compartir mi idea de negocio con otros asociados?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! No, existe un acuerdo de confidencialidad por parte del consultor, en cada proceso de consultoria que se maneje a través de Coomeva Fundación.</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿ El diágnostico empresarial tiene algún costo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! El diagnostico empresarial en la ciudad de Cali si genera un costo, para las demás ciudades a nivel nacional es gratuito. Para conocer más te invitamos a conocer más te invitamos a contactarnos.</p><p>¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿ Cuánto tiempo puedo durar un proceso de consultoría empresarial?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que no existe un tiempo estandarizado, el tiempo de cada proceso de consultoria es acorde a las necesidades de de intervención de cada uno de las empresas y sus empresarios.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿ Si no me encuentro satisfecho con los resultados de la consultoria empresarial, hay devolución del dinero?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Si el asociado manifiesta insatisfacción en el resultado del proceso de consultoria, se inicia un proceso de evaluación del mismo, si se concluye que no fue satisfactorio, se procede con el reembolso del dinero.</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Mentorias
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿ Mi idea de negocio o proyecto empresarial se encontrará seguro con el Mentor?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Claro que si,  dentro de las políticas del programa, existe un acuerdo de confidencialidad para que los mentores brinden procesos de mentorias a través de Coomeva Fundación.</p><p>¡Feliz día! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuánto tiempo se puede demorar mi mentor en responder a mis consultas?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Queremos informarte que como plazo máximo de respuesta a tus requerimientos,  tu mentor cuenta con 3 días hábiles. En caso de que tu mentor no se comunique contigo, puedes dirigir tu sugerencia o comentario Línea fija nacional: 01 8000 950123 o Desde tu móvil: #464</p><p>¡Feliz día! </p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Mi mentor puede solicitarme dinero  para asesorarme?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que bajo ningún concepto tu mentor cuenta con la autorización o aval del Grupo Coomeva para solicitarte dinero, ya que nuestro servicio de mentorías especializadas es gratuito. Esperamos haberte sido de ayuda con nuestra respuesta.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿El mentor puede atender mis consultas por fuera de la plataforma dándome una cita aparte?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Nos encanta saber que adelantas tu proyecto o idea de negocio con nosotros. Te informamos que es por medio de la plataforma que el mentor está avalado para atender tus consultas.</p><p>¡Feliz tarde! :)</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué hago si mi mentor no me contesta?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Si al cabo de 3 días tu mentor no te responde, comunícate a la Línea fija nacional: 01 8000 950123 o Desde tu móvil: #464  aquí podremos brindarte la información necesaria para que aclares tus dudas y para que tus consultas sean contestadas lo más pronto posible.</p><p>¡Feliz día! </p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
                        <li class="collapsible-question-group">
							<div class="collapsible-header group">Módulo Blog
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué temas trata el blog?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que en el Blog de Red Coomeva se tocan temas enfocados en los intereses de cada uno de los cinco círculos de profesionales también temas de desarrollo empresarial y de interés general.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Puedo escribir para el blog?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Claro que sí, Red Coomeva es un espacio en el que puedes escribir y ser publicado. Sigue los pasos a continuación:</p><p>1. Escribe tu artículo en Red de profesionales Coomeva.</p><p>2. Móntalo a Red Coomeva.</p><p>3. Tu artículo será evaluado por el Comité Editorial de la plataforma y aprobado o rechazado según su pertinencia.</p><p>¡Feliz tarde! </p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuáles son los requerimientos para que un artículo sea aprobado en el blog?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te informamos que para que un artículo sea aprobado en el Blog de Red  Coomeva, debe cumplir con los siguientes requerimientos:</p><p>1. Debe tener una extensión mínima de una cuartilla y media.</p><p>2. Debe tratar un tema relacionado con el círculo de profesionales al cual perteneces o sobre desarrollo empresarial</p><p>3. Debe tener buena ortografía</p><p>4. Debe responder a la estructura de: Título, Subtitulo, Introducción, Cuerpo de texto, Conclusión o cierre, debe por último, contar con fuentes confiables que sustenten tus planteamientos.Quedamos atentos por si surgen nuevas dudas en el camino.</p><p>¡Feliz día!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cuáles son los requisitos para empezar a escribir para el blog de Red Coo?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Nuestro único requisito para que  es que seas un asociado a Coomeva y te guste escribir. Descubre cómo vincularte comunicándote a Línea fija nacional: 01 8000 950123 </p><p>Desde tu móvil: #464</p><p>¡Feliz día! :)</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="help-platform" class="content help-answers">
			{{-- <div class="row">
				<div class="small-12 columns">
					<p class="block-text-medium">
						Nullam metus urna, porta et nulla sed, pellentesque hendrerit leo. Nulla facilisi. Phasellus volutpat, velit vitae rutrum hendrerit, nisl diam ultricies metus, et accumsan ipsum.
					</p>
				</div>
			</div> --}}
			<div class="row">
				<div class="small-12 columns">
					<ul class="collapsible no-bullet" data-collapsible="accordion">
						<li class="collapsible-question-group">
							<div class="collapsible-header group">Preguntas Frecuentes Red Coomeva
								<i class="right mdi mdi-chevron-right"></i>
							</div>
							<div class="collapsible-body">
								<div class="row">
									<div class="small-12 columns">
										<ul class="collapsible" data-collapsible="accordion">
											<li class="collapsible-list-item active">
												<div class="collapsible-header">¿Qué es  Red Coomeva?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola, gracias por comunicarte con nosotros! Te informamos que Red  Coomeva, es la red de profesionales, técnicos, tecnólogos y empresarios asociados a Coomeva.  En este espacio podrás encontrar artículos de interés, cursos y seminarios de actualización profesional, puedes crear tu proyecto o idea de negocio; recibir asesoría de mentores especializados y hacer tu propia red de networking. ¿Qué esperas para empezar a participar? ¡Feliz día!.</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Existe el anonimato en esta Red?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Esperamos que estés muy bien. Te informamos que cada uno de los asociados que deseen ingresar a la plataforma, debe de realizar el registro diligenciando cada uno de los campos solicitados, de esta manera tendrás un perfil que te identificará. De acuerdo a esto el anonimato no existe. ¡Feliz tarde!</p>
												</div>
											</li>
											<li class="collapsible-list-item">
												<div class="collapsible-header">¿Qué hacer ante situaciones de acoso en caso de presentarse en esta Red?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Nos encanta saber que haces parte de Red de profesionales Coomeva, si en algún momento ocurre algún incidente que te gustaría compartirnos puedes hacerlo ingresando a <a rel="" href="https://goo.gl/dY2vBx">https://goo.gl/dY2vBx</a>, en este espacio podremos ayudarte a gestionar tus peticiones, quejas, reclamos y sugerencias. Quedamos atentos para atenderte lo más pronto posible. ¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header">¿Cómo se debe tratar la información privada (fotos, videos…) en esta Red?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te invitamos a que conozcas nuestra ley de protección de datos en el siguiente enlace y puedas despejar todas tus dudas: https://goo.gl/4iScpr Quedamos atentos. ¡Feliz tarde!</p>
												</div>
											</li>
                                            <li class="collapsible-list-item">
												<div class="collapsible-header"> ¿Cómo proteger la privacidad en esta Red?
													<i class="right mdi mdi-chevron-right"></i>
												</div>
												<div class="collapsible-body">
													<p>¡Hola! Te invitamos a que conozcas nuestra ley de protección de datos en el siguiente enlace y puedas despejar todas tus dudas:  <a rel="" href="https://goo.gl/4iScpr">https://goo.gl/4iScpr</a>¡Feliz tarde!</p>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@stop
