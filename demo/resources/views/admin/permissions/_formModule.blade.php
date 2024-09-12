<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" class="form-control" placeholder="{{ __('Name') }}" name="name"
        @if (isset($permissions['name'])) value="{{ $permissions['name'] }}" @endif required>
</div>
