<?php

return [
    'mail.subject' => 'Confirmación Inscripción Primer Reto',
    'mail.program' => 'Confirmación Inscripción en el programa',
	'mail.body' => 'Bienvenido/a a :nombre_convocatoria, el programa de iNNpulsa Colombia para emprendedores de Alto Impacto.<br/>Te confirmamos que hemos recibido la inscripción de tu emprendimiento, el cual será evaluado en un plazo aproximado de 30 días. Nos estaremos comunicando contigo para darte a conocer los resultados de la postulación realizada
	<br/><br/>
	Gracias por hacer parte de las empresas que construyen el futuro del país.',
	'mail.empodera2020.body' => 'Estimado emprendedor, </br>
	Confirmamos que tu postulación ha sido recibida. <br><br> Próximamente nos pondremos en contacto contigo para comunicarte el resultado de la evaluación.  
	<br><br>
	Gracias por tu interés en ser parte de EMPODERA. ¡Eres el motor de nuestra organización!',
	'programs' => [
		'choose' => 'Selecciona tu <strong class="dark-text">Proyecto</strong> o <strong class="dark-text">Empresa</strong> creados anteriormente. Si no cuentas con ninguna de las opciones anteriores, debes crear una haciendo click en el botón “más” (+).',
		'mterms' => '<p>La información y datos personales suministrados a iNNpulsa Colombia podrán ser procesados, recolectados, almacenados, usados, circulados, suprimidos, compartidos, actualizados, transmitidos, de acuerdo con los términos y condiciones de las Políticas de Privacidad previsto en el artículo 10 del Decreto 1377 de 2013, reglamentario de la Ley 1581 de 2012.</p>',
		'discussions' => 'Preguntas Frecuentes',
		'step1' => 'Inicio',
		'step4' => 'Formulario de inscripción',
	],

	'entities' => [
		'entity' => 'Asesor de servicio',
		'create' => 'Registro de proyecto',
        'submit' => 'Registrar',

        'project' => [
			'error_stage' => '¡La etapa es obligatoria!',
            'documents' => [
                'title' => 'Vinculación',
                'description' => 'En esta sección debes adjuntar los siguientes documentos de tu emprendimiento: Cámara de Comercio con una vigencia no mayor a 3 meses, RUT y cédula del representante legal. Al terminar el proceso de validación de los documentos, te enviaremos una notificación con tu Carta de Compromiso de participación en el programa y podrás ingresar al Marketplace.',
				'decriptionReportFinal' => 'Diligencia y carga el informe final en este espacio.'
            ],
        ]
	],

	// Evaluaciones
	'evaluations' => [
		'terms' => [
			'title' => 'Compromiso de confidencialidad y no conflicto de intereses',
			'link' => 'Acepto <a href=":route" target="_blank" class="sky-blue-text bold-text">Compromiso de confidencialidad y no conflicto de intereses</a>.',
			'error' => 'Debes aceptar el compromiso de confidencialidad.'
        ],
		'emails' => [
			'returned' => [
				'subject' => 'Conoce los resultados de tu aplicación Reto 1 - ALDEA'
            ]
        ],
        'typequalitycommentpurchaser'=>'¿Apruebas el pago al asesor sobre el servicio prestado?'
	],

	// Marketplace
	'marketplace' => [
		'products' => 'Mis Servicios',
		'seller' => 'Asesor',
        'purchaser' => 'Comprador',

		'product' => [
			'abstract' => 'Descripción del servicio'
		],

		'agreement' => [
			'waiting' => 'Esperando acuerdo del asesor.',
			'create' => 'El acuerdo de negociación del servicio se ha creado, una vez esté terminado debes enviarlo para que sea aprobado por el empresario.',
			'confirmationsend' => 'El acuerdo de negociación será enviado al empresario para su revisión y aprobación, ¿estás seguro?',
			'waitconfirmationpurchaser' => 'Esperando confirmación del empresario.',
			'send' => 'El acuerdo de compra de servicio se ha enviado, ahora debes esperar a que el empresario realice algún comentario (si lo tiene) o acepte el acuerdo para comenzar a trabajar en tu servicio. Recibirás una notificación en tu correo cuando esto ocurra.',
			'confirmed' => 'Has aceptado el acuerdo de negociación enviado por el asesor, ahora debes esperar a que iNNpulsa Colombia revise y apruebe el acuerdo. Recibirás una notificación a tu correo electrónico cuando esto ocurra',
			'deriverable' => 'Has enviado los entregables correctamente.'
		],

		'purchase' => [
			'seller' => 'Datos del asesor',
			'instructions' => 'Solo debes comunicarte con tu asesor para acordar el pago y el envío.',
            'product' => 'Servicio',
            'voucherinsufficient' => 'El saldo que tienes es inferior al precio del producto/servicio que estas adquiriendo'
		],

		'offer' => [
			'confirmation' => 'Recuerda: Una vez ofertado el servicio no podrás modificar el valor.',
			'instructions' => 'Recibirás una notificación cuando el asesor acepte o rechace tu oferta.',
			'rejected' => 'Oferta rechazada, será notificado el empresario.'
		],

		'filters' => [
			'provider' => 'Nombre del asesor',
			'product' => 'Nombre del servicio'
		]
		],

		'mentoring' => [
			'process' => 'Cordialmente te informamos que tu solicitud realizada al mentor :requesting ha sido aceptada para iniciar el proceso de acompañamiento.'
		]
];
