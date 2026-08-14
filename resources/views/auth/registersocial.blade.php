@if(App\RegistroSesion::getLoginSocial())
	<div class="row">
		<div class="mobile-12 tablet-11 tablet-centered columns">
			<div class="content-social-register text-center">
				<label class="label title text-center text-md lighter-text">Regístrate a través de:</label>

				<ul class="social-login mobile-block-grid-1 tablet-block-grid-3 list-register-social text-center">
					<li>
						<a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="login_facebook button small expand social-btn-facebook btn-lowerc radius btn-shadow btn-bold social-btn-register text-left">
							Facebook
							<i class="right mdi mdi-facebook icon-btn mdi-16"></i>
						</a>
					</li>
					<li>
						<a href="{{ route('auth.provider', ['provider' => 'linkedin']) }}" class="login_linkedin button small expand social-btn-linkedin btn-lowerc radius btn-shadow btn-bold social-btn-register text-left">
							Linkedin
							<i class="right mdi mdi-linkedin-box icon-btn mdi-16"></i>
						</a>
					</li>
					<li>
						<a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="login_twitter button small expand btn-lowerc radius btn-shadow btn-bold social-btn-twitter social-btn-register text-left">
							X
							<i class="right mdi mdi-close-outline icon-btn mdi-16"></i>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
@endif
