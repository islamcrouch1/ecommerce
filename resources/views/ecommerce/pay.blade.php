@extends('layouts.ecommerce.app')
@section('content')
    <section class="section-b-space light-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <iframe width="100%" height="830px"
                        src="https://accept.paymob.com/api/acceptance/iframes/718386?payment_token={{ $key }}"></iframe>

                </div>
            </div>
        </div>
    </section>
@endsection
