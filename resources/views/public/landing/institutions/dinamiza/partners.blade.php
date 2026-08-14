{{-- dinamiza partners --}}
@if(isset($partners) && count($partners) > 0)
<section id="dinamiza-partners" class="block-vpadding-top section-land" data-stellar-background-ratio="0.5">
    <div class="partners-container">
        <div class="row">
            <div class="small-12 columns">
                <h3 class="section-title text-center white-text">En Dinamiza te podrás conectar con</h3>
            </div>
        </div>
        <div class="slick-dinamiza-partners block-vpadding-both">
            @if(isset($partners))
                @foreach ($partners as $partner)
                    <div class="partners-slick-item wrap-img-slider">
                        @if($partner->url_aliado)
                            <a href="{{{ $partner->url_aliado }}}" title="{{{ $partner->nombre_aliado }}}" target="_blank">
                                <img class="partners-slick-img" src="{{{ ($partner->logo_aliado ? $partner->logo_aliado : Config::get('tuproyecto.logo')) }}}" alt="{{{ $partner->nombre_aliado }}}">
                            </a>
                        @else
                            <img class="partners-slick-img" src="{{{ ($partner->logo_aliado ? $partner->logo_aliado : Config::get('tuproyecto.logo')) }}}" alt="{{{ $partner->nombre_aliado }}}">
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
@endif