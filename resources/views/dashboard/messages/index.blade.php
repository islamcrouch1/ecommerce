@extends('layouts.Dashboard.app')

@section('adminContent')
    <div class="card overflow-hidden mb-3">
        <div class="card-header bg-light">
            <div class="row flex-between-center">
                <div class="col-sm-auto">
                    <h5 class="mb-1 mb-md-0">{{ __('Messages') }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body fs--1 p-0">

            @if ($messages->count() > 0)
                @foreach ($messages->sortBy('created_at') as $message)
                    <a class="border-bottom-0 notification rounded-0 border-x-0 border-300" href="#!">
                        <div class="notification-avatar">
                            <div class="avatar avatar-xl me-3">
                                <img class="rounded-circle"
                                    src="{{ asset('storage/images/users/' . $message->sender->profile) }}"
                                    alt="" />

                            </div>
                        </div>
                        <div class="notification-body">
                            <p class="mb-1">{{ $message->message }}</p>
                            <span class="notification-time"><span class="me-2" role="img" aria-label="Emoji">📢</span>
                                {{ $message->created_at }}
                                <span class="badge badge-soft-info ">{{ interval($message->created_at) }}</span>

                        </div>
                    </a>
                @endforeach
            @else
                <a class="border-bottom-0 notification rounded-0 border-x-0 border-300" href="#!">
                    <div class="notification-body">
                        <p class="mb-1">{{ __("You don't have messages to display") }}</p>
                    </div>
                </a>
            @endif

        </div>
        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $messages->appends(request()->query())->links() }}
        </div>
    </div>
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>

        <div class="card-body p-0">
            <div class="row g-0 h-100">
                <div class="col-md-12 d-flex flex-center">
                    <div class="p-4 p-md-5 flex-grow-1">
                        <form method="POST" action="{{ route('messages.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="message">{{ __('Message') }}</label>
                                <input name="message" class="form-control @error('message') is-invalid @enderror"
                                    value="{{ old('message') }}" type="text" autocomplete="on" id="message"
                                    required />
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

        </div>
    </div>
@endsection
