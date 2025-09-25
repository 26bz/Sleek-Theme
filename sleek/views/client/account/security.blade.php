<div class="space-y-6 pt-4">
    <x-navigation.breadcrumb />

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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-base/70"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @elseif(str_contains(strtolower($session->formatted_device), 'tablet'))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-base/70"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-base/70"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
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
                        class="px-6 py-2.5 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20 flex items-center gap-2"
                        type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        {{ __('account.change_password') }}
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-base/70" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11zm0-9.414l2.293-2.293 1.414 1.414L12 15.414l-2.707-2.707 1.414-1.414L12 12.586z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">{{ __('Two-Factor Authentication is enabled') }}</p>
                        <p class="text-sm text-base/60">{{ __('account.two_factor_authentication_enabled') }}</p>
                    </div>
                </div>

                <x-button.secondary wire:click="disableTwoFactor"
                    class="flex items-center gap-2 font-medium transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    {{ __('Disable two factor authentication') }}
                </x-button.secondary>
            @else
                <div class="flex items-center gap-3 mb-4">
                    <div class="bg-neutral/10 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-base/70" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">{{ __('Two-Factor Authentication is disabled') }}</p>
                        <p class="text-sm text-base/60">{{ __('account.two_factor_authentication_description') }}</p>
                    </div>
                </div>

                <x-button.primary wire:click="enableTwoFactor"
                    class="flex items-center gap-2 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
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
                                class="px-6 py-2.5 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20 flex items-center gap-2"
                                type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                {{ __('account.two_factor_authentication_enable') }}
                            </x-button.primary>
                        </div>
                    </form>

                    <x-slot name="closeTrigger">
                        <button @click="document.location.reload()"
                            class="text-base hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </x-slot>
                </x-modal>
            @endif
        </div>
    </div>
</div>
