<div class="space-y-6 pt-4">
    <div class="space-y-6">
        @isset($affiliate)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm p-6 flex flex-col gap-2">
                    <h3 class="text-lg font-semibold text-base">{{ __('affiliates::affiliate.visitors') }}</h3>
                    <p class="text-sm text-base/60">{{ __('affiliates::affiliate.total-visitors') }}</p>
                    <span class="text-2xl font-bold text-primary/80">{{ Number::format($affiliate->visitors) }}</span>
                </div>

                <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm p-6 flex flex-col gap-2">
                    <h3 class="text-lg font-semibold text-base">{{ __('affiliates::affiliate.signups') }}</h3>
                    <p class="text-sm text-base/60">{{ __('affiliates::affiliate.total-signups') }}</p>
                    <span class="text-2xl font-bold text-primary/80">{{ Number::format($affiliate->signups) }}</span>
                </div>

                <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm p-6 flex flex-col gap-2">
                    <h3 class="text-lg font-semibold text-base">{{ __('affiliates::affiliate.earnings') }}</h3>
                    <p class="text-sm text-base/60">{{ __('affiliates::affiliate.total-earnings') }}</p>
                    <div class="mt-1 space-y-1 text-sm text-base/80">
                        @foreach ($affiliate->earnings as $currency => $amount)
                            <div class="flex items-center justify-between bg-background border border-neutral/10 rounded-lg px-3 py-2">
                                <span class="font-medium">{{ $currency }}</span>
                                <span>{{ $amount }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @php($referralLink = url('/?ref=' . $affiliate->code))

            <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-neutral/10 p-4 bg-neutral/5">
                    <h2 class="text-xl font-semibold">{{ __('affiliates::affiliate.affiliate') }}</h2>
                    <p class="text-sm text-base/60 mt-1">{{ __('affiliates::affiliate.your-affiliate-link') }}</p>
                </div>

                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-form.input value="{{ $referralLink }}" name="ref" divClass="sm:flex-1 !mt-0" type="text"
                            readonly />

                        <div class="flex sm:w-auto">
                            <x-button.primary type="button"
                                class="w-full sm:w-auto sm:!w-fit flex items-center justify-center gap-2"
                                x-on:click.prevent="if (navigator.clipboard) { navigator.clipboard.writeText('{{ $referralLink }}'); }">
                                <x-ri-file-copy-line class="size-4" />
                                {{ __('affiliates::affiliate.copy') }}
                            </x-button.primary>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-background-secondary border border-neutral/20 rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                        <h2 class="text-xl font-semibold">{{ __('affiliates::affiliate.signup-for-affiliate') }}</h2>
                        <p class="text-sm text-base/60">{{ __('affiliates::affiliate.you-havent-signed-up-yet') }}</p>
                    </div>

                    <form wire:submit.prevent="signup" method="POST" class="space-y-4">
                        @if ($signup_type === 'custom')
                            <x-form.input name="referral_code" type="text" :label="__('affiliates::affiliate.code')"
                                wire:model="referral_code" required />
                        @endif

                        <div class="flex justify-end">
                            <x-button.primary type="submit" class="px-6 py-2.5 flex items-center gap-2">
                                <x-ri-user-add-line class="size-4" />
                                {{ __('auth.sign_up') }}
                            </x-button.primary>
                        </div>
                    </form>
                </div>
            </div>
        @endisset
    </div>
</div>
