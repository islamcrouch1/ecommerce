@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Sell Asset') . ' - ' . getName($account) }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('assets.sell', ['account' => $account->id]) }}"
                            enctype="multipart/form-data">
                            @csrf



                            <div style="display:none" class="div-data" data-url="{{ route('entries.accounts') }}"
                                data-locale="{{ app()->getLocale() }}"></div>

                            <div class="mb-3">
                                <label class="form-label" for="price">{{ __('Enter sell price') }}</label>
                                <input name="price" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" type="number" step="0.01" autocomplete="on"
                                    id="price" autofocus required />
                                @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>






                            <div class="mb-3">
                                <label class="form-label" for="account_id">{{ __('select cash account') }}</label>

                                <select class="form-select @error('account_id') is-invalid @enderror" aria-label=""
                                    name="account_id" id="account_id">

                                    <option value="">{{ __('select cash account') }}
                                    </option>

                                    @foreach (getCashAccounts() as $account)
                                        <option value="{{ $account->id }}">
                                            {{ getName($account) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('account_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('entry description') }}</label>
                                <input name="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('description') }}" type="text" autocomplete="on" id="description"
                                    required />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="doc_num">{{ __('document number') }}</label>
                                <input name="doc_num" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ old('doc_num') }}" type="number" min="1" autocomplete="on"
                                    id="doc_num" />
                                @error('doc_num')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="image">{{ __('document image') }}</label>
                                <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" required />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="" style="width:100px; border: 1px solid #999"
                                        class="img-thumbnail img-prev">
                                </div>

                            </div>



                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Sell') . ' ' . __('asset') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
