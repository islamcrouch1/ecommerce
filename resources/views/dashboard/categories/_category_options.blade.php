@php
    isset($count) ? $count++ : ($count = 1);
@endphp

<option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>
    {{ str_repeat(' - ', $count) }} {{ app()->getLocale() == 'ar' ? $category->name_ar : $category->name_en }}
</option>

@if ($category->children->count() > 0)
    @foreach ($category->children as $subCat)
        @include('dashboard.categories._category_options', [
            'category' => $subCat,
            'count' => $count,
        ])
    @endforeach
@endif
