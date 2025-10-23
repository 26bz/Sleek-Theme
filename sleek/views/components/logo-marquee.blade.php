@if (theme('enable_logo_marquee', true))
    @php
        $logoUrls = [
            theme('logo_marquee_image_url_1', 'https://placehold.co/200x80/cccccc/666666?text=Logo+1'),
            theme('logo_marquee_image_url_2', 'https://placehold.co/200x80/cccccc/666666?text=Logo+2'),
            theme('logo_marquee_image_url_3', 'https://placehold.co/200x80/cccccc/666666?text=Logo+3'),
            theme('logo_marquee_image_url_4', 'https://placehold.co/200x80/cccccc/666666?text=Logo+4'),
            theme('logo_marquee_image_url_5', 'https://placehold.co/200x80/cccccc/666666?text=Logo+5'),
            theme('logo_marquee_image_url_6', 'https://placehold.co/200x80/cccccc/666666?text=Logo+6'),
        ];

        $allLogos = array_merge($logoUrls, $logoUrls);
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl md:text-4xl font-bold text-base mb-4">{{ theme('logo_marquee_title') }}</h2>
                <p class="text-lg text-base/70 max-w-2xl mx-auto">{{ theme('logo_marquee_description') }}</p>
            </div>

            <div class="relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-background to-transparent z-10">
                </div>
                <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-background to-transparent z-10">
                </div>

                <div class="flex overflow-hidden">
                    <div class="flex animate-marquee whitespace-nowrap">
                        @foreach ($allLogos as $logoUrl)
                            <div class="flex-shrink-0 h-12 w-auto mx-6 flex items-center justify-center">
                                <img src="{{ $logoUrl }}" alt="Trusted Partner Logo"
                                    class="h-full w-auto object-contain opacity-70">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
    </style>
@endif
