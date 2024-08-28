<?php

namespace App\Livewire\Components;

use App\Models\Employee;
use App\Models\Office;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{

    use WithPagination;

    public $search = '', $sortField = 'id', $sortDirection = 'desc', $sortIcon = '-down';

    public $id, $name, $office, $lastname, $phone, $birthDate, $dui, $hasAccount = false;
    public $usernameUser, $emailUser, $passwordUser;
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    public function render()
    {
        return view('livewire.components.users-table',[
            'employees' => Employee::search($this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(8),
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

    private function clearFields(): void
    {
        $this->name = '';
        $this->office = '';
        $this->lastname = '';
        $this->phone = '';
        $this->birthDate = '';
        $this->dui = '';
        $this->id = '';
        $this->usernameUser = '';
        $this->emailUser = '';
        $this->passwordUser = '';
        $this->hasAccount = false;
    }

    public function openModal(Employee $employee = null): void
    {
        if ($employee) {
            $this->id = $employee->id;
            $this->name = $employee->name;
            $this->office = $employee->office->id ?? '';
            $this->lastname = $employee->lastname;
            $this->phone = $employee->phone;
            $this->birthDate = $employee->birth_date;
            $this->dui = $employee->dui;
            $this->hasAccount = $employee->user !== null;
            $this->usernameUser = $employee->user->username ?? '';
            $this->emailUser = $employee->user->email ?? '';
            $this->passwordUser = '';
            $this->dispatch('modalReady',
                office: (string)$this->office);
        } else {
            $this->clearFields();
        }
    }

    #[On('createOrUpdate')]
    public function createOrUpdate(): void
    {
        $employee = Employee::updateOrCreate(
            ['id' => $this->id],
            [
                'name' => $this->name,
                'office_id' => $this->office,
                'lastname' => $this->lastname,
                'phone' => $this->phone,
                'birth_date' => $this->birthDate,
                'dui' => $this->dui,
            ]);

        if ($this->hasAccount) {
            $employee->user()->updateOrCreate(
                ['employee_id' => $employee->id],
                [
                    'username' => $this->usernameUser,
                    'email' => $this->emailUser,
                    'password' => bcrypt($this->passwordUser),
                ]);
        } else {
            $employee->user()->delete();
        }


        $this->clearFields();
        $this->dispatch('showToastAlert',
            title: $this->id ? 'Employee created' : 'Employee updated',
            icon: 'success');
    }

    #[On('delete')]
    public function delete(): void
    {
        try {
            $employee = Employee::findOrfail($this->id);
            $employee->user()->delete();
            $employee->delete();

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
    public function confirmDelete($id): void
    {
        $this->id = $id;
        $this->dispatch('show-delete-alert');
    }
}
