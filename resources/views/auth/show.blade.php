@extends('layouts.session')
@section('title', 'Login')

@section('content')
    <div class="bg-image vh-100 d-flex">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex flex-column justify-content-start mb-3">
                    <div class="mt-auto pb-3">
                        <h1 class="text-white custom-fs fw-bold mb-4">Honor the memory of<br>your loved ones.</h1>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-md-5">
                    <div class="glass-card px-5 me-5 py-2 vh-100">
                        <div class="d-flex justify-content-center">
                            <img src="{{ asset('img/logoblanco.png') }}" alt="La Auxiliadora" class="logo mb-4">
                        </div>
                        <h2 class="pb-5 text-light fw-bold">Sign in</h2>
                        @livewire('auth.login')
                        <div class="text-center ">
                            <p class="text-light">Or sign in with</p>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-outline-secondary glass-dark-card  rounded-circle"><i
                                        class="fa-brands fa-google"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

