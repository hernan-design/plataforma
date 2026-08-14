<script type="text/template" id="project-program-review-365-tpl">
	<div class="panel-review-program-project panel-content radius">
		<!-- div class="submenu-tabs-review-program no-shadow no-border clearfix">
			<ul id="project-tabs-navs-review" class="project-program-submenu-review tabs-sub-nav" data-tab
				data-tab-init="is_hover:false">
				<li class="tab-title active">
					<a href="#program-preview-result" title="Resultado"
					   aria-controls="program-preview-result">Resultado</a>
				</li>
				<li class="tab-title">
					<a href="#program-preview-diagnostic" title="Diagnóstico"
					   aria-controls="program-preview-diagnostic">Diagnóstico</a>
				</li>
				<li class="tab-title">
					<a href="#program-preview-opportunities" title="Oportunidades"
					   aria-controls="program-preview-opportunities">Oportunidades</a>
				</li>
			</ul>
		</div> -->

		<!-- <div class="tabs-content"> -->
		<div id="program-preview-diagnostic" class="">
			<div class="inner-panel-program-review">
				<h5 class="inst-color-secondary bold-text">Resultados del diagnóstico empresarial.</h5>
				<br>
				<p>A continuación encontrarás los resultados del diagnóstico de tu empresa/emprendimiento. Estos resultados se componen de una gráfica de radar con el puntaje de las tres áreas evaluadas, una recomendación general para cada área y recomendaciones de recursos con los que puedes fortalecer tu empresa/emprendimiento.</p>
			</div>
			<div class="inner-panel-program-review">
				<canvas id="chart-area-result-program"></canvas>
			</div>
		</div>



		<div id="program-preview-result" class="">
			<!-- Informacion de la empresa -->
			<div class="inner-panel-program-review">
<%= report['data_general']['texto_respuesta'] %>
</div>
</div>


<!-- </div> -->
</div>
</div>
</script>
