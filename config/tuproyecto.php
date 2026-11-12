<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Global
	|--------------------------------------------------------------------------
	|
	| Default global config values.
	|
	*/

	'key' => '1',

	'title' => 'TuProyecto',

	'privacy' => false,

	'noreply' => 'info@tuproyecto.com',

	'secure_domains' => ['http://redemprendedoresbavaria.net', 'http://tuproyecto.com', 'http://andidelfuturo.com', 'http://emprendedoreslafayette.com', 'http://inversionangel.com', 'http://seissabana.com'],

	'src_params_separate' => '[.tp.]',

	/*
	|--------------------------------------------------------------------------
	| Meta Tags
	|--------------------------------------------------------------------------
	|
	| Default values.
	|
	*/

	'header_logo' => '/images/institutions/compensar/compensar-logo-header-plataforma-pos.png',

	'logo' => '/images/institutions/compensar/compensar-logo-header-plataforma-pos.png',

	'color' => '#000000',

	'url' => 'https://coposoftware.com',

	'favicon' => '/images/institutions/compensar/compensar-favicon.png',

	'description' => 'Construye TuProyecto. Recibe aportes y opiniones de mentores para llevarlo a una etapa de financiación. Es TuProyecto pero no estas solo.',

	'keywords' => 'emprendimiento,conectividad,innovacion,proyecto,asesoria en proyecto,ayuda en proyecto,financiacion de proyectos,financiacion colectiva,crowdfunding,crowdfunding colombia,apoyo a proyectos',

	'social_image' => '/images/no-image.svg',

	'avatar_image' => '/images/no-user-image.svg',

	'no_image' => '/images/no-image.svg',

	'no_project_image' => '/images/no-image-770x460.svg',

	'no_event_image' => '/images/no-image.svg',

	'no_promotion_image' => '/images/no-image.svg',

	/*
	|--------------------------------------------------------------------------
	| Twitter cards
	|--------------------------------------------------------------------------
	|
	| Default twitter cards values.
	|
	*/

	'twitter_creator' => '@TuProyectoTweet',

	/*
	|--------------------------------------------------------------------------
	| Social Links
	|--------------------------------------------------------------------------
	|
	| Default social values.
	|
	*/

	'social_facebook' => 'https://www.facebook.com/pages/Tuproyectocom/172218829608483',

	'social_twitter' => 'https://twitter.com/TuProyectoTweet',

	'social_youtube' => 'https://www.youtube.com/channel/UCDycMgIyiKWe9gxy6WRPZIw/videos',

	'instagram' => 'http://instagram.com/tuproyecto',

	/*
	|--------------------------------------------------------------------------
	| Social Logos
	|--------------------------------------------------------------------------
	|
	| Default social logos.
	|
	*/

	'logo_facebook' => 'http://static.tuproyecto.com/images/social/facebook.png',

	'logo_twitter' => 'http://static.tuproyecto.com/images/social/twitter.png',

	'logo_youtube' => 'http://static.tuproyecto.com/images/social/youtube.png',

	/*
	|--------------------------------------------------------------------------
	| Social Logos Modules
	|--------------------------------------------------------------------------
	|
	| Default logos modules.
	|
	*/

	'image_forum' => 'http://static.tuproyecto.com/images/social/foro.png',

	'image_project' => 'http://static.tuproyecto.com/images/social/project.png',

	/*
	|--------------------------------------------------------------------------
	| Icons sections
	|--------------------------------------------------------------------------
	|
	| Default Icon Sections.
	|
	*/

	'icon' => [
		'forum' => 'mdi-pen',

		'article' => 'mdi-comment-multiple-outline',

		'course' => 'mdi-chair-school',
	],


	/*
	|--------------------------------------------------------------------------
	| Video Landing
	|--------------------------------------------------------------------------
	|
	| Default Video Landing
	|
	*/

	'video_webm' => 'http://static.tuproyecto.com/videos/landing/web_default.webm',

	'video_mp4' => 'http://static.tuproyecto.com/videos/landing/web_default.mp4',

	'video_ogg' => 'http://static.tuproyecto.com/videos/landing/web_default.ogv',

	/*
	|--------------------------------------------------------------------------
	| Bavaria Resources
	|--------------------------------------------------------------------------
	|
	| Default Bavaria resources.
	|
	*/

	'image_fundacion_bavaria' => 'http://static.tuproyecto.com/images/institutions/bav-emprendimiento-75x75.png',

	'url_fundacion_bavaria' => 'http://www.bavaria.co/5-499/fundacion_bavaria_ds/',

	/*
	|--------------------------------------------------------------------------
	| Key APIs Default
	|--------------------------------------------------------------------------
	|
	| Default API keys
	|
	*/

	'google_analytics' => 'UA-61971428-1',

	'facebook_api_key' => '394349060716779',

	'linkedin_api_key' => '77ez4jgez6p7gq',

	'twitter_api_key' => 'l9wS3zKeA72KMburG4S0WZkBK',

	'twitter_secret_key' => 'R3v2y2fTGBYrsLwm3uQaKG9LasNng8aTt7hVSO6T1yWFfGH4rs',

	'grecatcha_api_key' => '6LdCY0sUAAAAAHPUA9Yz0uvDTa0Vg9mZKgzmN-uj',

    'grecatcha_secret_key' => '6LdCY0sUAAAAAPC3DD4c5lo7izux5mtIXLgRDqHQ',


   	/*
    |--------------------------------------------------------------------------
    | Sync Algolia Auto On Update or Create Item
    |--------------------------------------------------------------------------
    |
    | This is  a custom parameter for tuproyecto.com
    | the parameter is 'true' to allow  sync to algolia
	| when running php artisan algolia:sync, if false then just output to log the results of retrieved
	| items
    */

    'algolia_sync' => env('ALGOLIA_SYNC', true),

	/*
	|--------------------------------------------------------------------------
	| Whatsapp Help Number
	|--------------------------------------------------------------------------
	*/

	'whatsapp_number' => 3197798990
];
