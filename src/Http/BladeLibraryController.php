<?php

namespace BladeLibrary\Http;

use BladeLibrary\BladeLibraryComponentFinder;
use BladeLibrary\ViewBuilder;

class BladeLibraryController
{
    public function index()
    {
        return view('library::library.index');
    }

    public function get(BladeLibraryComponentFinder $finder, ViewBuilder $builder, $book, $chapter)
    {
        $book = $finder->get($book);
        $chapter = collect($book['chapters'])->firstWhere('alias', $chapter);
        $body = $chapter['body'];

        $view = $builder->build($body);

        return view('library::library.show', [
            'view' => $view,
        ]);
    }
}
