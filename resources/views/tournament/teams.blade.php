@extends('layouts.default')

@section('title', $tournament->name." - ".trans('messages.teams'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ $tournament->name." - ".trans('messages.teams') }}</h2>
    </article>
    <section id="content" class="a">
        <article>
            <ul>
                <li><a id="games" href="/tournament/{{ $tournament->slug }}">{{ trans('messages.games') }}</a></li>
                <li><a id="stats" href="/tournament/{{ $tournament->slug }}/stats">{{ trans('messages.stats') }}</a></li>
                <li><a id="teams" href="/tournament/{{ $tournament->slug }}/teams">{{ trans('messages.teams') }}</a></li>
            </ul>
            <table class="table table-hover">
                <tr>
                    <th>{{ trans('messages.team') }}</th>
                </tr>
            @foreach($tournament->groups as $g)
                @foreach($g->teams as $t)
                <tr>
                    <th>{!! $t->name !!}</th>
                </tr>
                    @endforeach
            @endforeach
            </table>
        </article>
    </section>
@stop