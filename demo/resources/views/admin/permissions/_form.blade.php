<div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" class="form-control" placeholder="{{ __('Name') }}" name="name"
        @if (isset($permissions['name'])) value="{{ $permissions['name'] }}" @endif required>
</div>

<div class="form-group">
    <label for="key">{{ __('Key') }}</label>
    <input type="text" class="form-control" placeholder="{{ __('Key') }}" name="key"
        @if (isset($permissions['key'])) value="{{ $permissions['key'] }}" @endif required>
</div>

<label for="module_id">{{ __('Module') }}</label>
<select name="module_id" class="form-control">
    <option value="" disabled selected>{{ __('Select Module') }}</option>
    @foreach ($modules as $module)
        <option value="{{ $module->id }}" {{ $permissions['module_id'] ?? null == $module->id ? 'selected' : '' }}>
            {{ $module->name }}
        </option>
    @endforeach
</select>
