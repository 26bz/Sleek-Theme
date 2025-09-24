<button
    {{ $attributes->merge(['class' => 'flex items-center gap-2 justify-center text-primary text-sm font-medium hover:text-primary/80 py-2 px-4 rounded-md transition-all duration-200 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-primary/30']) }}>
    {{ $slot }}
</button>
