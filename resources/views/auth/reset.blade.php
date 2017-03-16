@extends('layouts.default')

@section('title', trans('messages.newpassword'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.newpassword') }}</h2>
    </article>

    <section id="content" class="a">
    <article>

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="error-message">{{ $error }}</p>
            @endforeach
        @endif

        <div id="loginform">
        {!! Form::open(array('action' => 'Auth\PasswordController@postReset')) !!}



    <div>
        {!! Form::label('email', trans('messages.email') ) !!}
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        {!! Form::label('password',  trans('messages.password') ) !!}
        <input type="password" name="password">
    </div>

    <div>
        {!! Form::label('password_confirmation', trans('messages.passwordverify') ) !!}
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">
            {{ trans('messages.resetpassword') }}
        </button>
    </div>
        {!! Form::close() !!}
        </div>
    </article>
    </section>
@stop