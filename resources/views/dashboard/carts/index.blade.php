@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-2 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('User\'s carts') }}
                    </h5>
                </div>

                <div class="col-10 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        <form id="filter-form" style="display: inline-block" action="">


                            <div class="d-inline-block">
                                <select name="country_id" class="form-select form-select-sm sonoo-search"
                                    id="autoSizingSelect">
                                    <option value="" selected>{{ __('All Countries') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ request()->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                        </form>


                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($users->count() > 0)
                    <table class="table table-sm table-striped fs--1 mb-0 overflow-hidden">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="name">
                                    {{ __('Name') }}</th>
                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Phone') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('Cart Total') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                    {{ __('products') }}</th>

                                <th class="sort pe-1 align-middle white-space-nowrap" data-sort="phone">
                                </th>

                            </tr>
                        </thead>
                        <tbody class="list" id="table-customers-body">
                            @foreach ($users as $user)
                                <tr class="btn-reveal-trigger">


                                    <td class="name align-middle white-space-nowrap py-2"><a
                                            href="{{ route('users.show', ['user' => $user->id]) }}">
                                            <div class="d-flex d-flex align-items-center">
                                                <div class="avatar avatar-xl me-2">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $user->profile) }}"
                                                        alt="" />
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="mb-0 fs--1">{{ $user->name }} <br>

                                                    </h5>

                                                </div>
                                            </div>
                                        </a></td>
                                    <td class="phone align-middle white-space-nowrap py-2"><a
                                            href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>

                                    @php
                                        $cart_items = getCartItems($user);
                                    @endphp

                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {{ getCartSubtotal($cart_items) . $user->country->currency }} </td>

                                    <td class="phone align-middle white-space-nowrap py-2"><button href=""
                                            class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#products-modal-{{ $user->id }}"
                                            class="btn btn-falcon-info btn-sm me-1 mb-1">{{ $cart_items->count() }}
                                        </button></td>


                                    <td class="phone align-middle white-space-nowrap py-2">
                                        {!! getWhatsappCart($user) !!}
                                    </td>
                                </tr>




                                <!-- start order track modal for each order -->
                                <div class="modal fade" id="products-modal-{{ $user->id }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document"
                                        style="max-width: 500px">
                                        <div class="modal-content position-relative">
                                            <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                <button
                                                    class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                                                    <h4 class="mb-1" id="modalExampleDemoLabel">
                                                        {{ __('products') . ' #' . $user->id }}
                                                    </h4>
                                                </div>
                                                <div class="m-2">
                                                    @if ($cart_items->count() > 0)
                                                        <ul class="list-group">

                                                            @foreach ($cart_items as $item)
                                                                <li class="list-group-item">
                                                                    <div class="row">
                                                                        <div class="col-md-5">

                                                                            <div class="d-flex d-flex align-items-center">
                                                                                <div class="avatar avatar-xl me-2">
                                                                                    <img class="rounded-circle"
                                                                                        src="{{ asset($item->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $item->product->images[0]->media->path) }}"
                                                                                        alt="" />
                                                                                </div>
                                                                                <div class="flex-1">
                                                                                    <h5 class="mb-0 fs--1">
                                                                                        {{ getProductName($item->product, $item->combination) }}
                                                                                    </h5>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            {{ productPrice($item->product, $item->product_combination_id, 'vat') . $user->country->currency }}
                                                                        </div>
                                                                        <div class="col-md-1">{{ $item->qty }}</div>
                                                                        <div class="col-md-3">
                                                                            {{ productPrice($item->product, $item->product_combination_id, 'vat') * $item->qty . $user->country->currency }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <h3 class="p-4">{{ __('No products To Show') }}</h3>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end order track modal for each user -->
                            @endforeach
                        </tbody>

                    </table>
                @else
                    <h3 class="p-4">{{ __('No Data To Show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $users->appends(request()->query())->links() }}
        </div>

    </div>
@endsection
