<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <iframe class="w-full min-h-screen" src="{{ $getSource() }}"></iframe>
    </div>
</x-dynamic-component>
