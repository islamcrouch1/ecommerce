@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">{{ __('Edit role') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('roles.update', ['role' => $role->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name">{{ __('role name') }}</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $role->name }}" type="text" autocomplete="on" id="name" autofocus
                                    required />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">{{ __('role description') }}</label>
                                <input name="description" class="form-control @error('description') is-invalid @enderror"
                                    value="{{ $role->description }}" type="text" autocomplete="on" id="description"
                                    autofocus required />
                                @error('description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="code">{{ __('Permissions') }}</label>

                                <div class="table-responsive scrollbar">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('Module') }}</th>
                                                <th scope="col">{{ __('Permissions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $models = [
                                                    'users',
                                                    'roles',
                                                    'settings',
                                                    'countries',
                                                    'categories',
                                                    'orders',
                                                    'vendor_orders',
                                                    'products',
                                                    'shipping_rates',
                                                    'withdrawals',
                                                    'notes',
                                                    'queries',
                                                    'messages',
                                                    'orders_report',
                                                    'slides',
                                                    'orders_notes',
                                                    'logs',
                                                    'bonus',
                                                    'warehouses',
                                                    'add_stock',
                                                    'stock_lists',
                                                    'stock_inventory',
                                                    'stock_transfers',
                                                    'stock_shortages',
                                                    'running_orders',
                                                    'brands',
                                                    'attributes',
                                                    'variations',
                                                    'website_setting',
                                                    'states',
                                                    'cities',
                                                    'shipping_methods',
                                                    'medias',
                                                    'accounts',
                                                    'taxes',
                                                    'petty_cash',
                                                    'entries',
                                                    'quick_entries',
                                                    'purchases',
                                                    'income_statement',
                                                    'sales',
                                                    'branches',
                                                    'credit_management',
                                                    'stages',
                                                    'previews',
                                                    'previews_clients',
                                                    'previews_score',
                                                    'assets',
                                                    'cash_accounts',
                                                    'accounting_operations',
                                                    'balance_statement',
                                                    'crm',
                                                    'vendor_products',
                                                    'trial_balance',
                                                    'payments',
                                                    'coupons',
                                                    'carts',
                                                    'website_traffic',
                                                    'offers',
                                                    'testimonials',
                                                    'reviews',
                                                    'installment_companies',
                                                    'installment_requests',
                                                    'shipping_companies',
                                                    'employees',
                                                    'attendances',
                                                    'rewards',
                                                    'payroll',
                                                    'employee_permissions',
                                                    'contacts',
                                                    'units_categories',
                                                    'units',
                                                    'boms',
                                                    'manufacturing_orders',
                                                    'quotations',
                                                    'rfq',
                                                    'currencies',
                                                    'exchange_rates',
                                                    'invoices',
                                                ];
                                                $models_ar = [
                                                    'المستخدمين',
                                                    'الصلاحيات',
                                                    'الاعدادات',
                                                    'الدول',
                                                    'الأقسام ',
                                                    'الطلبات',
                                                    'طلبات التجار',
                                                    'المنتجات',
                                                    'أسعار الشحن',
                                                    'طلبات سحب الرصيد',
                                                    'الملاحظات',
                                                    'الاستفسارات',
                                                    'الرسائل والدعم',
                                                    'تقرير الطلبات',
                                                    'سلايدر',
                                                    'ملاحظات الاوردرات',
                                                    'سجل الأنشطة',
                                                    'البونص',
                                                    'المخازن',
                                                    'أضافة مخزون',
                                                    'سجلات المخزون',
                                                    'جرد المخزون',
                                                    'تحويلات المخزون',
                                                    'نواقص المخزون',
                                                    'اوامر تشعيل المخازن',
                                                    'العلامات التجارية',
                                                    'سمات المنتجات',
                                                    'متغيرات المنتجات',
                                                    'اعدادات الموقع',
                                                    'المحافظات',
                                                    'المدن',
                                                    'طرق الشحن',
                                                    'الوسائط',
                                                    'الحسابات',
                                                    'الضرائب',
                                                    'العهد',
                                                    'القيود اليومية',
                                                    'القيود السريعة',
                                                    'المشتريات',
                                                    'قوائم الدخل',
                                                    'المبيعات',
                                                    'الفروع',
                                                    'ادارة الائتمان',
                                                    'مراحل المعاينات',
                                                    'المعاينات',
                                                    'عملاء المعاينات',
                                                    'نتيجة المعاينات',
                                                    'ادارة الاصول',
                                                    'حسابات الخزينة',
                                                    'العمليات المحاسبية',
                                                    'الميزانية العمومية',
                                                    'ادارة العملاء',
                                                    'منتجات التجار',
                                                    'ميزان المراجعة',
                                                    'الدفغ',
                                                    'الكوبونات',
                                                    'سلات التسوق',
                                                    'زوار الموقع الالكتروني',
                                                    'العروض',
                                                    'اراء العملاء',
                                                    'تقييمات المنتجات',
                                                    'شركات التقسيط',
                                                    'طلبات التقسيط',
                                                    'شركات الشحن',
                                                    'الموظفين',
                                                    'الحضور والانصراف',
                                                    'المكافآت',
                                                    'كشف الرواتب',
                                                    'اذونات الموظفين',
                                                    'تواصل معنا',
                                                    'اقسام وحدات القياس',
                                                    'وحدات القياس',
                                                    'قائمة مكونات المواد',
                                                    'اوامر التصنيع',
                                                    'عروض الاسعار',
                                                    'طلبات عروض الاسعار',
                                                    'العملات',
                                                    'اسعار الصرف',
                                                    'الفواتير',
                                                ];
                                            @endphp

                                            @foreach ($models as $index => $model)
                                                <tr>
                                                    <td>{{ app()->getLocale() == 'ar' ? $models_ar[$index] : $model }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $permissions_maps = ['create', 'update', 'read', 'delete', 'trash', 'restore'];
                                                            $permissions_maps_ar = ['انشاء', 'تعديل', 'مشاهدة', 'حذف نهائي', 'حذف مؤقت', 'استعادة'];
                                                        @endphp

                                                        @if ($model == 'settings')
                                                            @php
                                                                $permissions_maps = ['read', 'update'];
                                                                $permissions_maps_ar = ['مشاهدة', 'تعديل'];
                                                            @endphp
                                                        @endif
                                                        <div class="mb-3">
                                                            <select
                                                                class="form-select @error('permissions') is-invalid @enderror js-choice"
                                                                name="permissions[]" multiple="multiple"
                                                                data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                @foreach ($permissions_maps as $index => $permissions_map)
                                                                    <option
                                                                        {{ $role->hasPermission($model . '-' . $permissions_map) ? 'selected' : '' }}
                                                                        value="{{ $model . '-' . $permissions_map }}">
                                                                        {{ app()->getLocale() == 'ar' ? $permissions_maps_ar[$index] : $permissions_map }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('permissions')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Edit role') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
