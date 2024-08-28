<section>
    <div class="container">
        <div class="row col-xl-11 mx-auto py-4">
            <div class="glass-dark-card glass-border rounded py-4">
                <div class="col-sm-11 mx-auto d-flex justify-content-between align-items-center">
                    <h2 class="py-4 text-light fw-bold text-center">Sale records</h2>
                    <div class="d-flex gap-2">
                        <input wire:model.live="search" type="search" class="form-control rounded" data-bs-theme="dark"
                               placeholder="Search">
                        <button class="btn btn-glass-success" data-bs-toggle="modal"
                                wire:click="openModal"
                                data-bs-target="#saleModal">
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
                                <th wire:click="sortBy('sale_date')" class="hide-icon" scope="col">Sale date <i
                                        class="fa-solid fa-sort{{$this->sortField === 'sale_date' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th wire:click="sortBy('execution_date')" class="hide-icon" scope="col">Execution date
                                    <i
                                        class="fa-solid fa-sort{{$this->sortField === 'execution_date' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th wire:click="sortBy('total')" class="hide-icon" scope="col">Total <i
                                        class="fa-solid fa-sort{{$this->sortField === 'total' ? $this->sortIcon : ''}} p-1"></i>
                                </th>
                                <th scope="col">Office</th>
                                <th scope="col">Customer</th>
                                <th class="border-top-right" scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($sales->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-light">No records found</td>
                                </tr>
                            @endif
                            @foreach($sales as $sale)
                                <tr wire:loading.class="skeleton-loader opacity-50">
                                    <td class="text-center">{{$sale->id}}</td>
                                    <td>{{$sale->sale_date}}</td>
                                    <td>{{$sale->execution_date}}</td>
                                    <td>${{$sale->total}}</td>
                                    <td>{{$sale->office->location}}</td>
                                    <td>{{$sale->customer->name}}</td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <a href="#" class="btn btn-glass-blue" wire:click="openModal({{$sale}})"
                                           data-bs-toggle="modal" data-bs-target="#saleModal"><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="{{route('viewTicket', $sale->id)}}" class="btn btn-glass-success"
                                           target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                                        <a href="#" class="btn btn-glass-danger"
                                           wire:click="confirmDelete({{$sale->id}})"><i
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
                            <span class="text-light">Showing {{$sales->firstItem()}} to {{$sales->lastItem()}} of {{$sales->total()}} results</span>
                        </div>

                        @php
                            $totalPages = $sales->lastPage();
                            $currentPage = $sales->currentPage();
                            $startPage = max($currentPage - 2, 1);
                            $endPage = min($startPage + 4, $totalPages);

                            if ($endPage - $startPage < 4) {
                                $startPage = max($endPage - 4, 1);
                            }
                        @endphp

                        <nav aria-label="Page navigation" class="text-center text-md-end">
                            <ul class="pagination justify-content-center justify-content-md-end glass-link-border rounded">
                                @if ($sales->onFirstPage())

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
                                    @if ($page == $sales->currentPage())
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

                                @if ($sales->hasMorePages())
                                    <li class="page-item">
                                        <button class="page-link glass-button-next glass-link-border"
                                                wire:click="nextPage" rel="next"> >
                                        </button>
                                    </li>
                                    @if($totalPages > 5)
                                        <li class="page-item">
                                            <button class="page-link glass-button-next glass-link-border"
                                                    wire:click="gotoPage({{$sales->lastPage()}})" rel="last"> >>
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
                                                    wire:click="gotoPage({{$sales->lastPage()}})" rel="last"> >>
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
    <div wire:ignore.self class="modal fade" id="saleModal" tabindex="-1" data-bs-theme="dark"
         data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{isset($this->id) ?  'Updating sale' : 'Add new sale'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-5 py-4">
                    <div class="glass-form container">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Customer</label>
                                <div wire:ignore class="input-group">
                                    <select wire:model="customer" id="selectCustomer" class="selectpicker rounded"
                                            data-live-search="true" data-style="btn-glass-dark border-rd-full"
                                            title="Select one">
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Office</label>
                                <div wire:ignore class="input-group">
                                    <select wire:model="office" id="selectOffice" class="selectpicker"
                                            data-live-search="true" data-style="btn-glass-dark border-rd-full"
                                            title="Select one">
                                        @foreach($offices as $office)
                                            <option value="{{$office->id}}">{{$office->location}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="progress" class="form-label text-light fw-semibold">Services</label>
                            <div wire:ignore class="input-group col-sm-12">
                                <span class="input-group-text rounded-start"><i class="fa-solid fa-percent"></i></span>
                                <select wire:model="serviceIds" id="selectServices" class="selectpicker"
                                        data-live-search="true" data-style="btn-glass-dark" data-width="90%" multiple>
                                    @foreach($dbServices as $service)
                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Sale date</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-calendar-days"></i></span>
                                    <input wire:model="saleDate" type="date" class="form-control rounded-end">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="name" class="form-label text-light fw-semibold">Execution date</label>
                                <div class="input-group">
                                    <span class="input-group-text rounded-start"><i
                                            class="fa-solid fa-calendar-days"></i></span>
                                    <input wire:model="executionDate" type="date" class="form-control rounded-end">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 mx-auto text-center">
                                <label for="name" class="form-label text-light fw-semibold">Total</label>
                                <div class="input-group mb-3">
                                <span class="input-group-text rounded-start"><i
                                        class="fa-solid fa-sack-dollar"></i></span>
                                    <input wire:model="total" type="number" class="form-control rounded-end"
                                           disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="createOrUpdateBtn">
                        {{isset($this->id) ?  'Update sale' : 'Add sale'}}
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

    Livewire.on('checkStock', (data) => {
        if(!data.updating){
            Toast.fire({
                icon: data.icon,
                title: data.title
            });
        }
    });

    $('#selectCustomer').selectpicker('render');

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
        $('#selectServices').selectpicker('val', data.services);
        $('#selectCustomer').selectpicker('val', data.customer);
        $('#selectOffice').selectpicker('val', data.office);
    });

    document.getElementById('createOrUpdateBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to save this sale!",
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

    $('#selectServices').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    @this.set('serviceIds', $(this).val())
        ;
    });

    $('#selectCustomer').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    @this.set('customer', $(this).val())
        ;
    });

    $('#selectOffice').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    @this.set('office', $(this).val())
        ;
    });
</script>
@endscript



