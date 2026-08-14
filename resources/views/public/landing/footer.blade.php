<div class="copyright-social-footer">
	<div class="row valign-middle">
		<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
			<span class="inst-copyright">Todo el contenido &copy; {{ $institution->nombre_institucion }} {{ date('Y') }}</span>
		</div>
		<div class="mobile-12 tablet-4 columns text-center">
			{!! HTML::image((isset($parameters['imagen_footer']) ? $parameters['imagen_footer'] : Config::get('tuproyecto.logo')), 'Logo', array('id' => 'logo-bottom-inst')) !!}
		</div>
		<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-right">
			<ul class="list-social-footer text-small-right text-mobile-center">
				<li>
					<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
						<i class="mdi mdi-facebook"></i>
					</a>
				</li>
				<li>
					<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
						<i class="mdi mdi-close-outline"></i>
					</a>
				</li>
				<li>
					<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
						<i class="mdi mdi-youtube"></i>
					</a>
				</li>
				{{-- <li>
					<a href="" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
						<i class="mdi mdi-instagram"></i>
					</a>
				</li> --}}
			</ul>
		</div>
	</div>
</div>
