<div class="flex flex-col gap-2 min-w-[140px]">
    <strong class="block text-xs font-semibold uppercase text-base/60 tracking-wide">
        {{ __('Currency') }}
    </strong>
    <x-select
        wire:model.live="currentCurrency"
        :options="$this->currencies"
        placeholder="Select currency"
        class="min-w-[120px] flex-shrink-0"
    />
</div>
