@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Add New') . ' ' . __('entry') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">


                <div class="col-md-12 d-flex flex-center">

                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('entries.quick.store') }}" enctype="multipart/form-data">
                            @csrf


                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="operation">{{ __('select the operation') }}</label>

                                    <select class="form-select operation @error('operation') is-invalid @enderror"
                                        aria-label="" name="operation" id="operation" required>
                                        <option value="">
                                            {{ __('select the operation') }}
                                        </option>
                                        @foreach ($operations as $operation)
                                            <option value="{{ $operation->id }}"
                                                {{ old('operation') == $operation->id ? 'selected' : '' }}>
                                                {{ getName($operation) }}
                                            </option>
                                        @endforeach
                                        <option value="sell_fixed_assets"
                                            {{ old('operation') == 'sell_fixed_assets' ? 'selected' : '' }}>
                                            {{ __('sell fixed assets') }}
                                        </option>
                                        <option value="purchase_fixed_assets"
                                            {{ old('operation') == 'purchase_fixed_assets' ? 'selected' : '' }}>
                                            {{ __('purchase fixed assets') }}
                                        </option>
                                        <option value="payment_receipts_purchases"
                                            {{ old('operation') == 'payment_receipts_purchases' ? 'selected' : '' }}>
                                            {{ __('payment receipts for purchases') }}
                                        </option>
                                        <option value="receipts_sales"
                                            {{ old('operation') == 'receipts_sales' ? 'selected' : '' }}>
                                            {{ __('receipts for sales') }}
                                        </option>

                                        <option value="pay_withdrawal_request"
                                            {{ old('operation') == 'pay_withdrawal_request' ? 'selected' : '' }}>
                                            {{ __('pay of withdrawal requests for vendors') }}
                                        </option>

                                        <option value="employee_loan"
                                            {{ old('operation') == 'employee_loan' ? 'selected' : '' }}>
                                            {{ __('employee loan') }}
                                        </option>

                                        <option value="petty_cash"
                                            {{ old('operation') == 'petty_cash' ? 'selected' : '' }}>
                                            {{ __('employee petty cash') }}
                                        </option>

                                        <option value="petty_cash_settlement"
                                            {{ old('operation') == 'petty_cash_settlement' ? 'selected' : '' }}>
                                            {{ __('employee petty cash settlement') }}
                                        </option>

                                        <option value="salary_card_proof"
                                            {{ old('operation') == 'salary_card_proof' ? 'selected' : '' }}>
                                            {{ __('proof of entitlement to the salary card') }}
                                        </option>

                                        <option value="salary_payment"
                                            {{ old('operation') == 'salary_payment' ? 'selected' : '' }}>
                                            {{ __('Payment of salary to employees') }}
                                        </option>





                                    </select>
                                    @error('operation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3 acc">
                                    <label class="form-label" for="type">{{ __('account type') }}</label>

                                    <select class="form-select acc-type @error('type') is-invalid @enderror" aria-label=""
                                        name="type" id="type" required>
                                        <option value="">
                                            {{ __('select account type') }}
                                        </option>
                                        <option value="cash_accounts"
                                            {{ old('type') == 'cash_accounts' ? 'selected' : '' }}>
                                            {{ __('cash account') }}
                                        </option>
                                        <option value="bank_accounts"
                                            {{ old('type') == 'bank_accounts' ? 'selected' : '' }}>
                                            {{ __('bank') }}
                                        </option>
                                        <option value="receipt_notes"
                                            {{ old('type') == 'receipt_notes' ? 'selected' : '' }}>
                                            {{ __('receipt notes') }}
                                        </option>
                                        <option value="payment_notes"
                                            {{ old('type') == 'payment_notes' ? 'selected' : '' }}>
                                            {{ __('payment notes') }}
                                        </option>

                                        <option value="deferred_suppliers"
                                            {{ old('type') == 'deferred_suppliers' ? 'selected' : '' }}>
                                            {{ __('deferred') }}
                                        </option>

                                        {{-- <option value="deferred_customers"
                                            {{ old('type') == 'deferred_customers' ? 'selected' : '' }}>
                                            {{ __('deferred customers') }}
                                        </option> --}}


                                    </select>
                                    @error('type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 employees mb-3">
                                    <label class="form-label" for="employees">{{ __('select employees') }}</label>
                                    <select
                                        class="form-select employees-field model-search @error('employees') is-invalid @enderror"
                                        data-url="{{ route('model.search') }}"
                                        data-salary_card_url="{{ route('employees.salary_cards') }}"
                                        data-salary_url="{{ route('employees.salary') }}"
                                        data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                        data-user_type="employees" data-type="admins" name="employees[]" multiple>
                                        <option value="">
                                            {{ __('select employees') }}</option>

                                    </select>
                                    @error('employees')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 salary_cards mb-3">
                                    <label class="form-label" for="salary_cards">{{ __('select salary card') }}</label>
                                    <select class="form-select salary_cards-field" name="salary_cards">
                                        <option value="">
                                            {{ __('select salary card') }}</option>

                                    </select>
                                    @error('salary_cards')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div style="display:none" class="col-md-6 salary mb-3">
                                    <label class="form-label" for="salary">{{ __('select salary') }}</label>
                                    <select class="form-select salary-field" name="salary">
                                        <option value="">
                                            {{ __('select salary') }}</option>

                                    </select>
                                    @error('salary')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 employee mb-3">
                                    <label class="form-label" for="employee">{{ __('select employee') }}</label>
                                    <select
                                        class="form-select employee-field model-search @error('employee') is-invalid @enderror"
                                        data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                        data-user_type="employees" data-type="admins" name="employee">
                                        <option value="">
                                            {{ __('select employee') }}</option>

                                    </select>
                                    @error('employee')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 petty_cash mb-3">
                                    <label class="form-label" for="petty_cash">{{ __('petty cash') }}</label>

                                    <input name="petty_cash"
                                        class="form-control petty_cash-field @error('petty_cash') is-invalid @enderror"
                                        value="{{ old('petty_cash') }}" data-url="{{ route('petty_cash.settlement') }}"
                                        data-locale="{{ app()->getLocale() }}" type="text" disabled autocomplete="on"
                                        id="petty_cash" required />

                                    @error('petty_cash')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 expenses_account mb-3">


                                    <label class="form-label"
                                        for="flash_news_ar">{{ __('please add expenses accounts') }}</label><br>
                                    <button href="javascript:void(0);" data-accounts="{{ $expenses_accounts }}"
                                        data-url="{{ route('entries.accounts') }}"
                                        data-locale="{{ app()->getLocale() }}"
                                        class="btn btn-outline-primary btn-sm add_expenses_account me-1 mb-1 mt-1"
                                        type="button">{{ __('add expenses account') }}
                                    </button>
                                    <div class="field_wrapper">

                                    </div>

                                </div>


                                <div style="display:none" class="col-md-6 suppliers mb-3">
                                    <label class="form-label" for="supplier">{{ __('select supplier') }}</label>
                                    <select
                                        class="form-select suppliers-field model-search @error('supplier') is-invalid @enderror"
                                        data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                        data-user_type="purchases" data-type="supplier" name="supplier">
                                        <option value="">
                                            {{ __('select supplier') }}</option>

                                    </select>
                                    @error('supplier')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 purchasesorders mb-3">
                                    <label class="form-label" for="order">{{ __('select document') }}</label>
                                    <select class="form-select purchasesorders-field"
                                        data-url="{{ route('model.search.orders') }}"
                                        data-locale="{{ app()->getLocale() }}" name="order">
                                        <option value="">
                                            {{ __('select document') }}</option>

                                    </select>
                                    @error('order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 customers mb-3">
                                    <label class="form-label" for="customer">{{ __('select customer') }}</label>
                                    <select
                                        class="form-select customers-field model-search @error('customer') is-invalid @enderror"
                                        data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                        data-user_type="sales" data-type="customer" name="customer">
                                        <option value="">
                                            {{ __('select customer') }}</option>

                                    </select>
                                    @error('customer')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 salesorders mb-3">
                                    <label class="form-label" for="order">{{ __('select document') }}</label>
                                    <select class="form-select salesorders-field"
                                        data-url="{{ route('model.search.orders') }}"
                                        data-locale="{{ app()->getLocale() }}" name="order">
                                        <option value="">
                                            {{ __('select document') }}</option>

                                    </select>
                                    @error('order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-6 withdrawals mb-3">
                                    <label class="form-label"
                                        for="withdrawal_id">{{ __('select withdrawal request') }}</label>
                                    <select class="form-select withdrawals-field"
                                        data-url="{{ route('model.search.orders') }}"
                                        data-locale="{{ app()->getLocale() }}" data-type="withdrawals"
                                        name="withdrawal_id">
                                        <option value="">
                                            {{ __('select withdrawal request') }}</option>

                                    </select>
                                    @error('withdrawal_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div style="display:none" class="col-md-7 fixedassets mb-3">
                                    <label class="form-label"
                                        for="fixed_asset">{{ __('select fixed asset account') }}</label>
                                    <select
                                        class="form-select fixedassets-field model-search @error('fixed_asset') is-invalid @enderror"
                                        data-url="{{ route('model.search') }}" data-locale="{{ app()->getLocale() }}"
                                        data-parent="" data-type="fixed_assets" name="fixed_asset">
                                        <option value="">
                                            {{ __('select fixed asset account') }}</option>

                                    </select>
                                    @error('fixed_asset')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3 operation_type">
                                    <label class="form-label" for="operation_type">{{ __('operation type') }}</label>

                                    <select
                                        class="form-select operation_type-field @error('operation_type') is-invalid @enderror"
                                        aria-label="" name="operation_type" id="operation_type" required>
                                        <option value="">
                                            {{ __('select operations type') }}
                                        </option>
                                        <option value="in" {{ old('operation_type') == 'in' ? 'selected' : '' }}>
                                            {{ __('IN') }}
                                        </option>
                                        <option value="out" {{ old('operation_type') == 'out' ? 'selected' : '' }}>
                                            {{ __('OUT') }}
                                        </option>
                                    </select>
                                    @error('operation_type')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-6 mb-3 amount">
                                    <label class="form-label" for="amount">{{ __('amount') }}</label>
                                    <input name="amount"
                                        class="form-control amount-field @error('description') is-invalid @enderror"
                                        value="{{ old('amount') }}" type="number" min="1" step="0.01"
                                        autocomplete="on" id="amount" required />
                                    @error('amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-12 mb-3 account">
                                    <label class="form-label" for="account">{{ __('select account') }}

                                        <span style="display:none"
                                            class="petty_cash_title">{{ ' - ' . __('To settle the remainder of the petty cash') }}</span>

                                    </label>
                                    <select class="form-select account-field acc-model-search"
                                        data-url="{{ route('model.search.accounts') }}"
                                        data-locale="{{ app()->getLocale() }}" data-parent=""
                                        data-type="quick_accounts" name="account" required>
                                        <option value="">
                                            {{ __('select account') }}</option>

                                    </select>
                                    @error('account')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>




                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="description">{{ __('entry description') }}</label>
                                    <input name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        value="{{ old('description') }}" type="text" autocomplete="on"
                                        id="description" />
                                    @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div style="display:none" class="col-md-12 mb-3 due-date">
                                    <label class="form-label" for="due_date">{{ __('due date') }}</label>
                                    <input type="datetime-local" id="due_date" name="due_date"
                                        class="form-control duedate-field @error('due_date') is-invalid @enderror"
                                        value="{{ old('due_date') }}">

                                    @error('due_date')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="doc_num">{{ __('document number') }}</label>
                                    <input name="doc_num" class="form-control @error('description') is-invalid @enderror"
                                        value="{{ old('doc_num') }}" type="number" min="1" autocomplete="on"
                                        id="doc_num" />
                                    @error('doc_num')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="image">{{ __('document image') }}</label>
                                    <input name="image" class="img form-control @error('image') is-invalid @enderror"
                                        type="file" id="image" required />
                                    @error('image')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                            </div>






                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="" style="width:100px; border: 1px solid #999"
                                        class="img-thumbnail img-prev">
                                </div>

                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Add New') . ' ' . __('entry') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
