<div x-data>
    <template x-for="(notification, index) in $store.notifications.notifications" :key="notification.id">
        <div x-show="notification.show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4" class="fixed bottom-4 right-4 z-50 max-w-sm"
            :style="'bottom: ' + (20 + index * 80) + 'px;'">

            <div class="flex items-start gap-3 p-4 rounded-lg shadow-lg border border-neutral/20"
                :class="{
                    'bg-success/10 border-success/20': notification.type === 'success',
                    'bg-error/10 border-error/20': notification.type === 'error',
                    'bg-info/10 border-info/20': notification.type === 'info',
                    'bg-warning/10 border-warning/20': notification.type === 'warning',
                    'bg-neutral/10 border-neutral/20': !notification.type
                }">

                <div class="flex-shrink-0">
                    <div class="p-1 rounded-full"
                        :class="{
                            'text-success': notification.type === 'success',
                            'text-error': notification.type === 'error',
                            'text-info': notification.type === 'info',
                            'text-warning': notification.type === 'warning',
                            'text-base/70': !notification.type
                        }">
                        <template x-if="notification.type === 'success'">
                            <x-ri-checkbox-circle-fill class="size-5" />
                        </template>
                        <template x-if="notification.type === 'error'">
                            <x-ri-error-warning-fill class="size-5" />
                        </template>
                        <template x-if="notification.type === 'info'">
                            <x-ri-information-fill class="size-5" />
                        </template>
                        <template x-if="notification.type === 'warning'">
                            <x-ri-alert-fill class="size-5" />
                        </template>
                        <template x-if="!notification.type">
                            <x-ri-notification-3-fill class="size-5" />
                        </template>
                    </div>
                </div>

                <div class="flex-1 pt-0.5">
                    <p class="text-sm font-medium" x-text="notification.message"></p>
                </div>

                <button @click.stop="$store.notifications.removeNotification(notification.id)"
                    class="flex-shrink-0 ml-2 p-1 rounded-full hover:bg-neutral/10 transition-colors">
                    <x-ri-close-line class="size-4 text-base/60" />
                </button>
            </div>
        </div>
    </template>
</div>
