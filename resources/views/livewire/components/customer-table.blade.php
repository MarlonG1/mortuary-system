<section>
    <div class="container">
        <div class="row col-xl-12 mx-auto py-4">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Customer records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openCreateModal"
                                data-bs-target="#customerModal">
                            <i class="fa-solid fa-user-plus"></i></button>
                    </div>
                </div>
                <div class="col-sm-11 mx-auto pb-3">
                    <div class="table-responsive">
                        <table class="table glass-table">
                            <thead>
                            <tr>
                                <th class="border-top-left" scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone number</th>
                                <th scope="col">DUI</th>
                                <th scope="col">Location</th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($customers as $customer)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">{{$customer->id}}</td>
                                    <td>{{$customer->name}} {{$customer->lastname}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->dui}}</td>
                                    <td>{{$customer->location}}</td>
                                    <td class="d-flex gap-2">
                                        <a href="#" class="btn btn-glass-blue"
                                           wire:click="openCreateModal({{$customer}})"
                                           data-bs-toggle="modal" data-bs-target="#customerModal"><i
                                                class="fa-solid fa-user-pen"></i></a>
                                        <a href="#" class="btn btn-glass-danger" data-id="{{$customer->id}}"
                                           id="deleteBtn"><i
                                                class="fa-solid fa-user-slash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center ">
                        <div class="text-center text-md-start mb-2 mb-md-0">
                            <span class="text-light">Showing {{$customers->firstItem()}} to {{$customers->lastItem()}} of {{$customers->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $customers->lastPage();
                            $currentPage = $customers->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($customers->onFirstPage())

                                    @if($totalPages > 5)
                                        <li class="page-item disabled">
                                            <button class="page-link glass-button-prev glass-link-border"
                                                    wire:click="gotoPage(1)" rel="first"> <<
                                            </button>
                                        </li>
                                    @endif

                                    <li class="page-item disabled">
                                        <span class="page-link glass-button-prev glass-link-border"> < </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <button class="page-link glass-button-prev glass-link-border"
                                                wire:click="previousPage" rel="prev"> <
                                        </button>
                                    </li>
                                @endif

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    @if ($page == $customers->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link glass-active glass-link-border">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <button class="page-link glass-link-border"
                                                    wire:click="gotoPage({{ $page }})">{{ $page }}</button>
                                        </li>
                                    @endif
                                @endfor

                                @if ($customers->hasMorePages())
                                        @if($totalPages > 5)
                                            <li class="page-item">
                                                <button class="page-link glass-button-next glass-link-border"
                                                        wire:click="gotoPage({{$customers->lastPage()}})" rel="last"> >>
                                                </button>
                                            </li>
                                        @endif
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link glass-button-next glass-link-border"> > </span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <div wire:ignore.self class="modal fade" id="customerModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating customer' : 'Add new customer'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="col-sm-12">
                            <label for="name" class="form-label text-light fw-semibold">Name</label>
                            <div class="input-group mb-3">
                                <span class="rounded-start input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                                <input wire:model="name" type="name" class="form-control rounded-end"
                                       placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="form-label text-light fw-semibold">Lastname</label>
                            <div class="input-group mb-3">
                                <span class="rounded-start input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                                <input wire:model="lastname" type="lastname" class="form-control rounded-end"
                                       placeholder="Lastname">
                            </div>
                        </div>
                        <div class="d-flex gap-1 col-sm-12">
                            <div class="mb-3 col-sm-6">
                                <label for="phone" class="form-label text-light fw-semibold">Phone number</label>
                                <div class="input-group">
                                    <span class="rounded-start input-group-text"><i
                                            class="fa-solid fa-phone"></i></span>
                                    <input wire:model="phone" type="phone" class="form-control rounded-end"
                                           placeholder="7777-7777">
                                </div>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="dui" class="form-label text-light fw-semibold">DUI</label>
                                <div class="input-group">
                                    <span class="rounded-start input-group-text"><i
                                            class="fa-solid fa-id-card"></i></span>
                                    <input wire:model="dui" type="dui" class="form-control rounded-end"
                                           placeholder="00000000-0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-light fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="rounded-start input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input wire:model="email" type="email" class="form-control rounded-end"
                                       placeholder="Email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label text-light fw-semibold">Location</label>
                            <div class="input-group">
                                <span class="rounded-start input-group-text"><i
                                        class="fa-solid fa-map-location"></i></span>
                                <textarea wire:model="location" class="form-control rounded-end"
                                          placeholder="Location"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createOrUpdateBtn">
                        {{isset($this->id) ?  'Update customer' : 'Add customer'}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>


@script
<script>
    Livewire.on('showToastAlert', (data) => {
        Toast.fire({
            icon: data.icon,
            title: data.title
        });
    });

    document.getElementById('deleteBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                popup: 'custom-popup text-light',
                title: 'text-light',
                confirmButton: 'btn btn-primary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let id = document.getElementById('deleteBtn').getAttribute('data-id');

                $wire.dispatchSelf('deleteCustomer', {id: id});
            }
        });
    });

    document.getElementById('createOrUpdateBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this customer!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            customClass: {
                popup: 'custom-popup text-light',
                title: 'text-light',
                confirmButton: 'btn btn-primary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                $wire.dispatchSelf('createOrUpdateCustomer');
            }
        });
    });

    document.addEventListener('hidden.bs.modal', function (event) {
        $wire.dispatchSelf('cleanCache');
    });
</script>
@endscript
