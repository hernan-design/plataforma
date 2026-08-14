@extends('layout.core.layout')

@section('title_site'){{ Lang::get('passwords.title') }}@stop
@section('meta_title'){{ Lang::get('passwords.title') }}@stop
@section('meta_description'){{ Lang::get('passwords.description') }}@stop
@section('meta_url'){{ Request::url() }}@stop

@section('content')
<div id="remind-account" class="recovery-pass wrapper-signin">
    <div class="row">
        <div class="small-12 tablet-7 medium-5 tablet-centered columns">
            <div id="remind-account-content" class="inner-signin panel-content radius">
                {!! Form::open(['url' => 'password/email', 'data-abide' => '']) !!}
                    <div class="row">
                        <div class="small-12 columns">
                            <div class="wrap-icon-remind-account text-center">
                                <span class="remind-account-circle circle-reflex-bottom">
                                    <i class="mdi mdi-account-key"></i>
                                </span>
                            </div>
                            <p class="description-info text-center text-md">Introduce tu dirección de correo electrónico.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns input-field">
                            <i class="prefix mdi mdi-email"></i>
                            {!! Form::text('correo_electronico', old('correo_electronico'), [
                                'required' => '',
                                'pattern' => 'email',
                                'class' => 'validate'
                            ]) !!}
                            <label for="correo_electronico" data-error="Campo obligatorio o e-mail incorrecto">E-mail</label>
                        </div>
                    </div>

                    @if($errors->any())
                        <div class="row">
                            <div class="small-12 columns">
                                <div data-alert class="notice-box-tp alert" style="display:block;">
                                    <i class="icon-alert"></i>
                                    <span>
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{!! $error !!}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @elseif (Session::has('status'))
                        <div class="row">
                            <div class="small-12 columns">
                                <div data-alert class="notice-box-tp success" style="display:block;">
                                    <i class="icon-alert"></i>
                                    <span>{{ Session::get('status') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="small-12 columns">
                            {!! Form::submit('Enviar', ['class' => 'button xmedium sky-blue expand btn-shadow radius']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop