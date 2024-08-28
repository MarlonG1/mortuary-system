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
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    @include('header.show')
    <title>Home</title>
</head>
<body>
<div class="bg-image-home vh-100 d-flex flex-column">

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a href="#"><img src="{{asset('img/logo-color.png')}}" class="logo p-3" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto pe-5">
                    <li class="nav-item pe-5">
                        <a href="#services" class="text-decoration-none text-light fw-bold">Services</a>
                    </li>
                    <li class="nav-item pe-5">
                        <a href="#" class="text-decoration-none text-light fw-bold">Locations</a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="text-decoration-none text-light fw-bold">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
        <h1 class="text-white custom-fs fw-bold mb-4">They are always with us</h1>
    </div>
    <div class="d-flex justify-content-center pb-5">
        <a href="#"><i class="fa-solid fa-2xl fa-chevron-down" style="color: #455A64"></i></a>
    </div>
</div>
<div class="line"></div>
<div class="bg-image-main" id="services">
    <div class="container">
        <div class="row">
            <h1 class="text-white fs-1 fw-bold text-center py-4">Our services</h1>
            <div class="col-12 glass-dark-card glass-border d-flex justify-content-center custom-radius-semicircle">
                <div class="row w-100">
                    <div class="col-12 col-sm-6 col-md-4 d-flex flex-column py-5">
                        <img src="{{asset('img/img-service1.png')}}" class="mx-auto" alt="">
                        <div class="text-center mx-5">
                            <h3 class="text-white pt-2">Emergency</h3>
                            <hr class="custom-hr">
                            <p class="text-light text-justify px-4">
                                You're not alone!
                                In this moment of
                                emergency, leave everything in
                                our hands</p>
                            <a href="#" class="btn btn-secondary color-primary fw-semibold w-75
                                 custom-radius">Contact us
                                <i class="ps-2 fa-solid fa-phone" style="color: #455A64;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 d-flex flex-column py-5">
                        <img src="{{asset('img/img-service2.png')}}" class="mx-auto" alt="">
                        <div class="text-center mx-5">
                            <h3 class="text-white pt-2">Family Support</h3>
                            <hr class="custom-hr">
                            <p class="text-light text-justify px-4">
                                Worthy that moment of
                                farewell receiving a service
                                with quality and human sense,
                                no debt and no interest.</p>
                            <a href="#" class="btn btn-secondary color-primary fw-semibold w-75
                                 custom-radius">Contact us
                                <i class="ps-2 fa-solid fa-phone" style="color: #455A64;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 d-flex flex-column py-5">
                        <img src="{{asset('img/img-service3.png')}}" class="mx-auto" alt="">
                        <div class="text-center mx-5">
                            <h3 class="text-white pt-2">Family Protection</h3>
                            <hr class="custom-hr">
                            <p class="text-light text-justify px-4">
                                Worthy that moment of
                                farewell receiving a service
                                with quality and human sense,
                                no debt and no interest.</p>
                            <a href="#" class="btn btn-secondary color-primary fw-semibold w-75
                                 custom-radius">Contact us
                                <i class="ps-2 fa-solid fa-phone" style="color: #455A64;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container pt-5">
        <div class="row">
            <div class="col-sm-9 glass-dark-card glass-border d-flex justify-content-center custom-radius-semicircle mx-auto gap-5">
                <div class="col d-flex flex-column py-3 px-5">
                    <div class="text-center mx-1">
                        <h3 class="text-white pt-2">Clients</h3>
                        <hr class="custom-hr">
                        <p class="text-light fs-4 text-justify px-4 mb-1 text-center">
                            10 <i class="fa-solid fa-box-archive"></i></p>
                    </div>
                </div>
                <div class="col d-flex flex-column py-3 px-5">
                    <div class="text-center mx-1">
                        <h3 class="text-white pt-2">Offices</h3>
                        <hr class="custom-hr">
                        <p class="text-light fs-4 text-justify px-4 text-center">
                            10 <i class="fa-solid fa-people-group mb-1"></i></p>
                    </div>
                </div>
                <div class="col d-flex flex-column py-3 px-5 ">
                    <div class="text-center mx-4">
                        <h3 class="text-white pt-2">Chapels</h3>
                        <hr class="custom-hr">
                        <p class="text-light fs-4 text-justify px-4 text-center">
                            10 <i class="fa-solid fa-place-of-worship mb-1"></i></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5" id="contact">
        <div class="row">
            <div class="glass-dark-card glass-border d-flex justify-content-center custom-radius-semicircle mx-auto py-5">
                <div class="col-sm-6 d-flex flex-column ps-5">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1937.0341436674018!2d-88.85715104406427!3d13.834938004640684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f635fe2ad74c89d%3A0x2f23a487d90de924!2sRivera%20Rent%20a%20car!5e0!3m2!1ses-419!2ssv!4v1721277573707!5m2!1ses-419!2ssv"
                        style="border:0; width: 100%; height: 100%" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="custom-radius-semicircle"></iframe>
                </div>
                <div class="col-sm-6 d-flex flex-column px-5">
                    <h3 class="text-white pt-2 text-center">Contact us</h3>
                    <div class="d-flex justify-content-center text-light gap-1">
                        <p class="me-2"><i class="fa-brands fa-whatsapp fa-lg ms-1"></i> +503 2121-2828</p>
                        <p class="me-2"><i class="fa-solid fa-phone fa-lg ms-1"></i> +503 2121-2828 </p>
                        <p class="me-2"><i class="fa-solid fa-blender-phone fa-lg ms-1"></i> +1 2121-2828</p>
                    </div>
                    <form class="glass-form">
                        <div class="col-sm-12 d-flex gap-2">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-light fw-semibold">First Name</label>
                                    <input type="text" class="form-control rounded" placeholder="First Name">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label text-light fw-semibold">Email</label>
                                    <input type="email" class="form-control rounded" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-sm-6 pe-2">
                                <div class="mb-3">
                                    <label for="lastname" class="form-label text-light fw-semibold">Lastname</label>
                                    <input type="text" class="form-control rounded" placeholder="Lastname">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label text-light fw-semibold">Phone Number</label>
                                    <input type="text" class="form-control rounded" placeholder="Phone number">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 p-0">
                            <div class="mb-3">
                                <label for="reason" class="form-label text-light fw-semibold">Reason</label>
                                <input type="text" class="form-control rounded" placeholder="Reason">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label text-light fw-semibold">Message</label>
                                <textarea class="form-control rounded" placeholder="Message"
                                          style="min-height: 200px;"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary color-primary fw-semibold w-50
                             rounded">Send message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('footer.show')
</div>
{{--Footer scripts--}}
<script src="https://kit.fontawesome.com/4e9e3f37c1.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>

