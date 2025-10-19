@if (theme('enable_panel_showcase', true))
    <div class="py-16 w-full">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1 flex flex-col justify-center lg:justify-start">
                    <h2 class="text-3xl md:text-4xl font-bold text-base mb-6">
                        {{ theme('panel_showcase_title', 'Powerful Game Control Panel') }}
                    </h2>
                    <p class="text-lg text-base/70">
                        {{ theme('panel_showcase_description', 'Take full control of your game servers with our intuitive control panel. Easily manage settings, monitor performance, and deploy mods with just a few clicks.') }}
                    </p>
                </div>

                <div class="order-1 lg:order-2 flex justify-center lg:justify-end">
                    @php
                        $showcaseImageUrl = theme('panel_showcase_image_url', 'https://placehold.co/1200x800');
                    @endphp

                    <div class="rounded-lg overflow-hidden shadow-lg border border-neutral/10 w-full max-w-lg">
                        <img src="{{ $showcaseImageUrl }}" alt="Game Control Panel" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
