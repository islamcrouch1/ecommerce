@if (!Route::is('purchases.show') && !Route::is('orders.show') && !Route::is('sales.show'))

    <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
        <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
                document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
        </script>
        <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">

                <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip"
                    data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span
                            class="toggle-line"></span></span></button>

            </div><a class="navbar-brand" href="{{ route('home') }}">
                <div class="d-flex align-items-center py-3 "><img class="me-2 admin-logo"
                        src="{{ asset(websiteSettingMedia('header_logo')) }}" alt="" width="150" />
                </div>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <div class="navbar-vertical-content scrollbar">
                <ul style="padding-bottom: 55px" class="navbar-nav flex-column mb-3" id="navbarVerticalNav">

                    @if (Auth::user()->hasRole('administrator|superadministrator'))



                        @if (checkPer(['users', 'roles']))


                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Users & Roles') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('users-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('users*') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Users') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('roles-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('roles*') ? 'active' : '' }}"
                                        href="{{ route('roles.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user-tag"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Roles') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>

                        @endif


                        @if (checkPer(['countries', 'states', 'cities', 'branches']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Countries && Shipping') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                @if (auth()->user()->hasPermission('countries-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('countries*') ? 'active' : '' }}"
                                        href="{{ route('countries.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-globe"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Countries') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('states-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('states*') ? 'active' : '' }}"
                                        href="{{ route('states.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-globe"></span></span><span
                                                class="nav-link-text ps-1">{{ __('states') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('cities-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('cities*') ? 'active' : '' }}"
                                        href="{{ route('cities.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-globe"></span></span><span
                                                class="nav-link-text ps-1">{{ __('cities') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('branches-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('branches*') ? 'active' : '' }}"
                                        href="{{ route('branches.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-globe"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Branches') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer(['medias']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Medias') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('medias-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('medias*') ? 'active' : '' }}"
                                        href="{{ route('medias.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-image"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Medias') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer(['carts', 'coupons', 'website_traffic', 'offers', 'testimonials']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Marketing') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('carts-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('user_carts*') ? 'active' : '' }}"
                                        href="{{ route('user_carts.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-shopping-cart"></span></span><span
                                                class="nav-link-text ps-1">{{ __('User\'s carts') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('coupons-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('coupons*') ? 'active' : '' }}"
                                        href="{{ route('coupons.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-money-bill"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Coupons') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('offers-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('offers.index*') ? 'active' : '' }}"
                                        href="{{ route('offers.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                                                <span class="fas fa-calendar-alt"></span></span><span
                                                class="nav-link-text ps-1">{{ __('offers') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('testimonials-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('testimonials.index*') ? 'active' : '' }}"
                                        href="{{ route('testimonials.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                                                <span class="fas fa-comments"></span></span><span
                                                class="nav-link-text ps-1">{{ __('testimonials') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('reviews-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('reviews.index*') ? 'active' : '' }}"
                                        href="{{ route('reviews.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                                                <span class="fas fa-comment"></span></span><span
                                                class="nav-link-text ps-1">{{ __('product reviews') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('website_traffic-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('admin.views*') ? 'active' : '' }}"
                                        href="{{ route('admin.views') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon">
                                                <span class="fas fa-chart-bar"></span></span><span
                                                class="nav-link-text ps-1">{{ __('website traffic') }}</span>
                                        </div>
                                    </a>
                                @endif



                            </li>
                        @endif


                        @if (checkPer(['crm']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('CRM') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('crm-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('clients*') ? 'active' : '' }}"
                                        href="{{ route('clients.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Clients') }}</span>
                                        </div>
                                    </a>
                                @endif
                            </li>

                        @endif



                        @if (auth()->user()->hasPermission('credit_management-read'))

                            @if (checkPer(['stages', 'previews_clients', 'previews']))

                                <li class="nav-item">
                                    <!-- label-->
                                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                        <!-- Orders -  -->
                                        <div class="col-auto navbar-vertical-label">{{ __('Credit Management') }}
                                        </div>
                                        <div class="col ps-0">
                                            <hr class="mb-0 navbar-vertical-divider" />
                                        </div>
                                    </div>
                                    @if (auth()->user()->hasPermission('stages-read'))
                                        <!-- parent pages--><a
                                            class="nav-link {{ Route::is('stages*') ? 'active' : '' }}"
                                            href="{{ route('stages.index') }}" role="button" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-credit-card"></span></span><span
                                                    class="nav-link-text ps-1">{{ __('stages') }}</span>
                                            </div>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('previews_clients-read'))
                                        <!-- parent pages--><a
                                            class="nav-link {{ Route::is('previews_clients*') ? 'active' : '' }}"
                                            href="{{ route('previews_clients.index') }}" role="button"
                                            data-bs-toggle="" aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-credit-card"></span></span><span
                                                    class="nav-link-text ps-1">{{ __('Clients') }}</span>
                                            </div>
                                        </a>
                                    @endif


                                    @if (auth()->user()->hasPermission('previews-read'))
                                        <!-- parent pages--><a
                                            class="nav-link {{ Route::is('previews*') ? 'active' : '' }}"
                                            href="{{ route('previews.index') }}" role="button" data-bs-toggle=""
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                        class="fas fa-credit-card"></span></span><span
                                                    class="nav-link-text ps-1">{{ __('Previews') }}</span>
                                            </div>
                                        </a>
                                    @endif

                                </li>
                            @endif

                        @endif



                        @if (checkPer(['settings', 'website_setting', 'slides', 'logs', 'messages', 'notifications', 'bonus']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Settings') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('settings-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('settings*') ? 'active' : '' }}"
                                        href="{{ route('settings.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-cogs"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Settings') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('website_setting-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('website-setting*') ? 'active' : '' }}"
                                        href="{{ route('website-setting.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-cogs"></span></span><span
                                                class="nav-link-text ps-1">{{ __('website setting') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('slides-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('slides*') ? 'active' : '' }}"
                                        href="{{ route('slides.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-images"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Slides') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('logs-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('logs*') ? 'active' : '' }}"
                                        href="{{ route('logs.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-file"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Logs') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('bonus-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('bonus*') ? 'active' : '' }}"
                                        href="{{ route('bonus.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-money-bill"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Bonus') }}</span>
                                        </div>
                                    </a>
                                @endif



                                @if (auth()->user()->hasPermission('messages-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('messages*') ? 'active' : '' }}"
                                        href="{{ route('messages.admin.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-comments"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Messages') }}</span>
                                        </div>
                                    </a>
                                @endif

                                <a class="nav-link {{ Route::is('notifications*') ? 'active' : '' }}"
                                    href="{{ route('notifications.index') }}" role="button" data-bs-toggle=""
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-bell"></span></span><span
                                            class="nav-link-text ps-1">{{ __('Notification') }}</span>
                                    </div>
                                </a>

                            </li>
                        @endif


                        @if (checkPer(['categories', 'brands', 'attributes', 'variations', 'products', 'vendor_products']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Products && categories') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('categories-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('categories*') ? 'active' : '' }}"
                                        href="{{ route('categories.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-sitemap"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Categories') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('brands-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('brands*') ? 'active' : '' }}"
                                        href="{{ route('brands.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-sitemap"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Brands') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('attributes-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('attributes*') ? 'active' : '' }}"
                                        href="{{ route('attributes.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-sitemap"></span></span><span
                                                class="nav-link-text ps-1">{{ __('attributes') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('variations-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('variations*') ? 'active' : '' }}"
                                        href="{{ route('variations.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-sitemap"></span></span><span
                                                class="nav-link-text ps-1">{{ __('variations') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('products-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('products*') ? 'active' : '' }}"
                                        href="{{ route('products.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-box-open"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Products') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('vendor_products-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('products.vendors*') ? 'active' : '' }}"
                                        href="{{ route('products.vendors') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-box-open"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Vendors Products') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer([
                                'warehouses',
                                'add_stock',
                                'stock_lists',
                                'stock_inventory',
                                'stock_transfers',
                                'stock_shortages',
                                'running_orders',
                            ]))
                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- users - roles - countries - settings -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Warehouses Management') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                @if (auth()->user()->hasPermission('warehouses-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('warehouses*') ? 'active' : '' }}"
                                        href="{{ route('warehouses.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-sitemap"></span></span><span
                                                class="nav-link-text ps-1">{{ __('warehouses') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('running_orders-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('running_orders*') ? 'active' : '' }}"
                                        href="{{ route('running_orders.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('running orders') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('add_stock-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('stock.management.add*') ? 'active' : '' }}"
                                        href="{{ route('stock.management.add') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Add Stock') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('stock_lists-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('stock.management.list*') ? 'active' : '' }}"
                                        href="{{ route('stock.management.list') }}" role="button"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Stocks Lists') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('stock_inventory-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('stock.management.inventory*') ? 'active' : '' }}"
                                        href="{{ route('stock.management.inventory') }}" role="button"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Stock Inventory') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('stock_transfers-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('stock_transfers.index*') ? 'active' : '' }}"
                                        href="{{ route('stock_transfers.index') }}" role="button"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Stock Transfers') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('stock_shortages-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('stock.management.index*') ? 'active' : '' }}"
                                        href="{{ route('stock.management.index') }}" role="button"
                                        data-bs-toggle="" aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-layer-group"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Stock Shortages') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif



                        @if (checkPer(['orders', 'vendor_orders']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Orders') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('orders-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('orders*') ? 'active' : '' }}"
                                        href="{{ route('orders.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-receipt"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Orders') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('orders-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('orders-vendor*') ? 'active' : '' }}"
                                        href="{{ route('orders-vendor') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-receipt"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Vendors Orders') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer(['purchases']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Purchases') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('purchases-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('purchases*') ? 'active' : '' }}"
                                        href="{{ route('purchases.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-receipt"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Purchases') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer(['sales']))


                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Sales') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('sales-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('sales*') ? 'active' : '' }}"
                                        href="{{ route('sales.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-receipt"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Sales') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>
                        @endif


                        @if (checkPer(['accounts', 'assets', 'entries', 'trial_balance', 'income_statement', 'balance_statement', 'taxes']))


                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Accounts') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('accounts-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('accounts*') ? 'active' : '' }}"
                                        href="{{ route('accounts.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Accounts') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('assets-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('assets*') ? 'active' : '' }}"
                                        href="{{ route('assets.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Assets Management') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('entries-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('entries.index*') ? 'active' : '' }}"
                                        href="{{ route('entries.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Entries') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('trial_balance-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('entries.trial*') ? 'active' : '' }}"
                                        href="{{ route('entries.trial') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Trial Balance') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('income_statement-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('entries.income*') ? 'active' : '' }}"
                                        href="{{ route('entries.income') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Income statement') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('balance_statement-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('entries.balance*') ? 'active' : '' }}"
                                        href="{{ route('entries.balance') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Balance sheet') }}</span>
                                        </div>
                                    </a>
                                @endif


                                @if (auth()->user()->hasPermission('taxes-read'))
                                    <!-- parent pages--><a class="nav-link {{ Route::is('taxes*') ? 'active' : '' }}"
                                        href="{{ route('taxes.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Taxes') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>

                        @endif


                        @if (checkPer(['withdrawals', 'orders_report']))

                            <li class="nav-item">
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <!-- Orders -  -->
                                    <div class="col-auto navbar-vertical-label">{{ __('Ecommerce') }}
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>
                                @if (auth()->user()->hasPermission('withdrawals-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('withdrawals*') ? 'active' : '' }}"
                                        href="{{ route('withdrawals.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Withdrawals Requests') }}</span>
                                        </div>
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('orders_report-read'))
                                    <!-- parent pages--><a
                                        class="nav-link {{ Route::is('finances*') ? 'active' : '' }}"
                                        href="{{ route('finances.index') }}" role="button" data-bs-toggle=""
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-credit-card"></span></span><span
                                                class="nav-link-text ps-1">{{ __('Orders Report') }}</span>
                                        </div>
                                    </a>
                                @endif

                            </li>

                        @endif

                    @endif

                    {{-- @if (Auth::user()->hasRole('affiliate'))
                    <li class="nav-item">
                        <!-- label-->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <!-- users - roles - countries - settings -->
                            <div class="col-auto navbar-vertical-label">{{ __('Products') }}
                            </div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider" />
                            </div>
                        </div>
                        <!-- parent pages-->
                        <a class="nav-link {{ Route::is('affiliate.products*') ? 'active' : '' }}"
                            href="{{ route('affiliate.products.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-box-open"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Products') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('mystore.show*') ? 'active' : '' }}"
                            href="{{ route('mystore.show') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-store"></span></span><span
                                    class="nav-link-text ps-1">{{ __('My Store') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('favorite*') ? 'active' : '' }}"
                            href="{{ route('favorite') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-heart"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Favorite') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('cart.*') ? 'active' : '' }}" href="{{ route('cart') }}"
                            role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-cart-plus"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Shopping Cart') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('shipping_rates.affiliate.*') ? 'active' : '' }}"
                            href="{{ route('shipping_rates.affiliate') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-truck"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Shipping Rates') }}</span>
                            </div>
                        </a>

                    </li>

                    <li class="nav-item">
                        <!-- label-->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <!-- users - roles - countries - settings -->
                            <div class="col-auto navbar-vertical-label">{{ __('Orders') }}
                            </div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider" />
                            </div>
                        </div>
                        <!-- parent pages-->
                        <a class="nav-link {{ Route::is('orders.affiliate*') ? 'active' : '' }}"
                            href="{{ route('orders.affiliate.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-receipt"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Orders') }}</span>
                            </div>
                        </a>



                    </li>

                    <li class="nav-item">
                        <!-- label-->
                        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                            <!-- users - roles - countries - settings -->
                            <div class="col-auto navbar-vertical-label">{{ __('Settings') }}
                            </div>
                            <div class="col ps-0">
                                <hr class="mb-0 navbar-vertical-divider" />
                            </div>
                        </div>
                        <!-- parent pages-->

                        <a class="nav-link {{ Route::is('withdrawals.user*') ? 'active' : '' }}"
                            href="{{ route('withdrawals.user.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-wallet"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Wallet') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('notifications*') ? 'active' : '' }}"
                            href="{{ route('notifications.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-bell"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Notification') }}</span>
                            </div>
                        </a>

                        <a class="nav-link {{ Route::is('messages*') ? 'active' : '' }}"
                            href="{{ route('messages.index') }}" role="button" data-bs-toggle=""
                            aria-expanded="false">
                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                        class="fas fa-comments"></span></span><span
                                    class="nav-link-text ps-1">{{ __('Messages') }}</span>
                            </div>
                        </a>
                    </li>
                @endif --}}

                    @if (Auth::user()->hasRole('vendor'))
                        <li class="nav-item">
                            <!-- label-->
                            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                <!-- users - roles - countries - settings -->
                                <div class="col-auto navbar-vertical-label">{{ __('Products') }}
                                </div>
                                <div class="col ps-0">
                                    <hr class="mb-0 navbar-vertical-divider" />
                                </div>
                            </div>
                            <!-- parent pages-->
                            <a class="nav-link {{ Route::is('vendor-products*') ? 'active' : '' }}"
                                href="{{ route('vendor-products.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                            class="fas fa-box-open"></span></span><span
                                        class="nav-link-text ps-1">{{ __('Products') }}</span>
                                </div>
                            </a>

                        </li>

                        <li class="nav-item">
                            <!-- label-->
                            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                <!-- users - roles - countries - settings -->
                                <div class="col-auto navbar-vertical-label">{{ __('Orders') }}
                                </div>
                                <div class="col ps-0">
                                    <hr class="mb-0 navbar-vertical-divider" />
                                </div>
                            </div>
                            <!-- parent pages-->
                            <a class="nav-link {{ Route::is('vendor.orders*') ? 'active' : '' }}"
                                href="{{ route('vendor.orders.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                            class="fas fa-receipt"></span></span><span
                                        class="nav-link-text ps-1">{{ __('Orders') }}</span>
                                </div>
                            </a>



                        </li>

                        <li class="nav-item">
                            <!-- label-->
                            <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                <!-- users - roles - countries - settings -->
                                <div class="col-auto navbar-vertical-label">{{ __('Settings') }}
                                </div>
                                <div class="col ps-0">
                                    <hr class="mb-0 navbar-vertical-divider" />
                                </div>
                            </div>
                            <!-- parent pages-->

                            <a class="nav-link {{ Route::is('withdrawals.user*') ? 'active' : '' }}"
                                href="{{ route('withdrawals.user.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                            class="fas fa-wallet"></span></span><span
                                        class="nav-link-text ps-1">{{ __('Wallet') }}</span>
                                </div>
                            </a>

                            <a class="nav-link {{ Route::is('notifications*') ? 'active' : '' }}"
                                href="{{ route('notifications.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                            class="fas fa-bell"></span></span><span
                                        class="nav-link-text ps-1">{{ __('Notification') }}</span>
                                </div>
                            </a>

                            <a class="nav-link {{ Route::is('messages*') ? 'active' : '' }}"
                                href="{{ route('messages.index') }}" role="button" data-bs-toggle=""
                                aria-expanded="false">
                                <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                            class="fas fa-comments"></span></span><span
                                        class="nav-link-text ps-1">{{ __('Messages') }}</span>
                                </div>
                            </a>
                        </li>
                    @endif

                </ul>

            </div>
        </div>
    </nav>

@endif
