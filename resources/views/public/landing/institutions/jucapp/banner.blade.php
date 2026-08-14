<section id="bolivar-banner">
	<figure class="slick-slider-default">
		<div class="wrap-img-slider">
			<div class="slider-img">
			</div>
			<div class="slick-slider-content xlarge-offset-1">
				<div class="rows">
					<div class="small-12 tablet-12 xlarge-5 columns">
						<div class="slider-content">
							<H5 class="slick-title-1">¿Tienes talento?</H5>
							<p class="slick-text-1">Encuentra tu empleo ideal, ¡engánchate al mundo laboral!  </p>
							<div class="panel">
								<strong>
									<p>Busca una oferta</p>
								</strong>
								<div class="row">
									{!! Form::open(['route' => 'search.index', 'method' => 'GET', 'id' => 'form-search']) !!}
									<div class="large-4 columns">
										<input type="text" placeholder="ej. Operador" id="" name="search" >
									</div>
									<div class="large-4 columns">
										<select name="category_program" id="category_program">
											
												<option value="--">Cargo area</option>
										
												@foreach( App\CategoriaProceso::getCategoriesProcess() as $category)
													<option value="{{ $category->key }}"   >{{ $category->value}}</option>
												@endforeach
										</select>
									</div>
									<div class="large-4 columns">
										<button type="submit">
											Buscar oferta &nbsp; <i class="mdi mdi-20 mdi-magnify icon-search"></i>
										</button>
									{!! Form::close() !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</figure>
</section>
