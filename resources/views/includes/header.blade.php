<h1>
    @if (Lang::getLocale() == 'sv')
        <a href="/" accesskey="h"><img src="/images/logo.png" alt="{{ trans('messages.sitename') }}" width="257"
                                       height="81"></a>
    @else
        <a href="/" accesskey="h"><img src="/images/logo-en.png" alt="{{ trans('messages.sitename') }}" width="257"
                                       height="81"></a>
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
    <ul>
        <li><a accesskey="1" href="/">{{ trans('messages.home') }}</a> <em>(1)</em></li>
    </ul>
</nav>