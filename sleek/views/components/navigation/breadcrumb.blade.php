@php
    $currentUrl = url()->current();
    $currentPath = parse_url($currentUrl, PHP_URL_PATH) ?? '/';
    $currentPath = $currentPath === '' ? '/' : $currentPath;
    $normalizedCurrentUrl = rtrim($currentUrl, '/');

    $navigation = [\App\Classes\Navigation::getLinks()];

    if (\Illuminate\Support\Facades\Auth::check()) {
        $navigation[] = \App\Classes\Navigation::getAccountDropdownLinks();
        $navigation[] = \App\Classes\Navigation::getDashboardLinks();
    }

    function normalizeNavigationUrl($url)
    {
        if (!is_string($url) || $url === '' || $url === '#') {
            return [null, null];
        }

        $fullUrl = filter_var($url, FILTER_VALIDATE_URL) ? $url : url($url);
        $fullUrl = rtrim($fullUrl, '/');

        $path = parse_url($fullUrl, PHP_URL_PATH) ?? '/';
        $path = $path === '' ? '/' : $path;

        return [$fullUrl, $path];
    }

    function findBreadcrumb($items, $currentUrl, $currentPath)
    {
        foreach ($items as $item) {
            [$itemUrl, $itemPath] = normalizeNavigationUrl($item['url'] ?? null);

            if ($itemUrl && ($itemUrl === $currentUrl || $itemPath === $currentPath)) {
                return [$item];
            }

            if (!empty($item['children'])) {
                $childTrail = findBreadcrumb($item['children'], $currentUrl, $currentPath);
                if (!empty($childTrail)) {
                    return array_merge([$item], $childTrail);
                }
            }
        }

        return [];
    }

    $breadcrumbs = [];
    foreach ($navigation as $group) {
        $breadcrumbs = findBreadcrumb($group, $normalizedCurrentUrl, $currentPath);
        if (!empty($breadcrumbs)) {
            break;
        }
    }
@endphp

<div class="flex flex-row items-center pb-4">
    @if (!empty($breadcrumbs))
        @foreach ($breadcrumbs as $index => $breadcrumb)
            @if ($index > 0)
                <x-ri-arrow-right-s-line class="size-4 text-base mx-2" />
            @endif

            @if (count($breadcrumbs) === 1)
                <span class="text-2xl font-bold">
                    {{ $breadcrumb['name'] ?? '' }}
                </span>
            @elseif ($index === count($breadcrumbs) - 1)
                <span class="text-base/80 font-semibold">
                    {{ $breadcrumb['name'] ?? '' }}
                </span>
            @else
                <a href="{{ $breadcrumb['url'] ?? (isset($breadcrumb['route']) ? route($breadcrumb['route'], $breadcrumb['params'] ?? []) : '#') }}"
                    class="text-lg font-bold hover:text-primary">
                    {{ $breadcrumb['name'] ?? '' }}
                </a>
            @endif
        @endforeach
    @else
        <span class="text-lg font-bold">{{ __('navigation.home') }}</span>
    @endif
</div>
