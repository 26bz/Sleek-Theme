<div class="flex items-center {{ $divClass ?? '' }}">
    <input type="checkbox" name="{{ $name }}" id="{{ $id ?? $name }}"
        {{ $attributes->except(['label', 'name', 'id', 'class', 'divClass', 'required']) }}
        class="form-checkbox size-4 text-primary rounded focus:ring-primary/30 hover:border-primary ring-offset-background focus:ring-2 bg-background-secondary border-neutral/20" />
    <label class="ml-2 text-sm text-base" for="{{ $id ?? $name }}">
        @if (isset($label))
            {{ $label }}
        @else
            {{ $slot }}
        @endif
    </label>

    @error($name)
        <p class="text-error text-xs">{{ $message }}</p>
    @enderror
</div>
