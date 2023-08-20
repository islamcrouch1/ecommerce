@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">

                    @php
                        $records_amount = getSettlementAmountForSheet($sheet);
                        $remainig_amount = $sheet->amount - $records_amount;
                    @endphp

                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('review petty cash sheet settlement') . ' - ' . $sheet->user->name . ' - ' . __('petty cash amount') . ' : ' . $sheet->amount . ' - ' . __('remaining amount') . ' : ' . $remainig_amount }}

                    </h5>
                </div>
            </div>
        </div>


        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($records->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">{{ __('ID') }}
                                </th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('statement') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="email">
                                    {{ __('amount') }}</th>


                                <th class="sort pe-1 align-middle white-space-nowrap" style="min-width: 100px;"
                                    data-sort="joined">{{ __('Created at') }}</th>


                                <th class="align-middle no-sort"></th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($records as $index => $record)
                                <tr class="btn-reveal-trigger">


                                    <td class="phone align-middle white-space-nowrap py-2">{{ $index + 1 }}
                                    </td>



                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $record->statement }}
                                        <br>
                                        {{ $record->notes }}
                                    </td>


                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ $record->amount }}
                                    </td>



                                    <td class="joined align-middle py-2">{{ $record->created_at }} <br>
                                        {{ interval($record->created_at) }} </td>







                                    <td class="align-middle white-space-nowrap py-2 text-end">
                                        <div class="dropdown font-sans-serif position-static">
                                            <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal"
                                                type="button" id="customer-dropdown-0" data-bs-toggle="dropdown"
                                                data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                                                    class="fas fa-ellipsis-h fs--1"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end border py-0"
                                                aria-labelledby="customer-dropdown-0">
                                                <div class="bg-white py-2">


                                                    @if ($record->media_id != null)
                                                        <a class="dropdown-item" href="{{ asset($record->media->path) }}"
                                                            target="_blank"> {{ __('invoice image') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No data to show') }}</h3>
                @endif
            </div>
        </div>




    </div>
@endsection
