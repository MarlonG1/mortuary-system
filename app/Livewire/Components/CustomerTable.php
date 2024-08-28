<?php

namespace App\Livewire\Components;

use App\Models\Customer;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    public $id, $name, $lastname, $email, $phone, $location, $dui, $search = '';

    public function render(): View
    {
        return view('livewire.components.customer-table', [
            'customers' => Customer::search($this->search)->orderBy('id', 'desc')->paginate(8),
        ]);
    }

    private function clearFields(): void
    {
        $this->name = '';
        $this->lastname = '';
        $this->email = '';
        $this->phone = '';
        $this->location = '';
        $this->dui = '';
        $this->id = null;
    }

    public function openCreateModal(Customer $customer = null): void
    {
        if ($customer) {
            $this->name = $customer->name;
            $this->lastname = $customer->lastname;
            $this->email = $customer->email;
            $this->phone = $customer->phone;
            $this->location = $customer->location;
            $this->dui = $customer->dui;
            $this->id = $customer->id;
        } else {
            $this->clearFields();
        }
    }


    #[On('createOrUpdateCustomer')]
    public function createOrUpdateCustomer(): void
    {
        $this->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'location' => 'required',
            'dui' => 'required',
        ]);

        Customer::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'dui' => $this->dui,
            ]);

        $this->clearFields();
        $this->dispatch('showToastAlert',
        title : $this->id ? 'Customer created' : 'Customer updated',
        icon : 'success');
    }

    #[On('deleteCustomer')]
    public function deleteCustomer($id): void
    {
        try{
            $customer = Customer::findOrfail($id);
            $customer->delete();
        } catch (\Exception $e) {
            $this->dispatch('showToastAlert',
                title : 'Oops, something went wrong',
                icon : 'error');
        }

        $this->dispatch('showToastAlert',
            title : 'Customer deleted',
            icon : 'success');
    }

    #[On('cleanCacheImage')]
    public function cleanCacheImage() : void
    {
        $this->clearFields();
    }
}
