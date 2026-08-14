@extends('layout.landing.layout')
@section('excludestyles', true)
@section('head')
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/owl.carousel.min.css">
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/owl.theme.default.css">
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/aos.css">
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/style.min.css">
  <link rel="stylesheet" href="//static-files-01-clients.coposoftware.com/prana/css/landing.css">
@endsection

@section('content')
  <header id="header-section">
    <nav class="navbar navbar-expand-lg pl-3 pl-sm-0" id="navbar">
    <div class="container">
      <div class="navbar-brand-wrapper d-flex w-100">
		{!! HTML::image(App\RegistroSesion::getInstitutionImg(), App\RegistroSesion::getInstitutionName(), ['width' => '55']) !!}
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="mdi mdi-menu navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse navbar-menu-wrapper" id="navbarSupportedContent">
        <ul class="navbar-nav align-items-lg-center align-items-start ml-auto">
          <li class="d-flex align-items-center justify-content-between pl-4 pl-lg-0">
            <div class="navbar-collapse-logo">
				{!! HTML::image(App\RegistroSesion::getInstitutionImg(), App\RegistroSesion::getInstitutionName(), ['width' => '55']) !!}
            </div>
            <button class="navbar-toggler close-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="mdi mdi-close navbar-toggler-icon pl-5"></span>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#header-section">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#routes-section">Rutas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#weare-section">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#allies-section">Aliados</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="#founders-section">Integrantes</a>
          </li>
          <li class="nav-item btn-contact-us pl-4 pl-lg-0">
			@auth
				<a href="{{ route('comunidad.index') }}" class="btn btn-info">{{ trans('app.comunidad') }}</a>
			@else
            	<a href="{{ route('login') }}" class="btn btn-info">{{ trans('app.login') }}</a>
			@endauth
          </li>
        </ul>
      </div>
    </div>
    </nav>
  </header>
  <div class="banner sja-background pt-5">
    <div class="container">
      <h1 class="font-weight-semibold">Bienvenidos a nuestra academia</h1>
      <h6 class="font-weight-normal text-muted pb-3">Rutas de formación para los emprendedores de la cultura.</h6>
      <img src="//static-files-01-clients.coposoftware.com/prana/images/prana-20-anos.png" alt="Prana INC 20 años" class="img-fluid px-5">
    </div>
  </div>

  <div class="content-wrapper">
    <div class="container">
      <section class="features-overview" id="routes-section">
        <div class="content-header">
          <h2>Conoce nuestras rutas de formación</h2>
        </div>
        <div class="d-md-flex justify-content-between">
          <div class="grid-margin d-flex justify-content-start">
            <div class="features-width">
              <img src="//static-files-01-clients.coposoftware.com/prana/images/ruta-formacion-negocios.svg" alt="Ruta de formación de plan de negocios" class="img-icons">
              <h5 class="py-3">Ruta de formación de plan de negocios.</h5>
              <p class="text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
              <a href="#"><p class="readmore-link">Ver más</p></a>
            </div>
          </div>
          <div class="grid-margin d-flex justify-content-center">
            <div class="features-width">
              <img src="//static-files-01-clients.coposoftware.com/prana/images/ruta-fondo-emprender.svg" alt="Ruta fondo emprender" class="img-icons">
              <h5 class="py-3">Ruta fondo emprender (3 meses)</h5>
              <p class="text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
              <a href="#"><p class="readmore-link">Ver más</p></a>
            </div>
          </div>
        </div>
      </section>
      <section class="digital-marketing-service" id="weare-section">
        <div class="row align-items-center">
          <div class="col-12 col-lg-7 grid-margin grid-margin-lg-0" data-aos="fade-right">
            <h3 class="m-0">Cursos de las industrias creativas</h3>
            <div class="col-lg-7 col-xl-6 p-0">
              <p class="py-4 m-0 text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
              <p class="font-weight-medium text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer</p>
            </div>
          </div>
          <div class="col-12 col-lg-5 p-0 img-digital grid-margin grid-margin-lg-0" data-aos="fade-left">
            <img src="//static-files-01-clients.coposoftware.com/prana/images/image-1-cards.png" alt="" class="img-fluid">
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-12 col-lg-7 text-center flex-item grid-margin" data-aos="fade-right">
            <img src="//static-files-01-clients.coposoftware.com/prana/images/image-2-cards.png" alt="" class="img-fluid">
          </div>
          <div class="col-12 col-lg-5 flex-item grid-margin" data-aos="fade-left">
            <h3 class="m-0">Eventos y ferias.</h3>
            <div class="col-lg-9 col-xl-8 p-0">
              <p class="py-4 m-0 text-muted">Power-packed with impressive features and well-optimized, this template is designed to provide the best performance in all circumstances.</p>
              <p class="pb-2 font-weight-medium text-muted">Its smart features make it a powerful stand-alone website building tool.</p>
            </div>
            <button class="btn btn-info">Readmore</button>
          </div>
        </div>
		<div class="row align-items-center">
			<div class="col-12 col-lg-7 grid-margin grid-margin-lg-0" data-aos="fade-right">
			  <h3 class="m-0">Foros</h3>
			  <div class="col-lg-7 col-xl-6 p-0">
				<p class="py-4 m-0 text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
				<p class="font-weight-medium text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer</p>
			  </div>
			</div>
			<div class="col-12 col-lg-5 p-0 img-digital grid-margin grid-margin-lg-0" data-aos="fade-left">
			  <img src="//static-files-01-clients.coposoftware.com/prana/images/image-1-cards.png" alt="" class="img-fluid">
			</div>
		</div>
      </section>
      <section class="case-studies" id="allies-section">
        <div class="row grid-margin">
          <div class="col-12 text-center pb-5">
            <h2>Aliados</h2>
          </div>
          <div class="col-12 col-md-6 col-lg-3 stretch-card mb-3 mb-lg-0" data-aos="zoom-in">
            <div class="card color-cards">
              <div class="card-body p-0">
                <div class="bg-transparent text-center card-contents border border-dark">
                  <div class="card-image">
                    <img src="//static-files-01-clients.coposoftware.com/prana/images/logo-sena.png" class="case-studies-card-img" alt="">
                  </div>
                </div>
                <div class="card-details text-center pt-3">
                    <h6 class="m-0 pb-3">Servicio Nacional de Aprendizaje</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 stretch-card mb-3 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
            <div class="card color-cards">
              <div class="card-body p-0">
                <div class="bg-primary text-center card-contents">
                  <div class="card-image">
                      <img src="//static-files-01-clients.coposoftware.com/prana/images/logo-javeriana.png" class="case-studies-card-img" alt="">
                  </div>
                </div>
                <div class="card-details text-center pt-3">
                    <h6 class="m-0 pb-3">Universidad <br>Javeriana</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 stretch-card mb-3 mb-lg-0" data-aos="zoom-in" data-aos-delay="400">
            <div class="card color-cards">
              <div class="card-body p-0">
                <div class="bg-light text-center card-contents">
                  <div class="card-image">
                      <img src="//static.tuproyecto.com/images/institutions/innpulsa/landing-octubre-2018/innpulsa-logo-header.svg" class="case-studies-card-img w-75" alt="">
                  </div>
                </div>
                <div class="card-details text-center pt-3">
                    <h6 class="m-0 pb-3">Innpulsa <br>Colombia</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-3 stretch-card" data-aos="zoom-in" data-aos-delay="600">
            <div class="card color-cards">
              <div class="card-body p-0">
                <div class="bg-success text-center card-contents">
                  <div class="card-image">
                      <img src="//static-files-01-clients.coposoftware.com/prana/images/logo-bogota-design.jpg" class="case-studies-card-img" alt="">
                  </div>
                </div>
                <div class="card-details text-center pt-3">
					<h6 class="m-0 pb-3">Bogotá Design <br>Festival</h6>
                </div>
              </div>
            </div>
          </div>
		  <div class="col-12 col-md-6 col-lg-3 stretch-card" data-aos="zoom-in" data-aos-delay="600">
            <div class="card color-cards">
              <div class="card-body p-0">
                <div class="bg-info text-center card-contents">
                  <div class="card-image">
                      <img src="//static-files-01-clients.coposoftware.com/prana/images/logo-fundacion-bolivar.jpeg" class="case-studies-card-img" alt="">
                  </div>
                </div>
                <div class="card-details text-center pt-3">
                    <h6 class="m-0 pb-3">Fundación Bolivar <br>Davivienda</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="customer-feedback" id="founders-section">
        <div class="row">
          <div class="col-12 text-center pb-5">
            <h2>Integrantes</h2>
            <h6 class="section-subtitle text-muted m-0">Lorem ipsum dolor sit amet, tincidunt vestibulum.</h6>
          </div>
          <div class="owl-carousel owl-theme grid-margin">
              <div class="card customer-cards">
                <div class="card-body">
                  <div class="text-center">
                    <img src="http://pranainc.org/wp-content/uploads/2023/10/imagen_2023-10-25_195852058.png" width="89" height="89" alt="" class="img-customer">
                    <p class="m-0 py-3 text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
                    <div class="content-divider m-auto"></div>
                    <h6 class="card-title pt-3">Juan Carlos Gaitan</h6>
                    <h6 class="customer-designation text-muted m-0">CEO</h6>
                  </div>
                </div>
              </div>
              <div class="card customer-cards">
                <div class="card-body">
                  <div class="text-center">
                    <img src="http://pranainc.org/wp-content/uploads/2023/10/imagen_2023-10-25_195655578.png" width="89" height="89" alt="" class="img-customer">
                    <p class="m-0 py-3 text-muted">Lorem ipsum dolor sit amet, tincidunt vestibulum. Fusce egeabus consectetuer turpis, suspendisse.</p>
                    <div class="content-divider m-auto"></div>
                    <h6 class="card-title pt-3">Diego Garcia-Reyes</h6>
                    <h6 class="customer-designation text-muted m-0">Representante</h6>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </section>
      <footer class="border-top">
        <div class="d-flex justify-content-between">
          <p class="text-center text-muted pt-4">Copyright © 2023 - {{ date('Y') }}<a href="https://www.tuproyecto.com/" class="px-1">TuProyecto.com.</a> Todos los derechos reservados.</p>
          <div class="d-flex justify-content-start pt-4">
            <p class="text-center text-small">
              Cónocenos <a href="https://www.pranainc.org/" target="_blank" class="text-dark">Prana INC</a>
			</p>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="//static-files-01-clients.coposoftware.com/prana/js/jquery.min.js"></script>
  <script src="//static-files-01-clients.coposoftware.com/prana/js/bootstrap.min.js"></script>
  <script src="//static-files-01-clients.coposoftware.com/prana/js/owl.carousel.min.js"></script>
  <script src="//static-files-01-clients.coposoftware.com/prana/js/aos.js"></script>
  <script src="//static-files-01-clients.coposoftware.com/prana/js/landingpage.js"></script>
  <script>
	$(document).ready(function () {
		$('div[id^="modal"]').remove();
	});
  </script>
@endsection
