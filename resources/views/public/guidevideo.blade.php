<div id="videoModal" class="reveal-modal-main small clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h6 class="inner-title-modal text-center">{{ $title }}</h6>
	</div>
	{{-- Content modal --}}
	<div class="content-modal">
		<div class="content-modal-video flex-video widescreen vimeo">
			<div id="{{ $playerid }}" class="video-swfobject" data-urlvideo="{{ $urlvideo }}">
				{{-- Lang::get('app.flashplayer.requiere') --}}
			</div>
		</div>
	</div>
	{{-- Footer modal --}}
	<div class="footer-modal hidesoft"></div>
	<a class="close content-close close-reveal-modal">&#215;</a>
</div>