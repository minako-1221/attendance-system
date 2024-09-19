<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}" />
    <link rel="stylesheet" href="{{asset('css/common.css')}}" />
    @yield('css')
    @yield('js')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <a href="/" class="header__logo">
                    Atte
                </a>
                <nav>
                    <ul class="header-nav">
                        @if (Auth::check())
                            <li class="header-nav__item">
                                <a href="/attendance" class="header-nav__link">ホーム</a>
                            </li>
                            <li class="header-nav__item">
                                <a href="/attendance/records/{date?}" class="header-nav__link">日付一覧</a>
                            </li>
                            <li class="header-nav__item">
                                <form class="form__logout" action="/logout" method="post">
                                    @csrf
                                    <button class="header-nav__button">ログアウト</button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <small class="copyright">
                Atte,inc.
            </small>
        </div>
    </footer>
</body>

</html>