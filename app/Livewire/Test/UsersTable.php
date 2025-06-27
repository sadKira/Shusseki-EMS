<?php

namespace App\Livewire\Test;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $search = '';

    public $year = '';

    public function render()
    {
        return view('livewire.test.users-table', [
            'users' => User::search($this->search)
            ->when($this->year != '', function ($query) {
                $query->where('year_level', $this->year);
            })
            
            ->paginate($this->perPage)
        ]);
    }
}
