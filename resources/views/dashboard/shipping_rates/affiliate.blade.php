@extends('layouts.dashboard.app')

@section('adminContent')




    <!-- Main content -->
    <section class="content">

        <!-- Default box -->



        <div class="card">
            <div class="card-header">


                <h3 class="card-title">{{ __('Shipping Rates') }}</h3>

            </div>
            <div class="card-body p-0 table-responsive">
                @if ($shipping_rates->count() > 0)
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('City') }}
                                </th>
                                <th>
                                    {{ __('Shipping Rate') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                @foreach ($shipping_rates as $shipping_rate)
                                    <td>
                                        <small>
                                            {{ app()->getLocale() == 'ar' ? $shipping_rate->city_ar : $shipping_rate->city_en }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            {{ $shipping_rate->cost . $shipping_rate->country->currency }}
                                        </small>
                                    </td>

                            </tr>
                @endforeach


                </tbody>
                </table>

                <div class="row mt-3"> {{ $shipping_rates->appends(request()->query())->links() }}</div>
            @else
                <h3 class="p-2">{{ __('No shipping rates To Show') }}</h3>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->


@endsection
