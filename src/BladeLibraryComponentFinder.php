<?php

namespace BladeLibrary;

use Illuminate\Filesystem\Filesystem;
use SplFileInfo;
use Illuminate\Support\Str;
use Symfony\Component\Finder\Finder;

class BladeLibraryComponentFinder
{
    protected $finder;
    protected $files;
    protected $booksPath;
    protected $componentsPath;

    public function __construct(Finder $finder, Filesystem $files, string $booksPath)
    {
        $this->finder = $finder;
        $this->files = $files;
        $this->booksPath = $booksPath;
        $this->componentsPath = resource_path('views/components');
    }

    public function all()
    {
        if (! $this->files->isDirectory($this->booksPath)) {
            return [];
        }

        /**
         * First, we take all the files in the $booksPath and consider
         * those books.
         */
        $books = collect($this->files->allFiles($this->booksPath))
            ->map(function (SplFileInfo $file) {
                return $this->parseBookFromBookFile($file);
            });

        /**
         * TODO: Next, we check to see if there are any regular components that
         * contain @story, as those will be considered books as well.
         */

        /**
         * TODO: Finally, we check for class components to see if any of those
         * contain the @story comment flag.
         */


        return $books;
    }

    public function get(string $alias)
    {
        return $this->all()->firstWhere('alias', $alias);
    }

    protected function parseBookFromBookFile(SplFileInfo $file)
    {
        $alias = $this->aliasFromFileName($file->getFilename());

        return [
            'path' => $file->getPathname(),
            'alias' => $alias,
            'name' => $this->nameFromAlias($alias),
            'view' => view('books.' . $alias, [
                'embedStories' => true
            ]),
            'chapters' => $this->getChapters($file),
        ];
    }

    protected function aliasFromFileName(string $fileName)
    {
        return str_replace(
            ['.blade.php'],
            [''],
            $fileName
        );
    }

    protected function nameFromAlias(string $alias)
    {
        return str_replace(
            ['-', '_'],
            [' ', ' '],
            Str::title($alias)
        );
    }

    protected function getChapters(SplFileInfo $file)
    {
        $alias = $file->getBasename('.blade.php');
        $contents = $this->files->get($file->getPathname());
        preg_match_all('/@story(?:\([\'"]([\w\s]+)[\'"]\))?(.*?)@endstory/s', $contents, $matches);

        if (empty($matches)) return [];

        [$all, $names, $bodies] = $matches;

        $chapters = [];

        foreach ($names as $idx => $name) {
            $chapters[] = [
                'name' => $name,
                'alias' => Str::slug($name ?: $alias . '-' . $idx),
                'body' => $bodies[$idx],
            ];
        }

        return $chapters;
    }
}
