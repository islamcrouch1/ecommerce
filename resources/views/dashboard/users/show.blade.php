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





            @if (auth()->user()->hasPermission('crm-read'))
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

                        @if (auth()->user()->hasPermission('crm-create'))
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

            @if (auth()->user()->hasPermission('notes-read'))
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
                                                @if (auth()->user()->hasPermission('messages-trash|messages-delete'))
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
@endsection
