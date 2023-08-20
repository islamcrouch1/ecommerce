@extends('layouts.dashboard.app')

@section('adminContent')
    @if (auth()->user()->hasPermission('queries-update'))
        <div class="row pt-1 g-0 h-100">
            <div class="col-md-12 d-flex flex-center">
                <div class="flex-grow-1">
                    <form method="POST" action="{{ route('notes.admin.update', ['note' => $note->id]) }}">
                        @csrf
                        <div class="mb-3 mt-3">
                            <label class="form-label" for="note">{{ __('Edit Note') }}</label>
                            <input name="note" class="form-control @error('note') is-invalid @enderror"
                                value="{{ $note->note }}" type="text" autocomplete="on" id="note" required />
                            @error('note')
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
@endsection
