@if ($account->accounts->count() > 0 && $count < 3)
    @foreach ($account->accounts as $subAccount)
        @php
            $balance = getTrialBalance($subAccount->id, request()->from, request()->to);
            $count++;
        @endphp

        <tr class="collapse show table-warning" id="col-{{ $account->id }}">
            <td>
                {{-- @if ($subAccount->accounts->count() > 0)
                    <a class="btn btn-falcon-primary" data-bs-toggle="collapse" href="#col-{{ $subAccount->id }}"
                        role="button" aria-expanded="false" aria-controls="col-{{ $subAccount->id }}">
                        <span class="fas fa-plus">
                    </a>
                @endif --}}

            </td>
            <td>{{ getName($subAccount) }}</td>
            <td class="text-end">{{ $balance . ' ' . getCurrency() }}</td>
        </tr>


        @include('dashboard.entries._balance_account', [
            'account' => $subAccount,
        ])
    @endforeach
@endif
