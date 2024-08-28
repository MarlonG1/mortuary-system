<?php

namespace App\Livewire\Components;

use App\Models\Customer;
use App\Models\Office;
use App\Models\Sale;
use App\Models\Service;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;

class SaleTable extends Component
{
    use WithPagination;

    public $search = '', $sortField = 'id', $sortDirection = 'desc', $sortIcon = '-down';
    public $id, $customer, $office, $total = 0, $saleDate, $executionDate, $services = [], $serviceIds = [], $isUpdating = false;
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function render()
    {
        return view('livewire.components.sale-table', [
            'sales' => Sale::search($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(8),
            'dbServices' => Service::orderBy('name', 'asc')->get(),
            'customers' => Customer::orderBy('name', 'asc')->get(),
            'offices' => Office::all(),
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            $this->sortIcon = $this->sortDirection === 'asc' ? '-up' : '-down';
        } else {
            $this->sortDirection = 'asc';
            $this->sortIcon = '-up';
        }

        $this->sortField = $field;
    }

    public function updatedServiceIds($value): void
    {
        $selectedIds = collect($value);

        $this->services = $this->services->filter(function ($service) use ($selectedIds) {
            return $service !== null && $selectedIds->contains($service->id);
        });

        if (!$selectedIds->isEmpty() && !$this->isUpdating) {
//            $selectedIds->each(function ($serviceId) {
//                $service = Service::find($serviceId);
//
//                if ($service->serviceDetail->stock <= 0) {
//                    $this->dispatch('showToastAlert',
//                        icon: 'error',
//                       title: 'The stock of ' . $service->name . ' is not enough');
//                    $this->serviceIds = $this->services->pluck('id')->map(fn($service) => (string)$service)->toArray();
//                }
//            });

            $selectedIds->each(function ($serviceId) {
                $service = Service::find($serviceId);
                foreach ($service->products as $product) {
                    if ($product->productDetail->current_stock <= 0) {
                        $this->dispatch('checkStock',
                            icon: 'error',
                            title: 'The stock of ' . $product->name . ' is not enough',
                            updating: $this->isUpdating);
                        $this->serviceIds = array_diff($this->serviceIds, [$serviceId]);
                        $this->services = $this->services->filter(fn($service) => $service->id != $serviceId);
                        $this->dispatch('modalReady',
                            customer: (string)$this->customer,
                            office: (string)$this->office,
                            services: $this->serviceIds);
                    }
                }
            });
        }


        $newServices = $selectedIds->diff($this->services->pluck('id'))
            ->map(fn($serviceId) => Service::find($serviceId))
            ->filter();

        $this->services = $this->services->merge($newServices)->unique('id');
        $this->total = $this->calculateTotal();
    }

    public function openTicket($id)
    {

    }

    public function updatedServices(): void
    {
        $this->total = $this->calculateTotal();
    }

    private function calculateTotal(): float
    {
        return empty($this->services) ? 0 : $this->services
            ->filter(fn($service) => !is_null($service))
            ->sum(fn($service) => $service->serviceDetail->price);
    }

    public function clearFields()
    {
        $this->id = '';
        $this->customer = '';
        $this->office = '';
        $this->total = 0;
        $this->saleDate = '';
        $this->executionDate = '';
        $this->isUpdating = false;
        $this->services = [];
        $this->serviceIds = [];
    }

    public function openModal(Sale $sale = null): void
    {
        if ($sale) {
            $this->isUpdating = (bool)$sale->id;
            $this->id = $sale->id;
            $this->customer = $sale->customer_id;
            $this->office = $sale->office_id;
            $this->saleDate = $sale->sale_date;
            $this->executionDate = $sale->execution_date;
            $this->services = collect($sale->services);
            $this->serviceIds = $this->services->pluck('id')->map(fn($service) => (string)$service)->toArray();
            $this->total = $sale->total;
            $this->dispatch('modalReady',
                customer: (string)$this->customer,
                office: (string)$this->office,
                services: $this->serviceIds);
        } else {
            $this->clearFields();
        }

//        dd($this->isUpdating);
    }

    #[On('createOrUpdate')]
    public function createOrUpdate(): void
    {
        $sale = Sale::updateOrCreate(['id' => $this->id], [
            'customer_id' => $this->customer,
            'office_id' => $this->office,
            'sale_date' => $this->saleDate,
            'execution_date' => $this->executionDate,
            'total' => $this->total,
        ]);


        $sale->services()->sync($this->serviceIds);

        $servicesIds = $this->serviceIds;
        $servicesInSale = $sale->services->pluck('id')->toArray();

        if (!$this->isUpdating && $servicesIds === $servicesInSale) {
            $this->services->each(function ($service) {
                foreach ($service->products as $product) {
                    $product->productDetail->current_stock -= $product->pivot->quantity;
                    $product->productDetail->save();
                }
            });
        }


        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: $this->id ? 'Sale created' : 'Sale updated',
            icon: 'success');
    }

    public function viewTicket($id)
    {
        $this->redirect(route('viewPdf', ['id' => $id]));
    }

    #[On('delete')]
    public function delete(): void
    {
        try {
            $sale = Sale::findOrfail($this->id);
            $sale->delete();
        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title: 'Oops, something went wrong',
                icon: 'error');
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: 'Sale deleted',
            icon: 'success');
    }

    public function confirmDelete($id): void
    {
        $this->id = $id;
        $this->dispatch('show-delete-alert');
    }
}
