@extends('layouts.default')

@section('title', trans('messages.earliertournaments'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.earliertournaments') }}</h2>
    </article>
    <article id="content">
        <section class="content">
            <table>
                <tr><th>{{ trans('messages.tournament') }}</th><th>{{ trans('messages.games') }}</th><th>{{ trans('messages.created') }}</th></tr>
            @foreach($tournaments as $t)
                    <tr>
                        <td><a href="/tournament/{{ $t->slug }}"> {{ $t->name }}</a></td>
                        <td>{{ App\Game::where(['tournament_id' => $t->id])->count() }}</td>
                        <td>{{ $t->created_at->diffForHumans() }}</td>
                    </tr>
            @endforeach
            </table>
        </section>
    </article>
@stop