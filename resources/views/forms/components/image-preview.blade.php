<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <img class="w-full" src="{{ $getSource() }}" alt="No image found.">
    </div>
</x-dynamic-component>
