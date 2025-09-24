<div class="space-y-6 pt-4">
    <x-navigation.breadcrumb />

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Account Settings</h1>
            <p class="text-sm text-base/60 mt-1">Manage your personal information and account preferences</p>
        </div>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-neutral/10 p-4 bg-neutral/5">
            <div class="flex items-center gap-2">
                <x-ri-user-settings-line class="size-5 text-primary/70" />
                <h2 class="font-medium">Personal Information</h2>
            </div>
            <p class="text-sm text-base/60 mt-1 pl-7">Update your account information and email address.</p>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-form.input name="first_name" type="text" :label="__('general.input.first_name')" :placeholder="__('general.input.first_name_placeholder')"
                    wire:model="first_name" required dirty />

                <x-form.input name="last_name" type="text" :label="__('general.input.last_name')" :placeholder="__('general.input.last_name_placeholder')" wire:model="last_name"
                    required dirty />

                <x-form.input name="email" type="email" :label="__('general.input.email')" :placeholder="__('general.input.email_placeholder')" required
                    wire:model="email" dirty class="md:col-span-2" />

                <x-form.properties :custom_properties="$custom_properties" :properties="$properties" dirty />
            </div>

            <div class="flex justify-end mt-6">
                <x-button.primary wire:click="submit" class="px-6 py-2.5 flex items-center gap-2">
                    <x-ri-save-line class="size-4" />
                    Save Changes
                </x-button.primary>
            </div>
        </div>
    </div>

    <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-neutral/10 p-4 bg-neutral/5">
            <div class="flex items-center gap-2">
                <x-ri-shield-keyhole-line class="size-5 text-primary/70" />
                <h2 class="font-medium">Security</h2>
            </div>
            <p class="text-sm text-base/60 mt-1 pl-7">Manage your account security settings.</p>
        </div>

        <div class="divide-y divide-neutral/10">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div class="bg-neutral/10 p-2 rounded-lg">
                            <x-ri-lock-password-line class="size-5 text-base/70" />
                        </div>
                        <div>
                            <h3 class="font-medium">Password</h3>
                            <p class="text-sm text-base/60 mt-1">Change your account password to keep your account
                                secure.</p>
                        </div>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-background hover:bg-neutral/10 border border-neutral/20 rounded-lg text-sm font-medium transition-colors">
                        <x-ri-key-line class="size-4" />
                        Change Password
                    </a>
                </div>
            </div>

            @if (config('settings.2fa_enabled', false))
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="bg-neutral/10 p-2 rounded-lg">
                                <x-ri-shield-check-line class="size-5 text-base/70" />
                            </div>
                            <div>
                                <h3 class="font-medium">Two-Factor Authentication</h3>
                                <p class="text-sm text-base/60 mt-1">Add additional security to your account using
                                    two-factor authentication.</p>
                            </div>
                        </div>
                        <a href="{{ route('2fa.setup') }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-background hover:bg-neutral/10 border border-neutral/20 rounded-lg text-sm font-medium transition-colors">
                            <x-ri-smartphone-line class="size-4" />
                            Manage 2FA
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
