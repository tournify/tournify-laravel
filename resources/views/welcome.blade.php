@extends('layouts.default')

@if (Lang::getLocale() == 'sv')
    @section('title', 'Hem')
    @section('description', 'Enkelt att skapa turneringar')
@section('keywords', 'skapa turnering, turneringar, turnering, hantera turnering, gruppspel, FIFA, Hearthstone')
@else
    @section('title', 'Home')
    @section('description', 'Easy to create tournaments')
    @section('keywords', 'create a tournament, tournament, tournaments, manage a tournament, cup, league, group, FIFA, Hearthstone')
@endif


@section('content')

    <article id="welcome">
        <h2><span>{{ trans('messages.domainfirst') }}</span>{{ trans('messages.domainlast') }}</h2>
        <p>{{ trans('messages.welcome') }}</p>

        {!! Form::open(['url' => 'tournament/create', 'method' => 'get']) !!}
        <p><input type="text" name="tourname" id="tourname" placeholder="{{ trans('messages.tournamentname') }}"></p>
        <div id="savebutton">
            <button type="submit">{{ trans('messages.create') }}</button>
        </div>
        {!! Form::close() !!}
        {{--<ul class="download-a a">--}}
            {{--<li class="as"><a rel="external" href="./">Download on the App Store</a></li>--}}
            {{--<li class="gp"><a rel="external" href="./">Get it on Google Play</a></li>--}}
        {{--</ul>--}}
    </article>
    <section id="content" class="a">
        <div class="row">
        <div class="col-md-12">
        <ol id="gamesfeed">
            @foreach($tournaments as $tournament)
            <li><i class="fa fa-trophy icon"></i> <b>{{ $tournament->from_time }}</b> {{ trans('messages.wascreated') }} <a href='/tournament/{!! $tournament->slug !!}'>{!! $tournament->name !!}</a>!
            @endforeach
        </ol>
        </div>
        </div>

    <article class="va" id="subscribe-section">
        <header class="heading-a">
            <h3><span class="strong">{{ trans('messages.subscribe') }}</span> {{ trans('messages.toournewsletter') }}</h3>
        </header>
        {!! Form::open(array('class' => 'form-b')) !!}
            <fieldset>
                <p>
                    <label id="emaillabel" for="fba">{{ trans('messages.email') }}_</label>
                    <input type="email" id="fba" name="fba" required>
                    <button id="newsletter-button" type="submit">{{ trans('messages.submit') }}</button>
                </p>
                <p class="scheme-b">{{ trans('messages.subscribeexplanation') }}</p>
            </fieldset>
        {!! Form::close() !!}
    </article>
        </section>
    <script>

        $(document).ready(function(){
            var fba = $('#fba');
            var emaillabel = $('#emaillabel');
            if (fba.val() != "") {
                emaillabel.hide();
            }
            fba.on('focus',function(){
                emaillabel.hide();
            });
            $('#newsletter-button').on('click', function() {
                var form = $(this).parents('form:first');
                $.ajax({
                    url: '/subscribe',
                    type: "post",
                    data: form.serialize(),
                    success: function(data){
                        var json = $.parseJSON(data);
                        if (json.status == "failed") {
                            $('#subscribe-section fieldset').append('<p style="color:red;">{{ trans('messages.subscribefailed') }}</p>');
                        } else {
                            $('#subscribe-section').html('<header class="heading-a"> <h3>{{ trans('messages.subscribethankyou') }}</h3> </header><p class="scheme-b">{{ trans('messages.subscribeexplanation') }}</p>');
                        }
                    }
                });
                return false;
            });
        });

    </script>
@stop

