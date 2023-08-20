@extends('layouts.dashboard.app')

@section('adminContent')


    @if (Auth::user()->hasRole('affiliate') || Auth::user()->hasRole('vendor'))
        <div class="card mb-3">
            <form method="POST" action="{{ route('user.store.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-header position-relative min-vh-25 mb-7">

                    <div class="cover-image">
                        <div class="bg-holder rounded-3 rounded-bottom-0 img-prev-cover"
                            style="background-image:url({{ getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->store_cover != null ? getMediaPath(getUserInfo(Auth::user())->store_cover) : asset('assets/img/store_cover.jpg') }});">
                        </div>
                        <!--/.bg-holder-->

                        <input name="store_cover" class="d-none cover" id="upload-cover-image" type="file" />
                        <label class="cover-image-file-input" for="upload-cover-image"><span
                                class="fas fa-camera me-2"></span><span>{{ __('Change cover photo') }}</span></label>
                    </div>
                    <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                        <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                                src="{{ getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->store_profile != null ? getMediaPath(getUserInfo(Auth::user())->store_profile) : asset('storage/images/users/' . $user->profile) }}"
                                width="200" alt="" data-dz-thumbnail="data-dz-thumbnail" class="img-prev" />
                            <input name="store_profile" class="d-none img" id="profile-image" type="file" />
                            <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image"><span
                                    class="bg-holder overlay overlay-0"></span><span
                                    class="z-index-1 text-white dark__text-white text-center fs--1"><span
                                        class="fas fa-camera"></span><span class="d-block">Update</span></span></label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="mb-3">
                                <label class="form-label" for="store_name">{{ __('Your store name') }}</label>
                                <input name="store_name" class="form-control @error('store_name') is-invalid @enderror"
                                    value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->store_name : '' }}"
                                    type="text" autocomplete="on" id="store_name" />
                                @error('store_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="store_description">{{ __('Your store description') }}</label>
                                <textarea name="store_description" class="form-control @error('store_description') is-invalid @enderror" type="text"
                                    id="store_description">{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->store_description : '' }}</textarea>
                                @error('store_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label"
                                    for="commercial_record">{{ __('commercial record photo') }}</label>
                                <input name="commercial_record"
                                    class="img form-control @error('commercial_record') is-invalid @enderror" type="file"
                                    id="commercial_record" />
                                @error('commercial_record')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->commercial_record != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo(Auth::user())->commercial_record) }}"
                                            target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo(Auth::user())->commercial_record) }}"
                                                style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                        </a>
                                    </div>
                                </div>
                            @endif



                            <div class="mb-3">
                                <label class="form-label" for="tax_card">{{ __('tax card photo') }}</label>
                                <input name="tax_card" class="img form-control @error('tax_card') is-invalid @enderror"
                                    type="file" id="tax_card" />
                                @error('tax_card')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->tax_card != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo(Auth::user())->tax_card) }}" target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo(Auth::user())->tax_card) }}"
                                                style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="id_card_front">{{ __('ID card front') }}</label>
                                <input name="id_card_front"
                                    class="img form-control @error('id_card_front') is-invalid @enderror" type="file"
                                    id="id_card_front" />
                                @error('id_card_front')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->id_card_front != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo(Auth::user())->id_card_front) }}"
                                            target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo(Auth::user())->id_card_front) }}"
                                                style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="id_card_back">{{ __('ID card back') }}</label>
                                <input name="id_card_back"
                                    class="img form-control @error('id_card_back') is-invalid @enderror" type="file"
                                    id="id_card_back" />
                                @error('id_card_back')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            @if (getUserInfo(Auth::user()) != null && getUserInfo(Auth::user())->id_card_back != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo(Auth::user())->id_card_back) }}"
                                            target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo(Auth::user())->id_card_back) }}"
                                                style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="bank_account">{{ __('bank account number') }}</label>
                                <input name="bank_account"
                                    class="form-control @error('bank_account') is-invalid @enderror"
                                    value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->bank_account : '' }}"
                                    type="text" autocomplete="on" id="bank_account" />
                                @error('bank_account')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="company_address">{{ __('company address') }}</label>
                                <input name="company_address"
                                    class="form-control @error('company_address') is-invalid @enderror"
                                    value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->company_address : '' }}"
                                    type="text" autocomplete="on" id="company_address" />
                                @error('company_address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="website">{{ __('website') }}</label>
                                <input name="website" class="form-control @error('website') is-invalid @enderror"
                                    value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->website : '' }}"
                                    type="text" autocomplete="on" id="website" />
                                @error('website')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="facebook_page">{{ __('facebook page') }}</label>
                                <input name="facebook_page"
                                    class="form-control @error('facebook_page') is-invalid @enderror"
                                    value="{{ getUserInfo(Auth::user()) != null ? getUserInfo(Auth::user())->facebook_page : '' }}"
                                    type="text" autocomplete="on" id="facebook_page" />
                                @error('facebook_page')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                    name="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endif




    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">My Profile</h5>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $user->name }}" type="text" autocomplete="on" id="name"
                                    autofocus required />
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email address</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" autocomplete="on" value="{{ $user->email }}"
                                    required />
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="role">Account type</label>

                                <select class="form-select @error('role') is-invalid @enderror" aria-label=""
                                    name="role" id="role" disabled>
                                    @if ($user->hasRole('vendor') || $user->hasRole('affiliate'))
                                        <option value="{{ $user->hasRole('affiliate') ? '4' : '3' }}" selected>
                                            {{ $user->hasRole('affiliate') ? 'affiliate' : 'vendor' }}</option>
                                    @else
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                                @error('role')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="country">Country</label>

                                <select class="form-select @error('country') is-invalid @enderror" aria-label=""
                                    name="country" id="country" disabled>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $user->country_id == $country->id ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'ar' ? $country->name_ar : $country->name_en }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="phone">Phone</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="txt"
                                    autocomplete="on" id="phone" name="phone" autocomplete="on"
                                    value="{{ $user->phone }}" disabled />
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="row gx-2">
                                <div class="mb-3 col-sm-4">
                                    <label class="form-label" for="old_password">old password</label>
                                    <input class="form-control @error('old_password') is-invalid @enderror"
                                        type="password" autocomplete="on" id="old_password" name="old_password" />
                                    @error('old_password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-sm-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        autocomplete="on" id="password" name="password" />
                                    @error('password')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-sm-4">
                                    <label class="form-label" for="password_confirmation">Confirm
                                        Password</label>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        type="password" autocomplete="on" id="password_confirmation"
                                        name="password_confirmation" />
                                    @error('password_confirmation')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="gender">Gender</label>

                                <br>
                                <div class="form-check form-check-inline">
                                    <input {{ $user->gender == 'male' ? 'checked' : '' }}
                                        class="form-check-input @error('gender') is-invalid @enderror" id="gender1"
                                        type="radio" name="gender" value="male" disabled />
                                    <label class="form-check-label" for="flexRadioDefault1">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input {{ $user->gender == 'female' ? 'checked' : '' }}
                                        class="form-check-input @error('gender') is-invalid @enderror" id="gender2"
                                        type="radio" name="gender" value="female" disabled />
                                    <label class="form-check-label" for="flexRadioDefault2">Female</label>
                                </div>

                                @error('gender')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="profile">Profile picture</label>
                                <input name="profile" class="img form-control @error('profile') is-invalid @enderror"
                                    type="file" id="profile" />
                                @error('profile')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">

                                <div class="col-md-10">
                                    <img src="{{ asset('storage/images/users/' . $user->profile) }}"
                                        style="width:100px; border: 1px solid #999" class="img-thumbnail img-prev">
                                </div>

                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Edit
                                    My Profile</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
