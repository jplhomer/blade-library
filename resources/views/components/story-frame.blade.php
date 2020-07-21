<div class="border" x-data="{ view: 'preview' }">
    <div x-show="view == 'preview'">
        {{ $slot }}
    </div>
    @if ($body) <pre class="font-mono text-sm p-4 overflow-auto" x-show="view == 'code'">{{ $body }}</pre> @endif
    <footer class="bg-gray-200 text-right">
        <button @click="view = 'preview'" class="uppercase text-xs p-1">Preview</button>
        @if ($body) <button @click="view = 'code'" class="uppercase text-xs p-1">Code</button> @endif
    </footer>
</div>
