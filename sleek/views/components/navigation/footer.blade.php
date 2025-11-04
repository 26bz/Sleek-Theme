<footer class="w-full py-12 border-t border-neutral/10 bg-background-secondary mt-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <div>
                <div class="mb-6">
                    <x-logo class="h-8 w-auto" />
                </div>
                <p class="text-sm text-base/70 mb-4">
                    {{ theme('footer_text', 'Reliable hosting solutions for businesses of all sizes. Get started in minutes with our easy-to-use platform.') }}
                </p>
                <div class="flex space-x-4">
                    @if (theme('social_twitter'))
                        <a href="{{ theme('social_twitter') }}" target="_blank" rel="noopener"
                            class="text-base/60 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                    @endif
                    @if (theme('social_instagram'))
                        <a href="{{ theme('social_instagram') }}" target="_blank" rel="noopener"
                            class="text-base/60 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    @endif
                    @if (theme('social_facebook'))
                        <a href="{{ theme('social_facebook') }}" target="_blank" rel="noopener"
                            class="text-base/60 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                    @endif
                    @if (theme('social_discord'))
                        <a href="{{ theme('social_discord') }}" target="_blank" rel="noopener"
                            class="text-base/60 hover:text-primary transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.608 1.2495-1.8447-.2762-3.6677-.2762-5.4878 0-.1634-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            <div>
                <h3 class="text-base font-semibold mb-4">{{ __('Quick Links') }}</h3>
                @php
                    $footerNavigationLinks = request()->route() ? \App\Classes\Navigation::getLinks() : [];
                @endphp
                <ul class="space-y-2">
                    @foreach ($footerNavigationLinks as $nav)
                        @if (!isset($nav['children']) || empty($nav['children']))
                            <li>
                                <a href="{{ $nav['url'] }}"
                                    class="text-sm text-base/70 hover:text-primary transition-colors"
                                    @if (isset($nav['spa']) && $nav['spa']) wire:navigate @endif>
                                    {{ $nav['name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    <li><a href="/tickets"
                            class="text-sm text-base/70 hover:text-primary transition-colors">{{ __('Ticket Support') }}</a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-base font-semibold mb-4">{{ __('Our Services') }}</h3>
                <ul class="space-y-2">
                    @foreach (\App\Models\Category::take(6)->get() as $category)
                        <li>
                            <a href="/products/{{ $category->slug }}"
                                class="text-sm text-base/70 hover:text-primary transition-colors" wire:navigate>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="text-base font-semibold mb-4">{{ __('Contact Us') }}</h3>
                <ul class="space-y-3">
                    @if (theme('contact_email') || config('settings.company_email'))
                        <li class="flex items-start gap-3 text-sm text-base/70">
                            <x-ri-mail-line class="size-5 text-primary flex-shrink-0" />
                            <span>{{ theme('contact_email') ?: config('settings.company_email') }}</span>
                        </li>
                    @endif
                    @if (theme('contact_phone') || config('settings.company_phone'))
                        <li class="flex items-start gap-3 text-sm text-base/70">
                            <x-ri-phone-line class="size-5 text-primary flex-shrink-0" />
                            <span>{{ theme('contact_phone') ?: config('settings.company_phone') }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-neutral/10 flex flex-col md:flex-row justify-between items-center">
            <div class="text-sm text-base/70 mb-4 md:mb-0">
                {{ __('© :year :app_name. | All rights reserved.', ['year' => date('Y'), 'app_name' => config('app.name')]) }}
            </div>

            <div class="flex items-center gap-2">
                <a href="https://paymenter.org" target="_blank"
                    class="group flex items-center gap-2 text-base/50 hover:text-base">
                    <svg class="size-4 text-current group-hover:text-[#4667FF]" width="150" height="205"
                        viewBox="0 0 150 205" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1_17)">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 107V205H42.8571V139.638H100C133.333 139.638 150 123 150 89.7246V69.5L75 107V69.5L148.227 32.8863C143.133 10.9621 127.057 0 100 0H0V107ZM0 107V69.5L75 32V69.5L0 107Z">
                            </path>
                        </g>
                        <defs>
                            <clipPath id="clip0_1_17">
                                <rect width="150" height="205"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    <p class="text-sm">Powered by Paymenter</p>
                </a>

                <span class="text-base/50 mx-2">|</span>
                <a href="https://26bz.online" target="_blank"
                    class="text-base/50 hover:text-primary transition-colors">
                    <span class="text-sm">Theme by 26bz</span>
                </a>
            </div>
        </div>
    </div>
</footer>
