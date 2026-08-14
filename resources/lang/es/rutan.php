<?php

return [
    'entities' => [

		'create' => 'Registro de proyecto',
        'submit' => 'Registrar',

		'project' => [
			'required' => 'required',
			'error_industry' => '¡Macrosector-Microsector es obligatorio!',
			'error_stage' => '¡Tipo Emprendimiento es obligatorio!',
			'stage' => 'Tipo Emprendimiento',
			'industry' => 'Macrosector-Microsector (*)',
            'placeholder' => [
				'industry' => 'Seleccione Macrosector-Microsector',
				'stage' => 'Seleccione Tipo Emprendimiento',
			]
        ],
        'company' => [
			'stage' => 'Tipo Empresa',
			'industry' => 'Macrosector-Microsector',
			'nit' => 'Número de identificación sin dígito de verificación',
			'covering' => 'Tamaño de la empresa',
			'society_type' => 'Naturaleza Jurídica',
			'cellphone' =>  'Número de celular de la empresa',
            'placeholder' => [
				'industry' => 'Seleccione Macrosector-Microsector',
				'stage' => 'Seleccione tipo empresa',
			    'covering' => 'Seleccione tamaño de la empresa',
				'society_type' => 'Seleccione naturaleza jurídica',
			]
        ]
	],
	'evaluation' => [
		'notification' => [
				'ideacion' => [
					'subject' => '¡Bienvenido(a) a la Ruta del emprendimiento! 🙋🏾‍♀️🚀🙋🏽‍♂️',
				],
				'preincubacion' => [
					'subject' => '¡Bienvenido(a) a la Ruta del emprendimiento! 🙋🏾‍♀️🚀🙋🏽‍♂️',
				],
				'incubacion' => [
					'subject' => '¡Bienvenido(a) a la Ruta del emprendimiento! 🙋🏾‍♀️🚀🙋🏽‍♂️',
				],
				'aceleracion' => [
					'subject' => '¡Bienvenido(a) a la Ruta del emprendimiento! 🙋🏾‍♀️🚀🙋🏽‍♂️',
				],
				'consolidacion' => [
					'subject' => '¡Bienvenido(a) a la Ruta del emprendimiento! 🙋🏾‍♀️🚀🙋🏽‍♂️',
				],
				'sin_base_tecnologica' => [
					'subject' => 'Tenemos noticias sobre tu postulación a la Ruta del emprendimiento',
				],
				'edad' => [
					'subject' => 'Tenemos noticias sobre tu postulación a la Ruta del emprendimiento',
				],
				'ciudad' => [
					'subject' => 'Tenemos noticias sobre tu postulación a la Ruta del emprendimiento',
				],
				'SinCamaraComercio' => [
					'subject' => 'Tenemos noticias sobre tu postulación a la Ruta del emprendimiento',
				],
				'lab_innovacion' => [
					'subject' => 'Tenemos noticias sobre tu postulación a la Ruta del emprendimiento',
				]
		]
	],
	//step/perfil
	'perfil' => [
		'city' => 'Ciudad de nacimiento'
	],

	// Mentorias

	'mentoria' => [
		'texto' => 'Proceso De Acompañamiento',
	],

	'mentoring' => [
		'evaluation' => [
			'comentaryEntrepreneur' => '7. Queremos conocer todas sus opiniones para continuar mejorando ¡Te leemos!',
			'comentaryMentor' => 'Comentario',
			'totalScoreEntrepreneur' => '6. Si tuviera que dar una calificación total al acompañamiento, ¿qué calificación asignaría?'
		]
	],

	'marketplace' => [
		'create_product' => [
			'new_producto' => 'Nuevo Servicio',
		],
		'agreement' => [
			'waiting' => 'Esperando acuerdo del vendedor.',
			'confirmation' => 'Al aceptar entregables, éste se enviará a :institution para revisión ¿quieres aceptar?',
			// 'waitconfirmation' => 'Esperando aprobación de :institution.',
			// 'create' => 'El acuerdo de compra de servicio se ha creado, una vez este terminado debes enviarlo para que sea aprobado por el comprador.',
			// 'confirmationsend' => 'El acuerdo de negociación será enviado al vendedor para su revisión y aprobación, ¿estás seguro?',
			// 'waitconfirmationpurchaser' => 'Esperando confirmación del comprador.',
			// 'send' => 'El acuerdo de compra de servicio se ha registrado, ahora debes esperar a que el comprador realice algún comentario (si lo tiene) o acepte el acuerdo para comenzar a trabajar en tu servicio. Recibirás una notificación en tu correo cuando esto ocurra.',
			'confirmed' => 'Has aceptado los entregables registrados por el proveedor, deberás esperar a que se aprueben. Recibirás una notificación en tu correo cuando esto acurra.',
			// 'confirm' => 'Esperando aprobación de :institution.',
			// 'deliverables' => [
			// 	'seller' => 'Debes cargar los entregables para seguir el proceso de calificación de la venta.',
			// 	'purchaser' => 'Debes esperar a que el vendedor cargue los entregables para seguir el proceso de calificación de la compra.',
			// 	'review' => 'Esperando confirmacion de entregables.'
			// ]
		],
	],


];