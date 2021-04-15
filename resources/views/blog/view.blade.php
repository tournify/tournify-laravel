@extends('layouts.default')

@if ($lang == 'sv')
    @section('title',  $post->title )
@else
    @section('title',  $post->title_en )
@endif
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        @if ($lang == 'sv')
            <h2>{{ $post->title }}</h2>
        @else
            <h2>{{ $post->title_en }}</h2>
        @endif
    </article>
    <article id="content">
        <section class="content">
                <a href="/blog/">{{ trans('messages.back') }}</a>
                <div class="post">
                    @if ($lang == 'sv')
                        {!! $post->content !!}
                    @else
                        {!! $post->content_en !!}
                    @endif
                    <div class="post-footer">{{ trans('messages.createdof') }} {{ $post->user->name }} {{ Laravelrus\LocalizedCarbon\LocalizedCarbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans() }}</div>
                </div>
        </section>
    </article>
@stop