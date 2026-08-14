  @extends('public.search.search')

@section('search.content')
	{{-- ------------------ Search Templates JS -------------------- --}}
	<script type="text/template" id="search-sidemenu-filter-tpl">
		{!! Form::open(['route' => 'search.index', 'method' => 'GET', 'id' => 'form-filters-search'])  !!}
			<ul class="side-nav-slide">

				<li>
					<input type="radio" name="type" id="type-all" value="" class="check-filter with-gap" <%- type == '' ? 'checked' : '' %> onChange="this.form.submit()">
                
					<label for="type-all" class="text-sm">{{ Lang::choice('app.all', 0) }} <span class="gray-lighter">({{$answer['total_count'] ?? 0 }})</span></label>
				</li>
				{{-- <li>
					<input type="radio" name="type" id="type-courses" value="course" class="check-filter with-gap" <%- type == 'course' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-courses" class="text-sm">{{ Lang::choice('learn.course', 0) }} <span class="gray-lighter">(0)</span></label>
				</li> --}}
				{{-- <li>
					<input type="radio" name="type" id="type-articles" value="article" class="check-filter with-gap" <%- type == 'article' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-articles" class="text-sm">{{ Lang::choice('blog.article', 0) }} <span class="gray-lighter">({{ $answer['facets']['type']['article'] ?? 0 }})</span></label>
				</li> --}}
				{{-- <li>
					<input type="radio" name="type" id="type-forums" value="forum" class="check-filter with-gap" <%- type == 'forum' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-forums" class="text-sm">{{ Lang::choice('forum.forum', 0) }} <span class="gray-lighter">({{ $answer['facets']['type']['forum'] ?? 0 }})</span></label>
				</li> --}}
				<li>
					<input type="radio" name="type" id="type-programs" value="program" class="check-filter with-gap" <%- type == 'program' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-programs" class="text-sm">{{ transtp('programs.title') }} <span class="gray-lighter">({{ $answer['facets']['type']['program'] ?? 0 }})</span></label>
				</li>
				<li>
					<input type="radio" name="type" id="type-events"  value="event" class="check-filter with-gap" <%- type == 'event' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-events" class="text-sm">{{ Lang::choice('event.event', 0) }} <span class="gray-lighter">({{ $answer['facets']['type']['event'] ?? 0 }})</span></label>
				</li>
				<li>
					<input type="radio" name="type" id="type-products" value="product" class="check-filter with-gap" <%- type == 'product' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-products" class="text-sm">{{ transtp('search.typeProducts') }} <span class="gray-lighter">({{ $answer['facets']['type']['product'] ?? 0 }})</span></label>
				</li>
			    <li>
					<input type="radio" name="type" id="type-mentors" value="mentor" class="check-filter with-gap" <%- type == 'mentor' ? 'checked' : '' %> onChange="this.form.submit()">
					<label for="type-mentors" class="text-sm">{{ Lang::choice('mentoring.mentor', 0) }} <span class="gray-lighter">({{ $answer['facets']['type']['mentor'] ?? 0 }})</span></label>
				</li>
				<li id="filtro-etapa">
				</li>
				<li id="filtro-categoria">
				</li>
				<li id="filtro-entidad">
				</li>
			</ul>
			<input type="hidden" name="search" value="<%- search %>">
		{!! Form::close() !!}
	</script>


	{{-- template etapa --}}
	<script type="text/template" id="filtro-etapa-tpl">
		<div class="row" id="filtro-etapa-section">
			<div class="small-12 columns input-field">
				<select id="stage" name="stage" class="change-choice" required data-placeholder="{{ transtp('entities.project.placeholder.stage') }}" placeholder="{{ transtp('entities.project.placeholder.stage') }}" >
					<option value="">Todos</option>
					@foreach( App\EtapaProyecto::getStages() as $value)
						<option value="{{ $value->codigo_etapa_proyecto }}" <%- typeof(stage) !== 'undefined' && stage == '{{ $value->codigo_etapa_proyecto }}' ? 'selected': ''%>  >{{ $value->nombre_etapa_proyecto }}</option>
					@endforeach
				</select>
				<label>{{ transtp('entities.project.stage') }}:</label>
			</div>
		</div>
	</script>

	{{-- template categoria --}}
	<script type="text/template" id="filtro-categoria-tpl">
		<div class="row" id="filtro-categoria-section">
			<div class="small-12 columns input-field">
				<select id="category_program" name="category_program" class="change-choice" required data-placeholder="{{ transtp('entities.project.placeholder.category') }}" placeholder="{{ transtp('entities.project.placeholder.category') }}" >
					<option value="">Todos</option>

					@foreach( App\CategoriaProceso::getCategoriesProcess() as $category)

						<option value="{{ $category->key }}" <%- typeof(category_program) !== 'undefined' && category_program == '{{ $category->key }}' ? 'selected': ''%>  >{{ $category->value}}</option>
					@endforeach
				</select>
				<label for="category_program">{{ transtp('entities.project.category') }}:</label>
			</div>
		</div>
	</script>

	{{-- template entidad --}}
	<script type="text/template" id="filtro-entidad-tpl">
		<div class="row" id="filtro-entidad-section">
			<div class="small-12 columns input-field">
				<select id="entity" name="entity" class="change-choice" required data-placeholder="{{ transtp('entities.placeholder') }}" placeholder="{{ transtp('entities.placeholder') }}" >
					<option value="">Todos</option>

					@foreach( App\Entidad::getEntitiesCacheList() as $entity)

						<option value="{{ $entity->key }}" <%- typeof(entity) !== 'undefined' && entity == '{{ $entity->key }}' ? 'selected': ''%>  >{{ $entity->value}}</option>
					@endforeach
				</select>
				<label for="entity">{{ transtp('entities.title') }}:</label>
			</div>
		</div>
	</script>
	@stop

