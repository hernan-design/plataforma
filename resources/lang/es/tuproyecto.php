<?php

return [
	'mail.empodera2020.body' => 'Estimado emprendedor, </br>
	Confirmamos que tu postulación ha sido recibida. <br><br> Próximamente nos pondremos en contacto contigo para comunicarte el resultado de la evaluación.
	<br><br>
	Gracias por tu interés en ser parte de EMPODERA. ¡Eres el motor de nuestra organización!',
    'register' => [
		'principalbutton' => 'Regístrate',
		'adviselogin' => [
			'text' => 'Si ya te has registrado antes,',
			'button' => 'Inicia sesión'
		],
		'invitation' => '<p class="text-center lighter-text gray-base-text">Para ser parte de <span class="sky-blue-text bold-text">:institution</span>, debes completar un registro y recibir confirmación.</p>'
	],

	'myprojects' => 'Mis emprendimientos',
	'surveys' => 'Encuestas',
	'conversations' => 'Conversaciones',
	'documents' => 'Documentos',

	// Menu
	'menu' => [
		'evaluations' => 'Evaluar emprendimientos'
	],

	// Steps
	'steps' => [
		'entity' => [
			'title' => 'Crea una entidad',
			'description' => 'Si tienes una empresa o un proyecto de emprendimiento, puedes empezar a crearlo ahora. Si no, puedes omitir este paso y crearlo después.'
		],
		'channels' => [
			'description' => 'Los canales son espacios que están diseñados para segmentar el contenido y los intereses de los usuarios. Selecciona los canales que te generen interés y obtendrás contenido segmentado.'
		],
		'terms' => [
			'text' => 'Acepto los <a href=":terms" target="_blank" class="sky-blue-text bold-text">Términos de Uso</a> y las <a href=":privacy" target="_blank" class="sky-blue-text bold-text">Políticas de Privacidad</a>',
			'intro' => 'Valoramos tu privacidad como si fuera la nuestra.<br>Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de :institution.'
		]
	],

	// Forms
	'forms' => [
		'nextpage' => 'Siguiente'
	],

	// Convocatorias
	'programs' => [
		'apply' => 'Participa',
		'postregister' => 'El proyecto <strong class="dark-text">:project</strong> ya se encuentra inscrito en esta convocatoria.',
		'postregisterapply' => 'El proyecto <strong class="dark-text">:project</strong> ya se encuentra inscrito en esta convocatoria. <br>Solo podrás volver a aplicar a esta convocatoria desde el <strong class="dark-text">:next</strong>.',
		'validation_id' => 'El usuario con identificación <strong class="dark-text">:id</strong> ya se encuesta registrado en esta convocatoria<br>Recuerda que para esta convocatoria solo se permite una postulación por usuario.',
		'registered' => 'Ya estas inscrito en esta convocatoria',
		'message' => '<p>Selecciona la categoría que mejor se adapte a tu emprendimiento.</p>',
		'cancelregistration' => 'Cancelar inscripción',
		'choose' => 'Selecciona tu <strong class="dark-text">Proyecto</strong>, <strong class="dark-text">Grupo</strong> o <strong class="dark-text">Empresa</strong> creados anteriormente. Si no cuentas con ninguna de las opciones anteriores, debes crear una haciendo click en el botón “más” (+).',
		'discussions' => 'Discusiones',
		'description' => 'Descripción',
		'descriptionprogram' => 'Descripción de la convocatoria',
		'mterms' => 'Para participar en esta convocatoria debes aceptar los términos y condiciones bajo los cuales confirmas que estás de acuerdo con los mecanismos empleados para recolectar información, su uso y los procesos establecidos para tratar dicha información.',
		'terms' => 'Términos',
		'termsprogram' => 'Términos de la convocatoria',
		'attached' => 'Anexos',
		'step1' => 'Selección convocatoria',
		'step2' => 'Aceptación de términos',
		'step3' => 'Datos básicos',
		'step4' => 'Información complementaria',
		'program' => 'Convocatoria',
        'title' => 'Convocatorias',
        'subheader'=>'Encuentra tus convocatorias aquí',
		'closed'=>'Convocatoria cerrada',
		'open'=>'Convocatoria <span class="success-text">abierta</span>',
		'closedmessage'=>'Esta convocatoria se encuentra cerrada.',
		'notallowedmessage'=>'No puedes participar en esta convocatoria',
		'selectprogram' => 'Elige un proyecto',
		'uploadimgprogram' => 'Cambiar imagen.'
	],

	// Entidades
	'entities' => [
		'entity' => 'Entidad',
		'create' => 'Registro de entidad',
		'submit' => 'Crear',
		'see' => 'Ver entidad',
		'mycontent' => 'Mi contenido',
		'main' => 'Proyectos',
		'remove' => 'Eliminar emprendimiento',
        'businessmodel' => 'Modelo de negocio',
        'createentity' => 'Crear emprendimiento',
		'title' => 'Entidades',
		'placecholder' => 'Selecciona una entidad',

		'project' => [
			'required' => '',
			'error_industry' => '',
			'error_stage' => '',
			'description' => 'Descripción general',
			'stage' => 'Etapa',
			'category'=>'Categoría',
			'industry' => 'Industria',
			'appointment' => 'Cargo',
			'placeholder' => [
				'description' => 'Describe tu proyecto',
				'stage' => 'Selecciona etapa',
				'category' => 'Selecciona categoría',
				'industry' => 'Selecciona industria',
				'city' => 'Selecciona ciudad'
			],
            'conversations' => 'Conversaciones',
            'documents' => [
                'title' => 'Documentos',
                'description' => 'En esta sección podrás subir imágenes y documentos que complementen la información de tu proyecto.'
            ],
			'creator' => 'Creador',
			'city' => 'Ciudad',
			'city_entrepreneurship' => 'Ciudad'
		],

		'company' => [
			'stage' => 'Etapa',
			'industry' => 'Industria',
			'nit' =>  'Número de identificación',
			'covering' =>  'Cubrimiento',
			'society_type' => 'Tipo sociedad',
			'cellphone' =>  'Número de whatsapp',
			'placeholder' => [
				'industry' => 'Selecciona industria',
				'stage' => 'Selecciona etapa',
			    'covering' => 'Seleccione cubrimiento',
				'society_type' => 'Seleccione tipo sociedad',
			]
		],

		'filters' => [
			'project' => 'Nombre del proyecto'
		]
	],

	// Evaluaciones
	'evaluations' => [
		'title' => 'Evaluación de emprendimientos',
		'titlesurvey' => 'Aplicación',
		'titlecomment' => 'Comentario',
		'success' => '¡Gracias! Tu evaluación ha sido registrada exitosamente.',
        'return' => 'El proyecto fue devuelto debido a inconsistencias en la información o a que este se encontraba incompleto y se ha borrado de la lista de proyectos a evaluar. El usuario ha sido notificado.',
        'typeevaluationcommentpurchaser'=>"¿Recomienda los servicios prestados por el asesor a otro empresario?",
        'typequalitycommentpurchaser'=>'¿El producto o servicio que adquirió cumplió con las expectativas?',
		'terms' => [
			'title' => 'Términos y Condiciones.',
			'link' => 'Acepto <a href=":route" target="_blank" class="sky-blue-text bold-text">Términos y Condiciones</a> de evaluador.',
			'error' => 'Debes aceptar los terminos y condiciones.'
		],
		'emails' => [
			'returned' => [
				'subject' => 'Conoce los resultados de tu aplicación'
			]
		]
	],

	// Mentorias
	'mentoring' => [
		'subjectAcceptMentoring' => 'Asignación Mentoría :institution',
		'subjectAcceptMentoringEntrepreneur' => 'El emprendedor  :nameEntrepreneur ha aceptado lo realizado en una sesión de mentoría',
		'subjectFinishedMentoring' => 'El mentor :nameMentor ha finalizado una sesión de mentoría',
		'subjectEvaluateMentor' => 'Evalua a tu mentor',
		'subjectRefuseMentoting' => 'Solicitud de mentoría rechazada',
		'slcStage' => 'Etapa',
		'processWith' => 'Proceso de mentoria con:',
		'endProcess' => 'Finalizar proceso de mentoria',
		'evaluateTo' => 'Mentor',
		'evaluateEntrepreneurship' => 'Emprendedor',
		'requestEntrepreneurship' => 'Emprendimientos',
		'chooseEntrepreneurship' => 'Elije tu emprendimiento',
		'mentoring' => 'Mentorías',
		'mentor-role' => 'Tu rol es mentor',
		'newRequestProcess' => 'Nueva solicitud de mentoría',
		'entrepreneurship-role' => 'Tu rol es emprendedor',
		'requestProcess' => 'Solicitar Proceso de Mentoría',
		'entrepreneurship' => 'Emprendimiento',
		'active' => 'Mentorías activas',
		'request' => 'Solicitudes de Mentoría',
		'invitation' => 'Aún no eres mentor. <a href=":route" class="button xtiny sky-blue radius btn-shadow btn-lowerc btn-clean-margin">Conviértete en mentor</a> y obtén beneficios apoyando a emprendedores a lograr sus metas.',
		'title' => 'Mentorías',
		'tabMentor' => 'Mentores',
		'tabProcess' => 'Procesos de mentoria',
		'create' => [
			'experience' => 'Mi experiencia',
			'select' => 'Elige un proyecto',
			'specialties' => 'Especialidades (áreas de experiencia)',
			'sectors' => 'Sectores Económicos (industrias)',
			'attached' => 'Adjunto Hoja de vida',
			'terms1' => '<span>Acepto los</span>',
			'terms2' => '<span>de mentoría de la plataforma.</span>'
		],
		'confirmation' => [
			'end' => 'Recuerde que solo se puede finalizar si es la última asesoría/mentoría del proceso',
			'accept' => 'Estas aceptando la mentoria',
			'refuse' => 'Estas rechazando la mentoria'
		],
        'notification' => 'Tu solicitud ha sido enviada al mentor :mentor para su valoración y aprobación, pronto recibirás su respuesta, gracias.',
        'btn-close-mentoring-question'=>'Finalizar Mentoría',
        'closed' => 'Ha finalizado el proceso de acompañamiento',
		'emails' => [
			'evaluation' => [
				'entrepreneur' => [
					'text' => 'Te invitamos a realizar la evaluación del mentor asignado a tu proceso de acompañamiento.'
				],
				'mentor' => [
					'subjectMentorEvaluation' => 'Tu evaluacion de mentoria',
					'bodyMentorEvaluation' => 'Hola <b> :usuario </b><br><br>
											   Agradecemos la confianza que has depositado en nosotros durante el proceso de acompañamiento.<br><br>
											   <b> &#34; :recomendacion_mentor &#34; </b> <br><br>
											   Te invitamos a seguir construyendo el sueño de ser empresario y continuar participando en nuestras actividades y eventos.<br><br>',
					'text' => ':entrepreneur  ha finalizado el proceso de acompañamiento, te invitamos a realizar la evaluación.'
				]
			],
			'notification' => 'Ayudar a los demás es una de las acciones más gratificantes, aun más cuando lo haces con tu tiempo, conocimiento y experiencia. :mentored  ha encontrado en tu perfil de mentor la posibilidad de crecer con su proyecto/empresa :entity. Sí consideras que es posible ayudarle con el siguiente tema:',
			'discution' => 'El usuario :owner_mail :title',
		],
		'comment' => [
			'notification' => 'Se ha registrado un nuevo comentario en el siguiente proceso: '
		],
		'atachment' => [
			'notification' => 'Se ha cargado un archivo adjunto en el siguiente proceso: '
		],
		'filters' => [
			'title' => 'Buscar un mentor',
			'number_document' => '# documento',
			'name_entrepreneurship' => 'Nombre emprendimiento'
		],
		'process' => 'Cordialmente te informamos que tu solicitud realizada al mentor :requesting ha sido aceptada para iniciar el proceso de acompañamiento.',
		'processRefused' => 'Cordialmente te informamos que tu solicitud realizada al mentor :requesting de a cuerdo a su criterio de evaluacion no ha sido aceptada. Te invitamos a consultar otros Mentores para dar continuidad a tu proceso de acompañamiento.',
		'evaluation' => [
			'noteEntrepreneur' => 'Buscando la excelencia en la calidad de nuestros servicios y trabajando para un mejoramiento continuo, le agradecemos realizar la evaluación del mentor.',
			'noteMentor' => 'Escribe tus recomendaciones finales.',
			'suggestionEntrepreneur' => 'Descripción.',
			'comentaryEntrepreneur' => 'Comentario',
			'comentaryMentor' => 'Comentario',
		]
	],

	// Marketplace
	'marketplace' => [
		'purchaseTitle' => 'Compras',
		'nonePurchase' => 'No tienes compras realizadas.',
		'products' => 'Mis Productos',
		'buyProduct' => 'Adquirir',
		'titleconfirmPurchase' => 'Confirmación de compra',
		'titleButtonConfirmPurchase' => 'Continuar compra',
		'showPurchases' => 'Ver mis compras',
		'paymentMethods' => 'Medios de pago',
		'confirmPurchase' => 'este es el producto que seleccionaste para comprar',
		'reviewPurchase' => 'Revisa detalladamente tu compra y confirma',
		'finishPurchaseReview' => 'Finalizar compra',
		'numberPurchase' => 'Tu número de compra:',
		'showSuccessPurchases' => 'Ver mis compras',
        'seller' => 'Vendedor',
        'purchaser' => 'Comprador',
		'purchaserMessages' => [
			'purchaseinDevelopment' => 'En desarrollo'
		],
		'product' => [
			'abstract' => 'Descripción del producto',
			'user-product-detail_title' => 'Sobre el Proveedor - Contacto'
		],

		'commitment' => [
			'confirmation' => '¿Estás seguro de que leíste y validaste toda la información registrada en la carta de compromiso? Una vez aceptada la carta de compromiso, ésta no puede ser modificada.',
		],

		'agreement' => [
			'waiting' => 'Esperando acuerdo del vendedor.',
			'confirmation' => 'Al confirmar el acuerdo, éste se enviará a :institution para revisión ¿quieres confirmarlo?',
			'waitconfirmation' => 'Esperando aprobación de :institution.',
			'create' => 'El acuerdo de compra de servicio se ha creado, una vez este terminado debes enviarlo para que sea aprobado por el comprador.',
			'confirmationsend' => 'El acuerdo de negociación será enviado al vendedor para su revisión y aprobación, ¿estás seguro?',
			'waitconfirmationpurchaser' => 'Esperando confirmación del comprador.',
			'send' => 'El acuerdo de compra de servicio se ha registrado, ahora debes esperar a que el comprador realice algún comentario (si lo tiene) o acepte el acuerdo para comenzar a trabajar en tu servicio. Recibirás una notificación en tu correo cuando esto ocurra.',
			'confirmed' => 'Has aceptado el acuerdo registrado por el proveedor, deberás esperar a que se apruebe el acuerdo al que han llegado. Recibirás una notificación en tu correo cuando esto acurra.',
			'confirm' => 'Esperando aprobación de :institution.',
            'deliverables' => [
                'seller' => 'Debes cargar los entregables para seguir el proceso de calificación de la venta.',
				'purchaser' => 'Debes esperar a que el vendedor cargue los entregables para seguir el proceso de calificación de la compra.',
				'review' => 'Esperando confirmacion de entregables.'
            ]
		],

		'purchase' => [
			'seller' => 'Datos del vendedor',
            'success' => '¡Felicitaciones, has finalizado tu compra!',
            'already'=>'Ya esta compra fue realizada con anterioridad',
			'instructions' => 'Solo debes comunicarte con tu vendedor para acordar el pago y el envío.',
			'product' => 'Producto',
            'notallowed' => 'Para comprar productos y servicios debes contar con los permisos para marketplace.',
            'store' => [
				'confirmation' => '¿Estás seguro que deseas realizar esta compra?'
			],
			'mail' => [
				'subject' => 'Vendiste :product',
				'subjectPurchase' => 'Compraste :product',
				'titleMailConfirm' => 'Vendiste ¡Buen trabajo!',
				'infoPurchase' => 'Información de Compra'
			]
		],

		'offer' => [
            'confirmation' => 'Recuerda: Una vez ofertado no podrá ser modificado el valor.',
            'waiting' => 'Esperando aprobación de la oferta por parte del vendedor',
			'success' => '¡Felicitaciones, has realizado una oferta!',
			'instructions' => 'Recibirás una notificación cuando el vendedor acepte o rechace tu oferta.',
			'confirmed' => 'Oferta confirmada, sera notificado el comprador para continuar con el proceso.',
			'rejected' => 'Oferta rechazada, sera notificado al comprador.',
			'seller' => [
				'confirmation' => '¿Estás seguro que deseas aceptar esta oferta?',
				'cancel' => '¿Estás seguro que deseas rechazar esta oferta?'
			]
		],

		'filters' => [
			'provider' => 'Nombre del proveedor',
			'product' => 'Nombre de producto',
			'upscore' => 'Mayor calificación',
			'downscore' => 'Menor calificación'
		],
		'create_product' => [
			'new_producto' => 'Nuevo Producto',
		],
		'create' => [
			'products' => 'Crear producto',
			'promos' => 'Crear promoción',
			'typeownerentity'=>'Proyecto/Empresa',
			'modality' => [
				'virtual' => 'Virtual',
				'semipresencial' => 'Semipresencial',
				'presencial' => 'Presencial'
			]
		]
	],

	'notifications' => [
		'like' => [
			'title' => [
				'general' => 'gusta tu publicación.',
				'product' => 'gusta tu producto.',
				'wall' => 'gusta una publicación tuya en comunidades.',
				'article' => 'gusta tu artículo.',
				'event' => 'gusta tu evento.',
				'forum' => 'gusta tu tema en el foro.',
				'mentoring' => 'gusta tu pregunta en una asesoría.',
				'call' => 'gusta tu convocatoria.',
				'entity' => 'gusta tu emprendimiento.',
				'course' => 'gusta tu curso.',
				'discussion' => 'gusta tu discusión',
				'discussion_comment' => 'gusta tu comentario de discusión'
			]
		],
		'discussion' => [
			'title' => [
				'general' => 'creó una discusión.',
				'wall' => 'creó una discusión para una publicación tuya.',
				'article' => 'creó una discusión para un artículo tuyo.',
				'event' => 'creó una discusión para un evento tuyo.',
				'forum' => 'creó una discusión para un foro tuyo.',
				'mentoring' => 'creó una discusión para una mentoría tuya.',
				'call' => 'creó una discusión para una convocatoria.',
				'entity' => 'creó una discusión para un emprendimiento tuyo.',
				'marketplace' => 'creó una discusión para un producto tuyo en marketplace.',
				'course' => 'creó una discusión para aprende.'
			],
			'titleAlt' => [
				'general' => 'una discusión.',
				'wall' => 'una discusión para una publicación en la que participaste.',
				'article' => 'una discusión para un artículo en el que participaste.',
				'event' => 'una discusión para un evento en el que participaste.',
				'forum' => 'una discusión para un foro en el que participaste.',
				'mentoring' => 'una discusión para una mentoría en el que participaste.',
				'call' => 'una discusión para una convocatoria en la que participaste.',
				'entity' => 'una discusión para un emprendimiento en el que participaste.',
				'marketplace' => 'una discusión para un producto en el que participaste.',
				'course' => 'una discusión para aprende donde participaste.'
			]
		],
		'discussion_comment' => [
			'title' => [
				'general' => 'un comentario para una discusión tuya.'
			],
			'titleAlt' => [
				'general' => 'un comentario para una discusión en la que participaste.'
			]
		]
	],

	// Auth
	'auth' => [
		'user' => 'No existe una cuenta con el correo electrónico asociado.',
		'password' => 'Usuario o contraseña no coinciden. Por favor, asegúrate de que el bloqueo de mayúsculas no está activado e inténtalo de nuevo.<br/>¿Olvidaste tu contraseña? <a href="password/email">Solicita una nueva</a>.'
    ],

    'text_security' => [
		'email' => ''
    ],

	// Eventos
    'event' => [
        'button' => [
            'participate' => 'Participar',
            'stopparticipating' => 'Dejar de participar'
		],
		'organizers' => [
            'title' => 'Organizadores'
		],
		'textMeet' => 'Ten en cuenta el día y la hora del evento, podrás ingresar a la reunión dando clic en el siguiente botón.',
		'closed' => 'Evento Cerrado',
		'modal' => '¿Realmente deseas participar en este evento?'

    ],

	'calls' => [
		'category' => 'Categoría',
		'stage' => 'Etapa',
		'Entity' => 'Entidad',
		'diagnostic' => 'Queremos que conozcas los resultados de tu aplicación a la herramienta de diagnóstico, adjunto encontrarás un documento con los resultados obtenidos.'
	],

	'search' => [
		'typeProducts' => 'Productos'
    ],

	// Aprende
    'learn' => [
        'type' => [
            'courses' => 'Cursos',
            'webinars'=> 'Webinars',
            'conferences'=>'Conferencias',
            'certificates'=>'Certificados',
			'mycontent'=>'Mi contenido'
		],
		'desc' => [
            'courses' => 'Cursos Destacados',
            'webinars'=> 'Webinars destacados',
            'conferences'=>'Conferencias destacadas'
		],
		'certificate' => [
			'title' => '<h1 style="color: #292E65">ASOCIACIÓN COLOMBIANA PRO NIÑO CON <br> PARÁLISIS CEREBRAL</h1>',
			'to' => '<p style="font-size: 15px; color: #434343">Certifica que: </p>',
			'subject' => '<p style="font-size: 15px; color: #434343"> Participó en el :course, <br> modalidad virtual. </p>',
			'nameFirm' => 'Nombre de la persona',
			'occupationFirm' => 'Ocupacion de la persona'
		],
		'payment' => 'De pago',
		'free' => 'Gratis',
		'name'=> 'Nombre',
		'inscription' => 'Inscribirme a este curso',
		'filter'=> [
			'title' => 'Cursos'
		],
		'freecourse' => 'Gratis',
		'relevantcourses'=> 'Cursos Destacados',
		'sidecourse'=> [
			'discussion' => [
				'title' => 'CONVERSACIONES'
			],
			'students' => [
				'title' => 'ESTUDIANTES'
			],
			'developer' => [
				'title' => 'DESARROLLADORES'
			],
			'certificate' => [
				'title' => 'CERTIFICADO'
			]
		]
	],
	// Forms
	'pricing' => [
		'title' => 'Obtén un plan para acceder a todo nuestro contenido',
		'subtitle' => 'QUÉ OBTIENES'
	],
	'reserve' => [
        'title' => 'Bienvenido, para continuar lo invitamos a inscribirse, por favor ingrese al <span class="sky-blue-text">Centro de ayuda Propace</span>',
        'subtitle' => 'Aún no cuenta con  <span class="sky-blue-text">acceso</span> a esta sección.'
	],
	'users' => [
		'entrepreneurship' => 'Emprendimientos',
		'program' => 'Convocatorias'
	],

	//step/perfil
	'perfil' => [
		'city' => 'Ciudad'
	],
	//mentoria
	'mentoria' => [
		'texto' => 'Proceso De Mentoria'
	],
	//blog
	'likes' => 'emprendedores',
];
