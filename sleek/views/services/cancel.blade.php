<div class="space-y-6">
    <div class="bg-background rounded-lg border border-neutral/20 p-4">
        <p class="text-base/80">
            {{ __('services.cancel_are_you_sure') }}
        </p>
    </div>

    <div class="space-y-5">
        <x-form.select 
            name="type" 
            label="{{ __('services.cancel_type') }}" 
            required 
            wire:model="type"
        >
            <option value="end_of_period">{{ __('services.cancel_end_of_period') }}</option>
            <option value="immediate">{{ __('services.cancel_immediate') }}</option>
        </x-form.select>

        <x-form.textarea 
            name="reason" 
            label="{{ __('services.cancel_reason') }}" 
            required 
            wire:model="reason"
            rows="4" 
        />

        <template x-if="$wire.type === 'immediate'">
            <div class="bg-error/10 border border-error/20 text-error p-4 rounded-lg">
                <p class="text-sm">{{ __('services.cancel_immediate_warning') }}</p>
            </div>
        </template>

        <div class="pt-2">
            <x-button.danger 
                wire:click="cancelService"
                wire:confirm="{{ __('services.cancel_are_you_sure') }}"
                class="flex items-center gap-2"
            >
                <x-ri-close-circle-line class="size-4" />
                {{ __('services.cancel') }}
            </x-button.danger>
        </div>
    </div>
</div>