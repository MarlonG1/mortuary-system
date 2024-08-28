<section>
    <div class="container">
        <div class="row col-xl-11 mx-auto py-5">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Categories records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openModal"
                                data-bs-target="#categoryModal">
                            <i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-sm-10 mx-auto pb-3">
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
                                <th wire:click="sortBy('type')" scope="col" class="hide-icon">Type <i
                                        class="fa-solid fa-sort{{$this->sortField === 'type' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th scope="col">
                                    Stockable
                                </th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($categories->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-light">No records found</td>
                                </tr>
                            @endif
                            @foreach($categories as $category)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">
                                        {{$category->id}}
                                    </td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->type}}</td>
                                    <td>{{$category->stock  ? 'Yes' : 'No'}}</td>
                                    <td class="d-flex gap-2">
                                        <a href="#" class="btn btn-glass-blue" wire:click="openModal({{$category}})"
                                           data-bs-toggle="modal" data-bs-target="#categoryModal"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="btn btn-glass-success"
                                           data-bs-toggle="modal" data-bs-target="#detailsModal"
                                           wire:click="openModal({{$category}})">
                                            <i class="fa-solid fa-book"></i></a>
                                        <a href="#" class="btn btn-glass-danger"
                                           wire:click="confirmDelete({{$category->id}})"><i
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
                            <span class="text-light">Showing {{$categories->firstItem()}} to {{$categories->lastItem()}} of {{$categories->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $categories->lastPage();
                            $currentPage = $categories->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($categories->onFirstPage())

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
                                    @if ($page == $categories->currentPage())
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

                                @if ($categories->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$categories->lastPage()}})" rel="last"> >>
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
                                                    wire:click="gotoPage({{$categories->lastPage()}})" rel="last"> >>
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
    <div wire:ignore.self class="modal fade" id="categoryModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating category' : 'Add new category'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="col-sm-12">
                            <label for="name" class="form-label text-light fw-semibold">Name</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-user-pen"></i></span>
                                <input wire:model="name" type="name" class="form-control rounded-end"
                                       placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="name" class="form-label text-light fw-semibold">Type</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-list"></i></span>
                                <select wire:model="type" class="form-select rounded-end"
                                        aria-label="Default select example">
                                    <option selected>Choose...</option>
                                    <option value="Product">Product</option>
                                    <option value="Service">Service</option>
                                </select>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                <div class="form-check">
                                    <input wire:model="isStockable"
                                           {{$this->isStockable ?? 'checked'}} class="form-check-input" type="checkbox"
                                           value="true" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Is stockable
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label text-light fw-semibold">Details</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start"><i
                                        class="fa-solid fa-text-height"></i></span>
                                <textarea wire:model="details" class="form-control rounded-end"
                                          placeholder="Details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createOrUpdateBtn">
                        {{isset($this->id) ?  'Update category' : 'Add category'}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="detailsModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating category' : 'Add new category'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <label for="location" class="form-label text-light fw-semibold">Details</label>
                        <div class="input-group">
                                <span class="input-group-text rounded-start"><i
                                        class="fa-solid fa-text-height"></i></span>
                            <textarea wire:model="details" class="form-control rounded-end"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="updateDetailsBtn">
                        Update details
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

    document.getElementById('createOrUpdateBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this category!",
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

    document.getElementById('updateDetailsBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this category!",
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
                $wire.dispatchSelf('updateDetails');
            }
        });
    });

    document.addEventListener('hidden.bs.modal', function (event) {
        $wire.dispatchSelf('cleanCache');
    });
</script>
@endscript
