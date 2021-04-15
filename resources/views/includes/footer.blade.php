
    <figure>
        @if (Lang::getLocale() == 'sv')
            <img src="/images/logo-gray.png" alt="{{ trans('messages.sitename') }}" width="174" height="55">
        @else
            <img src="/images/logo-gray-en.png" alt="{{ trans('messages.sitename') }}" width="174" height="55">
        @endif
    </figure>
    <h3>{{ trans('messages.followus') }}</h3>
    @if (Lang::getLocale() == 'sv')
        <ul class="social-a">
            <li class="fb"><a rel="external" href="https://www.facebook.com/Turneringio-307365945986504/">Facebook</a></li>
            <li class="tw"><a rel="external" href="https://twitter.com/Turnering_io">Twitter</a></li>
        </ul>
    @else
        <ul class="social-a">
            <li class="fb"><a rel="external" href="https://www.facebook.com/Tournifyio-191461941196199/">Facebook</a></li>
            <li class="tw"><a rel="external" href="https://twitter.com/tournifyio">Twitter</a></li>
        </ul>
    @endif
    {{--<ul class="download-a">--}}
    {{--<li class="as"><a rel="external" href="./">Download on the App Store</a></li>--}}
    {{--<li class="gp"><a rel="external" href="./">Get it on Google Play</a></li>--}}
    {{--</ul>--}}
    <p>&copy; <span class="date">{{ date("Y") }}</span> {{ trans('messages.sitename') }}. {{ trans('messages.allrightsreserved') }} <a href="https://github.com/uberswe">{{ trans('messages.createdby') }}</a> <a href="/privacy-policy">{{ trans('messages.privacypolicy') }}</a> <a href="/terms-of-service">{{ trans('messages.tos') }}</a></p>