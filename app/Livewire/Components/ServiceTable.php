<?php

namespace App\Livewire\Components;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceTable extends Component
{
    use WithPagination;

    public $search = '', $sortField = 'id', $sortDirection = 'desc', $sortIcon = '-down';

    public $id, $name, $available, $category, $description, $price, $initialStock, $currentStock, $products = [], $productIds = [], $quantities = [];
    public $hasStock = false;
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function render(): View
    {
        return view('livewire.components.service-table', [
            'services' => Service::search($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(8),
            'dbProducts' => Product::orderBy('name', 'asc')->get(),
            'categories' => Category::where('type', 'Service')->orderBy('name', 'asc')->get(),
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

    public function updatedProductIds($value): void
    {
        $this->products = Product::find($value);
    }

    public function updatedCategory($value): void
    {
        if ($value) {
            $this->hasStock = Category::findOrFail($value)->stock;
        } else {
            $this->hasStock = false;
        }
    }

    private function clearFields(): void
    {
        $this->name = '';
        $this->category = '';
        $this->description = '';
        $this->price = '';
        $this->initialStock = '';
        $this->currentStock = '';
        $this->products = [];
        $this->quantities = [];
        $this->productIds = [];
        $this->available = false;
        $this->hasStock = false;
    }

    public function openModal(Service $service = null): void
    {
        if ($service) {
            $this->id = $service->id;
            $this->name = $service->name;
            $this->available = $service->available;
            $this->category = $service->category_id;
            $this->description = $service->serviceDetail->description ?? '';
            $this->price = $service->serviceDetail->price ?? '';
            $this->initialStock = $service->serviceDetail->initial_stock ?? '';
            $this->currentStock = $service->serviceDetail->current_stock ?? '';
            $this->products = $service->products;
            $this->quantities = $service->products->pluck('pivot.quantity', 'id')->toArray() ?? [];
            $this->productIds = $this->products->pluck('id')->map(fn($product) => (string)$product)->toArray() ?? [];
            $this->dispatch('modalReady',
                category: (string)$this->category,
                products: $this->productIds);

            if ($this->category) {
                $this->hasStock = Category::findOrFail($this->category)->stock;
            } else {
                $this->hasStock = false;
            }
        } else {
            $this->clearFields();
        }

    }

    #[On('createOrUpdate')]
    public function createOrUpdate(): void
    {
        $service = Service::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'available' => true,
                'category_id' => $this->category,
            ]);

        $service->serviceDetail()->updateOrCreate(
            ['service_id' => $service->id],
            [
                'description' => $this->description,
                'price' => $this->price,
                'initial_stock' => $this->initialStock,
                'current_stock' => $this->currentStock,
            ]);

        foreach ($this->products as $product) {
            $service->products()->syncWithoutDetaching([$product->id => ['quantity' => $this->quantities[$product->id]]]);
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: $this->id ? 'Service created' : 'Service updated',
            icon: 'success');
    }

    #[On('delete')]
    public function delete(): void
    {
        try {
            $service = Service::findOrfail($this->id);
            $service->delete();
        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title: 'Oops, something went wrong',
                icon: 'error');
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: 'Service deleted',
            icon: 'success');
    }

    public function confirmDelete($id): void
    {
        $this->id = $id;
        $this->dispatch('show-delete-alert');
    }
}
