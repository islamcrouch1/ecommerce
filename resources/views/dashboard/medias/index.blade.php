@extends('layouts.dashboard.app')

@section('adminContent')
    <div class="card mb-3" id="customersTable"
        data-list='{"valueNames":["name","email","phone","address","joined"],"page":10,"pagination":true}'>
        <div class="card-header">
            <div class="row flex-between-center">
                <div class="col-4 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">
                        {{ __('Medias') }}
                    </h5>
                </div>
                <div class="col-8 col-sm-auto text-end ps-2">

                    <div id="table-customers-replace-element">

                        @if (auth()->user()->hasPermission('medias-create'))
                            <a href="{{ route('medias.create') }}" class="btn btn-falcon-default btn-sm" type="button"><span
                                    class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span><span
                                    class="d-none d-sm-inline-block ms-1">{{ __('Add') }}</span></a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive scrollbar">
                @if ($medias->count() > 0)
                    <div class="container">
                        <div class="row">
                            @foreach ($medias as $media)
                                <div class="col-md-3">
                                    <div style="height: 300px" class="d-flex justify-content-center align-items-center">
                                        <a data-bs-toggle="modal" data-bs-target="#media-modal-{{ $media->id }}">
                                            <img style="width: 100% !important" class="rounded-1 img-thumbnail w-25 mt-3"
                                                src="{{ asset($media->path) }}" alt="" />
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <h3 class="p-4">{{ __('No data to show') }}</h3>
                @endif
            </div>
        </div>


        <div class="card-footer d-flex align-items-center justify-content-center">
            {{ $medias->appends(request()->query())->links() }}
        </div>

    </div>


    @foreach ($medias as $media)
        <div class="modal fade" id="media-modal-{{ $media->id }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px">
                <div class="modal-content position-relative">
                    <div class="position-absolute top-0 end-0 mt-2 me-2 z-index-1">
                        <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="rounded-top-lg py-3 ps-4 pe-6 bg-light">
                            <h4 class="mb-1" id="modalExampleDemoLabel">{{ __('Media Details') }}</h4>
                        </div>
                        <div class="p-4 pb-0">
                            <form method="POST" action="{{ route('medias.destroy', ['media' => $media->id]) }}">
                                @csrf
                                @method('DELETE')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div style="height: 300px" class="d-flex justify-content-center align-items-center">
                                            <img style="width: 100% !important" class="rounded-1 img-thumbnail w-25 mt-3"
                                                src="{{ asset($media->path) }}" alt="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">

                                            <tbody>
                                                <tr class="table-primary">
                                                    <td>{{ __('image dimentions') }}</td>
                                                    <td>{{ $media->height . 'px' . '*' . $media->width . 'px' }}</td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <td>{{ __('image extention') }}</td>
                                                    <td>{{ $media->extension }}</td>
                                                </tr>
                                                <tr class="table-secondary">
                                                    <td> <a href="{{ asset($media->path) }}"
                                                            target="_blank">{{ __('image url') }}</a>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tbody>


                                        </table>
                                        <button class="btn btn-falcon-danger me-1 mb-1" type="submit">{{ __('Delete') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
