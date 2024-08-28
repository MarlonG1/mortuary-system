<section class="pb-5">
    <div class="container">
        <div class="row col-xl-11 mx-auto pt-5">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Product records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openModal()"
                                data-bs-target="#productModal">
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
                                <th scope="col" class="pe-5">Progress</th>
                                <th scope="col">Count</th>
                                <th scope="col">Stock</th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($products->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-light">No records found</td>
                                </tr>
                            @endif
                            @foreach($products as $product)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">
                                        {{$product->id}}
                                    </td>
                                    <td>{{$product->name}}</td>
                                    <td class="pt-3">
                                        <div class="progress">
                                            <div class="progress-bar {{$this->setProgressBarLevel($product)}}"
                                                 role="progressbar"
                                                 style="width: {{$this->calculatePercent($product)}}%;"
                                                 aria-valuenow="{{$this->calculatePercent($product)}}" aria-valuemin="0"
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{$this->calculatePercent($product) . '%'}}</td>
                                    <td class="text-center">{{$product->productDetail->current_stock . '/' . $product->productDetail->initial_stock}}</td>
                                    <td class="d-flex gap-2">
                                        <a href="#" class="btn btn-glass-blue" wire:click="openModal({{$product}})"
                                           data-bs-toggle="modal" data-bs-target="#productModal"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="#" class="btn btn-glass-success"
                                           data-bs-toggle="modal" data-bs-target="#imageModal"
                                           data-id="{{$product->id}}"
                                           wire:click="openModal({{$product}})">
                                            <i class="fa-regular fa-image"></i></a>
                                        <a href="#" class="btn btn-glass-danger"
                                           wire:click="confirmDelete({{$product->id}})"><i
                                                class="fa-solid fa-eraser"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <div class="text-center text-md-start mb-2 mb-md-0">
                            <span class="text-light">Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $products->lastPage();
                            $currentPage = $products->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($products->onFirstPage())

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
                                    @if ($page == $products->currentPage())
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

                                @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$products->lastPage()}})" rel="last"> >>
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
                                                    wire:click="gotoPage({{$products->lastPage()}})" rel="last"> >>
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
    <div wire:ignore.self class="modal fade" id="productModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating product' : 'Add new product'}}</h5>
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
                                <label for="name" class="form-label text-light fw-semibold">Price</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text rounded-start"><i class="fa-solid fa-sack-dollar"></i></span>
                                    <input wire:model="price" type="number" class="form-control rounded-end"
                                           placeholder="Name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="progress" class="form-label text-light fw-semibold">Categories</label>
                            <div wire:ignore class="input-group col-sm-12">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-percent"></i></span>
                                <select wire:model="categories" id="selectCategories" class="selectpicker"
                                        data-live-search="true" data-style="btn-glass-dark" data-width="90%" multiple>
                                    @foreach($dbCategories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($this->hasStock)
                                <p class="text-center text-secondary-emphasis mt-0  mb-3">One of the categories selected
                                    has a
                                    stock</p>
                            @endif
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
                                <div class="col-sm-6 pe-0">
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
                        <hr>
                        @if($this->newImage)
                            <div wire:loading.class="loader mx-auto">
                                <img src="{{ $this->newImage->temporaryUrl() }}"
                                     class="rounded" alt="" width="100%">
                            </div>
                            <p class="text-center text-secondary-emphasis">This is a preview of the photo</p>
                        @else
                            <div wire:loading.class="loader mx-auto">
                                <img src="{{ $this->image }}" class="rounded"
                                     alt=""
                                     width="100%">
                            </div>
                        @endif
                        <div class="input-group pt-3">
                            <span class="input-group-text rounded-start"><i class="fa-solid fa-camera"></i></span>
                            <input type="file" class="form-control rounded-end" wire:model="newImage">
                        </div>
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
    <div wire:ignore.self class="modal fade" id="imageModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product photo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="mb-3 text-center">
                            <label for="name"
                                   class="form-label text-light fw-semibold"> {{ $this->newImage ? 'Image preview':  'Current image' }}</label>
                            @if($this->newImage)
                                <div wire:loading.class="loader mx-auto">
                                    <img src="{{ $this->newImage->temporaryUrl() }}"
                                         class="rounded" alt="" width="100%">
                                </div>
                                <p>This is a preview of the photo</p>
                            @else
                                @if(isset($this->id))
                                    <div wire:loading.class="loader mx-auto">
                                        <img src="{{ $this->image }}" class="rounded"
                                             alt=""
                                             width="100%">
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="mb-3 text-center">
                            <label for="location" class="form-label text-light fw-semibold">Upload new image</label>
                            <div wire:ignore class="input-group">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-camera"></i></span>
                                <input type="file" class="form-control rounded-end" wire:model="newImage">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            wire:click="cleanCacheImage">Cancel
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="changeImageBtn">
                        Save changes
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
        $('#selectCategories')
            .selectpicker('val', data.categories);
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

    document.getElementById('changeImageBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this image!",
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
                let id = document.getElementById('changeImageBtn').getAttribute('data-id');
                $wire.dispatchSelf('changeImage', {id: id});
            }
        });
    });


    $('#selectCategories').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
        let currentCategories = @this.get('categories');
        let changedCategory = $(this).find('option').eq(clickedIndex).val();

        if (isSelected) {
            currentCategories.push(changedCategory);
        } else {
            currentCategories = currentCategories.filter(category => category !== changedCategory);
        }

    @this.set('categories', currentCategories)
        ;
    });
</script>
@endscript

