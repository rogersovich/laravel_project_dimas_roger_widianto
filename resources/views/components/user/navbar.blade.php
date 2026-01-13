<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">TokoKu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#produk">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                        Keranjang
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kontak">Pembayaran</a>
                </li>
            </ul>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary ms-lg-3">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3">Login</a>
            @endauth
        </div>
    </div>
</nav>
