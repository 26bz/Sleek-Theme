@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'required' => false,
    'divClass' => null,
    'hideRequiredIndicator' => false,
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

    <select id="{{ $id ?? $name }}" {{ $multiple ? 'multiple' : '' }}
        {{ $attributes->except(['options', 'id', 'name', 'multiple', 'class']) }}
        class="block px-2.5 py-2.5 w-full text-sm text-base bg-background border border-neutral/20
        rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-neutral/30 focus:border-neutral hover:border-neutral transition-all duration-200 form-select disabled:bg-background/50 disabled:cursor-not-allowed">
        @if (count($options) == 0 && $slot)
            {{ $slot }}
        @else
            @foreach ($options as $key => $option)
                <option value="{{ gettype($options) == 'array' ? $option : $key }}"
                    {{ ($multiple && $selected ? in_array($key, $selected) : $selected == $option) ? 'selected' : '' }}>
                    {{ $option }}</option>
            @endforeach
        @endif
    </select>
    @if ($multiple)
        <p class="text-xs text-base">
            {{ __('Pro tip: Hold down the Ctrl (Windows) / Command (Mac) button to select multiple options.') }}</p>
    @endif

    @error($name)
        <p class="text-error text-xs">{{ $message }}</p>
    @enderror
</fieldset>
