@foreach ($models as $model)
    <div class="col-md-4 mb-3">
        <label class="form-label" for="{{ $model }}">{{ __($model) }}</label>
        <select class="form-select @error('permissions') is-invalid @enderror js-choice" name="permissions[]"
            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
            @foreach ($permissions as $permission)
                <option
                    @if (isset($role)) {{ $role->hasPermission($model . '-' . $permission) ? 'selected' : '' }} @endif
                    value="{{ $model . '-' . $permission }}">
                    {{ __($permission) }}
                </option>
            @endforeach
        </select>
        @error('permissions')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
@endforeach
