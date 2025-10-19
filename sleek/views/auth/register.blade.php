<div class="min-h-[80vh] flex items-center justify-center w-full py-4">
    <form
        class="mx-auto flex flex-col gap-3 shadow-lg px-6 sm:px-8 py-6 bg-background-secondary backdrop-blur-sm rounded-lg max-w-2xl w-full border border-neutral/20"
        wire:submit.prevent="submit" id="register">
        <div class="flex flex-col items-center mb-4">
            <x-logo class="h-10 mb-2" />
            <h1 class="text-xl font-bold text-center text-base">{{ __('auth.sign_up_title') }}</h1>
            <p class="text-xs text-base/60 mt-1 text-center">Create your account to get started</p>
        </div>

        <div class="flex flex-col md:grid md:grid-cols-2 gap-3">
            <x-form.input name="first_name" type="text" :label="__('general.input.first_name')" :placeholder="__('general.input.first_name_placeholder')" wire:model="first_name"
                required divClass="mt-1" />

            <x-form.input name="last_name" type="text" :label="__('general.input.last_name')" :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name"
                required divClass="mt-1" />

            <x-form.input name="email" type="email" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" required wire:model="email"
                divClass="col-span-2 mt-1" />

            <x-form.input name="password" type="password" :label="__('Password')" :placeholder="__('Your password')" wire:model="password"
                required divClass="mt-1" />

            <x-form.input name="password_confirm" type="password" :label="__('Password')" :placeholder="__('Confirm your password')"
                wire:model="password_confirmation" required divClass="mt-1" />

            <x-form.properties :custom_properties="$custom_properties" :properties="$properties" />

            @if (config('settings.tos'))
                <div class="col-span-2 mt-1">
                    <x-form.checkbox wire:model="tos" name="tos" required>
                        {{ __('product.tos') }}
                        <a href="{{ config('settings.tos') }}" target="_blank"
                            class="text-primary hover:underline transition-colors">
                            {{ __('product.tos_link') }}
                        </a>
                    </x-form.checkbox>
                </div>
            @endif
        </div>

        <x-captcha :form="'register'" />

        <x-button.primary
            class="w-full py-2 mt-3 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
            type="submit">
            {{ __('Sign up') }}
        </x-button.primary>

        <div class="text-center mt-3 text-xs text-base/70">
            {{ __('auth.already_have_account') }}
            <a class="text-primary font-medium hover:underline transition-colors" href="{{ route('login') }}"
                wire:navigate>
                {{ __('auth.sign_in') }}
            </a>
        </div>
    </form>
</div>
