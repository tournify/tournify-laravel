@extends('layouts.default')

@section('title', trans('messages.privacypolicy'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.privacypolicy') }}</h2>
    </article>
    <section id="content" class="a">
        <article id="main">
            <p>Names of games, teams, players, your account and related info is public and can be shown on the website.</p>
            <p>We will not share your email with third parties and we will not use it to send out advertising not related to our website or company. You may unsubscribe or ask to have your email removed at anytime. The email may be kept if you have made financial transactions with us.</p>
            <p>We use third party services such as Google Analytics to track users on our website. These services may store other information about you not mentioned here.</p>
            <p>We use cookies to allow users to create tournaments and log in to our website.</p>
        </article>
    </section>
@stop