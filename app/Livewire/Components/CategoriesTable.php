<?php

namespace App\Livewire\Components;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CategoriesTable extends Component
{
    use WithPagination;

    public $search = '', $sortField = 'id', $sortDirection = 'desc', $sortIcon = '-down';
    public $id, $name, $details, $type, $isStockable = false;
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function render() : View
    {
        return view('livewire.components.categories-table', [
            'categories' => Category::search($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(8),
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

    private function clearFields(): void
    {
        $this->name = '';
        $this->details = '';
        $this->type = '';
        $this->isStockable = false;
        $this->id = null;
    }

    public function openModal(Category $category = null): void
    {
        if ($category) {
            $this->name = $category->name;
            $this->details = $category->details;
            $this->type = $category->type;
            $this->isStockable = $category->stock;
            $this->id = $category->id;
        } else {
            $this->clearFields();
        }
    }

    #[On('createOrUpdate')]
    public function createOrUpdate(): void
    {
        Category::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'details' => $this->details,
                'type' => $this->type,
                'stock' => $this->isStockable,
            ]);

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: $this->id ? 'Category created' : 'Category updated',
            icon: 'success');
    }

    public function confirmDelete($id): void
    {
        $this->id = $id;
        $this->dispatch('show-delete-alert');
    }

    #[On('delete')]
    public function delete(): void
    {
        try {
            $category = Category::findOrFail($this->id);
            $category->delete();
        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title: 'Oops, something went wrong',
                icon: 'error');
        }

        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: 'Category deleted',
            icon: 'success');
    }
}
