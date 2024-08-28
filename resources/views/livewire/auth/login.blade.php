<form wire:submit.prevent="login" class="glass-form">
    @if(session()->has('error'))
        <div>
            <p class="text-danger text-center">{{session('error')}}</p>
        </div>
    @endif
    <div class="mb-3">
        <label for="name" class="form-label text-light fw-semibold">Username</label>
        <input type="name" wire:model="username" class="form-control rounded-pill" placeholder="Username">
    </div>
    <div class="mb-4">
        <label for="password" class="form-label text-light fw-semibold">Password</label>
        <input type="password" wire:model="password" class="form-control rounded-pill" placeholder="Password">
    </div>
    <button type="submit" id="login-btn" class="btn btn-secondary color-primary fw-semibold w-100
                             py-2 mb-3 custom-radius">Login
    </button>
    <button id="btn" class="btn btn-primary">Test</button>
</form>



@section('scripts')
    <script>
        document.getElementById('btn').addEventListener('click', function () {
            Swal.fire({
                title: 'Test',
                text: 'asdasdad',
                icon: 'error',
                confirmButtonText: 'Ok',
                customClass: {
                    popup: 'custom-popup text-light',
                    title: 'text-light',
                    confirmButtonText: 'btn btn-secondary'
                }
            })
        })
    </script>

    @if(session()->has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Unexpected error',
                    text: '{{session('error')}}',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    customClass: {
                        popup: 'custom-popup text-light',
                        title: 'text-light',
                        confirmButtonText: 'btn-secondary'
                    }
                });
            });
        </script>
    @endif
@endsection
