@extends('layouts.default')

@section('title', $tournament->name)
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ $tournament->name }}</h2>
    </article>
    <section id="content" class="a">
        <article>
            <ul>
                <li><a id="games" href="/tournament/{{ $tournament->slug }}">{{ trans('messages.games') }}</a></li>
                <li><a id="teams" href="/tournament/{{ $tournament->slug }}/teams">{{ trans('messages.teams') }}</a></li>
            </ul>
            <div id="games-section">
                @foreach($tournament->groups as $group)
                    <div class="row">
                        <div class="col-md-12">
                            <main>
                                <ul>
                                    <li>&nbsp;</li>
                                    @foreach($group->games->all() as $game)
                                        <?php $i=0; ?>
                                        @foreach($game->teams as $team)
                                            <li class="game <?php if ($i==0) { echo "game-top"; } else { echo "game-bottom"; } ?>">{{ $team->name }} <input name="{{ $team->id }}" type="text" value="@foreach($game->scores as $score) @if ($score->team_id == $team->id){{ $score->score }}@endif @endforeach"></li>
                                            <li><?php if ($i==0) { ?><a href="/tournament/{{ $tournament->slug }}/{{ $game->slug }}">{!! $game->name !!}</a>

                                                <button type="submit" name="save-game" class="btn btn-default game-save">{{ trans('messages.save') }}</button><?php } ?></li>
                                                <?php $i++; ?>

                                        @endforeach
                                    @endforeach
                                </ul>
                            </main>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>
@stop

