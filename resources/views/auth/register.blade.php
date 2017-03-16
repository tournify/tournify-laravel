@extends('layouts.default')

@section('title', trans('messages.register'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.register') }}</h2>
    </article>
    <section id="content" class="a">
        <article id="main">

            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="error-message">{{ $error }}</p>
                @endforeach
            @endif

            <div id="loginform">
                {!! Form::open(array('action' => 'Auth\AuthController@getRegister')) !!}
    <div>
        {!! Form::label('name', trans('messages.name') ) !!}
        <input type="text" name="name" value="{{ old('name') }}">
    </div>

    <div>
        {!! Form::label('email', trans('messages.email') ) !!}
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        {!! Form::label('password', trans('messages.password')) !!}
        <input type="password" name="password">
    </div>

    <div>
        {!! Form::label('password_confirmation',  trans('messages.passwordverify') ) !!}
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">{{ trans('messages.createaccount') }}</button>
    </div>
                {!! Form::close() !!}
                </div>

                <p>{{ trans('messages.orloginwith') }}</p>
                <div class="social">
                    <a href="/auth/instagram">
                        <i class="fa fa-instagram fa-4x"></i>
                    </a>
                    <a href="/auth/facebook">
                        <i class="fa fa-facebook-square fa-4x"></i>
                    </a>
                    <a href="/auth/twitter">
                        <i class="fa fa-twitter-square fa-4x"></i>
                    </a>
                    <a href="/auth/google">
                        <i class="fa fa-google-plus-square fa-4x"></i>
                    </a>
                    <a href="/auth/github">
                        <i class="fa fa-github-square fa-4x"></i>
                    </a>
                </div>
    </article>
    </section>
@stop