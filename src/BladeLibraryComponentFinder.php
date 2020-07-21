<?php

namespace BladeLibrary;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
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
        $alias = $this->aliasFromFile($file);
        $chapters = $this->getChapters($file);

        $book = [
            'path' => $file->getPathname(),
            'alias' => $alias,
            'name' => $this->nameFromAlias($alias),
            'chapters' => $chapters,
        ];

        $book['view'] = view($this->injectChaptersIntoBookView($alias, $chapters, $file));

        return $book;
    }

    protected function aliasFromFile(SplFileInfo $file)
    {
        return $file->getBasename('.blade.php');
    }

    protected function nameFromAlias(string $alias)
    {
        return str_replace(
            ['-', '_'],
            [' ', ' '],
            Str::title($alias)
        );
    }

    protected function getChapters(SplFileInfo $file): Collection
    {
        $alias = $this->aliasFromFile($file);
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

        return collect($chapters);
    }

    protected function injectChaptersIntoBookView(string $bookAlias, Collection $chapters, SplFileInfo $file)
    {
        $contents = view('books.' . $bookAlias)->render();

        // First, replace all exact matches
        $contents = preg_replace_callback('/<!-- #library-component-\'([\w\s-]+)\' -->/', function ($matches) use ($bookAlias, $chapters) {
            $name = $matches[1];

            if (! $chapter = $chapters->firstWhere('name', $name)) return;

            return '<iframe src="/library/' . $bookAlias . '/' . $chapter['alias'] . '" frameborder="0"></iframe>';
        }, $contents);

        $anonymousChapters = $chapters->where('name', '');

        // Next, replace all remaining empty slots in sequential order
        $contents = preg_replace_callback('/<!-- #library-component- -->/', function ($matches) use ($bookAlias, $anonymousChapters) {
            $nextChapter = $anonymousChapters->shift();

            return '<iframe src="/library/' . $bookAlias . '/' . $nextChapter['alias'] . '" frameborder="0"></iframe>';
        }, $contents);

        // Finally, build the view using the contents
        return app(ViewBuilder::class)->build($contents);
    }
}
