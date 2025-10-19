<button
    {{ $attributes->merge(['class' => 'flex items-center gap-2 justify-center bg-error text-base text-sm font-medium hover:bg-error/90 py-2 px-4 rounded-md shadow-sm transition-all duration-200 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-error/30']) }}>

    {{ $slot }}
</button>
