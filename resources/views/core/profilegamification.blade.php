<div id="ranking-profile-user" class="row collapse inst-bgcolor inst-color">
	<div class="large-5 columns">
		<a href="{{ URL::route('usuario.nickname', Auth::user()->nickname_usuario) }}" class="left inst-user-ranking">
			{{ HTML::image(Auth::user()->imagen_usuario, Auth::user()->nickname_usuario, array('title' => Auth::user()->getName())) }}
		</a>
		<div class="left info-user-ranking">
			<a href="{{ URL::route('usuario.nickname', Auth::user()->nickname_usuario) }}" class="nickname-user-ranking">
				{{{ Auth::user()->nickname() }}}
			</a>
			<span class="name-inst-ranking">{{{ Cookie::get('_inst_name') }}}</span>
		</div>
	</div>


	<div class="large-7 columns">
		<ul class="small-block-grid-4 position-user-ranking">
			<li>
				<label>Puntaje</label>
				<div class="wrap-ranking-info">
					<i class="tp-icon tp-icon-cup"></i>
					<span class="value-ranking">{{ Auth::user()->contador_gamification }}</span>
				</div>
			</li>
			<li>
				<label>Medallas</label>
				<div class="wrap-ranking-info">
					<i class="tp-icon tp-icon-star"></i>
					<span class="value-ranking">0</span>
				</div>
			</li>
			<li>
				<label>Ranking</label>
				<div class="wrap-ranking-info">
					<i class="tp-icon tp-icon-crown"></i>
					<span class="value-ranking">{{ Auth::user()->posicion_gamification }}</span>
				</div>
			</li>
			<li>
				<label>Recompensas</label>
				<div class="wrap-ranking-info">
					<i class="tp-icon tp-icon-shooting"></i>
					<span class="value-ranking">0</span>
				</div>
			</li>
		</ul>
	</div>
</div>
