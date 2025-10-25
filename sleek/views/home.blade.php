<div class="max-w-7xl mx-auto">
    <div class="relative mb-16">
        <div class="text-center py-16 px-6">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-base mb-6 leading-tight">
                    {!! Str::markdown(theme('home_page_text', 'Professional **Web Hosting** Made Simple'), [
                        'allow_unsafe_links' => false,
                        'renderer' => [
                            'soft_break' => '<br>',
                        ],
                    ]) !!}
                </h1>
                <p class="text-lg md:text-xl text-base/70 mb-8 max-w-2xl mx-auto leading-relaxed">
                    {{ theme('hero_description', 'Reliable, fast, and secure hosting solutions for businesses of all sizes. Get started in minutes with our easy-to-use platform.') }}
                </p>
                @if (theme('hero_primary_button_text') || theme('hero_secondary_button_text'))
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                        @if (theme('hero_primary_button_text'))
                            <a href="{{ theme('hero_primary_button_url', '#services') }}" class="w-full sm:w-auto"
                                @if (str_starts_with(theme('hero_primary_button_url', '#services'), '#')) @else wire:navigate @endif>
                                <x-button.primary class="w-full sm:w-auto px-8 py-4 text-lg">
                                    <x-ri-flashlight-line class="size-5 mr-2" />
                                    {{ theme('hero_primary_button_text') }}
                                </x-button.primary>
                            </a>
                        @endif
                        @if (theme('hero_secondary_button_text'))
                            <a href="{{ theme('hero_secondary_button_url', '/tickets/create') }}"
                                class="w-full sm:w-auto" @if (str_starts_with(theme('hero_secondary_button_url', '/tickets/create'), '#')) @else wire:navigate @endif>
                                <x-button.secondary class="w-full sm:w-auto px-8 py-4 text-lg">
                                    <x-ri-customer-service-line class="size-5 mr-2" />
                                    {{ theme('hero_secondary_button_text') }}
                                </x-button.secondary>
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>


    @if (theme('enable_features_section', true))
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-base mb-4">
                    {{ theme('features_title', 'Why Choose Our Hosting?') }}</h2>
                <p class="text-lg text-base/70 max-w-2xl mx-auto">
                    {{ theme('features_subtitle', 'We provide everything you need to succeed online with reliable, fast, and secure hosting solutions.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        [
                            'title' => theme('feature_1_title', 'Lightning Fast'),
                            'description' => theme(
                                'feature_1_description',
                                'SSD storage, CDN integration, and optimized servers ensure your website loads in milliseconds.',
                            ),
                            'color' => 'primary',
                        ],
                        [
                            'title' => theme('feature_2_title', 'Bank-Level Security'),
                            'description' => theme(
                                'feature_2_description',
                                'Advanced security measures protect your data with SSL certificates, firewalls, and daily backups.',
                            ),
                            'color' => 'success',
                        ],
                        [
                            'title' => theme('feature_3_title', 'Expert Support 24/7'),
                            'description' => theme(
                                'feature_3_description',
                                'Our hosting experts are available around the clock to help with any technical issues or questions.',
                            ),
                            'color' => 'warning',
                        ],
                        [
                            'title' => theme('feature_4_title', 'Easily Scalable'),
                            'description' => theme(
                                'feature_4_description',
                                'Start small and grow big. Upgrade your resources instantly as your business expands.',
                            ),
                            'color' => 'info',
                        ],
                        [
                            'title' => theme('feature_5_title', 'User-Friendly Control Panel'),
                            'description' => theme(
                                'feature_5_description',
                                'Manage your hosting with our intuitive control panel. No technical knowledge required.',
                            ),
                            'color' => 'secondary',
                        ],
                        [
                            'title' => theme('feature_6_title', '99.9% Uptime Guarantee'),
                            'description' => theme(
                                'feature_6_description',
                                'Your website stays online with our reliable infrastructure and uptime monitoring.',
                            ),
                            'color' => 'error',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    @if ($feature['title'])
                        <div
                            class="bg-background-secondary border border-neutral/20 rounded-xl p-6 hover:border-neutral/30 transition-all duration-200 hover:shadow-sm">
                            <div class="bg-{{ $feature['color'] }}/10 p-3 rounded-lg w-fit mb-4">
                                <x-ri-check-line class="size-8 text-{{ $feature['color'] }}" />
                            </div>
                            <h3 class="text-xl font-semibold mb-3">{{ $feature['title'] }}</h3>
                            <p class="text-base/70 mb-4">{{ $feature['description'] }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <div class="w-full">
        <x-panel-showcase />
    </div>

    <div id="services" class="mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-base mb-4">{{ __('Choose Our Hosting Services') }}</h2>
            <p class="text-lg text-base/70 max-w-2xl mx-auto">
                {{ __('Explore our range of specialized hosting services designed to meet your specific needs.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', ['category' => $category->slug]) }}"
                    class="group bg-background-secondary border border-neutral/20 rounded-xl overflow-hidden hover:border-neutral/30 transition-all duration-200 hover:shadow-lg"
                    wire:navigate>
                    @if (theme('small_images', false))
                        <div class="p-6">
                            <div class="flex gap-x-3 items-center mb-3">
                                @if ($category->image)
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-14 h-14 object-cover rounded-md">
                                @else
                                    <div class="w-14 h-14 bg-neutral/10 flex items-center justify-center rounded-md">
                                        <x-ri-server-line class="size-6 text-base/30" />
                                    </div>
                                @endif
                                <h3 class="text-xl font-semibold group-hover:text-primary transition-colors">
                                    {{ $category->name }}</h3>
                            </div>
                        @else
                            @if ($category->image)
                                <div class="aspect-[16/10] overflow-hidden bg-neutral/10">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105">
                                </div>
                            @else
                                <div
                                    class="aspect-[16/10] bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center">
                                    <x-ri-server-line class="size-16 text-primary/30" />
                                </div>
                            @endif

                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-3 group-hover:text-primary transition-colors">
                                    {{ $category->name }}</h3>
                    @endif

                    @if (theme('show_category_description', true))
                        <div class="text-base/70 mb-4 line-clamp-3">
                            {!! strip_tags($category->description) !!}
                        </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-primary">{{ __('View Service') }}</span>
                        <x-ri-arrow-right-s-line
                            class="size-5 text-primary group-hover:translate-x-1 transition-transform" />
                    </div>
        </div>
        </a>
        @endforeach
    </div>
</div>

<div class="mb-16">
    <x-logo-marquee />
</div>

<div class="mb-16">
    <div class="bg-background-secondary border border-neutral/20 rounded-xl p-8 md:p-12 text-center">
        <h2 class="text-2xl md:text-3xl font-bold text-base mb-4">
            {{ theme('footer_cta_text', 'Ready to Get Started?') }}</h2>
        <p class="text-lg text-base/70 mb-8 max-w-2xl mx-auto">
            {{ theme('footer_cta_description', 'Join thousands of satisfied customers who trust us with their hosting needs. Get your website online today!') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @php
                $primaryLink = theme('cta_primary_link', '#services');
            @endphp
            <a href="{{ $primaryLink }}" class="w-full sm:w-auto">
                <x-button.primary class="w-full sm:w-auto px-8 py-4 text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    {{ theme('cta_primary_text', 'Explore Our Services') }}
                </x-button.primary>
            </a>

            @php
                $secondaryLink = theme('cta_secondary_link', 'tickets/create');

                $secondaryHref = $secondaryLink;
                if ($secondaryLink === 'tickets/create') {
                    $secondaryHref = route('tickets.create');
                }
            @endphp
            <a href="{{ $secondaryHref }}" class="w-full sm:w-auto" wire:navigate>
                <x-button.secondary class="w-full sm:w-auto px-8 py-4 text-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ theme('cta_secondary_text', 'Have Questions?') }}
                </x-button.secondary>
            </a>
        </div>
    </div>
</div>

{!! hook('pages.home') !!}
</div>
