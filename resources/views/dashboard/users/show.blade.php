@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 btn-reveal-trigger">
                <div class="card-header position-relative min-vh-25 mb-8">
                    <div class="cover-image">
                        <div class="bg-holder rounded-3 rounded-bottom-0"
                            style="background-image:url(../../assets/img/generic/4.jpg);">
                        </div>
                    </div>
                    <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                        <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                                src="{{ asset('storage/images/users/' . $user->profile) }}" width="200" alt=""
                                data-dz-thumbnail="data-dz-thumbnail" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-0">
        <div class="col-lg-12 pe-lg-2">
            <div class="card mb-3 overflow-hidden">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Account Information') }}</h5>
                </div>
                <div class="card-body bg-light">


                    <h6 class="fw-bold">{{ __('User ID') . ': #' . $user->id }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('User Name') . ': ' . $user->name }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('User Type') . ': ' }}
                        @if ($user->hasRole('affiliate'))
                            {{ __('Affiliate') }}
                        @elseif($user->hasRole('vendor'))
                            {{ __('Vendor') }}
                        @elseif($user->hasRole('user'))
                            {{ __('user') }}
                        @endif
                    </h6>
                    <h6 class="mt-2 fw-bold">
                        {{ __('Country') . ': ' . App()->getLocale() == 'ar' ? $user->country->name_ar : $user->country->name_en }}
                    </h6>
                    <h6 class="mt-2 fw-bold">{{ __('Phone') . ': ' . $user->phone }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Gender') . ': ' . $user->gender }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Verification Code') . ': ' . $user->verification_code }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Created At') . ': ' . $user->created_at }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Updated At') . ': ' . $user->updated_at }}</h6>
                    <h6 class="mt-2 fw-bold">{{ __('Email') . ': ' . $user->email }}</h6>
                    <div class="border-dashed-bottom my-3"></div>
                    <h6 class="mt-2 fw-bold"><a href="{{ route('users.edit', ['user' => $user->id]) }}"
                            class="btn btn-falcon-primary me-1 mb-1" type="button">{{ __('Edit') }}
                        </a></h6>

                </div>
            </div>


            @if ($user->hasRole('vendor'))
                <div class="card py-3 mb-3">
                    <div class="card-body py-3">
                        <div class="row g-0">
                            <div class="col-6 col-md-4 border-200 border-bottom border-end pb-4">
                                <h6 class="pb-1 text-700">{{ __('Available balance') }} </h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">
                                    {{ ($user->balance->available_balance < 0 ? 0 : $user->balance->available_balance) . ' ' . $user->country->currency }}
                                </p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-end pb-4 ps-3">
                                <h6 class="pb-1 text-700">{{ __('Bonus balance') }}</h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">
                                    {{ $user->balance->bonus . ' ' . $user->country->currency }}</p>
                            </div>
                            <div
                                class="col-6 col-md-4 border-200 border-bottom border-end border-md-end-0 pb-4 pt-4 pt-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">{{ __('Outstanding balance') }}</h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">
                                    {{ $user->balance->outstanding_balance . ' ' . $user->country->currency }}</p>
                            </div>
                            <div
                                class="col-6 col-md-4 border-200 border-md-200 border-bottom border-md-bottom-0 border-md-end pt-4 pb-md-0 ps-3 ps-md-0">
                                <h6 class="pb-1 text-700">{{ __('Pending withdrawal requests') }}</h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">
                                    {{ $user->balance->pending_withdrawal_requests . ' ' . $user->country->currency }}</p>
                            </div>
                            <div class="col-6 col-md-4 border-200 border-md-bottom-0 border-end pt-4 pb-md-0 ps-md-3">
                                <h6 class="pb-1 text-700">{{ __('Completed withdrawal requests') }}</h6>
                                <p class="font-sans-serif lh-1 mb-1 fs-2">
                                    {{ $user->balance->completed_withdrawal_requests . ' ' . $user->country->currency }}
                                </p>
                            </div>
                            <div class="col-6 col-md-4 pb-0 pt-4 ps-3">

                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if (auth()->user()->hasPermission('queries-read') && $user->hasRole('user'))
                <div class="card mb-3 overflow-hidden">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('User Queries') }}</h5>
                    </div>
                    <div class="card-body bg-light">

                        <div class="row g-0 h-100">

                            @if ($queries->count() > 0)
                                @foreach ($queries as $query)
                                    <div style="position: relative">
                                        <a style="padding-bottom: 35px"
                                            class="border-bottom-0 notification rounded-0 border-x-0 border-300"
                                            href="{{ route('users.show', ['user' => $query->admin->id]) }}">
                                            <div class="notification-avatar">
                                                <div class="avatar avatar-xl me-3">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $query->admin->profile) }}"
                                                        alt="" />

                                                </div>
                                            </div>
                                            <div class="notification-body">
                                                <p class="mb-1">{{ $query->query }}</p>
                                                <span class="notification-time"><span class="me-2" role="img"
                                                        aria-label="Emoji">📢</span>
                                                    {{ $query->created_at }}
                                                    <span
                                                        class="badge badge-soft-info ">{{ interval($query->created_at) }}</span>
                                                    <span
                                                        class="badge badge-soft-primary ">{{ __($query->query_type) }}</span>
                                                </span>


                                            </div>
                                        </a>
                                        <div
                                            style="position: absolute; bottom:5px; {{ app()->getLocale() == 'ar' ? 'right: 10px' : 'left: 10px' }}">
                                            @if (auth()->user()->hasPermission('queries-update') && auth()->user()->id == $query->admin_id)
                                                <a href="{{ route('queries.admin.edit', ['query' => $query->id]) }}"><span
                                                        class="badge badge-soft-success m-1">{{ __('Edit') }}</span></a>
                                            @endif
                                            @if (auth()->user()->hasPermission('queries-trash|queries-delete') && auth()->user()->id == $query->admin_id)
                                                <a href="{{ route('queries.admin.destroy', ['query' => $query->id]) }}"><span
                                                        class="badge badge-soft-danger m-1">{{ __('Delete') }}</span></a>
                                            @endif
                                        </div>

                                    </div>
                                @endforeach
                            @else
                                <div class="notification-body">
                                    <p>{{ __('There are currently no queries for this user') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer d-flex align-items-center justify-content-center">
                            {{ $queries->appends(request()->query())->links() }}
                        </div>

                        @if (auth()->user()->hasPermission('queries-create'))
                            <div class="row pt-1 g-0 h-100">
                                <div class="col-md-12 d-flex flex-center">
                                    <div class="flex-grow-1">
                                        <form method="POST" action="{{ route('users.query', ['user' => $user->id]) }}">
                                            @csrf
                                            <div class="mb-3 mt-3">
                                                <label class="form-label" for="note">{{ __('Add Query') }}</label>
                                                <input name="query"
                                                    class="form-control @error('query') is-invalid @enderror"
                                                    value="{{ old('query') }}" type="text" autocomplete="on"
                                                    id="query" required />
                                                @error('query')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'Hotline' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender1" type="radio" name="query_type" value="Hotline"
                                                        required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault1">{{ __('Hotline') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'Facebook' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender2" type="radio" name="query_type" value="Facebook"
                                                        required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Facebook') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'Email' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender3" type="radio" name="query_type" value="Email"
                                                        required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Email') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'Website' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender4" type="radio" name="query_type" value="Website"
                                                        required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Website') }}</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input
                                                        {{ old('query_type') == 'Customer service phone' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender5" type="radio" name="query_type"
                                                        value="Customer service phone" required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Customer service phone') }}</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'whatsapp' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender6" type="radio" name="query_type" value="whatsapp"
                                                        required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('whatsapp') }}</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input
                                                        {{ old('query_type') == 'Recommendation from client' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender7" type="radio" name="query_type"
                                                        value="Recommendation from client" required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Recommendation from client') }}</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input {{ old('query_type') == 'Instagram' ? 'checked' : '' }}
                                                        class="form-check-input @error('query_type') is-invalid @enderror"
                                                        id="gender8" type="radio" name="query_type"
                                                        value="Instagram" required />
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">{{ __('Instagram') }}</label>
                                                </div>

                                                @error('query_type')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">

                                                <select class="form-select @error('role') is-invalid @enderror"
                                                    aria-label="" name="role" id="role" required>
                                                    <option value="0">
                                                        {{ __('Dont send notification') }}</option>
                                                    @foreach ($roles as $role)
                                                        @if ($role->name !== 'user')
                                                            <option value="{{ $role->name }}">
                                                                {{ $role->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                    name="submit">{{ __('Save Query') }}</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasPermission('notes-read') && $user->hasRole('user'))
                <div class="card mb-3 overflow-hidden">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('User Notes') }}</h5>
                    </div>
                    <div class="card-body bg-light">

                        <div class="row g-0 h-100">

                            @if ($notes->count() > 0)
                                @foreach ($notes as $note)
                                    <div style="position: relative">
                                        <a style="padding-bottom: 35px"
                                            class="border-bottom-0 notification rounded-0 border-x-0 border-300"
                                            href="{{ route('users.show', ['user' => $note->admin->id]) }}">
                                            <div class="notification-avatar">
                                                <div class="avatar avatar-xl me-3">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $note->admin->profile) }}"
                                                        alt="" />

                                                </div>
                                            </div>
                                            <div class="notification-body">
                                                <p class="mb-1">{{ $note->note }}</p>
                                                <span class="notification-time"><span class="me-2" role="img"
                                                        aria-label="Emoji">📢</span>
                                                    {{ $note->created_at }}
                                                    <span
                                                        class="badge badge-soft-info ">{{ interval($note->created_at) }}</span>

                                            </div>
                                        </a>
                                        <div
                                            style="position: absolute; bottom:5px; {{ app()->getLocale() == 'ar' ? 'right: 10px' : 'left: 10px' }}">
                                            @if (auth()->user()->hasPermission('notes-update') && auth()->user()->id == $note->admin_id)
                                                <a href="{{ route('notes.admin.edit', ['note' => $note->id]) }}"><span
                                                        class="badge badge-soft-success m-1">{{ __('Edit') }}</span></a>
                                            @endif
                                            @if (auth()->user()->hasPermission('notes-trash|notes-delete') && auth()->user()->id == $note->admin_id)
                                                <a href="{{ route('notes.admin.destroy', ['note' => $note->id]) }}"><span
                                                        class="badge badge-soft-danger m-1">{{ __('Delete') }}</span></a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="notification-body">
                                    <p>{{ __('There are currently no notes for this user') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer d-flex align-items-center justify-content-center">
                            {{ $notes->appends(request()->query())->links() }}
                        </div>

                        @if (auth()->user()->hasPermission('notes-create'))
                            <div class="row pt-1 g-0 h-100">
                                <div class="col-md-12 d-flex flex-center">
                                    <div class="flex-grow-1">
                                        <form method="POST" action="{{ route('users.note', ['user' => $user->id]) }}">
                                            @csrf
                                            <div class="mb-3 mt-3">
                                                <label class="form-label" for="note">{{ __('Add Note') }}</label>
                                                <input name="note"
                                                    class="form-control @error('note') is-invalid @enderror"
                                                    value="{{ old('note') }}" type="text" autocomplete="on"
                                                    id="note" required />
                                                @error('note')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="mb-3">

                                                <select class="form-select @error('role') is-invalid @enderror"
                                                    aria-label="" name="role" id="role" required>
                                                    <option value="0">
                                                        {{ __('Dont send notification') }}</option>
                                                    @foreach ($roles as $role)
                                                        @if ($role->name !== 'user')
                                                            <option value="{{ $role->name }}">
                                                                {{ $role->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                    name="submit">{{ __('Save Note') }}</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasPermission('messages-read'))
                <div class="card mb-3 overflow-hidden">
                    <div class="card-header">
                        <h5 class="mb-0">{{ __('User Messages') }}</h5>
                    </div>
                    <div class="card-body bg-light">

                        <div class="row g-0 h-100">

                            @if ($messages->count() > 0)
                                @foreach ($messages->sortBy('created_at') as $message)
                                    <div class="notification">
                                        <a class="border-bottom-0  rounded-0 border-x-0 border-300"
                                            href="{{ route('users.show', ['user' => $message->sender->id]) }}">
                                            <div class="notification-avatar">
                                                <div class="avatar avatar-xl me-3">
                                                    <img class="rounded-circle"
                                                        src="{{ asset('storage/images/users/' . $message->sender->profile) }}"
                                                        alt="" />

                                                </div>
                                            </div>
                                        </a>
                                        <div class="notification-body">
                                            <p class="mb-1">{{ $message->message }}</p>
                                            <span class="notification-time"><span class="me-2" role="img"
                                                    aria-label="Emoji">📢</span>
                                                {{ $message->created_at }}
                                                <span
                                                    class="badge badge-soft-info ">{{ interval($message->created_at) }}</span>
                                                @if (auth()->user()->hasPermission('messages-trash|messages-delete') && auth()->user()->id == $message->sender_id)
                                                    <a
                                                        href="{{ route('messages.admin.destroy', ['message' => $message->id]) }}">Delete</a>
                                                @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="notification-body">
                                    <p>{{ __('There are currently no messages for this user') }}</p>
                                </div>
                            @endif
                        </div>

                        @if (auth()->user()->hasPermission('messages-create'))
                            <div class="row pt-1 g-0 h-100">
                                <div class="col-md-12 d-flex flex-center">
                                    <div class="flex-grow-1">
                                        <form method="POST"
                                            action="{{ route('messages.admin.store', ['user' => $user->id]) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label" for="message">{{ __('Message') }}</label>
                                                <input name="message"
                                                    class="form-control @error('note') is-invalid @enderror"
                                                    value="{{ old('message') }}" type="text" autocomplete="on"
                                                    id="message" required />
                                                @error('message')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                                    name="submit">{{ __('Send Message') }}</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>


    @if ($user->hasRole('affiliate') || $user->hasRole('vendor'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info" role="alert">
                    {{ __('user store information') }}</div>
            </div>
        </div>

        <div class="card mb-3">
            <form method="POST" action="{{ route('user.store.update', ['user' => $user->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="card-header position-relative min-vh-25 mb-7">

                    <div class="cover-image">
                        <div class="bg-holder rounded-3 rounded-bottom-0 img-prev-cover"
                            style="background-image:url({{ getUserInfo($user) != null && getUserInfo($user)->store_cover != null ? getMediaPath(getUserInfo($user)->store_cover) : asset('assets/img/store_cover.jpg') }});">
                        </div>
                        <!--/.bg-holder-->

                        <input name="store_cover" class="d-none cover" id="upload-cover-image" type="file" />
                        <label class="cover-image-file-input" for="upload-cover-image"><span
                                class="fas fa-camera me-2"></span><span>{{ __('Change cover photo') }}</span></label>
                    </div>
                    <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                        <div class="h-100 w-100 rounded-circle overflow-hidden position-relative"> <img
                                src="{{ getUserInfo($user) != null && getUserInfo($user)->store_profile != null ? getMediaPath(getUserInfo($user)->store_profile) : asset('storage/images/users/' . $user->profile) }}"
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
                                    value="{{ getUserInfo($user) != null ? getUserInfo($user)->store_name : '' }}"
                                    type="text" autocomplete="on" id="store_name" />
                                @error('store_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label"
                                    for="store_description">{{ __('Your store description') }}</label>
                                <textarea name="store_description" class="form-control @error('store_description') is-invalid @enderror"
                                    type="text" id="store_description">{{ getUserInfo($user) != null ? getUserInfo($user)->store_description : '' }}</textarea>
                                @error('store_description')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label class="form-label"
                                    for="commercial_record">{{ __('commercial record photo') }}</label>
                                <input name="commercial_record"
                                    class="img form-control @error('commercial_record') is-invalid @enderror"
                                    type="file" id="commercial_record" />
                                @error('commercial_record')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            @if (getUserInfo($user) != null && getUserInfo($user)->commercial_record != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo($user)->commercial_record) }}"
                                            target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo($user)->commercial_record) }}"
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

                            @if (getUserInfo($user) != null && getUserInfo($user)->tax_card != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo($user)->tax_card) }}" target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo($user)->tax_card) }}"
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

                            @if (getUserInfo($user) != null && getUserInfo($user)->id_card_front != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo($user)->id_card_front) }}" target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo($user)->id_card_front) }}"
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

                            @if (getUserInfo($user) != null && getUserInfo($user)->id_card_back != null)
                                <div class="mb-3">
                                    <div class="col-md-10">
                                        <a href="{{ getMediaPath(getUserInfo($user)->id_card_back) }}" target="_blank">
                                            <img src="{{ getMediaPath(getUserInfo($user)->id_card_back) }}"
                                                style="width:150px; border: 1px solid #999" class="img-thumbnail">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label" for="bank_account">{{ __('bank account number') }}</label>
                                <input name="bank_account"
                                    class="form-control @error('bank_account') is-invalid @enderror"
                                    value="{{ getUserInfo($user) != null ? getUserInfo($user)->bank_account : '' }}"
                                    type="text" autocomplete="on" id="bank_account" />
                                @error('bank_account')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="company_address">{{ __('company address') }}</label>
                                <input name="company_address"
                                    class="form-control @error('company_address') is-invalid @enderror"
                                    value="{{ getUserInfo($user) != null ? getUserInfo($user)->company_address : '' }}"
                                    type="text" autocomplete="on" id="company_address" />
                                @error('company_address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="website">{{ __('website') }}</label>
                                <input name="website" class="form-control @error('website') is-invalid @enderror"
                                    value="{{ getUserInfo($user) != null ? getUserInfo($user)->website : '' }}"
                                    type="text" autocomplete="on" id="website" />
                                @error('website')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="facebook_page">{{ __('facebook page') }}</label>
                                <input name="facebook_page"
                                    class="form-control @error('facebook_page') is-invalid @enderror"
                                    value="{{ getUserInfo($user) != null ? getUserInfo($user)->facebook_page : '' }}"
                                    type="text" autocomplete="on" id="facebook_page" />
                                @error('facebook_page')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="store_status">{{ __('store status') }}</label>
                                <select class="form-select @error('store_status') is-invalid @enderror" aria-label=""
                                    name="store_status" id="store_status">
                                    <option value="1"
                                        {{ getUserInfo($user) != null && getUserInfo($user)->store_status == 1 ? 'selected' : '' }}>
                                        {{ __('inactive') }}
                                    </option>
                                    <option value="2"
                                        {{ getUserInfo($user) != null && getUserInfo($user)->store_status == 2 ? 'selected' : '' }}>
                                        {{ __('active') }}
                                    </option>
                                </select>
                                @error('store_status')
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


    @if (
        $user->hasRole('administrator') &&
            auth()->user()->hasPermission('employees-read'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-info" role="alert">
                    {{ __('employee data') }}</div>
            </div>
        </div>

        <div class="card mb-3">
            <form method="POST" action="{{ route('user.employee.store', ['user' => $user->id]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="mb-3">
                                <label class="form-label" for="address">{{ __('address') }}</label>
                                <input name="address" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->address : '' }}"
                                    type="text" autocomplete="on" id="address" />
                                @error('address')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="job_title">{{ __('job title') }}</label>
                                <input name="job_title" class="form-control @error('job_title') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->job_title : '' }}"
                                    type="text" autocomplete="on" id="job_title" />
                                @error('job_title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="branch_id">{{ __('branch') }}</label>

                                <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id"
                                    id="branch_id">

                                    <option value="">{{ __('select branch') }}</option>

                                    @foreach (getbranches() as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ getEmployeeInfo($user) != null && getEmployeeInfo($user)->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ getName($branch) }}
                                        </option>
                                    @endforeach

                                </select>
                                @error('branch_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="national_id">{{ __('national ID') }}</label>
                                <input name="national_id" class="form-control @error('national_id') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->national_id : '' }}"
                                    type="text" autocomplete="on" id="national_id" />
                                @error('national_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="basic_salary">{{ __('basic salary') }}</label>
                                <input name="basic_salary"
                                    class="form-control @error('basic_salary') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->basic_salary : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on" id="basic_salary" />

                                @error('basic_salary')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="variable_salary">{{ __('variable salary') }}</label>
                                <input name="variable_salary" class="form-control @error('salary') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->variable_salary : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on"
                                    id="variable_salary" />

                                @error('variable_salary')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="work_hours">{{ __('working hours') }}</label>
                                <input name="work_hours" class="form-control @error('work_hours') is-invalid @enderror"
                                    value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->work_hours : '0' }}"
                                    type="number" min="0" step="0.01" autocomplete="on" id="work_hours" />

                                @error('work_hours')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="start_time">{{ __('start time') }}</label>
                                <div class="d-inline-block">
                                    <input type="time" id="start_time" name="start_time" class="form-control"
                                        value="{{ getEmployeeInfo($user) != null ? getEmployeeInfo($user)->start_time : null }}">
                                </div>

                                @error('start_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="Weekend_days">{{ __('Weekend days') }}</label>
                                <select class="form-select js-choice @error('Weekend_days') is-invalid @enderror"
                                    aria-label="" name="Weekend_days[]" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}' id="Weekend_days">



                                    @if (getEmployeeInfo($user) != null &&
                                            getEmployeeInfo($user)->Weekend_days &&
                                            is_array(unserialize(getEmployeeInfo($user)->Weekend_days)))
                                        <option value="Mon"
                                            {{ in_array('Mon', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Mon') }}</option>
                                        <option value="Tue"
                                            {{ in_array('Tue', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Tue') }}</option>
                                        <option value="Wed"
                                            {{ in_array('Wed', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Wed') }}</option>
                                        <option value="Thu"
                                            {{ in_array('Thu', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Thu') }}</option>
                                        <option value="Fri"
                                            {{ in_array('Fri', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Fri') }}</option>
                                        <option value="Sat"
                                            {{ in_array('Sat', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Sat') }}</option>
                                        <option value="Sun"
                                            {{ in_array('Sun', unserialize(getEmployeeInfo($user)->Weekend_days)) ? 'selected' : '' }}>
                                            {{ __('Sun') }}</option>
                                    @else
                                        <option value="Mon">{{ __('Mon') }}</option>
                                        <option value="Tue">{{ __('Tue') }}</option>
                                        <option value="Wed">{{ __('Wed') }}</option>
                                        <option value="Thu">{{ __('Thu') }}</option>
                                        <option value="Fri">{{ __('Fri') }}</option>
                                        <option value="Sat">{{ __('Sat') }}</option>
                                        <option value="Sun">{{ __('Sun') }}</option>
                                    @endif

                                </select>
                                @error('Weekend_days')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="image">{{ __('employee docs') }}</label>
                                <input name="images[]" class="imgs form-control @error('image') is-invalid @enderror"
                                    type="file" accept="image/*" id="image" multiple />
                                @error('image')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <div class="col-md-12" id="gallery">


                                </div>

                                <div class="product-images row">

                                    @if (getEmployeeInfo($user))
                                        @foreach (getEmployeeInfo($user)->images as $image)
                                            <div style="width:150px; height:150px; border: 1px solid #999"
                                                class="hoverbox rounded-3 text-center m-1 product-image-{{ $image->media->id }}">
                                                <img class="img-fluid" src="{{ asset($image->media->path) }}"
                                                    alt="" />
                                                <div class="light hoverbox-content bg-dark p-5 flex-center">
                                                    <div>
                                                        <a class="btn btn-light btn-sm mt-1"href="{{ asset($image->media->path) }}"
                                                            target="_blank"
                                                            data-url="{{ route('employee.delete.media', ['image_id' => $image->id]) }}"
                                                            data-media_id="{{ $image->media->id }}">{{ __('show') }}</a>

                                                        @if (auth()->user()->hasPermission('employees-update'))
                                                            <a class="btn btn-light btn-sm mt-1 " href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-modal-{{ $image->id }}">{{ __('Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="modal fade" id="delete-modal-{{ $image->id }}"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document"
                                                    style="max-width: 500px">
                                                    <div class="modal-content position-relative">
                                                        <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                                                            <button
                                                                class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-0">

                                                            <div class="p-4 pb-0">

                                                                <div style=" border: 1px solid #999"
                                                                    class="hoverbox rounded-3 text-center m-1">
                                                                    <img class="img-fluid"
                                                                        src="{{ asset($image->media->path) }}"
                                                                        alt="" />

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <a class="btn btn-primary delete-media"
                                                                data-url="{{ route('employee.delete.media', ['image_id' => $image->id]) }}"
                                                                data-media_id="{{ $image->media->id }}"
                                                                data-bs-dismiss="modal">{{ __('Delete') }}</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif



                                </div>
                            </div>











                            @if (auth()->user()->hasPermission('employees-update'))
                                <div class="mb-3">
                                    <button class="btn btn-primary d-block w-100 mt-3" type="submit"
                                        name="submit">{{ __('Save') }}</button>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endif

@endsection
