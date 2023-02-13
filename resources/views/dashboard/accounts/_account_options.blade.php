@php
    isset($count) ? $count++ : ($count = 1);
@endphp

<option value="{{ $account->id }}" {{ request()->parent_id == $account->id ? 'selected' : '' }}>
    {{ str_repeat(' - ', $count) }} {{ getName($account) }}
</option>

@if ($account->accounts->count() > 0)
    @foreach ($account->accounts as $subAccount)
        @include('dashboard.accounts._account_options', [
            'account' => $subAccount,
            'count' => $count,
        ])
    @endforeach
@endif
