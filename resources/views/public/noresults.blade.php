<div class="no-results-filter @if(!isset($visible)) hidesoft @endif">
	@if(isset($panel) && $panel) <div class="panel-content radius-tablet-up"> @endif
		@if( isset($message) )
			<p>{!! $message !!}</p>
			{{-- @if( isset($url) )
				<a href="{{ $url }}" class="no-results-create text-lg"><i class="mdi mdi-plus vcenter"></i>Crea uno nuevo aquí</a>
		 	@endif --}}
		@else
			<p>{{ trans('app.noresults') }}</p>
		@endif
	@if(isset($panel) && $panel) </div> @endif
</div>
