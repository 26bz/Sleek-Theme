<form
    class="mx-auto flex flex-col gap-3 shadow-lg px-6 sm:px-8 py-6 bg-background-secondary backdrop-blur-sm rounded-lg max-w-md w-full border border-neutral/20"
    wire:submit="submit" id="reset">
    <div class="flex flex-col items-center mb-4">
        <x-logo class="h-10 mb-2" />
        <h1 class="text-xl font-bold text-center text-base">{{ __('auth.reset_password') }}</h1>
        <p class="text-xs text-base/60 mt-1 text-center">Enter your email to reset your password</p>
    </div>
    <x-form.input name="email" type="text" :label="__('auth.input.email_label')" :placeholder="__('auth.input.email')" wire:model="email" required />

    <x-captcha :form="'reset'" />

    <x-button.primary
        class="w-full py-2 mt-2 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
        type="submit">
        {{ __('auth.reset_password') }}
    </x-button.primary>
</form>
