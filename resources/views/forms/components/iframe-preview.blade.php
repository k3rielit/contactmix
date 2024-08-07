<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <iframe class="w-full" src="{{ $getSource() }}"></iframe>
    </div>
</x-dynamic-component>
