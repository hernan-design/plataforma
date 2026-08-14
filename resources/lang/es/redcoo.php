<?php

return [

	// Mentorias
	'mentoring' => [
		'invitation' => 'Aún no eres mentor. <a href=":route" class="button xtiny sky-blue radius btn-shadow btn-lowerc btn-clean-margin">Conviértete</a> en uno de nuestros mentores voluntarios y ayuda a impulsar con tu experiencia las empresas y los sueños de nuestros Asociados.',
		'create' => [
			'experience' => 'Mi experiencia laboral',
			'select' => 'Proyecto empresarial o empresa',
			'specialties' => '¿En qué áreas de conocimiento ha centrado sus estudios? sugerimos seleccionar máximo 2',
			'sectors' => 'Seleccione los sectores en los cuales ud. tiene experiencia. sugerimos seleccionar máximo 3',
			'attached' => 'Descarga <a href="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/documents/coomeva/Formato+HV-+Programa+Mentorias+Voluntarias.docx" target="_blank"><span class="light-text">aquí</span></a> el formato de hoja de vida y cárgalo a continuación',
			'terms1' => 'He leído y acepto los',
			'terms2' => 'del programa de mentorías y entendiendo que este es un programa de donación de tiempo.'
		],
		'emails' => [
			'notification' => ' :mentored quiere iniciar un proceso de acompañamiento contigo.'
		]
	],

	'entities' => [
		'project' => [
			'industry' => 'Sector',
			'placeholder' => [
				'industry' => 'Selecciona sector'
			],
			'city' => 'Zona',
			'placeholder' => [
				'city' => 'Selecciona zona'
			]
		],
		'company' => [
			'industry' => 'Sector',
			'placeholder' => [
				'industry' => 'Selecciona sector'
			]
		]
	],

	// Marketplace
	'marketplace' => [
		'purchase' => [
			'notallowed' => 'Para comprar productos y servicios es necesario que seas afiliado a la cooperativa COOMEVA.'
		],
	],

	// Auth
	'auth' => [
		'user' => 'Usuario o contraseña no coinciden. Por favor, asegúrate de que el bloqueo de mayúsculas no está activado e inténtalo de nuevo.'
    ],
    
    'text_security' => [
        'email' =>  '<p>Coomeva no solicita ni solicitará información de sus datos de acceso a este portal por ningún tipo de medio así como datos económicos.</p> <p>Lo anterior significa que en nuestras comunicaciones, no se le solicitará la clave de acceso a Red Coomeva.</p>'
	]
];
