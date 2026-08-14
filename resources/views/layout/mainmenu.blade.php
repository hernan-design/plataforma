<div id="topmenu-main-options" class="">
	<div class="row md-wrapper">
		<div class="small-12 columns">

			<div class="top-menu-opts">
				<ul class="inline-list-grid valign-bottom">
					<li class="has-image">
						<i class="mdi mdi-sign-direction mdi-36 sky-blue"></i>
					</li>
					<li>
						<span class="text-md lighter-text gray-base-text">
							@if(Auth::check()) Hola <span class="dark-text normal-text">{{ Auth::user()->nombre_usuario }}</span>, @endif
							Bienvenido a <span class="sky-blue-text">{{ App\RegistroSesion::getWelcomeName() }}</span>.
						</span>
					</li>
				</ul>
			</div>
			@php $parents = App\Menu::getParents(App\TipoMenu::getType('platform')); @endphp
			<ul class="wrapper-item-options mobile-block-grid-2 tablet-block-grid-3 medium-block-grid-4">
				@foreach ($parents as $parent)
					<li>
						<div class="item-menu-opts">
							<h4 class="title-category-opts">
								<ul class="inline-list-grid valign-center">
									<li>{{ $parent->nombre_item_menu }}</li>
									<li class="has-image text-right"><i class="{{ $parent->icono_menu_item ?: 'mdi mdi-web' }} mdi-36 sky-blue"></i></li>
								</ul>
							</h4>
							<ul class="list-menu-opts tabs-route" data-tab data-options="is_hover:true">
								@php $children = App\Menu::getChildren(App\TipoMenu::getType('platform'), $parent->codigo_menu_institucion); @endphp
								@foreach ($children as $son)
									<li id="{{ $son->ruta_menu_institucion }}" class="tab-title {{ $son->clase_item_menu ? $son->clase_item_menu : '' }}">
										<a 	href="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('internal') ? ($son->ruta_menu_institucion ? url($son->ruta_menu_institucion) : '') : $son->ruta_menu_institucion }}"
											target="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('external') ? '_blank' : ''}}"
											data-section="{{ $son->seccion_menu_institucion }}"
											aria-controls="opt-{{ $son->codigo_menu_institucion }}">{{ $son->nombre_item_menu }}</a>
									</li>
								@endforeach
							</ul>
						</div>
					</li>
				@endforeach
			</ul>
			<div class="bottom-menu-opts tabs-content">
				<div class="content active">
					<div class="row">
						<div class="small-10 small-centered columns">
							<h4 class="thin-header gray-base-text text-center">
								<i class="mdi mdi-settings gray-base-text mdi-21 vcenter"></i>
								<span class="gray-base-text vcenter-text">Elige una opción del menú</span>
							</h4>
						</div>
					</div>
				</div>
				@foreach ($parents as $parent)
					@php $children = App\Menu::getChildren(App\TipoMenu::getType('platform'), $parent->codigo_menu_institucion); @endphp
					@foreach ($children as $son)
						<div id="opt-{{ $son->codigo_menu_institucion }}" class="content option-description inst-bgcolor-secondary landing-bgcolor-secondary">
							<div class="row">
								<div class="small-10 small-centered columns">
									<h4 class="thin-header text-center">
										<i class="{{ $son->icono_menu_item ?: 'mdi mdi-clipboard-text' }} mdi-21 vcenter"></i>
										<span class="vcenter-text">{{ $son->nombre_item_menu }}</span>
									</h4>
									<p class="text-md text-center">{{ $son->descripcion_menu_item }}</p>
								</div>
							</div>
						</div>
					@endforeach
				@endforeach
			</div>

		</div>
	</div>
</div>
