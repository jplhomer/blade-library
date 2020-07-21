<x-library-layout>
    <x-slot name="nav">
        @foreach ($books as $book)
            <button class="group w-full flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-900 rounded-md bg-gray-100 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150" wire:click.prevent="$set('book', '{{ $book['alias'] }}')">{{ $book['name'] }}</button>
        @endforeach
    </x-slot>

    @if ($this->activeBook)
        <div class="prose">
            <h1>{{ $this->activeBook['name'] }}</h1>

            @if ($this->activeBook['view'] ?? false)
                <div>{!! $this->activeBook['view'] !!}</div>
            @endif

            <h2>All Stories</h2>

            @foreach ($this->activeBook['stories'] as $story)
                @if ($story['name'])
                    <h3>{{ $story['name'] }}</h3>
                @endif

                <iframe src="/library/{{ $this->activeBook['alias'] }}/{{ $story['alias'] }}" frameborder="0"></iframe>
            @endforeach
        </div>
    @endif
</x-library-layout>
