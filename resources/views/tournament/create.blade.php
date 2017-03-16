@extends('layouts.default')

@section('title', trans('messages.createtournament'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.createtournament') }}</h2>
    </article>
    <section id="content" class="a">
        <article>
            {!! Form::open(array('action' => 'TournamentController@getMake')) !!}
            <div class="col-md-3 well">
                <div class="form-group">

                    <label for="tourtype">{{ trans('messages.tournamenttype') }}:</label>

                    <div class="input-group">
                        <select name="tourtype" id="tourtype">
                            <option value="0" SELECTED>{!! trans('messages.series') !!}</option>
                            <option value="1">{!! trans('messages.elimination') !!}</option>
                        </select>
                    </div>

                    <label for="tourname">{{ trans('messages.tournamentname') }}:</label>

                    <div class="input-group">
                        <input type="text" class="form-control" id="tourname" name="tourname"
                               value="{{ $data['tourname'] or '' }}">
                    </div>
                    <label for="teamcount">{{ trans('messages.teams') }}:</label>

                    <div class="input-group spinner">
                        <input type="text" class="form-control" id="teamcount" name="teamcount" value="8"><div class="input-group-btn-vertical">
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                        </div>
                    </div>
                    <div id="extragroup">
                    <label for="groupcount">{{ trans('messages.groups') }}:</label>

                    <div class="input-group spinner">
                        <input type="text" class="form-control" id="groupcount" name="groupcount" value="2"><div class="input-group-btn-vertical">
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                        </div>
                    </div>
                    <label for="meetcount">{{ trans('messages.meetings') }}:</label>

                    <div class="input-group spinner">
                        <input type="text" class="form-control" id="meetcount" name="meetcount" value="1"><div class="input-group-btn-vertical">
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                        </div>
                    </div>
                    <label for="elimcount">{{ trans('messages.toelimination') }}:</label>

                    <div class="input-group spinner">
                        <input type="text" class="form-control" id="elimcount" name="elimcount" value="2"><div class="input-group-btn-vertical">
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                            <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                        </div>
                    </div>
                    </div>
                    @if (Auth::user())
                        <div class="input-group">
                            <label for="private">{{ trans('messages.private') }}:</label><input type="checkbox" class="form-control" id="private" name="private">
                        </div>
                    @endif
                    <div class="input-group">
                        <button name="mix" id="mix">{{ trans('messages.mixteams') }}</button>
                    </div>
                    <div class="input-group">
                        <button type="submit">{{ trans('messages.create') }}</button>
                    </div>
                    <p>{{ trans('messages.tournamentwaitwarning') }}</p>

                    <h4><a id="advlnk" href="#">{!! trans('messages.advanced') !!}</a></h4>
                    <div id="advanced" style="display: none;">

                        <label for="winpoints">{{ trans('messages.winpoints') }}:</label>
                        <div class="input-group spinner">
                            <input type="text" class="form-control" id="winpoints" name="winpoints" value="3"><div class="input-group-btn-vertical">
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                            </div>
                        </div>

                        <label for="tiepoints">{{ trans('messages.tiepoints') }}:</label>
                        <div class="input-group spinner">
                            <input type="text" class="form-control" id="tiepoints" name="tiepoints" value="1"><div class="input-group-btn-vertical">
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                            </div>
                        </div>

                        <label for="losspoints">{{ trans('messages.losspoints') }}:</label>
                        <div class="input-group spinner">
                            <input type="text" class="form-control" id="losspoints" name="losspoints" value="0"><div class="input-group-btn-vertical">
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
                                <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-8" id="groups">
                <div class="col-md-5"><h2>{{ trans('messages.group') }} 1</h2>
                    <ul class="list-unstyled">
                        @for($i=1;$i<=8;$i++)
                            <li><input type="text" name="team[]" placeholder="{{ trans('messages.team') }} {{ $i }}">
                            </li>
                            @if ($i==4)
                    </ul>
                </div>
                <div class="col-md-5"><h2>{{ trans('messages.group') }} 2</h2>
                    <ul class="list-unstyled">
                        @endif
                        @endfor
                    </ul>
                </div>
            </div>
            {!! Form::close() !!}
        </article>
    </section>
    <script>
        function shuffle(n) {
            for (var t, u, i = n.length; 0 !== i;)u = Math.floor(Math.random() * i), i -= 1, t = n[i], n[i] = n[u], n[u] = t;
            return n
        }
        $(document).ready(function () {

            var advancedShown = false;
            function check(element, min, max) {
                if ($.isNumeric(element.val()) && (element.val() < min || element.val() > max)) {
                    return true;
                } else {
                    return false;
                }
            }

            function n() {
                if (!$.isNumeric(u.val()))return !1;
                if (!$.isNumeric(t.val()))return !1;
                $("input[name='team[]']").each(function () {
                    var n = $(this).val();
                    "" != n && l.push(n)
                }), x.html(""), gcount = u.val(), tcount = t.val();
                var n, e, c = tcount / gcount, o = 0, s = 1;
                for (i = 0; i < tcount; i++)gcount <= 1 && (n = x.append('<ul class="list-unstyled"></ul>').find("ul").last()), 0 == i && gcount > 1 && (e = x.append('<div class="col-md-5"><h2>{{ trans('messages.group') }} 1</h2></div>').find("div").last(), n = e.append('<ul class="list-unstyled"></ul>').find("ul").last(), s++), o >= c && gcount >= s && (e = x.append('<div class="col-md-5"><h2>{{ trans('messages.group') }} ' + s + "</h2></div>").find("div").last(), n = e.append('<ul class="list-unstyled"></ul>').find("ul").last(), o = 0, s++), n.append('<li><input type="text" name="team[]" placeholder="{{ trans('messages.team') }} ' + (i + 1) + '"></li>'), o++;
                l.reverse();
                $("input[name='team[]']").each(function () {
                    $(this).val(l.pop())
                })
            }

            var t = $("#teamcount"), u = $("#groupcount"), a = $("#meetcount"), c = $("#elimcount"),x = $("#groups"), l = [];
            t.on("input", function () {
                if (check(t, 0, 20)) {
                    alert("{!! trans('messages.teamcountwarning') !!}");
                } else {
                    n()
                }
            }), u.on("input", function () {
                n();
            }), a.on("input", function () {
                if (check(a, 0, 5)) {
                    alert("{!! trans('messages.meetcountwarning') !!}");
                } else {
                    n()
                }
            }), $("#mix").click(function () {
                return l = [], $("input[name='team[]']").each(function () {
                    var n = $(this).val();
                    l.push(n), shuffle(l)
                }).each(function () {
                    $(this).val(l.pop())
                }), !1
            });


            $('.spinner .btn:first-of-type').on('click', function() {
                var sib = $(this).parent().parent().find('input').first();
                $(sib).val( parseInt($(sib).val(), 10) + 1);
                if (check(t, 0, 20)) {
                    alert("{!! trans('messages.teamcountwarning') !!}");
                    $(sib).val( parseInt($(sib).val(), 10) - 1);
                } else if (check(a, 0, 5)) {
                    alert("{!! trans('messages.meetcountwarning') !!}");
                    $(sib).val( parseInt($(sib).val(), 10) - 1);
                } else {
                    if ($(sib).val() == $(t).val() || $(sib).val() == $(u).val()) {
                        n()
                    }
                }
            });
            $('.spinner .btn:last-of-type').on('click', function() {
                var sib = $(this).parent().parent().find('input').first();
                $(sib).val( parseInt($(sib).val(), 10) - 1);
                if (check(t, 0, 20)) {
                    alert("{!! trans('messages.teamcountwarning') !!}");
                    $(sib).val( parseInt($(sib).val(), 10) + 1);
                } else if (check(a, 0, 5)) {
                    alert("{!! trans('messages.meetcountwarning') !!}");
                    $(sib).val( parseInt($(sib).val(), 10) + 1);
                } else {
                    if ($(sib).val() == $(t).val() || $(sib).val() == $(u).val()) {
                        n()
                    }
                }
            });
            $('#advlnk').on('click', function() {
                if (advancedShown) {
                    $('#advanced').slideUp("slow", function () {
                        advancedShown = false;
                    })
                } else {
                    $('#advanced').slideDown("slow", function () {
                        advancedShown = true;
                    })
                }
                return false;
            });
            $('#tourtype').on('change', function () {
                var tour = $(this).val();
                if (tour == 1) {
                    $('#extragroup').slideUp("slow");
                    $('#advlnk').slideUp("slow");
                    $('#advanced').slideUp("slow");
                    $('#groupcount').val(1);
                    n();
                } else {
                    $('#extragroup').slideDown("slow");
                    $('#advlnk').slideDown("slow");
                }
            });
        });
    </script>
@stop