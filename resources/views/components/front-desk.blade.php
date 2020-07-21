<x-library-layout>
    <x-slot name="nav">
        @foreach ($books as $book)
            <button
                class="group w-full flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-200 transition ease-in-out duration-150 {{ $this->activeBook['name'] == $book['name'] ? 'text-gray-900 bg-gray-100' : 'text-gray-600' }}"
                wire:click.prevent="$set('book', '{{ $book['alias'] }}')">
                    {{ $book['name'] }}
            </button>
        @endforeach
    </x-slot>

    @if ($this->activeBook)
        <div class="prose">
            <h1>{{ $this->activeBook['name'] }}</h1>

            <div class="text-2xl">
                <code>&lt;x-{{ $this->activeBook['alias'] }}&gt;</code>
            </div>

            @if ($this->activeBook['view'] ?? false)
                <div>{!! $this->activeBook['view'] !!}</div>
            @endif

            <h2>All Stories</h2>
        </div>

        <div style="max-width: 65ch" class="mt-4">
            @foreach ($this->activeBook['stories'] as $story)
                @if ($story['name'])
                    <h3 class="text-lg font-medium mt-8 mb-2">{{ $story['name'] }}</h3>
                @endif

                <x-library-story-frame :name="$story['name']" :body="$story['body']"><iframe src="/library/{{ $story['chapter'] }}/{{ $story['alias'] }}" frameborder="0"></iframe></x-library-story-frame>
            @endforeach
        </div>
    @endif
</x-library-layout>
