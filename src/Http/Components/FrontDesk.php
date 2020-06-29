<?php

namespace BladeLibrary\Http\Components;

use Livewire\Component;

class FrontDesk extends Component
{
    public $book;

    protected $updatesQueryString = ['book'];

    public function mount()
    {
        $this->book = request()->query('book', $this->book);
    }

    public function render()
    {
        return view('library::components.front-desk', [
            'books' => [],
        ]);
    }

    // public function getActiveBookProperty()
    // {
    //     if (! $this->book) return false;

    //     return collect(Library::create()
    //         ->getBooks())
    //         ->firstWhere('slug', $this->book);
    // }
}
