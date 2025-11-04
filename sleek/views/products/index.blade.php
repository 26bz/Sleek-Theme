<div class="grid md:grid-cols-4 gap-6">
    <div class="flex flex-col gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-2">{{ $category->name }}</h1>
            <article class="prose dark:prose-invert text-base/70">
                {!! $category->description !!}
            </article>
        </div>
        <div class="bg-background-secondary border border-neutral/20 rounded-lg overflow-hidden shadow-sm">
            <div class="p-2">
                @foreach ($categories as $ccategory)
                    <a href="{{ route('category.show', ['category' => $ccategory->slug]) }}" wire:navigate
                        class="flex items-center px-3 py-2 rounded-md transition-colors duration-200 hover:bg-neutral/10 {{ $category->id == $ccategory->id ? 'bg-neutral/10 text-primary font-medium' : 'text-base/80' }}">
                        <x-ri-folder-line
                            class="size-4 mr-2 {{ $category->id == $ccategory->id ? 'text-primary' : 'text-base/60' }}" />
                        {{ $ccategory->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-6 col-span-3">
        @if (count($childCategories) >= 1)
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 h-fit">
                @foreach ($childCategories as $childCategory)
                    <div
                        class="flex flex-col bg-background-secondary hover:bg-background-secondary/90 border border-neutral/20 p-5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md group">
                        @if (theme('small_images', false))
                            <div class="flex gap-x-3 items-center mb-3">
                        @endif
                        @if ($childCategory->image)
                            <div
                                class="{{ !theme('small_images', false) ? 'aspect-[4/3] overflow-hidden rounded-md mb-4' : '' }}">
                                <img src="{{ Storage::url($childCategory->image) }}" alt="{{ $childCategory->name }}"
                                    class="{{ theme('small_images', false) ? 'w-14 h-14 object-cover rounded-md' : 'w-full h-full object-cover object-center rounded-md transition-transform duration-300 group-hover:scale-105' }}">
                            </div>
                        @elseif(!theme('small_images', false))
                            <div class="aspect-[4/3] bg-neutral/10 flex items-center justify-center rounded-md mb-4">
                                <x-ri-folder-5-line class="size-12 text-base/30" />
                            </div>
                        @endif
                        <h2 class="text-xl font-bold mb-2 group-hover:text-primary transition-colors duration-200">
                            {{ $childCategory->name }}</h2>
                        @if (theme('small_images', false))
                    </div>
                @endif
                @if (theme('show_category_description', true))
                    <div class="mb-4 text-sm text-base/70 line-clamp-2">
                        {!! strip_tags($childCategory->description) !!}
                    </div>
                @endif
                <div class="mt-auto">
                    <a href="{{ route('category.show', ['category' => $childCategory->slug]) }}" wire:navigate
                        class="block w-full">
                        <x-button.primary class="w-full justify-center">
                            <x-ri-folder-open-line class="size-4 mr-2" />
                            {{ __('common.button.view') }}
                        </x-button.primary>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    @endif
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 h-fit">
        @foreach ($products as $product)
            <div
                class="flex flex-col bg-background-secondary hover:bg-background-secondary/90 border border-neutral/20 p-5 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md group">
                <div class="relative overflow-hidden rounded-md mb-4">
                    @if ($product->stock === 0)
                        <div class="absolute top-2 right-2 z-10">
                            <span
                                class="text-xs font-medium px-2.5 py-1 rounded-full bg-error/10 text-error border border-error/20">
                                {{ __('product.out_of_stock') }}
                            </span>
                        </div>
                    @elseif($product->stock > 0)
                        <div class="absolute top-2 right-2 z-10">
                            <span
                                class="text-xs font-medium px-2.5 py-1 rounded-full bg-success/10 text-success border border-success/20">
                                {{ __('product.in_stock') }}
                            </span>
                        </div>
                    @endif
                    @if ($product->image)
                        <div class="aspect-[4/3] overflow-hidden rounded-md">
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover object-center rounded-md transition-transform duration-300 group-hover:scale-105">
                        </div>
                    @else
                        <div class="aspect-[4/3] bg-neutral/10 flex items-center justify-center rounded-md">
                            <x-ri-shopping-bag-4-line class="size-12 text-base/30" />
                        </div>
                    @endif
                </div>
                <div class="flex-1 flex flex-col">
                    <h2 class="text-xl font-bold mb-1 group-hover:text-primary transition-colors duration-200">
                        {{ $product->name }}</h2>

                    @if (theme('direct_checkout', false) && $product->description)
                        <div class="mb-3 text-sm text-base/70 line-clamp-2">
                            {!! strip_tags($product->description) !!}
                        </div>
                    @endif

                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-primary">
                                {{ $product->price()->formatted->price }}
                            </h3>
                        </div>

                        @if (($product->stock > 0 || !$product->stock) && $product->price()->available && theme('direct_checkout', false))
                            <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}"
                                class="block w-full" wire:navigate>
                                <x-button.primary class="w-full justify-center">
                                    <x-ri-shopping-cart-fill class="size-4 mr-2" />
                                    {{ __('product.add_to_cart') }}
                                </x-button.primary>
                            </a>
                        @else
                            <div class="flex items-center gap-2">
                                <a href="{{ route('products.show', ['category' => $product->category, 'product' => $product->slug]) }}"
                                    class="flex-grow" wire:navigate>
                                    <x-button.primary class="w-full justify-center">
                                        <x-ri-eye-fill class="size-4 mr-2" />
                                        {{ __('common.button.view') }}
                                    </x-button.primary>
                                </a>
                                @if ($product->stock !== 0 && $product->price()->available)
                                    <a href="{{ route('products.checkout', ['category' => $category, 'product' => $product->slug]) }}"
                                        wire:navigate>
                                        <x-button.secondary>
                                            <x-ri-shopping-bag-4-fill class="size-5" />
                                        </x-button.secondary>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
