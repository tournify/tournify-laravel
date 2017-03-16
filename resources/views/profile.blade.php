@extends('layouts.default')

@section('title', trans('messages.myprofile'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.myprofile') }}</h2>
    </article>

    <section id="content" class="a">
        <article>
            <p>{!! trans('messages.profilecomingsoon') !!}</p>
    </article>
    </section>
@stop