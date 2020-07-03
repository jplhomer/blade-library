<?php

namespace BladeLibrary\Http;

use BladeLibrary\BladeLibraryComponentFinder;
use Illuminate\Container\Container;

class BladeLibraryController
{
    public function index()
    {
        return view('library::library.index');
    }

    public function get(BladeLibraryComponentFinder $finder, $book, $chapter)
    {
        $book = $finder->get($book);
        $chapter = collect($book['chapters'])->firstWhere('alias', $chapter);
        $body = $chapter['body'];

        $factory = Container::getInstance()->make('view');

        $view = $this->createBladeViewFromString($factory, $body);

        return view('library::library.show', [
            'view' => $view,
        ]);
    }

    /**
     * Create a Blade view with the raw component string content.
     *
     * @param  \Illuminate\Contracts\View\Factory  $factory
     * @param  string  $contents
     * @return string
     */
    protected function createBladeViewFromString($factory, $contents)
    {
        $directory = storage_path('blade-library');

        if (! file_exists($viewFile = $directory.'/'.sha1($contents).'.blade.php')) {
            if (! is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($viewFile, $contents);
        }

        return 'library-generated::' . basename($viewFile, '.blade.php');
    }
}
