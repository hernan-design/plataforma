<?php

return [
    'field_change' => '<strong>:field</strong> cambió de :old_value a :new_value',

	'role' => [
		'updated' => 'Rol :title actualizado',
		'created' => 'Rol :title creado',

		'permission' => [
			'created' => 'Se ha asignado el permiso <strong>:display_name</strong> del módulo <strong>:nombre_modulo</strong> al rol :title',
			'deleted' => 'Se ha removido el permiso <strong>:display_name</strong> del módulo <strong>:nombre_modulo</strong> al rol :title'
		]
	],

	'user' => [
		'created' => 'Se ha creado el usuario <a class="blue" href="/usuario/:user_id">:user</a>',
		'role' => [
			'created' => 'Se ha asignado el rol <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>',
			'deleted' => 'Se ha removido el rol <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>'
		],
		'speciality' => [
		'created' => 'Se ha asignado la especialidad <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>',
		'deleted' => 'Se ha removido la especialidad <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>'
		],
		'sector' => [
		'created' => 'Se ha asignado el sector económico <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>',
		'deleted' => 'Se ha removido el sector económico <strong>:title</strong> a <a class="blue" href="/usuario/:user_id">:user</a>'
		],
		'session' => [
			'platform' => '<a class="blue" href="/usuario/:user_id">:user</a> ingresó a la plataforma'
		],
    	'modifications' => 'Se editaron los siguiente campos <strong> :modification </strong>'
    ],

    'mentor' => [
    	'sync' => 'Se ha sincronizado indice de algolia el usuario :user - :user_id al mentor <strong>:mentor</strong>'
	],

	'mentoring' => [
		'created' => 'Se ha creado la asesoría <strong>No.</strong> <a class="blue" href="/mentoria/:mentoring">:mentoring</a>',
		'deleted' => 'Se ha eliminado la asesoría <strong>No.</strong> <a class="blue" href="/mentoria/:mentoring">:mentoring</a>'
	],

	'event' => [
		'inscription' => 'Se ha inscrito <a class="blue" href="/usuario/:user_id">:user</a> al evento <strong>:title</strong>',
    	'sync' => 'Se ha sincronizado indice de algolia el usuario :user - :user_id al evento <strong>:evento</strong>',
		'unsuscribe' => '<a class="blue" href="/usuario/:user_id">:user</a> ha cancelado la inscripción al evento <strong>:title</strong>',
		'attended' => 'Se ha confirmado la asistencia de <a class="blue" href="/usuario/:user_id">:user</a> al evento <strong>:title</strong>',
		'removed' => 'Se ha eliminado la confirmación de <a class="blue" href="/usuario/:user_id">:user</a> al evento <strong>:title</strong>'
	],

	'product' => [
    	'sync' => 'Se ha sincronizado indice de algolia el usuario :user - :user_id al producto <strong>:producto</strong>'
	],

	'promotion' => [
		'approve' => 'Se ha aprobado <strong>:title</strong> No. <a class="blue" href="/marketplace/promociones/:promotion_id">:promotion_id</a>',
		'back' => 'Se ha rechazado <strong>:title</strong> No. <a class="blue" href="/marketplace/promociones/:promotion_id">:promotion_id</a>'
	],

	'reports' => 'Se ha generado el reporte <strong>:report</strong>',

  	'program' => 'Se ha modificado el resultado en la convocatoria <strong> :convocatoria </strong>',
];
