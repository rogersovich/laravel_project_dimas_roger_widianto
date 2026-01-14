<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold fs-2 text-primary" href="{{ route('home') }}">TokoKu</a>
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

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            Keranjang
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-danger">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.history') }}">Daftar Pesanan</a>
                    </li>
                @endauth
            </ul>

            @guest
                <a href="{{ route('login') }}" class="btn btn-primary ms-lg-3">Login</a>
            @endguest

            @auth
                <div class="d-flex align-items-center ms-lg-3">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary me-2">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

