@props([
    'name',
    'label' => null,
    'required' => false,
    'divClass' => null,
    'class' => null,
    'placeholder' => null,
    'id' => null,
    'type' => null,
    'hideRequiredIndicator' => false,
    'dirty' => false,
])
<fieldset class="flex flex-col mt-3 w-full {{ $divClass ?? '' }}">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium mb-1.5">
            {{ $label }}
            @if ($required && !$hideRequiredIndicator)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif
    <textarea type="{{ $type ?? 'text' }}" id="{{ $id ?? $name }}" name="{{ $name }}"
        class="block w-full text-sm text-base bg-background border border-neutral/20 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary hover:border-neutral/30 transition-all duration-200 disabled:bg-background/50 disabled:cursor-not-allowed {{ $class ?? '' }} @if ($type !== 'color') px-2.5 py-2.5 @endif"
        placeholder="{{ $placeholder ?? '' }}" @if ($dirty && isset($attributes['wire:model'])) wire:dirty.class="!border-yellow-600" @endif
        {{ $attributes->except(['placeholder', 'label', 'id', 'name', 'type', 'class', 'divClass', 'required', 'hideRequiredIndicator', 'dirty']) }}
        @required($required)>{{ $slot }}</textarea>
    @error($name)
        <p class="text-error text-xs">{{ $message }}</p>
    @enderror
</fieldset>
