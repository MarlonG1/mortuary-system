<?php

namespace App\Livewire\Components;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\View\View;
use Laravel\Scout\Searchable;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '', $sortField = 'id', $sortDirection = 'desc', $sortIcon = '-down';

    public $id, $name, $count, $progress, $stock, $price, $initialStock, $currentStock, $newImage, $image;
    public $categories = [];
    public $isService = false, $hasStock = false;
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function render(): View
    {
        return view('livewire.components.product-table', [
            'products' => Product::search($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(8),
            'dbCategories' => Category::all(),
        ]);
    }

    public function updatedCategories()
    {
        $this->hasStock = Category::whereIn('id', $this->categories)
            ->where('stock', true)
            ->exists();
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

    private function clearFields(): void
    {
        $this->name = '';
        $this->count = '';
        $this->stock = '';
        $this->price = '';
        $this->initialStock = '';
        $this->currentStock = '';
        $this->image = '';
        $this->newImage = '';
        $this->isService = false;
        $this->hasStock = false;
        $this->categories = [];
        $this->id = null;
    }

    public function openModal(Product $product = null): void
    {
        if ($product) {
            $this->name = $product->name;
            $this->count = $product->count;
            $this->stock = $product->stock;
            $this->price = $product->productDetail->price ?? '';
            $this->initialStock = $product->productDetail->initial_stock ?? '';
            $this->currentStock = $product->productDetail->current_stock ?? '';
            $this->image = $product->productDetail->image ?? '';
            $this->categories = $product->categories->pluck('id')->map(fn($category) => (string)$category)->toArray();
            $this->newImage = '';
            $this->id = $product->id;
            $this->hasStock = $product->categories->some(function ($category) {
                return $category->stock === true;
            });
            $this->dispatch('modalReady',
                categories: $this->categories);
        } else {
            $this->clearFields();
        }

    }

    private function calculatePercent(Product $product): int
    {
        $this->progress = round((($product->productDetail->current_stock / $product->productDetail->initial_stock) * 100), 0);
        return $this->progress;
    }

    public function setProgressBarLevel($product): string
    {
        $percent = $this->calculatePercent($product);

        $color = match (true) {
            $percent <= 70 && $percent >= 50 => 'bg-info-dark',
            $percent <= 50 && $percent >= 20 => 'bg-warning-dark',
            $percent <= 20 => 'bg-danger-dark',
            default => 'bg-success-dark',
        };

        return $color;
    }

    #[On('createOrUpdate')]
    public function createOrUpdate(): void
    {
        $product = Product::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'count' => 1,
            ]);

        $product->productDetail()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'price' => $this->price,
                'initial_stock' => $this->initialStock,
                'current_stock' => $this->currentStock,
            ]);

        $product->categories()->sync($this->categories);


        if ($this->newImage) {

            if ($product->productDetail->image){
                $oldImagePath = public_path('storage/img/products/' . $product->productDetail->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $productName = $product->id . '-' . $product->name . '.' . $this->newImage->extension();
            $this->newImage->storeAs(path: 'public/img/products', name: $productName);

            $product->productDetail->update([
                'image' => '/storage/img/products/' . $productName
            ]);
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: $this->id ? 'Product created' : 'Product updated',
            icon: 'success');
    }

    #[On('delete')]
    public function delete(): void
    {
        try {
            $product = Product::findOrfail($this->id);
            $product->delete();
        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title: 'Oops, something went wrong',
                icon: 'error');
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: 'Product deleted',
            icon: 'success');
    }

    #[On('changeImage')]
    public function changeImage($id): void
    {

        try {
            $product = Product::findOrfail($this->id);
            $productName = $product->id . '-' . $product->name . '.' . $this->newImage->extension();

            if ($this->newImage) {
                $oldImagePath = public_path('storage/img/products/' . $product->productDetail->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $this->newImage->storeAs(path: 'public/img/products', name: $productName);

            $product->productDetail->update([
                'image' => '/storage/img/products/' . $productName
            ]);

            $this->clearFields();
            $this->dispatch('showToastAlert',
                title: 'Image updated',
                icon: 'success'
            );

        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title: 'Oops, something went wrong',
                icon: 'error'
            );
        }
    }

    public function confirmDelete($id): void
    {
        $this->id = $id;
        $this->dispatch('show-delete-alert');
    }

    #[On('cleanCacheImage')]
    public function cleanCacheImage(): void
    {
        $this->clearFields();
    }
}
