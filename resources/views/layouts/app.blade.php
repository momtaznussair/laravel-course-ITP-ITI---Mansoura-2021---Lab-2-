<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <script src="{{ asset('js/jquery-2.6.min.js') }}"></script>
    @yield('custom-css')
    @yield('custom-js')
    <title>@yield('title')</title>
</head>
<body>

    {{-- navbar --}}

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
        <div class="container-fluid">
          <a class="navbar-brand ms-3" href="{{url('posts')}}">Blog Post</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{url('posts')}}">All Posts</a>
            </li>
            @guest
              <li class="nav-item">
                <a class="nav-link " aria-current="page" href="{{url('register')}}">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{url('login')}}">Login</a>
              </li>
            @endguest
            @auth
              <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
              </li>
            @endauth
            </ul>
            <form class="d-flex" action="{{url('posts/search')}}" method="post">
                @csrf
              <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

      {{--content--}}
    <div class="container mt-5 mb-4">
        @yield('content')
    </div>
</body>
</html>