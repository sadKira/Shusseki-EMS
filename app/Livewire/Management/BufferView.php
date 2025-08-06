<?php

namespace App\Livewire\Management;

use Livewire\Component;

class BufferView extends Component
{
    public $newIdea = '';

    // Static in-memory ideas list
    // Static data
    public $ideas = [
        'Use max-w-* + mx-auto for clean layouts',
        'Tailwind is mobile-first: always start with base styles',
        'Use responsive padding: px-4 sm:px-6 lg:px-8',
        'Combine with dark mode classes for a sleek UI',
    ];

    public function addIdea()
    {
        if (trim($this->newIdea) !== '') {
            array_unshift($this->ideas, $this->newIdea);
            $this->newIdea = '';
        }
    }
    public function render()
    {
        return view('livewire.management.buffer-view');
    }
}
