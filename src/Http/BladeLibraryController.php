<?php

namespace BladeLibrary\Http;

use BladeLibrary\BladeLibraryComponentFinder;
use BladeLibrary\ViewBuilder;

class BladeLibraryController
{
    public function index()
    {
        return view('library::index');
    }

    public function get(BladeLibraryComponentFinder $finder, ViewBuilder $builder, $book, $story)
    {
        $book = $finder->get($book);
        $story = collect($book['stories'])->firstWhere('alias', $story);
        $body = $story['body'];

        $view = $builder->build($body);

        return view('library::show', [
            'view' => $view,
        ]);
    }
}
