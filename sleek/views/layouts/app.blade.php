<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if (in_array(app()->getLocale(), config('app.rtl_locales'))) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Paymenter') }}
        @isset($title)
            - {{ $title }}
        @endisset
    </title>
    @vite(['themes/' . config('settings.theme') . '/js/app.js', 'themes/' . config('settings.theme') . '/css/app.css'], config('settings.theme'))
    @include('layouts.colors')

    @if (config('settings.logo'))
        <link rel="icon" href="{{ Storage::url(config('settings.logo')) }}" type="image/png">
    @endif
    @isset($title)
        <meta
            content="{{ isset($title) ? config('app.name', 'Paymenter') . ' - ' . $title : config('app.name', 'Paymenter') }}"
            property="og:title">
        <meta
            content="{{ isset($title) ? config('app.name', 'Paymenter') . ' - ' . $title : config('app.name', 'Paymenter') }}"
            name="title">
    @endisset
    @isset($description)
        <meta content="{{ $description }}" property="og:description">
        <meta content="{{ $description }}" name="description">
    @endisset
    @isset($image)
        <meta content="{{ $image }}" property="og:image">
        <meta content="{{ $image }}" name="image">
    @endisset

    <meta name="theme-color" content="{{ theme('primary') }}">

    {!! hook('head') !!}
</head>

<body class="w-full bg-background text-base min-h-screen flex flex-col antialiased" x-cloak x-data="{ darkMode: $persist({{ theme('force_dark_mode', false) ? 'true' : 'window.matchMedia(\'(prefers-color-scheme: dark)\').matches' }}) }"
    :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => { document.documentElement.classList.toggle('dark', val) });
    {{ theme('force_dark_mode', false) ? 'darkMode = true;' : '' }}">
    {!! hook('body') !!}
    <x-navigation />
    <x-navigation.dashboard-toolbar />
    <div class="w-full flex flex-grow">
        <div class="flex flex-col flex-grow overflow-auto">
            @php
                $isDashboardPage =
                    auth()->check() &&
                    (request()->routeIs('dashboard*') ||
                        request()->routeIs('services*') ||
                        request()->routeIs('invoices*') ||
                        request()->routeIs('tickets*') ||
                        request()->routeIs('account*') ||
                        request()->routeIs('profile*'));

                $dashboardPadding = 'pt-[7.5rem]';
                $regularPadding = 'pt-[6.5rem]';
            @endphp
            <main
                class="container mx-auto max-w-7xl px-6 lg:px-8 flex-grow {{ $isDashboardPage ? $dashboardPadding : $regularPadding }}">
                {{ $slot }}
            </main>
            <x-notification />
            <div class="pt-8">
                <x-navigation.footer />
            </div>
        </div>
        <x-impersonating />
    </div>
    {!! hook('footer') !!}
</body>

</html>
