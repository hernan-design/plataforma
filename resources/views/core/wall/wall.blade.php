@extends('layout.core.layout')

@section('content')

	<section id="wall-wrapper">
		<div class="row collapse top-section">
			<div class="small-12 columns">
				<div class="row">
					<div class="large-7 columns">
						{!! Form::open( ['action' => null, 'data-abide' => '', 'id' => 'form-post-wall'] ) !!}

							<div class="row collapse tool-sub-section">
								<div class="small-10 columns">
									<div class="block-tool-section textarea-post clearfix">
										<div class="row">
											<div class="small-12 columns wrap-texteditor-post">
												{!! Form::textarea('texto_muro', null,
													array(
														'class' => 'wysiwyg-postwall',
														'placeholder' => 'Comparte algo con nuestra comunidad.',
														'required' => 'required',
														'pattern' => 'max_char_textarea',
														'cols' => '50',
														'rows' => '2'
													))
												!!}
												{{-- <small class="error">El campo esta vació o tiene muy pocos caracteres</small> --}}
											</div>
										</div>
									</div>
								</div>
								<div class="small-2 columns">
									<ul class="small-block-grid-1 list-tool-section">
										<li>
											{!! Form::submit('Publicar', array('class' => 'button tiny expand')) !!}
										</li>
									</ul>
								</div>
							</div>
						{!! Form::close() !!}
					</div>

					<div class="large-3 columns">
						{{-- Next Events --}}
						@include('public/nextevents')

					</div>

					<div class="large-2 columns">
						{{-- Social include --}}
						@include('public/social')
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns">
				<div class="row">
					<div class="large-9 columns" id="wrapper-posts-wall">
						<div id="wrapper-preview-post"></div>
						<div id="wall-submenu-filter" class="title-section text-center">
							<dl class="top-sub-nav text-left">
								<dd class="active">{!! HTML::link('#all', 'Todos') !!}</dd>
								{{-- <dd>{{ HTML::link('#institution', 'Mi Institución') }}</dd>
								<dd>{{ HTML::link('#friends', 'Mi Red') }}</dd> --}}
								<dd>{!! HTML::link('#important', 'Destacados') !!}</dd>
							</dl>
						</div>
						@include('public.noresults')
						<section id="wall-posts-wrap">
							{{-- Render template post wall --}}
						</section>
					</div>

					<div class="large-3 columns">
						<aside class="data-aside data-aside-right">
							{{-- FAQ forum --}}
							@include('public.forum.faqlist')

							{{-- Convocatorias include --}}
							@include('public.opencalls')

							{{-- Blog's last posts include --}}
							@include('public.bloglastposts')

						</aside>
					</div>
				</div>
			</div>
		</div>

	</section>

@stop
