@if (isset($breadcrumbs) && isset($url))
	<ul class="breadcrumbs">
		<li><a href="{{{ $url }}}">inicio</a></li>
		@foreach ($breadcrumbs as $breadcrumb)
        	@php $url .= $breadcrumb @endphp
        	@if ($breadcrumb)
				<li><a href="{{{ $url }}}">{{{ $breadcrumb }}}</a></li>
        	@endif
       		@php $url .= '/' @endphp
        @endforeach
    </ul>
@endif
