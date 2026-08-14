<div class="content-noauth">
	<div class="row collapse">
		<div class="small-9 columns message-noauth">
			<p>{{{ $message }}}</p>
		</div>
		<div class="small-12 columns text-right btns-noauth">
			<div class="row collapse">
				<div class="large-8 columns">
					<p class="inst-color-invert">Haz parte de nuestra comunidad</p>
				</div>
				<div class="large-2 columns">
					<a href="{{ URL::route('home') }}" class="button tiny expand">
						Registro
					</a>
				</div>
				<div class="large-2 columns">
					<a href="{{ URL::route('home') }}" class="button tiny expand">
						{{{ Lang::get('app.login') }}}
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
