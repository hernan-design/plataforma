<div class="footer-sitemap-legal hide-for-mobile-only show-for-tablet">
	<nav class="footer-site-map">
		<div class="row">
			@php $parents = App\Menu::getParents(App\TipoMenu::getType('sitemap')); @endphp
			@foreach ($parents as $parent)
				<div class="mobile-12 tablet-6 medium-3 columns">
					<ul class="footer-site-map-nav">
						<li>{{ $parent->nombre_item_menu }}</li>
						@php $children = App\Menu::getChildren(App\TipoMenu::getType('sitemap'), $parent->codigo_menu_institucion); @endphp
						@foreach ($children as $son)
							<li><a href="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('internal') ? ($son->ruta_menu_institucion ? url($son->ruta_menu_institucion) : '#') : $son->ruta_menu_institucion }}" target="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('external') ? '_blank' : ''}}" data-section="{{ $son->seccion_menu_institucion }}">{{ $son->nombre_item_menu }}</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endforeach
			<div class="mobile-12 tablet-6 medium-3 columns">
				<ul class="footer-site-map-nav">
					<li>Contacto</li>
					{!! $institution->contacto_institucion !!}
				</ul>
			</div>
		</div>
	</nav>
	<div class="row">
		<div class="columns small-12">
			<div class="footer-legal">
				<ul class="footer-legal-nav">
					<li>{!! link_to_route('terminos', 'Términos de Uso') !!}</li>
					<li>{!! link_to_route('privacidad', 'Políticas de Privacidad') !!}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
