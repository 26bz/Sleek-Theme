<div class="space-y-6 pt-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">{{ __('Security Settings') }}</h1>
            <p class="text-sm text-base/60 mt-1">{{ __('Manage your account security and active sessions') }}</p>
        </div>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden mb-6">
        <div class="border-b border-neutral/20 p-4">
            <h2 class="font-medium">{{ __('account.sessions') }}</h2>
            <p class="text-sm text-base/60 mt-1">{{ __('These are your currently active sessions across devices.') }}</p>
        </div>

        <div class="p-4">
            @if (Auth::user()->sessions->filter(fn($session) => !$session->impersonating())->count() > 0)
                <div class="divide-y divide-neutral/10">
                    @foreach (Auth::user()->sessions->filter(fn($session) => !$session->impersonating()) as $session)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-4 gap-3">
                            <div class="flex items-start gap-3">
                                <div class="bg-neutral/10 p-2 rounded-lg">
                                    @if (str_contains(strtolower($session->formatted_device), 'mobile'))
                                        <x-ri-smartphone-line class="size-5 text-base/70" />
                                    @elseif(str_contains(strtolower($session->formatted_device), 'tablet'))
                                        <x-ri-tablet-line class="size-5 text-base/70" />
                                    @else
                                        <x-ri-computer-line class="size-5 text-base/70" />
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium">{{ $session->formatted_device }}</p>
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3 text-sm text-base/70">
                                        <span>{{ $session->ip_address }}</span>
                                        <span class="hidden sm:block text-base/40">•</span>
                                        <span>{{ $session->last_activity->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <x-button.secondary wire:click="logoutSession('{{ $session->id }}')"
                                class="text-sm !w-fit">
                                {{ __('account.logout_sessions') }}
                            </x-button.secondary>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-6 text-base/60">
                    <p>{{ __('No active sessions found.') }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden mb-6">
        <div class="border-b border-neutral/20 p-4">
            <h2 class="font-medium">{{ __('account.change_password') }}</h2>
            <p class="text-sm text-base/60 mt-1">{{ __('Update your password to maintain account security.') }}</p>
        </div>

        <div class="p-6">
            <form wire:submit="changePassword">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.input divClass="md:col-span-2" name="current_password" type="password" :label="__('account.input.current_password')"
                        :placeholder="__('account.input.current_password_placeholder')" wire:model="current_password" required />

                    <x-form.input name="password" type="password" :label="__('account.input.new_password')" :placeholder="__('account.input.new_password_placeholder')"
                        wire:model="password" required />

                    <x-form.input name="password_confirmation" type="password" :label="__('account.input.confirm_password')" :placeholder="__('account.input.confirm_password_placeholder')"
                        wire:model="password_confirmation" required />
                </div>

                <div class="flex justify-end mt-6">
                    <x-button.primary
                        class="px-6 py-2.5 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
                        type="submit">
                        <span class="flex items-center gap-2">
                            <x-ri-lock-password-line class="size-4" />
                            <span>{{ __('account.change_password') }}</span>
                        </span>
                    </x-button.primary>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden">
        <div class="border-b border-neutral/20 p-4">
            <h2 class="font-medium">{{ __('account.two_factor_authentication') }}</h2>
            <p class="text-sm text-base/60 mt-1">{{ __('Add an extra layer of security to your account.') }}</p>
        </div>

        <div class="p-6">
            @if ($twoFactorEnabled)
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-neutral/10 p-2 rounded-full">
                        <x-ri-shield-check-fill class="size-5 text-base/70" />
                    </div>
                    <div>
                        <p class="font-medium">{{ __('Two-Factor Authentication is enabled') }}</p>
                        <p class="text-sm text-base/60">{{ __('account.two_factor_authentication_enabled') }}</p>
                    </div>
                </div>

                <x-button.secondary
                    x-on:click="$store.confirmation.confirm({
                        title: '{{ __('account.two_factor_authentication_disable') }}',
                        message: '{{ __('account.two_factor_authentication_disable_description') }}',
                        confirmText: '{{ __('account.confirm') }}',
                        cancelText: '{{ __('account.cancel') }}',
                        callback: () => $wire.disableTwoFactor()
                    })"
                    class="flex items-center gap-2 font-medium transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4">
                        <path fill="currentColor"
                            d="M3.783 2.826 12 1l8.217 1.826a1 1 0 0 1 .783.976v9.987a6 6 0 0 1-2.672 4.992L12 23l-6.328-4.219A6 6 0 0 1 3 13.79V3.802a1 1 0 0 1 .783-.976ZM5 4.604v9.185a4 4 0 0 0 1.781 3.328L12 20.597l5.219-3.48A4 4 0 0 0 19 13.79V4.604L12 3.05 5 4.604Zm7 10.89 2.828-2.828-1.414-1.414L12 12.664l-1.414-1.414-1.414 1.414L12 15.492Z" />
                    </svg>
                    {{ __('Disable two factor authentication') }}
                </x-button.secondary>
            @else
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-neutral/10 p-2 rounded-full">
                        <x-ri-shield-keyhole-line class="size-5 text-base/70" />
                    </div>
                    <div>
                        <p class="font-medium">{{ __('Two-Factor Authentication is disabled') }}</p>
                        <p class="text-sm text-base/60">{{ __('account.two_factor_authentication_description') }}</p>
                    </div>
                </div>

                <x-button.primary wire:click="enableTwoFactor"
                    class="flex items-center gap-2 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">
                    <x-ri-shield-check-line class="size-4" />
                    {{ __('account.two_factor_authentication_enable') }}
                </x-button.primary>
            @endif

            @if ($showEnableTwoFactor)
                <x-modal :title="__('account.two_factor_authentication_enable')" open="true">
                    <p class="text-base/80 mb-4">{{ __('account.two_factor_authentication_enable_description') }}</p>

                    <div class="flex flex-col items-center bg-white p-4 rounded-lg">
                        <img src="{{ $twoFactorData['image'] }}" alt="QR code" class="w-64 h-64" />
                    </div>

                    <div class="mt-4 p-3 bg-background-secondary border border-neutral/20 rounded-lg">
                        <p class="text-sm font-medium mb-1">{{ __('account.two_factor_authentication_secret') }}</p>
                        <p class="font-mono text-sm break-all select-all">{{ $twoFactorData['secret'] }}</p>
                    </div>

                    <form wire:submit.prevent="enableTwoFactor" class="mt-6">
                        <x-form.input name="two_factor_code" type="text" :label="__('account.input.two_factor_code')" :placeholder="__('account.input.two_factor_code_placeholder')"
                            wire:model="twoFactorCode" required />

                        <div class="flex justify-end mt-6">
                            <x-button.primary
                                class="px-6 py-2.5 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20"
                                type="submit">
                                <span class="flex items-center gap-2">
                                    <x-ri-shield-check-line class="size-4" />
                                    <span>{{ __('account.two_factor_authentication_enable') }}</span>
                                </span>
                            </x-button.primary>
                        </div>
                    </form>

                    <x-slot name="closeTrigger">
                        <button @click="document.location.reload()"
                            class="text-base hover:text-primary transition-colors">
                            <x-ri-close-fill class="size-6" />
                        </button>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </div>
</div>
