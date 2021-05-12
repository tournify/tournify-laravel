@extends('layouts.default')

@section('title', $tournament->name." - Stats")
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ $tournament->name }} - {{ trans('messages.stats') }}</h2>
    </article>
    <section id="content" class="a">
        <article>
            <ul>
                <li><a id="games" href="/tournament/{{ $tournament->slug }}">{{ trans('messages.games') }}</a></li>
                <li><a id="stats" href="/tournament/{{ $tournament->slug }}/stats">{{ trans('messages.stats') }}</a></li>
                <li><a id="teams" href="/tournament/{{ $tournament->slug }}/teams">{{ trans('messages.teams') }}</a></li>
            </ul>

            @foreach($stats as $s)
                <?php if (!isset($currgroup)) {$currgroup = $s["groupid"]; ?>
                <div class="group">
                    <h3>{!! $s["group"] !!}</h3>
                    <table class="table table-hover">
                        <tr>
                            <th>{{ trans('messages.team') }}</th>
                            <th>{{ trans('messages.playedabrv') }}</th>
                            <th>{{ trans('messages.winsabrv') }}</th>
                            <th>{{ trans('messages.tiesabrv') }}</th>
                            <th>{{ trans('messages.lossesabrv') }}</th>
                            <th>+/-</th>
                            <th>{{ trans('messages.diffabrv') }}</th>
                            <th>{{ trans('messages.points') }}</th>
                        </tr>
                        <?php } ?>
                        <?php if ($currgroup != $s["groupid"]) {$currgroup = $s["groupid"]; ?>
                    </table>
                </div>
                <div class="group">
                    <h3>{!! $s["group"] !!}</h3>
                    <table class="table table-hover">
                        <tr>
                            <th>{{ trans('messages.team') }}</th>
                            <th>{{ trans('messages.playedabrv') }}</th>
                            <th>{{ trans('messages.winsabrv') }}</th>
                            <th>{{ trans('messages.tiesabrv') }}</th>
                            <th>{{ trans('messages.lossesabrv') }}</th>
                            <th>+/-</th>
                            <th>{{ trans('messages.diffabrv') }}</th>
                            <th>{{ trans('messages.points') }}</th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td>{{ $s["team"] }}</td>
                            <td>{{ $s["played"] }}</td>
                            <td>{{ $s["win"] }}</td>
                            <td>{{ $s["tied"] }}</td>
                            <td>{{ $s["loss"] }}</td>
                            <td>{{ $s["scoredon"] }}
                                - {{ $s["scoredagainst"] }}</td>
                            <td>{{ $s["diff"] }}</td>
                            <td>{{ $s["points"] }}</td>
                        </tr>
            @endforeach

                    </table>
                </div>
        </article>
    </section>
@stop