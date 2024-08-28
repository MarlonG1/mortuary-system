<section>
    <div class="container">
        <div class="row col-xl-12 mx-auto py-4">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Employees records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openModal"
                                data-bs-target="#employeeModal">
                            <i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-sm-11 mx-auto pb-3">
                    <div class="table-responsive">
                        <table class="table glass-table">
                            <thead>
                            <tr>
                                <th wire:click="sortBy('id')" class="border-top-left hide-icon" scope="col">ID<i
                                        class="fa-solid fa-sort{{$this->sortField === 'id' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th wire:click="sortBy('name')" class="hide-icon" scope="col">Name <i
                                        class="fa-solid fa-sort{{$this->sortField === 'name' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th wire:click="sortBy('lastname')" class="hide-icon" scope="col">Lastname <i
                                        class="fa-solid fa-sort{{$this->sortField === 'lastname' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th wire:click="sortBy('birthDate')" class="hide-icon" scope="col">Birth date <i
                                        class="fa-solid fa-sort{{$this->sortField === 'birthDate' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th scope="col">Office</th>
                                <th scope="col">Phone</th>
                                <th scope="col">DUI</th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($employees->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-light">No records found</td>
                                </tr>
                            @endif
                            @foreach($employees as $employee)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">
                                        {{$employee->id}}
                                    </td>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->lastname}}</td>
                                    <td>{{$employee->birth_date}}</td>
                                    <td>{{$employee->office->location}}</td>
                                    <td>{{$employee->phone}}</td>
                                    <td>{{$employee->dui}}</td>
                                    <td class="d-flex gap-2 h-100">
                                        <a href="#" class="btn btn-glass-blue" wire:click="openModal({{$employee}})"
                                           data-bs-toggle="modal" data-bs-target="#employeeModal"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="btn btn-glass-danger"
                                           wire:click="confirmDelete({{$employee->id}})"><i
                                                class="fa-solid fa-eraser"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center ">
                        <div class="text-center text-md-start mb-2 mb-md-0">
                            <span class="text-light">Showing {{$employees->firstItem()}} to {{$employees->lastItem()}} of {{$employees->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $employees->lastPage();
                            $currentPage = $employees->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($employees->onFirstPage())

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
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-prev glass-link-border"
                                                    wire:click="gotoPage(1)" rel="first"> <<
                                            </button>
                                        </li>
                                    @endif
                                    <li class="page-item">
                                        <button class="page-link glass-button-prev glass-link-border"
                                                wire:click="previousPage" rel="prev"> <
                                        </button>
                                    </li>
                                @endif

                                @for ($page = $startPage; $page <= $endPage; $page++)
                                    @if ($page == $employees->currentPage())
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

                                @if ($employees->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$employees->lastPage()}})" rel="last"> >>
                                            </button>
                                        </li>
                                    @endif
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link glass-button-next glass-link-border"> > </span>
                                    </li>

                                    @if($totalPages > 5)
                                        <li class="page-item disabled">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$employees->lastPage()}})" rel="last"> >>
                                            </button>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
    <div wire:ignore.self class="modal fade" id="employeeModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating employee' : 'Add new employee'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Name</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-user-pen"></i></span>
                                    <input wire:model="name" type="name" class="form-control rounded-end"
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Lastname</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-user-pen"></i></span>
                                    <input wire:model="lastname" type="text" class="form-control rounded-end"
                                           placeholder="lastname">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Phone</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-phone"></i></span>
                                    <input wire:model="phone" type="name" class="form-control rounded-end"
                                           placeholder="7777-7777">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Birth date</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-calendar-days"></i></span>
                                    <input wire:model="birthDate" type="date" class="form-control rounded-end"
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="name" class="form-label text-light fw-semibold">DUI</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-id-card"></i></span>
                                    <input wire:model="dui" type="text" class="form-control rounded-end"
                                           placeholder="00000000-0">
                                </div>
                            </div>
                        </div>
                        @json($this->hasAccount)
                        <div class="row">
                            <label for="progress" class="form-label text-light fw-semibold">Office</label>
                            <div wire:ignore class="input-group col-sm-12">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-percent"></i></span>
                                <select wire:model="office" id="selectOffice" class="selectpicker"
                                        data-live-search="true" data-style="btn-glass-dark" data-width="90%">
                                    @foreach($offices as $office)
                                        <option value="{{$office->id}}">{{$office->location}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center py-2">
                            <div class="form-check">
                                <input wire:model="hasAccount"
                                       {{$this->hasAccount ? 'checked' : ''}} class="form-check-input" type="checkbox"
                                       value="true" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Has account
                                </label>
                            </div>
                        </div>
                        @if($this->hasAccount)
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label text-light fw-semibold">Username</label>
                                    <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-id-card"></i></span>
                                        <input wire:model="usernameUser" type="text" class="form-control rounded-end"
                                               placeholder="Username...">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="name" class="form-label text-light fw-semibold">Username</label>
                                    <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-id-card"></i></span>
                                        <input wire:model="passwordUser" type="password" class="form-control rounded-end"
                                               placeholder="Password...">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="name" class="form-label text-light fw-semibold">Email</label>
                                    <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-envelope"></i></span>
                                        <input wire:model="emailUser" type="email" class="form-control rounded-end"
                                               placeholder="Email...">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createOrUpdateBtn">
                        {{isset($this->id) ?  'Update product' : 'Add product'}}
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

    Livewire.on('show-delete-alert', () => {
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
                $wire.dispatchSelf('delete');
            }
        });
    });

    Livewire.on('modalReady', (data) => {
        $('#selectOffice')
            .selectpicker('val', data.office)
    });

    document.getElementById('createOrUpdateBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this employee!",
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
                $wire.dispatchSelf('createOrUpdate');
            }
        });
    });

    $('#selectOffice').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        let selectedOffice = $(this).find('option').eq(clickedIndex).val();
    @this.set('office', selectedOffice)
        ;
    });

    $('#flexCheckDefault').on('change', function () {
        @this.set('hasAccount', this.checked);
    });

</script>
@endscript

