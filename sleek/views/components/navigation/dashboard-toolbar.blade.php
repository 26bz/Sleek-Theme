@php
    $dashboardLinks = auth()->check() ? \App\Classes\Navigation::getDashboardLinks() : [];
    $hasDashboardLinks = !empty($dashboardLinks);

    $isDashboardPage =
        auth()->check() &&
        (request()->routeIs('dashboard*') ||
            request()->routeIs('services*') ||
            request()->routeIs('invoices*') ||
            request()->routeIs('tickets*') ||
            request()->routeIs('account*') ||
            request()->routeIs('profile*'));
@endphp

@if ($hasDashboardLinks && $isDashboardPage)
    <div class="w-full bg-background-secondary border-b border-neutral/20 fixed top-16 z-10 h-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 h-full">
            <div class="flex items-center justify-between h-full">
                <div class="flex items-center gap-0.5 min-w-0 overflow-x-auto">
                    @php
                        $accountNav = null;
                        $otherNavs = [];

                        foreach ($dashboardLinks as $nav) {
                            if (strtolower($nav['name']) === 'account') {
                                $accountNav = $nav;
                            } else {
                                $otherNavs[] = $nav;
                            }
                        }
                    @endphp

                    @foreach ($otherNavs as $nav)
                        @if (isset($nav['children']) && count($nav['children']) > 0)
                            <div class="flex-shrink-0">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="flex items-center gap-1.5 px-2 py-1 text-xs font-medium whitespace-nowrap rounded-md transition-all duration-200 {{ $nav['active'] ? 'text-primary bg-primary/10' : 'text-base/70 hover:text-primary hover:bg-primary/5' }}">
                                        @isset($nav['icon'])
                                            <x-dynamic-component :component="$nav['icon']"
                                                class="size-3 flex-shrink-0 {{ $nav['active'] ? 'text-primary' : 'text-base/50' }}" />
                                        @endisset
                                        <span>{{ $nav['name'] }}</span>
                                        <x-ri-arrow-down-s-line class="size-2.5 flex-shrink-0 opacity-50"
                                            x-bind:class="{ 'rotate-180': open }" />
                                    </button>

                                    <div x-show="open" @click.outside="open = false"
                                        x-transition:enter="transition ease-out duration-150"
                                        x-transition:enter-start="opacity-0 scale-90"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-90" x-cloak style="z-index: 9999;"
                                        class="absolute left-0 mt-1 w-48 bg-background-secondary rounded-md shadow-xl border border-neutral/20 py-1">
                                        @foreach ($nav['children'] as $child)
                                            @if ($child['condition'] ?? true)
                                                <a href="{{ route($child['route'], $child['params'] ?? []) }}"
                                                    @if ($child['spa'] ?? true) wire:navigate @endif
                                                    @click="open = false"
                                                    class="block px-3 py-1.5 text-xs whitespace-nowrap hover:bg-primary/5 transition-colors {{ $child['active'] ? 'text-primary font-semibold bg-primary/5' : 'text-base hover:text-primary' }}">
                                                    {{ $child['name'] }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <x-navigation.link :href="route($nav['route'], $nav['params'] ?? [])" :spa="$nav['spa'] ?? true"
                                class="flex items-center px-3 py-2 {{ $nav['active'] ? 'text-primary' : '' }}">
                                {{ $nav['name'] }}
                            </x-navigation.link>
                        @endif
                    @endforeach
                </div>

                @if ($accountNav)
                    <div class="flex-shrink-0 ml-4">
                        @if (isset($accountNav['children']) && count($accountNav['children']) > 0)
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center px-3 py-2 text-sm font-semibold whitespace-nowrap text-base hover:text-base/80 {{ $accountNav['active'] ? 'text-primary' : '' }}">
                                    <span>{{ $accountNav['name'] }}</span>
                                </button>

                                <div x-show="open" @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 scale-90"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-90" x-cloak style="z-index: 9999;"
                                    class="absolute right-0 mt-1 w-48 bg-background-secondary rounded-md shadow-xl border border-neutral/20 py-1">
                                    @foreach ($accountNav['children'] as $child)
                                        @if ($child['condition'] ?? true)
                                            <a href="{{ route($child['route'], $child['params'] ?? []) }}"
                                                @if ($child['spa'] ?? true) wire:navigate @endif
                                                @click="open = false"
                                                class="block px-3 py-1.5 text-xs whitespace-nowrap hover:bg-primary/5 transition-colors {{ $child['active'] ? 'text-primary font-semibold bg-primary/5' : 'text-base hover:text-primary' }}">
                                                {{ $child['name'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <x-navigation.link :href="route($accountNav['route'], $accountNav['params'] ?? [])" :spa="$accountNav['spa'] ?? true"
                                class="flex items-center px-3 py-2 {{ $accountNav['active'] ? 'text-primary' : '' }}">
                                {{ $accountNav['name'] }}
                            </x-navigation.link>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif
