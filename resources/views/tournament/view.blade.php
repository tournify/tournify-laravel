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
                <li><a id="stats" href="/tournament/{{ $tournament->slug }}/stats">{{ trans('messages.stats') }}</a></li>
                <li><a id="teams" href="/tournament/{{ $tournament->slug }}/teams">{{ trans('messages.teams') }}</a></li>
            </ul>
            <div id="games-section">
            @foreach($tournament->groups as $group)
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{ $group->name }}</h3>
                        @foreach (array_chunk($group->games->all(), 2) as $gameRow)
                            <div class="row">
                                <div class="col-md-12">
                        @foreach($gameRow as $game)
                            <div class="col-md-4 well game-div">
                                {!! Form::open(array('action' => 'TournamentController@postSave')) !!}
                                <div class="alert alert-success" style="display: none;"></div>
                                <input type="hidden" name="game-id" value="{{ $game->id }}">
                                <div class="game-name">
                                    <h4><a href="/tournament/{{ $tournament->slug }}/{{ $game->slug }}">{{ $game->name }}</a></h4>
                                </div>
                                @foreach($game->teams as $team)
                                    <div class="col-md-5 team-score">
                                        {{ $team->name }} <input name="{{ $team->id }}" type="text" value="@foreach($game->scores as $score) @if ($score->team_id == $team->id){{ $score->score }}@endif @endforeach">
                                    </div>
                                @endforeach
                                <div class="game-submit">
                                    <button type="submit" name="save-game" class="btn btn-default game-save">{{ trans('messages.save') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-md-1">
                            </div>
                        @endforeach
                                    </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            @endforeach
            </div>
        </article>
    </section>
    <script>
        $(document).ready(function(){
            $('.game-save').on('click',function(){
                var form = $(this).parents('form:first');
                var parent = $(form).find('.alert');
                $.ajax({
                    url: '/tournament/save',
                    type: "post",
                    data: form.serialize(),
                    success: function(data){
                        $(parent).html("{{ trans('messages.scoresaved') }}");
                        $(parent).slideDown( "slow", function() {
                            setTimeout(function () {
                                $(parent).slideUp("slow", function() {});
                            }, 4000);
                        });
                    }
                });
                return false;
            });
        });
    </script>
@stop

