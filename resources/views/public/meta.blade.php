@php $institution = App\Institucion::getInstitutionSlug(App\Institucion::getInstitutionHost()); @endphp
@php $meta_tags = App\Institucion::getMetaTags($institution->codigo_institucion); @endphp

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0">
{{-- Secure tags TuProyecto --}}
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="login-tp" content="{{ Auth::check() ? 1 : 0 }}" />

<title>@yield('title_site', ($institution->nombre_institucion ? $institution->nombre_institucion : Config::get('tuproyecto.title')))</title>
<link rel="shortcut icon" href="{{ $meta_tags->favicon ? $meta_tags->favicon : Config::get('tuproyecto.favicon') }}" />
<link rel="icon" type="image/x-icon" href="{{ $meta_tags->favicon ? $meta_tags->favicon : Config::get('tuproyecto.favicon') }}">
<meta name="description" content="@yield('meta_description', ($institution->descripcion_institucion ? $institution->descripcion_institucion : Config::get('tuproyecto.description')))">
<meta name="keywords" content="@yield('meta_keywords', Config::get('tuproyecto.keywords'))">
<link rel="alternate" href="@yield('meta_url', ($institution->url_institucion ? $institution->url_institucion : Config::get('tuproyecto.url')))" hreflang="es">
<link rel="canonical" href="@yield('canonical_url', Request::url())" />
<meta name="robots" content="@yield('directivas', 'index,follow')">

{{-- og tags Facebook --}}
<meta property="og:description" content="@yield('meta_ob_description', ($institution->descripcion_institucion ? $institution->descripcion_institucion : Config::get('tuproyecto.description')))" />
<meta property="og:title" content="@yield('meta_ob_title', ($institution->nombre_institucion ? $institution->nombre_institucion : Config::get('tuproyecto.title')))" />
<meta property="og:type" content="@yield('meta_type', 'website')" />
<meta property="og:url" content="@yield('meta_url', ($institution->url_institucion ? $institution->url_institucion : Config::get('tuproyecto.url')))"/>
<meta property="og:image" content="@yield('meta_ob_image', ($meta_tags->social_image ? $meta_tags->social_image : Config::get('tuproyecto.favicon')))" />
<meta property="og:site_name" content="{{ $institution->nombre_institucion ? $institution->nombre_institucion : Config::get('tuproyecto.title') }}" />
<meta property="fb:app_id" content="{{ Cookie::get('_facebook_api_key', Config::get('tuproyecto.facebook_api_key')) }}" />
<meta property="article:publisher" content="{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}" />
<meta property="fb:article:publisher" content="{{ Cookie::get('_facebook_api_key', Config::get('tuproyecto.facebook_api_key')) }}" />
<meta property="fb:app_id" content="{{ Cookie::get('_facebook_api_key', Config::get('tuproyecto.facebook_api_key')) }}" />


{{-- og tags Google+ --}}
<meta itemprop="description" content="@yield('meta_description', ($institution->descripcion_institucion ? $institution->descripcion_institucion : Config::get('tuproyecto.description')))" />

{{-- Twitter Cards --}}
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="{{ $institution->twitter_institucion ? $institution->twitter_institucion : Config::get('tuproyecto.twitter_creator') }}" />
<meta name="twitter:title" content="@yield('meta_tw_title', ($institution->nombre_institucion ? $institution->nombre_institucion : Config::get('tuproyecto.title')))" />
<meta name="twitter:description" content="@yield('meta_tw_description', ($institution->descripcion_institucion ? $institution->descripcion_institucion : Config::get('tuproyecto.description')))" />
<meta name="twitter:creator" content="{{ $institution->twitter_institucion ? $institution->twitter_institucion : Config::get('tuproyecto.twitter_creator') }}" />
<meta name="twitter:image:src" content="@yield('meta_tw_image', ($meta_tags->social_image ? $meta_tags->social_image : Config::get('tuproyecto.favicon')))" />
<meta name="twitter:domain" content="{{ Request::getHost() }}" />