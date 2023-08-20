@if ($account->accounts->count() > 0)
    @foreach ($account->accounts as $subAccount)
        @php
            $balance = getTrialBalance($subAccount->id, request()->from, request()->to);
            $count++;
        @endphp

        <tr class="collapse table-warning" id="col-{{ $account->id }}">
            <td class="no-print">
                @if ($subAccount->accounts->count() > 0)
                    <a class="btn btn-falcon-primary" data-bs-toggle="collapse" href="#col-{{ $subAccount->id }}"
                        role="button" aria-expanded="false" aria-controls="col-{{ $subAccount->id }}">
                        <span class="fas fa-plus">
                    </a>
                @endif

            </td>
            <td><a class="dropdown-item" target="_blank"
                    href="{{ route('entries.index', ['account_id' => $subAccount->id]) }}">
                    {{ getName($subAccount) }}
                </a></td>
            <td>
                {{ getAccountBalance($subAccount->id, 'cr', request()->from, request()->to) . ' ' . getCurrency() }}
            </td>
            <td>
                {{ getAccountBalance($subAccount->id, 'dr', request()->from, request()->to) . ' ' . getCurrency() }}
            </td>
            <td class="text-end">{{ $balance . ' ' . getCurrency() }}</td>
        </tr>



        @include('dashboard.entries._balance_account_trial', [
            'account' => $subAccount,
        ])
    @endforeach
@endif
