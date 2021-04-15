@extends('layouts.default')

@section('title', trans('messages.blog'))
@section('description', trans('messages.easytocreatetournaments'))
@section('keywords', trans('defaultkeywords'))

@section('content')
    <article id="welcome" class="tiny">
        <h2>{{ trans('messages.blog') }}</h2>
    </article>
    <article id="content">
        <section class="content">
            @can('blog_post')
                <a href="/blog/create/">Create new post</a>
            @endcan
            @foreach($posts as $p)
                <h2><a href="/blog/@if ($lang == 'sv'){{ $p->slug }}@else{{ $p->slug_en }}@endif">
                        @if ($lang == 'sv')
                            {{ $p->title }}
                        @else
                            {{ $p->title_en }}
                        @endif</a></h2>
                <div class="post">
                    @if ($lang == 'sv')
                        {!! $p->content !!}
                    @else
                        {!! $p->content_en !!}
                    @endif
                <div class="post-footer">{{ trans('messages.createdof') }} {{ $p->user->name }} {{ Laravelrus\LocalizedCarbon\LocalizedCarbon::createFromTimeStamp(strtotime($p->created_at))->diffForHumans() }}</div>
                </div>
            @endforeach
        </section>
    </article>
@stop