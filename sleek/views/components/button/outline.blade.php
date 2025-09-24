<button
    {{ $attributes->merge(['class' => 'flex items-center gap-2 justify-center bg-transparent text-base text-sm font-medium border border-neutral/30 hover:bg-neutral/5 hover:border-neutral/50 py-2 px-4 rounded-md shadow-sm transition-all duration-200 cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-neutral/20']) }}>
    {{ $slot }}
</button>
