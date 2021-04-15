@extends('layouts.default')

@section('title', $tournament->name.' - '.$game->name)
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ $tournament->name }} - {{ $game->name }}</h2>
    </article>
    <section id="content" class="a">
        <article>
            <ul>
                <li><a id="games" href="/tournament/{{ $tournament->slug }}">{{ trans('messages.back') }}</a></li>
            </ul>
            <div class="col-md-10 well game-div">
                {!! Form::open(array('action' => 'TournamentController@postSave')) !!}
                <div class="alert alert-success" style="display: none;"></div>
                <input type="hidden" name="game-id" value="{{ $game->id }}">

                <div class="game-name">
                    <h4>{{ $game->name }}</h4>
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

