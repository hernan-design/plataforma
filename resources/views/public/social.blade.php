@if( in_array(Request::segment(1), ['muro', 'foro']) )
	<div class="social-accounts {{-- inst-bgcolor inst-color --}} inst-color-invert">
		<div class="row collapse">
			<div class="small-12 columns text-center">
				<label class="inline">{{{ Lang::get('app.followus') }}}</label>
			</div>
			<div class="small-12 columns text-center">
				<ul class="list-social-icons-account">
					<li class="text-left">
						<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank">
							<i class="fa fa-facebook"></i>
							{{-- <i class="social social-facebook-lt"></i> --}}
						</a>
					</li>
					<li class="text-left">
						<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank">
							<i class="fa-brands fa-x-twitter"></i>"></i>
							{{-- <i class="social social-twitter-icon"></i> --}}
						</a>
					</li>
					<li class="text-right">
						<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank">
							<i class="social social-youtube-icon"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
@else
	<div class="social-accounts-container clearfix show-for-medium-up">
		<ul class="right list-social-accounts">
			<li>
				<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank" class="circle-social youtube">
					<i class="mdi mdi-youtube-play"></i>
				</a>
			</li>
			<li>
				<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank" class="circle-social twitter">
					<i class="mdi mdi-close-outline"></i>
				</a>
			</li>
			<li>
				<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank" class="circle-social facebook">
					<i class="mdi mdi-facebook"></i>
				</a>
			</li>
		</ul>
	</div>
@endif
