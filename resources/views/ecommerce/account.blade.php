@extends('layouts.ecommerce.app')
@section('content')
    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="page-title">
                        <h2>{{ __('My Account') }}</h2>
                    </div>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb" class="theme-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('ecommerce.home') }}">{{ __('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('My Account') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb End -->


    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="dashboard-sidebar">
                        <div class="profile-top">
                            <div class="profile-image">
                                <img src="{{ asset('e-assets/images/avtar.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="profile-detail">
                                <h5>{{ $user->name }}</h5>
                                <h6>{{ $user->phone }}</h6>
                            </div>
                        </div>
                        <div class="faq-tab">
                            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#info"
                                        class="nav-link active">{{ __('My Account') }}</a></li>
                                {{-- <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#address"
                                        class="nav-link">Address Book</a></li> --}}
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#orders"
                                        class="nav-link">{{ __('My Orders') }}</a></li>
                                <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#wishlist" class="nav-link">
                                        {{ __('Wishlist') }}</a></li>
                                {{-- <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#payment"
                                        class="nav-link">Saved Cards</a></li> --}}
                                {{-- <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#profile"
                                        class="nav-link">Profile</a></li> --}}
                                {{-- <li class="nav-item"><a data-bs-toggle="tab" data-bs-target="#security"
                                        class="nav-link">Security</a> </li> --}}
                                <li class="nav-item"><a data-bs-toggle="modal" data-bs-target="#logout" class="nav-link">
                                        {{ __('Log Out') }}
                                    </a> </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <div class="tab-pane fade show active" id="info">
                            <div class="counter-section">
                                <div class="welcome-msg">
                                    <h4>{{ __('Hello,') . ' ' . $user->name }}</h4>
                                    <p>{{ __('From your account, you have the ability to view your recent account activity and update your account information. ') }}
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('e-assets/images/icon/dashboard/sale.png') }}"
                                                class="img-fluid">
                                            <div>
                                                <h3>{{ $orders->count() }}</h3>
                                                <h5>{{ __('Total Order') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('e-assets/images/icon/dashboard/homework.png') }}"
                                                class="img-fluid">
                                            <div>
                                                <h3>{{ $orders->where('status', 'pending')->count() }}</h3>
                                                <h5>{{ __('Pending Orders') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="counter-box">
                                            <img src="{{ asset('e-assets/images/icon/dashboard/order.png') }}"
                                                class="img-fluid">
                                            <div>
                                                <h3>{{ getFavs()->count() }}</h3>
                                                <h5>{{ __('Wishlist') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-account box-info">
                                    <div class="box-head">
                                        <h4>{{ __('Account Information') }}</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="box">
                                                <div class="box-title">
                                                    <h3>{{ __('Login Information') }}</h3>
                                                </div>
                                                <div class="box-content">
                                                    <h6>{{ $user->name }}</h6>
                                                    <h6>{{ __('phone:') . ' ' . $user->phone }}</h6>
                                                    <h6>
                                                        <a href="" data-bs-toggle="modal"
                                                            data-bs-target="#change_password" class="nav-link">
                                                            {{ __('Change Password') }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="box">
                                                <div class="box-title">
                                                    <h3>Newsletters</h3><a href="#">Edit</a>
                                                </div>
                                                <div class="box-content">
                                                    <p>You are currently not subscribed to any newsletter.</p>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="box mt-3">
                                        <div class="box-title">
                                            <h3>Address Book</h3><a href="#">Manage Addresses</a>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6>Default Billing Address</h6>
                                                <address>You have not set a default billing address.<br><a
                                                        href="#">Edit
                                                        Address</a></address>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6>Default Shipping Address</h6>
                                                <address>You have not set a default shipping address.<br><a
                                                        href="#">Edit Address</a></address>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="address">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Address Book</h3>
                                                <a href="#" class="btn btn-sm btn-solid">+ add new</a>
                                            </div>
                                            <div class="address-book-section">
                                                <div class="row g-4">
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>mark jecno <span>home</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>549 Sulphur Springs Road</p>
                                                                    <p>Downers Grove, IL</p>
                                                                    <p>60515</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>mobile: <span>+91 123 - 456 - 7890</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)" data-bs-target="#edit-address"
                                                                    data-bs-toggle="modal" class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="top">
                                                                <h6>mark jecno <span>office</span></h6>
                                                            </div>
                                                            <div class="middle">
                                                                <div class="address">
                                                                    <p>549 Sulphur Springs Road</p>
                                                                    <p>Downers Grove, IL</p>
                                                                    <p>60515</p>
                                                                </div>
                                                                <div class="number">
                                                                    <p>mobile: <span>+91 123 - 456 - 7890</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address" data-bs-toggle="modal"
                                                                    class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="tab-pane fade" id="orders">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card dashboard-table mt-0">
                                        <div class="card-body table-responsive-sm">
                                            <div class="top-sec">
                                                <h3>{{ __('My Orders') }}</h3>
                                            </div>
                                            <div class="table-responsive-xl">
                                                <table class="table cart-table order-table">
                                                    <thead>
                                                        <tr class="table-head">
                                                            {{-- <th scope="col">image</th> --}}
                                                            <th scope="col">{{ __('Order Id') }}</th>
                                                            {{-- <th scope="col">Product Details</th> --}}
                                                            <th scope="col">{{ __('Status') }}</th>
                                                            <th scope="col">{{ __('Price') }}</th>
                                                            <th scope="col">{{ __('View') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($orders as $order)
                                                            <tr>
                                                                {{-- <td>
                                                                    <a href="javascript:void(0)">
                                                                        <img src="../assets/images/pro3/1.jpg"
                                                                            class="blur-up lazyloaded" alt="">
                                                                    </a>
                                                                </td> --}}
                                                                <td>
                                                                    <span class="mt-0">#{{ $order->id }}</span>
                                                                </td>
                                                                {{-- <td>
                                                                    <span class="fs-6">Purple polo tshirt</span>
                                                                </td> --}}
                                                                <td>
                                                                    {!! orderStatus($order->status) !!}
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="theme-color fs-6">{{ $order->total_price . $order->country->currency }}</span>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('ecommerce.invoice', ['order' => $order->id]) }}"
                                                                        target="_blank">
                                                                        <i class="fa fa-eye text-theme"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="wishlist">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card dashboard-table mt-0">
                                        <div class="card-body table-responsive-sm">
                                            <div class="top-sec">
                                                <h3>{{ __('Wishlist') }}</h3>
                                            </div>
                                            <div class="table-responsive-xl">
                                                <table class="table cart-table wishlist-table">
                                                    <thead>
                                                        <tr class="table-head">
                                                            <th scope="col">{{ __('image') }}</th>
                                                            <th scope="col">{{ __('product') }}</th>
                                                            <th scope="col">{{ __('Action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach (getFavs() as $fav)
                                                            <tr>
                                                                <td>
                                                                    <a href="javascript:void(0)">
                                                                        <img src="{{ asset($fav->product->images->count() == 0 ? 'public/images/products/place-holder.jpg' : $fav->product->images[0]->media->path) }}"
                                                                            class="blur-up lazyloaded" alt="">
                                                                    </a>
                                                                </td>

                                                                <td>
                                                                    <span>{{ app()->getLocale() == 'ar' ? $fav->product->name_ar : $fav->product->name_en }}
                                                                    </span>
                                                                </td>

                                                                <td>
                                                                    <a href="{{ route('ecommerce.product', ['product' => $fav->product->id]) }}"
                                                                        class="btn btn-xs btn-solid">
                                                                        {{ __('View') }}
                                                                    </a>
                                                                    <a href="{{ route('ecommerce.fav.add', ['product' => $fav->product->id]) }}"
                                                                        class="btn btn-xs  btn-danger">
                                                                        {{ __('remove') }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach




                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="top-sec">
                                                <h3>Saved Cards</h3>
                                                <a href="#" class="btn btn-sm btn-solid">+ add new</a>
                                            </div>
                                            <div class="address-book-section">
                                                <div class="row g-4">
                                                    <div class="select-box active col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="bank-logo">
                                                                <img src="../assets/images/bank-logo.png"
                                                                    class="bank-logo">
                                                                <img src="../assets/images/visa.png" class="network-logo">
                                                            </div>
                                                            <div class="card-number">
                                                                <h6>Card Number</h6>
                                                                <h5>6262 6126 2112 1515</h5>
                                                            </div>
                                                            <div class="name-validity">
                                                                <div class="left">
                                                                    <h6>name on card</h6>
                                                                    <h5>Mark Jecno</h5>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>validity</h6>
                                                                    <h5>XX/XX</h5>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address" data-bs-toggle="modal"
                                                                    class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="select-box col-xl-4 col-md-6">
                                                        <div class="address-box">
                                                            <div class="bank-logo">
                                                                <img src="../assets/images/bank-logo1.png"
                                                                    class="bank-logo">
                                                                <img src="../assets/images/visa.png" class="network-logo">
                                                            </div>
                                                            <div class="card-number">
                                                                <h6>Card Number</h6>
                                                                <h5>6262 6126 2112 1515</h5>
                                                            </div>
                                                            <div class="name-validity">
                                                                <div class="left">
                                                                    <h6>name on card</h6>
                                                                    <h5>Mark Jecno</h5>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>validity</h6>
                                                                    <h5>XX/XX</h5>
                                                                </div>
                                                            </div>
                                                            <div class="bottom">
                                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#edit-address" data-bs-toggle="modal"
                                                                    class="bottom_btn">edit</a>
                                                                <a href="#" class="bottom_btn">remove</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="dashboard-box">
                                                <div class="dashboard-title">
                                                    <h4>profile</h4>
                                                    <a class="edit-link" href="#">edit</a>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <ul>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>company name</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>Fashion Store</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>email address</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>mark.jecno@gmail.com</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Country / Region</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>Downers Grove, IL</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Year Established</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>2018</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Total Employees</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>101 - 200 People</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>category</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>clothing</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>street address</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>549 Sulphur Springs Road</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>city/state</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>Downers Grove, IL</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>zip</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>60515</h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="dashboard-title mt-lg-5 mt-3">
                                                    <h4>login details</h4>
                                                    <a class="edit-link" href="#">edit</a>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <ul>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Email Address</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>mark.jecno@gmail.com <a class="edit-link"
                                                                            href="#">edit</a></h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Phone No.</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>+01 4485 5454<a class="edit-link"
                                                                            href="#">Edit</a></h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="details">
                                                                <div class="left">
                                                                    <h6>Password</h6>
                                                                </div>
                                                                <div class="right">
                                                                    <h6>******* <a class="edit-link"
                                                                            href="#">Edit</a>
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="security">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="dashboard-box">
                                                <div class="dashboard-title">
                                                    <h4>settings</h4>
                                                </div>
                                                <div class="dashboard-detail">
                                                    <div class="account-setting">
                                                        <h5>Notifications</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios1" value="option1" checked>
                                                                    <label class="form-check-label" for="exampleRadios1">
                                                                        Allow Desktop Notifications
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios2" value="option2">
                                                                    <label class="form-check-label" for="exampleRadios2">
                                                                        Enable Notifications
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios3" value="option3">
                                                                    <label class="form-check-label" for="exampleRadios3">
                                                                        Get notification for my own activity
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios"
                                                                        id="exampleRadios4" value="option4">
                                                                    <label class="form-check-label" for="exampleRadios4">
                                                                        DND
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account-setting">
                                                        <h5>deactivate account</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios4" value="option4" checked>
                                                                    <label class="form-check-label" for="exampleRadios4">
                                                                        I have a privacy concern
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios5" value="option5">
                                                                    <label class="form-check-label" for="exampleRadios5">
                                                                        This is temporary
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios1"
                                                                        id="exampleRadios6" value="option6">
                                                                    <label class="form-check-label" for="exampleRadios6">
                                                                        other
                                                                    </label>
                                                                </div>
                                                                <button type="button"
                                                                    class="btn btn-solid btn-xs">Deactivate
                                                                    Account</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account-setting">
                                                        <h5>Delete account</h5>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios3"
                                                                        id="exampleRadios7" value="option7" checked>
                                                                    <label class="form-check-label" for="exampleRadios7">
                                                                        No longer usable
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios3"
                                                                        id="exampleRadios8" value="option8">
                                                                    <label class="form-check-label" for="exampleRadios8">
                                                                        Want to switch on other account
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="radio_animated form-check-input"
                                                                        type="radio" name="exampleRadios3"
                                                                        id="exampleRadios9" value="option9">
                                                                    <label class="form-check-label" for="exampleRadios9">
                                                                        other
                                                                    </label>
                                                                </div>
                                                                <button type="button" class="btn btn-solid btn-xs">Delete
                                                                    Account</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  dashboard section end -->


    <!-- Modal start -->
    <div class="modal logout-modal fade" id="logout" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Logging Out') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Do you want to log out?') }}
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-dark btn-custom" data-bs-dismiss="modal">{{ __('no') }}</a>
                    {{-- <a href="" class="btn btn-solid btn-custom">{{__('yes')}}</a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-solid btn-custom" href="{{ route('logout') }}" data-bs-toggle="modal"
                            onclick="event.preventDefault();
                        this.closest('form').submit();"
                            data-bs-target="#exampleModal">{{ __('yes') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- modal end -->



    <!-- Modal start -->
    <div class="modal logout-modal fade" id="change_password" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="POST" action="{{ route('ecommerce.password.change') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('Change Password') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <div class="field-label">{{ __('Old password') }}</div>
                            <input class="form-control  @error('old_password') is-invalid @enderror" type="password"
                                autocomplete="on" id="old_password" name="old_password" required />
                            @error('old_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                            <div class="field-label">{{ __('Password') }}</div>
                            <input class="form-control  @error('password') is-invalid @enderror" type="password"
                                autocomplete="on" id="password" name="password" required />
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-12 col-sm-12 col-xs-12 ">
                            <div class="field-label">{{ __('Confirm Password') }}</div>
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" autocomplete="on" id="password_confirmation"
                                name="password_confirmation" required />
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-dark btn-custom"
                            data-bs-dismiss="modal">{{ __('close') }}</a>

                        <button type="submit" class="btn btn-solid btn-custom"
                            data-bs-toggle="modal">{{ __('change') }}
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- modal end -->
@endsection
