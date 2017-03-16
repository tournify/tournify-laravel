@extends('layouts.default')

@section('title', trans('messages.login'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('messages.defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.login') }}</h2>
    </article>
    <section id="content" class="a">
    <article id="main">
        @if($errors->has())
            @foreach($errors->all() as $error)
                <p class="error-message">{!!$error!!}</p>
            @endforeach
        @endif
        <div id="loginform">
        {!! Form::open(array('action' => 'Auth\AuthController@getIndex')) !!}
        {!! Form::label('email', trans('messages.email') ) !!}
            {!! Form::email('email', $value = null, $attributes = array()) !!}
        {!! Form::label('password', trans('messages.password') ) !!}
            {!! Form::password('password') !!}
        {!! Form::submit(trans('messages.login')) !!}
        {!! Form::close() !!}
        </div>
            <p class="form-sub-text"><a href="/password/email">{{ trans('messages.forgotpassword') }}</a> | <a href="/register">{{ trans('messages.createaccount') }}</a></p>

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