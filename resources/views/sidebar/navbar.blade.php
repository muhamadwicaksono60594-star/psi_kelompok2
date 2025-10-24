<header class="header">
    <div class="logo">
        <img src="{{ asset('images/rk2.png') }}" alt="Logo" style="width: 40px; margin-right: 10px;">
        <span class="logo-text">Radar Kediri</span>
    </div>
    <div class="user-info">
        <div class="user-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <span>{{ Auth::user()->name }}</span>
    </div>
</header>
