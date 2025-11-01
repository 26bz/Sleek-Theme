<div class="space-y-6 pt-4">
    <div class="space-y-6">
        @if($this->supportsPush())
            <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden" x-data="pushNotifications">
                <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                    <h2 class="text-xl font-semibold">{{ __('account.push_notifications') }}</h2>
                    <p class="text-sm text-base/60 mt-1">{{ __('account.push_notifications_description') }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <x-button.primary type="button" class="w-full sm:w-auto sm:!w-fit flex items-center gap-2"
                        @click="subscribe" x-bind:disabled="subscriptionStatus !== 'not_subscribed'">
                        <x-ri-notification-line class="size-5" />
                        {{ __('account.enable_push_notifications') }}
                    </x-button.primary>

                    <div class="space-y-2" x-show="subscriptionStatus !== 'unknown'">
                        <template x-if="subscriptionStatus === 'not_supported'">
                            <p class="text-sm text-error">{{ __('account.push_status.not_supported') }}</p>
                        </template>
                        <template x-if="subscriptionStatus === 'denied'">
                            <p class="text-sm text-error">{{ __('account.push_status.denied') }}</p>
                        </template>
                        <template x-if="subscriptionStatus === 'subscribed'">
                            <p class="text-sm text-success">{{ __('account.push_status.subscribed') }}</p>
                        </template>
                    </div>
                </div>
            </div>

            @script
            <script>
                Alpine.data('pushNotifications', () => ({
                        subscriptionStatus: 'unknown',

                        init() {
                            if ('serviceWorker' in navigator && 'PushManager' in window) {
                                navigator.serviceWorker.ready.then((registration) => {
                                    registration.pushManager.getSubscription().then((subscription) => {
                                        if (subscription) {
                                            this.subscriptionStatus = 'subscribed';
                                        } else {
                                            this.subscriptionStatus = Notification.permission === 'denied' ? 'denied' : 'not_subscribed';
                                        }
                                    });
                                });
                            } else {
                                this.subscriptionStatus = 'not_supported';
                            }
                        },

                        subscribe() {
                            if ('serviceWorker' in navigator && 'PushManager' in window) {
                                navigator.serviceWorker.ready.then((registration) => {
                                    registration.pushManager.getSubscription().then((subscription) => {
                                        if (subscription) {
                                            @this.call('storePushSubscription', JSON.stringify(subscription));
                                            this.subscriptionStatus = 'subscribed';
                                            return;
                                        }

                                        registration.pushManager.subscribe({
                                            userVisibleOnly: true,
                                            applicationServerKey: urlBase64ToUint8Array('{{ config('settings.vapid_public_key') }}')
                                        }).then((newSubscription) => {
                                            @this.call('storePushSubscription', JSON.stringify(newSubscription));
                                            this.subscriptionStatus = 'subscribed';
                                        }).catch((e) => {
                                            if (Notification.permission === 'denied') {
                                                this.subscriptionStatus = 'denied';
                                            } else {
                                                console.error('Failed to subscribe the user: ', e);
                                                this.subscriptionStatus = 'not_subscribed';
                                            }
                                        });
                                    });
                                });
                            } else {
                                this.subscriptionStatus = 'not_supported';
                            }
                        }
                    }));

                    function urlBase64ToUint8Array(base64String) {
                        const padding = '='.repeat((4 - base64String.length % 4) % 4);
                        const base64 = (base64String + padding)
                            .replace(/\-/g, '+')
                            .replace(/_/g, '/');

                        const rawData = window.atob(base64);
                        const outputArray = new Uint8Array(rawData.length);

                        for (let i = 0; i < rawData.length; ++i) {
                            outputArray[i] = rawData.charCodeAt(i);
                        }
                        return outputArray;
                    }
            </script>
            @endscript
        @endif

        <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                <h2 class="text-xl font-semibold">{{ __('account.notification') }}</h2>
                <p class="text-sm text-base/60 mt-1">{{ __('account.notifications_description') }}</p>
            </div>

            <div class="p-6 space-y-4" x-data="{ preferences: $wire.entangle('preferences') }">
                <div class="hidden md:grid md:grid-cols-3 text-xs font-semibold uppercase tracking-wide text-base/40">
                    <span class="col-span-1 pl-2">{{ __('account.notification') }}</span>
                    <span class="text-center">{{ __('account.email_notifications') }}</span>
                    <span class="text-center">{{ __('account.in_app_notifications') }}</span>
                </div>

                <div class="space-y-3">
                    @foreach($this->notifications as $notification)
                        <div
                            class="bg-background border border-neutral/10 rounded-lg px-4 py-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex items-start gap-3">
                                <div class="bg-neutral/10 text-base/60 rounded-lg p-2 hidden sm:flex">
                                    <x-ri-notification-3-line class="size-5" />
                                </div>
                                <div>
                                    <p class="font-medium text-base/80">{{ $notification->name }}</p>
                                    @if (! $notification->mail_controllable || ! $notification->in_app_controllable)
                                        <p class="text-xs text-base/50 mt-1">
                                            {{ __('Some channels may not be configurable for this notification.') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-4 md:gap-6">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wide text-base/50">{{ __('account.email_notifications') }}</span>
                                    <x-form.toggle :disabled="!$notification->mail_controllable"
                                        wire:model.defer="preferences.{{ $notification->key }}.mail_enabled" />
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wide text-base/50">{{ __('account.in_app_notifications') }}</span>
                                    <x-form.toggle :disabled="!$notification->in_app_controllable"
                                        wire:model.defer="preferences.{{ $notification->key }}.in_app_enabled" />
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-2 flex justify-end">
                    <x-button.primary wire:click="savePreferences" class="w-full sm:w-auto" wire:loading.attr="disabled">
                        <x-loading wire:loading wire:target="savePreferences" />
                        <span wire:loading.remove wire:target="savePreferences">
                            {{ __('general.save') }}
                        </span>
                    </x-button.primary>
                </div>
            </div>
        </div>
    </div>
</div>