@if (!theme('force_dark_mode', false))
    <button @click="darkMode = !darkMode" type="button" class="p-2 rounded-md hover:bg-neutral/10 transition-colors"
        aria-label="Toggle dark mode">
        <template x-if="!darkMode">
            <x-ri-moon-line class="size-5" />
        </template>
        <template x-if="darkMode">
            <x-ri-sun-line class="size-5" />
        </template>
    </button>
@endif
