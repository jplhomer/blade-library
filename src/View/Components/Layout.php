<?php

namespace BladeLibrary\View\Components;

use Illuminate\View\Component;

class Layout extends Component
{
    protected $books;

    public function __construct($books = [])
    {
        $this->books = $books;
    }

    public function render()
    {
        return view('library::components.layout');
    }
}
