@props(['href', 'spa' => true])
<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'flex flex-row items-center p-3 gap-2 text-sm font-semibold text-wrap transition-colors duration-200 ' .
            ($href === request()->url() ? 'text-primary' : 'text-base hover:text-primary'),
    ]) }}
    @if ($spa) wire:navigate @endif>
    {{ $slot }}
</a>
