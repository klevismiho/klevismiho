<header class="header">
    <div class="container">
        <a class="logo" href="{{ home_url('/') }}">
            Klevis Miho
        </a>

        @if (has_nav_menu('primary_navigation'))
        <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'echo' => false]) !!}
        </nav>
        @endif
    </div>
</header>