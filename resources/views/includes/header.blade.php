 <h1>
     @if (Lang::getLocale() == 'sv')
         <a href="/" accesskey="h"><img src="/images/logo.png" alt="{{ trans('messages.sitename') }}" width="257" height="81"></a>
     @else
         <a href="/" accesskey="h"><img src="/images/logo-en.png" alt="{{ trans('messages.sitename') }}" width="257" height="81"></a>
     @endif
 </h1>
    <nav id="skip">
        <ul>
            <li><a href="#nav" accesskey="n">{{ trans('messages.skiptonavigation') }} (n)</a></li>
            <li><a href="#content" accesskey="c">{{ trans('messages.skiptocontent') }} (c)</a></li>
            <li><a href="#footer" accesskey="f">{{ trans('messages.skiptofooter') }} (f)</a></li>
        </ul>
    </nav>
    <nav id="nav">
        @if (Auth::check())
            <ul>
                <li><a accesskey="1" href="/">{{ trans('messages.home') }}</a> <em>(1)</em></li>
                <li><a accesskey="2" href="/blog">{{ trans('messages.blog') }}</a> <em>(2)</em></li>
                <li><a accesskey="3" href="/tournament">{{ trans('messages.earliertournaments') }}</a> <em>(3)</em></li>
                <li><a accesskey="4" href="/profile">{{ trans('messages.profile') }}</a> <em>(4)</em>
                    <ul>
                        <li><a href="/logout">{{ trans('messages.logout') }}</a></li>
                    </ul>
                </li>
            </ul>
        @else
            <ul>
                <li><a accesskey="1" href="/">{{ trans('messages.home') }}</a> <em>(1)</em></li>
                <li><a accesskey="2" href="/blog">{{ trans('messages.blog') }}</a> <em>(2)</em></li>
                <li><a accesskey="3" href="/tournament">{{ trans('messages.earliertournaments') }}</a> <em>(3)</em></li>
                <li><a accesskey="4" href="/login">{{ trans('messages.login') }}</a> <em>(4)</em></li>
            </ul>
        @endif
    </nav>