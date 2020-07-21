<x-library-layout>
    <h1>Blade Library</h1>

    @foreach ($books as $book)
        <button wire:click.prevent="$set('book', '{{ $book['alias'] }}')">{{ $book['name'] }}</button>
    @endforeach

    @if ($this->activeBook)
        <h1>{{ $this->activeBook['name'] }}</h1>

        <div>{!! $this->activeBook['view'] !!}</div>

        @foreach ($this->activeBook['chapters'] as $chapter)
            @if ($chapter['name'])
                <h2>{{ $chapter['name'] }}</h2>
            @endif

            <iframe src="/library/{{ $this->activeBook['alias'] }}/{{ $chapter['alias'] }}" frameborder="0"></iframe>
        @endforeach
    @endif
</x-library-layout>
