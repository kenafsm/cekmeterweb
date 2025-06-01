<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <!-- Icon -->
    <link rel="shortcut icon" href="{{ asset('../assets/logo-cekmeter.png') }}">
</head>

<body>
    <section class="vh-100">

        {{-- @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
            </div>
        @endif --}}


        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-6 p-5">
                    <h3 class="text-center p-3">Login</h3>
                    <form class="user" action="{{ route('sample.validate_login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                aria-describedby="emailHelp" autofocus required>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="text-center">
                            <button class="btn btn-lg btn-block"
                                style="width: 250px; height: 50px; background-color: #3A57E8; color:white;"
                                type="submit">{{ __('Masuk') }}</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="{{ asset('assets/logo-login.jpg') }}" alt="Login image" class="w-100 vh-100"
                        style="object-fit: fill; object-position: left;">
                </div>
            </div>
        </div>
    </section>

    {{-- Alert --}}
    @include('sweetalert::alert')
    
</body>

</html>
