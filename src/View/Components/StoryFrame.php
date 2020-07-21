<?php

namespace BladeLibrary\View\Components;

use Illuminate\View\Component;

class StoryFrame extends Component
{
    public $name;
    public $body;

    public function __construct($name, $body = '')
    {
        $this->name = $name;
        $this->body = $body;
    }

    public function render()
    {
        return view('library::components.story-frame');
    }
}
