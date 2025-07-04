<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Event;

class ManageEvents extends Component
{
    use WithPagination;
    
    public $search = '';
    public $selectedSchoolYear = 'All';
    public $selectedMonth = 'All';
    public $sortField = 'title';
    public $sortDirection = 'asc';

    public $selection = true;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $baseQuery = Event::with('tags');

        $filteredQuery = (clone $baseQuery)
            ->when($this->selectedSchoolYear !== 'All' && $this->selectedSchoolYear !== null, function ($query) {
                $query->where('school_year', $this->selectedSchoolYear);
            })
            ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
                $query->whereMonth('created_at', $this->selectedMonth); // assumes full timestamp
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('location', 'like', "%{$this->search}%")
                        ->orWhereHas('tags', function ($tagQuery) {
                            $tagQuery->where('tag', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.management.manage-events', [
            'events' => $filteredQuery->paginate(5),
        ]);
    }
}
