@extends('layout.core.layout')

@section('title_site'){{ Lang::get('passwords.title') }}@stop
@section('meta_title'){{ Lang::get('passwords.title') }}@stop
@section('meta_description'){{ Lang::get('passwords.description') }}@stop
@section('meta_url'){{ Request::url() }}@stop

@section('content')

<div id="reset-account" class="recovery-pass wrapper-signin">
    <div class="row">
        <div class="small-12 tablet-7 medium-5 tablet-centered columns">
            <div id="reset-account-content" class="inner-signin panel-content radius">
                {!! Form::open(['url' => 'password/reset', 'data-abide' => '', 'class' => '']) !!}
                    <div class="row">
                        <div class="small-12 columns">
                            <div class="wrap-icon-reset-account text-center">
                                <span class="reset-account-circle circle-reflex-bottom">
                                    <i class="mdi mdi-account-key"></i>
                                </span>
                            </div>

                            <p class="description-info text-center text-md">Ingresa tu nueva contraseña</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns input-field">
                            <i class="prefix mdi mdi-email"></i>
                            {!! Form::text('correo_electronico', $email ?: old('correo_electronico'), [
                                'id' => 'correo_electronico',
                                'required' => 'required',
                                'pattern' => 'email',
                                'class' => 'validate',
                                'readonly' => 'readonly'
                            ]) !!}
                            <label for="correo_electronico" data-error="E-mail incorrecto.">E-mail</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns input-field">
                            <i class="prefix mdi mdi-lock"></i>
                            {!! Form::password('password', [
                                'id' => 'password',
                                'class' => 'validate',
                                'required' => 'required',
                                'pattern' => 'password_valid'
                            ]) !!}
                            <span class="error">{{ trans('passwords.password') }}</span>
                            <label for="password">Contraseña</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 columns input-field">
                            <i class="prefix mdi mdi-lock"></i>
                            {!! Form::password('password_confirmation', [
                                'id' => 'password_confirmation',
                                'required' => 'required',
                                'data-equalto' => 'password',
                                'class' => 'validate'
                            ]) !!}
                            <label for="password_confirmation" data-error="Las contraseñas no coincide.">Confirmar contraseña</label>
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
                    @endif

                    <div class="row">
                        <div class="small-12 columns">
                            {!! Form::submit('Confirmar', ['class' => 'button xmedium sky-blue expand btn-shadow radius']) !!}
                        </div>
                    </div>
                    {!! Form::hidden('token', $token) !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>

</div>

@stop