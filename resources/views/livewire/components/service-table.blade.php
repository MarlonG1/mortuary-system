<section>
    <div class="container">
        <div class="row col-xl-11 mx-auto  py-4">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Services records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openModal"
                                data-bs-target="#serviceModal">
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
                                <th wire:click="sortBy('available')" class="hide-icon" scope="col">Available <i
                                        class="fa-solid fa-sort{{$this->sortField === 'available' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($services->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-light">No records found</td>
                                </tr>
                            @endif
                            @foreach($services as $service)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">
                                        {{$service->id}}
                                    </td>
                                    <td>{{$service->name}}</td>
                                    <td>{{$service->available === true ? 'Yes' : 'No'}}</td>
                                    <td class="text-center">{{$service->serviceDetail->initial_stock !== 0 ? $service->serviceDetail->current_stock . '/' . $service->serviceDetail->initial_stock : 'Without stock'}}</td>
                                    <td class="text-center">${{$service->serviceDetail->price}}</td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn btn-glass-blue" wire:click="openModal({{$service}})"
                                           data-bs-toggle="modal" data-bs-target="#serviceModal"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="btn btn-glass-danger"
                                           wire:click="confirmDelete({{$service->id}})"><i
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
                            <span class="text-light">Showing {{$services->firstItem()}} to {{$services->lastItem()}} of {{$services->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $services->lastPage();
                            $currentPage = $services->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($services->onFirstPage())

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
                                    @if ($page == $services->currentPage())
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

                                @if ($services->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$services->lastPage()}})" rel="last"> >>
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
                                                    wire:click="gotoPage({{$services->lastPage()}})" rel="last"> >>
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
    <div wire:ignore.self class="modal fade" id="serviceModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating service' : 'Add new service'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Name</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-suitcase"></i></span>
                                    <input wire:model="name" type="name" class="form-control rounded-end"
                                           placeholder="Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i class="fa-solid fa-sack-dollar"></i></span>
                                    <input wire:model="price" type="number" class="form-control rounded-end"
                                           placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="progress" class="form-label text-light fw-semibold">Category</label>
                            <div wire:ignore class="input-group col-sm-12">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-percent"></i></span>
                                <select wire:model="category" id="selectCategory" class="selectpicker"
                                        data-live-search="true" data-style="btn-glass-dark" data-width="90%">
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($this->hasStock)
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="progress" class="form-label text-light fw-semibold">Current
                                        stock</label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text rounded-start"><i
                                                class="fa-solid fa-layer-group"></i></span>
                                        <input wire:model="currentStock" type="number"
                                               class="form-control rounded-end"
                                               placeholder="Current stock">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="progress" class="form-label text-light fw-semibold">Initial
                                        stock</label>
                                    <div class="input-group">
                                        <input wire:model="initialStock" type="number"
                                               class="form-control rounded-start"
                                               placeholder="Initial stock">
                                        <span class="input-group-text rounded-end"><i
                                                class="fa-solid fa-layer-group"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <label for="progress" class="form-label text-light fw-semibold">Description</label>
                            <div class="input-group">
                                <span class="input-group-text rounded-start"><i
                                        class="fa-solid fa-text-height"></i></span>
                                <textarea wire:model="description" class="form-control rounded-end"
                                          placeholder="Description..."></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="progress" class="form-label text-light fw-semibold text-center">Products to
                                assign</label>
                            <div wire:ignore class="input-group col-sm-12">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-percent"></i></span>
                                <select wire:model="productIds" id="productSelect" class="selectpicker"
                                        data-live-search="true" data-style="btn-glass-dark" data-width="90%" multiple>
                                    @foreach($dbProducts as $product)
                                        <option value="{{$product->id}}"
                                                data-subtext="Stock -> {{$product->productDetail->current_stock}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(count($this->products) > 0)
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <label for="progress" class="form-label text-light fw-semibold">Product</label>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <label for="progress" class="form-label text-light fw-semibold">Quantity</label>
                                </div>
                            </div>
                            @foreach($this->products as $product)
                                <div class="row pb-2" wire:key="product-row-{{$product->id}}">
                                    <div class="col-sm-6 ">
                                        <div class="input-group">

                                        <span class="input-group-text rounded-start"><i
                                                class="fa-solid fa-mug-saucer"></i></span>
                                            <input type="text"
                                                   class="form-control rounded-end"
                                                   disabled value="{{$product->name}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <div class="input-group">
                                            <input type="number"
                                                   class="form-control rounded-start"
                                                   placeholder="Count"
                                                   wire:model="quantities.{{$product->id}}"
                                            >
                                            <span class="input-group-text rounded-end"><i
                                                    class="fa-solid fa-layer-group"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createOrUpdateBtn">
                        {{isset($this->id) ?  'Update service' : 'Add service'}}
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
        $('#selectCategory')
            .selectpicker('val', data.category);

        $('#productSelect')
            .selectpicker('val', data.products);
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
                $wire.dispatchSelf('createOrUpdate');
            }
        });
    });


    $('#selectCategory').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    @this.set('category', $(this).val())
        ;
    });

    $('#productSelect').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    @this.set('productIds', $(this).val())
        ;
    });
</script>
@endscript


