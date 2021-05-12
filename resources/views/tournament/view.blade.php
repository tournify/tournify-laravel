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
                <li><a id="stats" href="/tournament/{{ $tournament->slug }}/stats">{{ trans('messages.stats') }}</a>
                </li>
                <li><a id="teams" href="/tournament/{{ $tournament->slug }}/teams">{{ trans('messages.teams') }}</a>
                </li>
            </ul>
            <div id="games-section" style='overflow-x:auto;font-size: 12pt !important;'>
                <div class="row" style="border: 1px solid #929292">
                    <div class="col-sm-2" style="border-right: 1px solid #929292"><strong>Group</strong></div>
                    <div class="col-sm-2" style="border-right: 1px solid #929292"><strong>Game</strong></div>
                    <div class="col-sm-2" style="border-right: 1px solid #929292"><strong>Home Team</strong></div>
                    <div class="col-sm-2" style="border-right: 1px solid #929292"><strong>Away Team</strong></div>
                    <div class="col-sm-2"></div>
                </div>
                @foreach($tournament->groups as $group)
                    @foreach ($group->games->all() as $game)
                        <div class="row" style="border: 1px solid #929292; min-height: 40pt;">
                            {!! Form::open(['url' => 'tournament/save', 'method' => 'post']) !!}
                            <input type="hidden" name="game-id" value="{{ $game->id }}">
                            <div class="alert alert-success" style="display: none;"></div>
                            <div class="col-sm-2" style="border-right: 1px solid #929292; height: 100%;">
                                {{ $group->name }}
                            </div>
                            <div class="col-sm-2" style="border-right: 1px solid #929292; height: 100%;">
                                <a href="/tournament/{{ $tournament->slug }}/{{ $game->slug }}">{{ $game->name }}</a>
                            </div>
                            @foreach($game->teams as $team)
                                <div class="col-sm-2" style="border-right: 1px solid #929292; height: 100%;">
                                    {{ $team->name }} <input name="{{ $team->id }}" type="text" style="width: 100%;"
                                                             value="@foreach($game->scores as $score) @if ($score->team_id == $team->id){{ $score->score }}@endif @endforeach">
                                </div>
                            @endforeach
                            <div class="col-sm-2">
                                <button type="submit" name="save-game" style="width: 100%; min-width: auto;"
                                        class="btn btn-default game-save">{{ trans('messages.save') }}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                @endforeach
            </div>
        </article>
    </section>
    <script>
        $(document).ready(function () {
            $('.game-save').on('click', function () {
                var form = $(this).parents('form:first');
                var parent = $(form).find('.alert');
                $.ajax({
                    url: '/tournament/save',
                    type: "post",
                    data: form.serialize(),
                    success: function (data) {
                        $(parent).html("{{ trans('messages.scoresaved') }}");
                        $(parent).slideDown("slow", function () {
                            setTimeout(function () {
                                $(parent).slideUp("slow", function () {
                                });
                            }, 4000);
                        });
                    }
                });
                return false;
            });
        });
    </script>
@stop

