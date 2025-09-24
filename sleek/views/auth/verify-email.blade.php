<div
    class="mx-auto flex flex-col gap-3 shadow-lg px-6 sm:px-8 py-6 bg-background-secondary backdrop-blur-sm rounded-lg max-w-md w-full border border-neutral/20">
    <div class="flex flex-col items-center mb-4">
        <x-logo class="h-10 mb-2" />
        <h1 class="text-xl font-bold text-center text-base">{{ __('auth.verification.notice') }}</h1>
        <p class="text-xs text-base/60 mt-1 text-center">{{ __('auth.verification.check_your_email') }}</p>
    </div>

    <form class="flex flex-col gap-2 mt-4" wire:submit.prevent="submit" id="verify-email">
        <x-captcha :form="'verify-email'" />

        <p class="text-sm text-base/70">{{ __('auth.verification.not_received') }}</p>
        <x-button.primary
            class="w-full py-2 mt-2 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
            type="submit">
            {{ __('auth.verification.request_another') }}
        </x-button.primary>
    </form>
</div>
