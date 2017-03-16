@extends('layouts.default')

@section('title', 'Create Post')
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>Create Post</h2>
    </article>
    <article id="content">
        <section class="content">
            @can('blog_post')
            @if($errors->has())
                @foreach($errors->all() as $error)
                    <p class="error-message">{!!$error!!}</p>
                @endforeach
            @endif
            <div id="loginform">
                {!! Form::open(array('action' => 'BlogController@getCreate')) !!}
                {!! Form::label('title', trans('messages.title') ) !!}
                {!! Form::text('title') !!}
                {!! Form::label('text', trans('messages.text') ) !!}
                {!! Form::textarea('text') !!}
                {!! Form::label('title', trans('messages.entitle') ) !!}
                {!! Form::text('entitle') !!}
                {!! Form::label('entext', trans('messages.entext') ) !!}
                {!! Form::textarea('entext') !!}
                {!! Form::submit(trans('messages.create')) !!}
                {!! Form::close() !!}
            </div>
            @endcan
        </section>
    </article>
@stop