@if (session()->has('success'))
    <!-- added to cart notification -->
    <div class="added-notification success-noty">
        <h3>{{ session()->get('success') }}</h3>
    </div>
    <!-- added to cart notification -->
@endif
@if (session()->has('error'))
    <!-- added to cart notification -->
    <div class="added-notification error-noty">
        <h3>{{ session()->get('error') }}</h3>
    </div>
    <!-- added to cart notification -->
@endif
