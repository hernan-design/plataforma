@extends('layout.core.layout')

@section('title_site'){{ Lang::get('search.title') }}@stop
@section('meta_title'){{ Lang::get('search.title') }}@stop
@section('meta_description'){{ Lang::get('search.description') }}@stop
@section('meta_url'){{ Request::url() }}@stop

@section('content')
	<section id="search-wrapper">
		<section id="search-content" class="search-content clearfix">
			{{-- Search dinamic content --}}
			@yield('search.content')
			<div class="row">
				<div class="small-3 columns">
					<div class="menu-filter-panel">
						<h6 class="title-panel clean-bottom black-text text-md">
                            <i class="mdi mdi-tune mdi-24 gray-light vcenter gutter-right"></i>
                            Filtros
                        </h6>
						<div id="side-menu-filter" class="">
							{{-- Render side menu filter --}}
						</div>
					</div>
				</div>
				<div class="small-9 columns">
				@if(is_array($answer) && isset($answer['total_count']))
					<div class="search-results h-hollow-bottom margin-item-bottom">
							<p><b>{{$answer['total_count']}} </b>Resultados</p>
					</div>
					@if($answer['total_count'] > 0)
						@if(is_array($answer) && isset($answer['program']) && count($answer['program'])> 0)
							<div class="section-title margin-item-bottom">
								<span>Programas ({{ $answer['facets']['type']['program'] ?? count($answer['program']) }}) </span><a href={{route('convocatoria.index')}} class="text-md">Ver más</a>
							</div>
							<div class="content-data-list content-result-searches">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-2 medium-block-grid-3 xxlarge-block-grid-3 browse-list-mask browse-list-search responsive-browse">
									@foreach ($answer['program'] as $hit)
										@if($hit['type'] == 'program')
											<li>
												<a href="{{ TuProyecto::getRouteSearch($hit) }}">
													<div class="list-item-wrap radius">
														<div class="top-item-list no-border">
															<div class="item-thumb">
																<img src="{{ $hit['image'] }}" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
															</div>
														</div>
														<div class="text-left content-item-list">
															<h5 class="list-item-title is-hovered ellipsis bold-text black-text">{!! isset($hit['_highlightResult']['title']) ? $hit['_highlightResult']['title']['value'] : $hit['title'] !!}</h5>
															<p class="text-sm black-text ellipsis">{!! isset($hit['_highlightResult']['entity_name']) ? $hit['_highlightResult']['entity_name']['value'] : $hit['entity_name'] !!}</p>
															@php
																$categories = isset($hit['_highlightResult']['_categories']) ? $hit['_highlightResult']['_categories']['value'] : $hit['_categories'];
															@endphp
															@if($categories)
																<p class="text-sm light-text"><span class="dark-text">Categoría(s): </span>
																	@foreach(explode( ',', $categories ) as $i => $category)
																		@if($category)
																			@if($i + 1 < count(explode( ',', $categories )) )
																				<span>{{$category }}, </span>
																			@else
																				<span>{{$category }} </span>
																			@endif
																		@endif
																	@endforeach
																</p>
															@endif
															@php
																$stages = isset($hit['_highlightResult']['_stages']) ? $hit['_highlightResult']['_stages']['value'] : $hit['_stages'];
															@endphp
															@if($stages)
																<p class="text-sm light-text"> <span class="dark-text">Fase(s): </span>
																	@foreach(explode( ',', $stages ) as $i => $stage)
																		@if($stage)
																			@if($i + 1 < count(explode( ',', $stages )) )
																				<span>{{$stage }}, </span>
																			@else
																				<span>{{$stage }} </span>
																			@endif
																		@endif
																	@endforeach
																</p>
															@endif
                                                            @php
                                                                $lang = 'es';
                                                                $date = isset($hit['_highlightResult']['deadline']) ? $hit['_highlightResult']['deadline']['value'] : $hit['deadline'];

                                                                $messageDate = TuProyecto::remainingDaysToEnd($date);
                                                                $formattedDate =  TuProyecto::dateFormat($date, 'daymonthnameyear');
                                                            @endphp
                                                            @if($date)
                                                                <p class="text-sm light-text">
                                                                    @if($messageDate)
                                                                        <span class="success-text">Abierta:</span> {!! $formattedDate !!}
                                                                        <span>( {{ $messageDate   }})</span>
                                                                    @else
                                                                        <span class='alert-text'>{!!  transtp('programs.closed') !!}</span>
                                                                    @endif
                                                                </p>    
                                                            @endif
															<div class="bottom-item-list">
																<ul class="inline-list-grid align-center">
																	<li class="text-right item-search-icon">
																		<i class="mdi {{ config('tuproyecto.icon.'.$hit['type']) }} mdi-21 vcenter"></i>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
							<div class="h-hollow-bottom margin-item-bottom">
							</div>
						@endif
						@if(is_array($answer) && isset($answer['event']) && count($answer['event'])> 0)
							<div class="section-title margin-item-bottom">
								<span>Eventos ({{ $answer['facets']['type']['event'] ?? count($answer['event']) }}) </span><a href={{route('calendario.index')}} class="text-md">Ver más</a>
							</div>
							<div class="content-data-list content-result-searches">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 large-block-grid-3 browse-list-mask browse-list-search slick-browse-events responsive-browse">
									@foreach ($answer['event'] as $hit)
										@if($hit['type'] == 'event')
											<li class="item-events item-carousel">
												<a href="{{ TuProyecto::getRouteSearch($hit) }}">
													<div class="list-item-wrap radius">
														<div class="top-item-list no-border">
															<div class="item-thumb">
																<img src="{{ $hit['image'] }}" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
															</div>
														</div>
													</div>
													<div class="content-item-list text-left">
														<h5 class="title-item-list is-hovered ellipsis">{!! isset($hit['_highlightResult']['title']) ? $hit['_highlightResult']['title']['value'] : $hit['title'] !!}</h5>
                                                        @php
																$categories = isset($hit['_highlightResult']['_categories']) ? $hit['_highlightResult']['_categories']['value'] : $hit['_categories'];
                                                        @endphp
                                                        @if($categories)
                                                            <p class="text-sm light-text"><span class="dark-text">Categoría(s): </span>
                                                                @foreach(explode( ',', $categories ) as $i => $category)
                                                                    @if($category)
                                                                        @if($i + 1 < count(explode( ',', $categories )) )
                                                                            <span>{{$category }}, </span>
                                                                        @else
                                                                            <span>{{$category }} </span>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </p>
                                                        @endif
                                                        @php
                                                            $stages = isset($hit['_highlightResult']['_stages']) ? $hit['_highlightResult']['_stages']['value'] : $hit['_stages'];
                                                        @endphp
                                                        @if($stages)
                                                            <p class="text-sm light-text"> <span class="dark-text">Fase(s): </span>
                                                                @foreach(explode( ',', $stages ) as $i => $stage)
                                                                    @if($stage)
                                                                        @if($i + 1 < count(explode( ',', $stages )) )
                                                                            <span>{{$stage }}, </span>
                                                                        @else
                                                                            <span>{{$stage }} </span>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </p>
                                                        @endif
                                                        @php
                                                            $lang = 'es';
                                                            $date = isset($hit['_highlightResult']['deadline']) ? $hit['_highlightResult']['deadline']['value'] : $hit['deadline'];

                                                            $messageDate = TuProyecto::remainingDaysToEnd($date);
                                                            $formattedDate =  TuProyecto::dateFormat($date, 'daymonthnameyear');
                                                        @endphp
                                                        @if($date)
                                                            <p class="text-sm light-text">
                                                                @if($messageDate)
                                                                    <span class="success-text">Abierta:</span> {!! $formattedDate !!}
                                                                    <span>( {{ $messageDate   }})</span>
                                                                @else
                                                                    <span class='alert-text'>{!!  transtp('event.closed') !!}</span>
                                                                @endif
                                                            </p>    
                                                        @endif
														<div class="bottom-item-list">
															<ul class="inline-list-grid align-center">
																<li class="text-right item-search-icon">
																	<i class="mdi {{ config('tuproyecto.icon.'.$hit['type']) }} mdi-21 vcenter"></i>
																</li>
															</ul>
														</div>
													</div>
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
                        	<div class="h-hollow-bottom margin-item-bottom">
                        	</div>
						@endif 
						@if(is_array($answer) && isset($answer['product']) && count($answer['product'])> 0)
							<div class="section-title margin-item-bottom">
								<span>Servicios ({{ $answer['facets']['type']['product'] ?? count($answer['product']) }}) </span> <a href={{route('marketplace.index')}} class="text-md">Ver más</a>
							</div>
							<div class="content-data-list content-result-searches">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-2 medium-block-grid-3 xxlarge-block-grid-3 browse-list-mask browse-list-search responsive-browse">
									@foreach ($answer['product'] as $hit)
										@if($hit['type'] == 'product')
											<li>
												<a href="{{ TuProyecto::getRouteSearch($hit) }}">
													<div class="list-item-wrap radius">
														<div class="top-item-list no-border">
															<div class="item-thumb">
																<img src="{{ $hit['image'] }}" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
															</div>
														</div>
														<div class="text-left content-item-list">
															<h5 class="list-item-title is-hovered ellipsis bold-text black-text">{!! isset($hit['_highlightResult']['title']) ? $hit['_highlightResult']['title']['value'] : $hit['title'] !!}</h5>
															<p class="text-sm black-text ellipsis">{!! isset($hit['_highlightResult']['entity_name']) ? $hit['_highlightResult']['entity_name']['value'] : $hit['entity_name'] !!}</p>
															@php
																$categories = isset($hit['_highlightResult']['_categories']) ? $hit['_highlightResult']['_categories']['value'] : $hit['_categories'];
															@endphp
															<p class="text-sm light-text"><span class="dark-text">Categoría(s): </span>
																@foreach(explode( ',', $categories ) as $i => $category)
																	@if($category)
																		@if($i + 1 < count(explode( ',', $categories )) )
																			<span>{{$category }}, </span>
																		@else
																			<span>{{$category }} </span>
																		@endif
																	@endif
																@endforeach
															</p>
                                                            
															@if(isset($hit['precio']))
															<p class="text-sm light-text">
																<span class="dark-text">Valor: </span>
																<span>{{isset($hit['_highlightResult']['precio']) ? $hit['_highlightResult']['precio']['value'] : $hit['precio']}}</span>
															</p>
															@endif
															<div class="bottom-item-list">
																<ul class="inline-list-grid align-center">
																	<li class="text-right item-search-icon">
																		<i class="mdi {{ config('tuproyecto.icon.'.$hit['type']) }} mdi-21 vcenter"></i>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</a>
											</li>
										@endif
										@endforeach
								</ul>
							</div>
								<div class="h-hollow-bottom margin-item-bottom">
								</div>
						@endif
						@if(is_array($answer) && isset($answer['mentor']) && count($answer['mentor'])> 0)
							<div class="section-title margin-item-bottom">
								<span>Mentores ({{ $answer['facets']['type']['mentor'] ?? count($answer['mentor']) }}) </span>  <a href={{route('mentoria.index')}} class="text-md">Ver más</a>
							</div>
							<div class="content-data-list content-result-searches">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-2 medium-block-grid-3 xxlarge-block-grid-3 browse-list-mask browse-list-search responsive-browse">
									@foreach ($answer['mentor'] as $hit)
										@if($hit['type'] == 'mentor')
											<li>
												<a href="{{ TuProyecto::getRouteSearch($hit) }}">
													<div class="list-item-wrap radius">
														<div class="top-item-list no-border">
															<div class="item-thumb">
																<img src="{{ $hit['image'] }}" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
															</div>
														</div>
														<div class="text-left content-item-list">
															<h5 class="list-item-title is-hovered ellipsis bold-text black-text">{!! isset($hit['_highlightResult']['title']) ? $hit['_highlightResult']['title']['value'] : $hit['title'] !!}</h5>
															@if(isset($hit['speciality_name']) && !empty($hit['speciality_name']))
																<p class="text-sm light-text ellipsis"><span class="dark-text">Especialidad: </span>{!! isset($hit['_highlightResult']['speciality_name']) ? $hit['_highlightResult']['speciality_name']['value'] : $hit['speciality_name'] !!}</p>
															@endif
                                                            @php
																$stages = isset($hit['_highlightResult']['_stages']) ? $hit['_highlightResult']['_stages']['value'] : $hit['_stages'];
															@endphp
															@if($stages)
																<p class="text-sm light-text"> <span class="dark-text">Fase(s): </span>
																	@foreach(explode( ',', $stages ) as $i => $stage)
																		@if($stage)
																			@if($i + 1 < count(explode( ',', $stages )) )
																				<span>{{$stage }}, </span>
																			@else
																				<span>{{$stage }} </span>
																			@endif
																		@endif
																	@endforeach
																</p>
															@endif
															<div class="bottom-item-list">
																<ul class="inline-list-grid align-center">
																	<li class="text-right item-search-icon">
																		<i class="mdi {{ config('tuproyecto.icon.'.$hit['type']) }} mdi-21 vcenter"></i>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</div>
						@endif {{-- end if type mentor --}}
					@else
						@include('public.noresults', ['visible' => true, 'panel' => true])
					@endif {{-- end if total count > 0--}}
				@else
					@include('public.noresults', ['visible' => true, 'panel' => true])
				@endif
				</div>
			</div>
		</section>
	</section>
@stop



