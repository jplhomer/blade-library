<?php

namespace BladeLibrary\View\Components;

use BladeLibrary\BladeLibraryComponentFinder;
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
            'books' => app(BladeLibraryComponentFinder::class)->all(),
        ]);
    }

    public function getActiveBookProperty()
    {
        if (! $this->book) return false;

        return app(BladeLibraryComponentFinder::class)->get($this->book);
    }
}
