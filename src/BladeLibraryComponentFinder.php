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
         * Next, we check to see if there are any regular components that
         * contain @story, as those will be considered books as well.
         */
        $components = collect(
                $this->finder
                    ->files()
                    ->in($this->componentsPath)
                    ->name('*.blade.php')
                    ->contains('@story')
            )->map(function ($path) {
                return $this->parseBookFromComponentFile($path);
            });

        /**
         * TODO: Finally, we check for class components to see if any of those
         * contain the @story comment flag.
         */

        $all = $books->map(function ($book) use ($components) {
            if ($component = $components->firstWhere('alias', $book['alias'])) {
                $book['stories'] = $book['stories']->concat($component['stories']);
            }

            return $book;
        });

        $all = $all->concat($components->whereNotIn('alias', $books->pluck('alias')));

        return $all->sortBy('alias');
    }

    public function get(string $alias)
    {
        return $this->all()->firstWhere('alias', $alias);
    }

    protected function parseBookFromBookFile(SplFileInfo $file)
    {
        $alias = $this->aliasFromFile($file);
        $contents = $this->files->get($file->getPathname());
        $stories = $this->getStories($alias, $contents);

        $book = [
            'path' => $file->getPathname(),
            'alias' => $alias,
            'name' => $this->nameFromAlias($alias),
            'stories' => $stories,
        ];

        $book['view'] = view($this->injectStoriesIntoBookView($alias, $stories, $file));

        return $book;
    }

    public function parseBookFromComponentFile(string $path)
    {
        $contents = $this->files->get($path);
        $alias = basename($path, '.blade.php');
        $stories = $this->getStories($alias, $contents);

        return [
            'path' => $path,
            'alias' => $alias,
            'name' => $this->nameFromAlias($alias),
            'stories' => $stories,
        ];
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

    protected function getStories(string $alias, string $contents): Collection
    {
        preg_match_all('/@story(?:\([\'"]([\w\s]+)[\'"]\))?(.*?)@endstory/s', $contents, $matches);

        if (empty($matches)) return [];

        [$all, $names, $bodies] = $matches;

        $stories = [];

        foreach ($names as $idx => $name) {
            $stories[] = [
                'name' => $name,
                'alias' => Str::slug($name ?: $alias . '-' . $idx),
                'body' => $bodies[$idx],
            ];
        }

        return collect($stories);
    }

    protected function injectStoriesIntoBookView(string $bookAlias, Collection $stories)
    {
        $contents = view('books.' . $bookAlias)->render();

        // First, replace all exact matches
        $contents = preg_replace_callback('/<!-- #library-component-\'([\w\s-]+)\' -->/', function ($matches) use ($bookAlias, $stories) {
            $name = $matches[1];

            if (! $story = $stories->firstWhere('name', $name)) return;

            return '<iframe src="/library/' . $bookAlias . '/' . $story['alias'] . '" frameborder="0"></iframe>';
        }, $contents);

        $anonymousStories = $stories->where('name', '');

        // Next, replace all remaining empty slots in sequential order
        $contents = preg_replace_callback('/<!-- #library-component- -->/', function ($matches) use ($bookAlias, $anonymousStories) {
            $nextStory = $anonymousStories->shift();

            if (!$nextStory) return;

            return '<iframe src="/library/' . $bookAlias . '/' . $nextStory['alias'] . '" frameborder="0"></iframe>';
        }, $contents);

        // Finally, build the view using the contents
        return app(ViewBuilder::class)->build($contents);
    }
}
