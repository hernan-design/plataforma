<section id="innpulsa-stats" class="section-land" data-stellar-background-ratio="0.5" data-magellan-destination="innpulsa-stats">
	{{--
	<div class="text-center">
		<h2 class="section-title white-text">Impacto aldea</h2>
	</div>
	<div class="innpulsa-slick-stats">
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number">6.300</h3>
                <p class="stats-numbers-text white-text">Postulaciones</p>
            </div>
        </div>
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number" style="font-size: 17px !important;">$18.120.000.000</h3>
                <p class="stats-numbers-text white-text">Millones en llaves destinadas a 600 emprendimientos</p>
            </div>
        </div>
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number">1335</h3>
                <p class="stats-numbers-text white-text">Acuerdos</p>
            </div>
        </div>
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number">600</h3>
                <p class="stats-numbers-text white-text">Emprendimientos</p>
            </div>
        </div>
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number">33%</h3>
                <p class="stats-numbers-text white-text">Crecimiento en ventas</p>
            </div>
        </div>
        <div class="wrap-img-slider">
            <div class="stats-item text-center">
                <h3 class="title-medium stat-number">39%</h3>
                <p class="stats-numbers-text white-text">Crecimiento en empleados</p>
            </div>
        </div>
    </div>
	-}}
	{{-- map --}}
	<div id="innpulsa-achievements" class="section-land no-padding" style="background:#fbfbfb;">
		<iframe class="full-width" height="450" src="https://www.youtube.com/embed/UBwy4PlaQRw"  allowfullscreen></iframe>
		<div class="row" style="background:white;transform: translateY(-6px);">
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<img class="center-block" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/IMG1.png" alt="">
			</div>
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<img class="center-block" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/IMG2.png" alt="">
			</div>
		</div>
		<div class="row" style="background:white;transform: translateY(-6px);">
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<div id="map-content-box" class="map-content-box">
					{{-- department info render --}}
				</div>
			</div>
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<div id="innpulsa-colombia-map" class="innpulsa-colombia-map-box" style="background:#0C216A;">
					{{-- map render --}}
				</div>
			</div>
		</div>
	</div>

	{{-- javascript template --}}
	<script type="text/template" id="department-map-tpl">

		<ul style="list-style:none;">
			<li>
				<img src="<%- imgdep %>"  style="padding-left:80px;" 
												alt="">
			</li>
		</ul>
		
		<ul class="" style="list-style:none;padding-left:80px;">
			<li class="has-image">
				<h3 style="font-family: 'Montserrat Bold';
				color: #FF0000;
				font-size: 14px;
				letter-spacing: 6px;
				margin-top: 20px;
				line-height: 30px;">BENEFICIOS DEL PROGRAMA EN:</h3><br>
			</li>
			<li>
				<h4 class="achievements-region-name"><%- region %></h4>
			</li>
			<li>
				<h5 class="benefited-companies-number" style="font-family: 'Montserrat Regular';
				font-size: 30px;
				color: #0C216A;
				margin-top: 55px;"><%- benefitedCompanies %></h5>
			</li>
			<li>
				<p class="benefited-companies-text" style="font-family: 'Montserrat Medium';
				font-size: 18px;
				color: #888888;
				width: 240px;">Empresas beneficiadas en el Departamento</p>
			</li>
			<li class="has-image">
				<h5 class="benefited-projects-number" style="font-family: 'Montserrat Regular';
				font-size: 30px;
				color: #0C216A;
				margin-top: 55px;"><%- benefitedProjects %></h5>
			</li>
			<li>
				<p class="benefited-projects-text" style="font-family: 'Montserrat Medium';
				font-size: 18px;
				color: #888888;
				width: 240px;">Recursos invertidos en Emprendimiento</p>
			</li>
		</ul>

	</script>
</section>
