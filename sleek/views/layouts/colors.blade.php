@php
    $lightColors = [
        'primary' => '0 0% 0%',
        'secondary' => '0 0% 65%',
        'neutral' => '0 0% 30%',
        'base' => '0 0% 0%',
        'muted' => '0 0% 40%',
        'inverted' => '0 0% 100%',
        'background' => '0 0% 100%',
        'background-secondary' => '0 0% 97%',
    ];

    $darkColors = [
        'primary' => '0 0% 85%',
        'secondary' => '0 0% 65%',
        'neutral' => '0 0% 30%',
        'base' => '0 0% 100%',
        'muted' => '0 0% 70%',
        'inverted' => '0 0% 5%',
        'background' => '0 0% 5%',
        'background-secondary' => '0 0% 10%',
    ];

    foreach ($lightColors as $key => $value) {
        $themeValue = theme($key, null);
        if ($themeValue) {
            $lightColors[$key] = str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', $themeValue));
        }
    }

    foreach ($darkColors as $key => $value) {
        $themeValue = theme('dark-' . $key, null);
        if ($themeValue) {
            $darkColors[$key] = str_replace(',', '', preg_replace('/^hsl\((.+)\)$/', '$1', $themeValue));
        }
    }
@endphp

<style>
    :root {
        --color-primary: {{ $lightColors['primary'] }};
        --color-secondary: {{ $lightColors['secondary'] }};
        --color-neutral: {{ $lightColors['neutral'] }};
        --color-base: {{ $lightColors['base'] }};
        --color-muted: {{ $lightColors['muted'] }};
        --color-inverted: {{ $lightColors['inverted'] }};
        --color-success: 142 76% 36%;
        --color-error: 0 85% 65%;
        --color-warning: 38 100% 50%;
        --color-inactive: 220 15% 40%;
        --color-info: 195 100% 50%;
        --color-background: {{ $lightColors['background'] }};
        --color-background-secondary: {{ $lightColors['background-secondary'] }};
    }

    .dark {
        --color-primary: {{ $darkColors['primary'] }};
        --color-secondary: {{ $darkColors['secondary'] }};
        --color-neutral: {{ $darkColors['neutral'] }};
        --color-base: {{ $darkColors['base'] }};
        --color-muted: {{ $darkColors['muted'] }};
        --color-inverted: {{ $darkColors['inverted'] }};
        --color-background: {{ $darkColors['background'] }};
        --color-background-secondary: {{ $darkColors['background-secondary'] }};
    }

    :root {
        color-scheme: light;
    }

    .dark {
        color-scheme: dark;
    }

    body:not(.dark) {
        color: hsl(0, 0%, 0%);
    }

    .dark {
        color: hsl(0, 0%, 100%);
    }

    .text-base {
        color: hsl(var(--color-base)) !important;
    }

    .text-primary {
        color: hsl(var(--color-primary)) !important;
    }

    button.text-base,
    a button.text-base {
        color: hsl(var(--color-base)) !important;
    }

    .dark button.text-base,
    .dark a button.text-base {
        color: hsl(0, 0%, 100%) !important;
    }

    body:not(.dark) button.text-base,
    body:not(.dark) a button.text-base {
        color: hsl(0, 0%, 0%) !important;
    }

    .dark .dropdown-content {
        color: hsl(0, 0%, 100%);
    }

    body:not(.dark) .dropdown-content {
        color: hsl(0, 0%, 0%);
    }

    .bg-success\/10,
    [class*="bg-success\/10"] {
        background-color: hsla(142, 76%, 36%, 0.1) !important;
    }

    .text-success,
    [class*="text-success"] {
        color: hsl(142, 76%, 36%) !important;
    }

    .border-success\/20,
    [class*="border-success\/20"] {
        border-color: hsla(142, 76%, 36%, 0.2) !important;
    }

    .bg-error\/10,
    [class*="bg-error\/10"] {
        background-color: hsla(0, 85%, 65%, 0.1) !important;
    }

    .text-error,
    [class*="text-error"] {
        color: hsl(0, 85%, 65%) !important;
    }

    .border-error\/20,
    [class*="border-error\/20"] {
        border-color: hsla(0, 85%, 65%, 0.2) !important;
    }

    .bg-warning\/10,
    [class*="bg-warning\/10"] {
        background-color: hsla(38, 100%, 50%, 0.1) !important;
    }

    .text-warning,
    [class*="text-warning"] {
        color: hsl(38, 100%, 50%) !important;
    }

    .border-warning\/20,
    [class*="border-warning\/20"] {
        border-color: hsla(38, 100%, 50%, 0.2) !important;
    }

    .bg-inactive\/10,
    [class*="bg-inactive\/10"] {
        background-color: hsla(220, 15%, 40%, 0.1) !important;
    }

    .text-inactive,
    [class*="text-inactive"] {
        color: hsl(220, 15%, 40%) !important;
    }

    .border-inactive\/20,
    [class*="border-inactive\/20"] {
        border-color: hsla(220, 15%, 40%, 0.2) !important;
    }

    .services-show .bg-success\/10 {
        background-color: hsla(142, 76%, 36%, 0.1) !important;
    }

    .services-show .bg-error\/10 {
        background-color: hsla(0, 85%, 65%, 0.1) !important;
    }

    .services-show .bg-warning\/10 {
        background-color: hsla(38, 100%, 50%, 0.1) !important;
    }

    .services-show .bg-inactive\/10 {
        background-color: hsla(220, 15%, 40%, 0.1) !important;
    }

    .services-show .text-success {
        color: hsl(142, 76%, 36%) !important;
    }

    .services-show .text-error {
        color: hsl(0, 85%, 65%) !important;
    }

    .services-show .text-warning {
        color: hsl(38, 100%, 50%) !important;
    }

    .services-show .text-inactive {
        color: hsl(220, 15%, 40%) !important;
    }

    .services-show .border-success\/20 {
        border-color: hsla(142, 76%, 36%, 0.2) !important;
    }

    .services-show .border-error\/20 {
        border-color: hsla(0, 85%, 65%, 0.2) !important;
    }

    .services-show .border-warning\/20 {
        border-color: hsla(38, 100%, 50%, 0.2) !important;
    }

    .services-show .border-inactive\/20 {
        border-color: hsla(220, 15%, 40%, 0.2) !important;
    }
</style>

@if (request()->is('admin*'))
    <style>
        :root {
            --color-primary: 229 100% 64%;
            --color-secondary: 237 33% 60%;
            --color-neutral: 220 25% 85%;
            --color-base: 0 0% 0%;
            --color-muted: 220 28% 25%;
            --color-inverted: 100 100% 100%;
            --color-background: 100 100% 100%;
            --color-background-secondary: 0 0% 97%;
        }
    </style>
@endif
