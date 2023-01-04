    <li><a
            href="{{ route('ecommerce.products', ['category' => $category->id]) }}">{{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}</a>

        @if ($category->children->count() > 0)
            <ul>
                @foreach ($category->children->sortBy('sort_order') as $subCat)
                    @include('layouts.ecommerce._category_options', [
                        'category' => $subCat,
                    ])
                @endforeach
            </ul>
        @endif

    </li>