<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--        Header scripts--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css"
          integrity="sha512-g2SduJKxa4Lbn3GW+Q7rNz+pKP9AWMR++Ta8fgwsZRCUsawjPvF/BxSMkGS61VsR9yinGoEgrHPGPn2mrj8+4w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js"
            integrity="sha512-yrOmjPdp8qH8hgLfWpSFhC/+R9Cj9USL8uJxYIveJZGAiedxyIxwNw4RsLDlcjNlIRR4kkHaDHSmNHAkxFTmgg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @vite(['resources/js/app.js'])
    {{--    <livewire:scripts />--}}
    <livewire:styles/>
    @livewireScripts
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @include('header.show')
    <title>@yield('title', 'Dashboard')</title>
</head>
<body>
@livewire('components.alert-component')
<div class="bg-image-dashboard">
    <div class="d-flex flex-column container-fluid">
        <div class="row">
            <div class="col-sm-2 px-0 glass-dark-card">
                <div class="h-full d-flex flex-column">
                    <div class="d-flex justify-content-center pt-4">
                        <div>
                            <a href="#"><img src="{{asset('img/logoblanco.png')}}" class="logo pb-3" alt=""></a>
                            <h1 class="fs-4 pt-2 text-center text-light fw-semibold fst-italic">Dashboard <i
                                    class="fa-solid fa-gauge-high ms-2"></i></h1>
                        </div>
                    </div>
                    <div class="text-center">
                        <ul class="option-list mx-auto py-4 text-light fw-semibold fs-5 list-unstyled d-flex gap-5 vertical-align-center flex-column w-100">
                            <li class="{{ Request::routeIs('dashboard') ? 'active-sidebar' : '' }}">
                                <a href="{{route('dashboard')}}"><i class="fa-solid fa-house p-1"></i> Home</a>
                            </li>
                            <li class="{{ Request::routeIs('calendar') ? 'active-sidebar' : '' }}">
                                <a href="{{route('calendar')}}"><i class="fa-solid fa-calendar p-1"></i> Calendar</a>
                            </li>
                            <li class="{{ Request::routeIs('sales') ? 'active-sidebar' : '' }}">
                                <a href="{{route('sales')}}"><i class="fa-solid fa-file-invoice-dollar p-1"></i> Sales</a>
                            </li>
                            <li class="{{ Request::routeIs('services') ? 'active-sidebar' : '' }}">
                                <a href="{{route('services')}}"><i class="fa-solid fa-suitcase p-1"></i> Services</a>
                            </li>
                            <li class="{{ Request::routeIs('products') ? 'active-sidebar' : '' }}">
                                <a href="{{route('products')}}"><i class="fa-solid fa-mug-saucer p-1"></i>
                                    Products</a>
                            </li>
                            <li class="{{ Request::routeIs('customers') ? 'active-sidebar' : '' }}">
                                <a href="{{route('customers')}}"><i class="fa-solid fa-people-roof p-1"></i>
                                    Customers</a>
                            </li>
                            <li class="{{ Request::routeIs('employees') ? 'active-sidebar' : '' }}">
                                <a href="{{route('employees')}}"><i class="fa-solid fa-id-card-clip p-1"></i> Employees</a>
                            </li>
                            <li class="{{ Request::routeIs('categories') ? 'active-sidebar' : '' }}">
                                <a href="{{route('categories')}}"><i class="fa-solid fa-list p-1"></i> Category</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-10 px-0">
                <nav class="navbar navbar-expand-lg navbar-dark glass-dark-card py-4">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto pe-5">
                            <li class="nav-item pe-5 d-flex gap-3 align-items-center">
                                <p class="text-light m-0">{{ auth()->user()->username }}</p>
                                <a href="#services" class="text-decoration-none text-light fw-bold"><i
                                        class="fa-solid fa-user"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>

                @yield('content')

            </div>
        </div>
    </div>
    @include('footer.show')
</div>

{{--Footer scripts--}}
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.8/dist/sweetalert2.all.min.js"></script>
<script src="{{asset('js/alerts.js')}}"></script>
<script src="https://kit.fontawesome.com/4e9e3f37c1.js" crossorigin="anonymous"></script>
</body>
</html>

