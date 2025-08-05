<?php

namespace App\Livewire\Management;

use Livewire\Component;

class BufferView extends Component
{
    public $newIdea = '';

    // Static in-memory ideas list
    public $ideas = [
        'Add AI-generated suggestions',
        'Group ideas into categories',
        'Export ideas as PDF or Markdown',
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
