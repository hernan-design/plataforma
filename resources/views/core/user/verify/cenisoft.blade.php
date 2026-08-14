<div class="verify-account-content-box">
	@if(isset($response->message) && $response->message != null)
		<p>{!! $response->message !!}</p>
	@endif

	@if(isset($response->link) && $response->link != null)
		<a href="{{ $response->link }}" target="_blank" class="verify-account-link inst-color-secondary">{{ $response->text }}</a>
	@endif

	@if(isset($response->button) && $response->button != null)
		<a href="{{ route('verify.account') }}" class="button small radius btn-resetc sky-blue">{{ $response->button }}</a>
	@endif
</div>