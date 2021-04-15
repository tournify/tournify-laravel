@extends('layouts.default')

@section('title', trans('messages.tos'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.tos') }}</h2>
    </article>
    <section id="content" class="a">
        <article id="main">
            <p>We try to make our terms of service easy to read. Don't abuse our site by using foul language or any other kind of abuse. Your account and any content on the site can be deleted at anytime. These terms may change at any time without notice.</p>

            <p>We are not responsible for the content posted by users. Please contact us via m@turnering.io regarding take downs and we will do our best to respond within 24 hours.</p>

            <p>Please see our privacy policy if you want to know what we do with your information.</p>
        </article>
    </section>
@stop