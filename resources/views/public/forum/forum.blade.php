@extends('layout.core.layout')

@section('content')
	<section id="foro-wrapper">
		<div class="row collapse top-section">

			<div class="small-12 columns">
				<div class="row">

					<div class="medium-7 columns">
						<div class="row collapse tool-sub-section">
							<div class="small-12 columns">
								<div class="block-tool-section">
									<div class="section-title inst-color-invert">
										{{-- Render section title --}}
									</div>
								</div>
							</div>
							{{-- <div class="small-2 columns">
								<ul class="small-block-grid-1 list-tool-section">
									<li>
										{!! HTML::link('#', 'Crear Tema', array('class' => 'button tiny expand create-theme')) !!}
									</li>
								</ul>
							</div> --}}
						</div>
					</div>

					<div class="large-3 columns">
						{{-- Next Events --}}
						@include('public/nextevents')
					</div>

					<div class="medium-2 columns">
						{{-- Social include --}}
						@include('public/social')
						{{-- <div class="content-search-form inst-bgcolor inst-color">
							{!! Form::open( array('action' => null, 'id' => 'search-form-forum') ) !!}
								<div class="row collapse">
									<div class="large-12 columns">
										<div class="row collapse">
											<div class="large-10 columns">
												{!! Form::text('filter', '', array('placeholder' => 'Busqueda...')) !!}
											</div>
											<div class="large-2 columns">
												<button class="postfix btn-search">
													<i class="fa fa-search"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							{!! Form::close() !!}
						</div> --}}
					</div>

				</div>
			</div>

		</div>

		<div class="row">
			<div class="large-9 columns">
				<div class="create-post-forum hidesoft">
					@if (Auth::check())
						{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-forum') ) !!}
							<fieldset>
								<a href="" class="create-theme close content-close">&times;</a>
								<div class="row">
									<div class="large-12 columns">
										<label for="titulo_foro">
											<span class="required-star">*</span>
											Titulo del tema
										</label>
										<small class="description-field-form">Si no sabes que escribir o necesitas asesoria puedes escribir tu pregunta y un asesor o la comunidad te ayudará</small>
										{!! Form::text('titulo_foro', null,
											array(
												'class' => '',
												'placeholder' => 'Titulo',
												'autofocus' => 'autofocus',
												'required' => 'required',
												'pattern' => "^.{1,125}$"
											))
										!!}
									</div>
								</div>
								<div class="row">
									<div class="large-12 columns">
										<label for="descripcion_foro">
											<span class="required-star">*</span>
											Descripción
										</label>
										{!! Form::textarea('descripcion_foro', null,
											array(
												'class' => '',
												'rows' => '3',
												'placeholder' => 'Descripción',
												'required' => 'required'
											))
										!!}
									</div>
								</div>
								<div class="row">
									<div class="large-8 columns">
										<label for="codigo_categoria_foro">
											<span class="required-star">*</span>
											Categoría
										</label>
										{!! Form::select('codigo_categoria_foro', array('' => Lang::get('app.default.select')) + $categories, '',
											array(
												'required' => 'required',
												'data-placeholder' => 'Elige una categoria.'
											))
										!!}
									</div>
								</div>
								<div class="row">
									<div class="large-8 columns">
										<small class="description-field-form">
											Selecciona los tags que esten relacionados con tu pregunta (Opcional)
										</small>
										{!! Form::text('tags_foro', null,
											array(
												'class' => '',
												'id' => 'tags_foro',
												'placeholder' => 'Agrega una etiqueta.'
											))
										!!}
									</div>
								</div>
								<div class="row collapse">
									<div class="large-12 columns"><hr></div>
								</div>
								<div class="row">
									<div class="right large-2 columns text-right">
										{!! Form::submit('Crear', array('class' => 'button tiny expand')) !!}
									</div>
								</div>
							</fieldset>
						{!! Form::close() !!}
					@else
						@include('public.unauth', array('message' => Lang::get('forum.unauth.theme')))
					@endif
				</div>
				<div class="forum-content-rules hidesoft">
					<a href="#" class="show-forum-rules close content-close">&times;</a>
					{!! Lang::get('forum.rules') !!}
				</div>
				<section id="forum-wrap" class="forum-wrap">

					{{-- Forum dinamic content  --}}
					@yield('forum.content')

				</section>
			</div>
			<div class="large-3 columns">
				<aside class="data-aside">
					<div class="key-words">
						<div class="title-section">
							<h6 class="inner-title-section text-center">Palabras Clave</h6>
						</div>
						<div class="tagcloud-forum"></div>
					</div>
				</aside>
			</div>
		</div>
	</section>
@stop
