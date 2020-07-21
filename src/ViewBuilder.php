<?php

namespace BladeLibrary;

use Illuminate\View\Factory;

class ViewBuilder
{
    protected $viewFactory;

    public function construct(Factory $viewFactory)
    {
        $this->viewFactory = $viewFactory;
    }

    public function build($contents)
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
