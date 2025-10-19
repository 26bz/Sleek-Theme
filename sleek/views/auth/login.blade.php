<div class="min-h-[80vh] flex items-center justify-center w-full py-4">
    <form
        class="mx-auto flex flex-col gap-3 shadow-lg px-6 sm:px-8 py-6 bg-background-secondary backdrop-blur-sm rounded-lg max-w-md w-full border border-neutral/20"
        wire:submit="submit" id="login">
        <div class="flex flex-col items-center mb-4">
            <x-logo class="h-10 mb-2" />
            <h1 class="text-xl font-bold text-center text-base">{{ __('auth.sign_in_title') }}</h1>
            <p class="text-xs text-base/60 mt-1 text-center">Enter your credentials to access your account</p>
        </div>

        <div class="space-y-3">
            <x-form.input name="email" type="email" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" wire:model="email"
                hideRequiredIndicator required />

            <x-form.input name="password" type="password" :label="__('general.input.password')" :placeholder="__('general.input.password_placeholder')" required
                hideRequiredIndicator wire:model="password" />

            <div class="flex flex-row items-center justify-between">
                <x-form.checkbox name="remember" label="Remember me" wire:model="remember" />
                <a class="text-sm text-primary hover:underline transition-colors"
                    href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
            </div>
        </div>

        <x-captcha :form="'login'" />

        <x-button.primary
            class="w-full py-2 mt-2 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
            type="submit">
            {{ __('auth.sign_in') }}
        </x-button.primary>

        @if (config('settings.oauth_github') || config('settings.oauth_google') || config('settings.oauth_discord'))
            <div class="flex flex-col items-center mt-3">
                <div class="my-2 flex items-center w-full">
                    <span aria-hidden="true" class="h-px grow bg-neutral/20"></span>
                    <span class="px-2 text-xs font-medium text-base/60">
                        {{ __('auth.or_sign_in_with') }}
                    </span>
                    <span aria-hidden="true" class="h-px grow bg-neutral/20"></span>
                </div>
                <div class="flex flex-row flex-wrap justify-center gap-2 w-full">
                    @foreach (['github', 'google', 'discord'] as $provider)
                        @if (config('settings.oauth_' . $provider))
                            <a href="{{ route('oauth.redirect', $provider) }}"
                                class="flex items-center justify-center px-3 py-1.5 flex-1 bg-background hover:bg-neutral/10 transition-colors border border-neutral/20 rounded-md text-xs">
                                <img src="/assets/images/{{ $provider }}-dark.svg" alt="{{ $provider }}"
                                    class="size-4 mr-1.5">
                                {{ __(ucfirst($provider)) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @if (!config('settings.registration_disabled', false))
            <div class="text-center mt-3 text-xs text-base/70">
                {{ __('auth.dont_have_account') }}
                <a class="text-primary font-medium hover:underline transition-colors" href="{{ route('register') }}"
                    wire:navigate>
                    {{ __('auth.sign_up') }}
                </a>
            </div>
        @endif
    </form>
</div>
