@extends('layouts.default')

@section('title', trans('messages.forgot'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.forgot') }}</h2>
    </article>
    <section id="content" class="a">
    <article>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="error-message">{{ $error }}</p>
            @endforeach
        @endif
        <div id="standardform">
        {!! Form::open(array('action' => 'Auth\PasswordController@getEmail')) !!}

            <div>
                {!! Form::label('email', trans('messages.email')) !!}
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                <button type="submit">
                    {{ trans('messages.sendlinktoreset') }}
                </button>
            </div>
        {!! Form::close() !!}
        </div>
    </article>
    </section>
@stop