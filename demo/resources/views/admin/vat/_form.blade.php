<div class="form-group">
    <label for="code">{{ __('Code') }}</label>
    <input type="text" class="form-control" placeholder="{{ __('Code') }}" name="code"
        @if (isset($vat['code'])) value="{{ $vat['code'] }}" @endif required>
</div>

<div class="form-group">
    <label for="vat">{{ __('Vat') }}</label>
    <input type="text" class="form-control" placeholder="{{ __('Vat') }}" name="vat"
        @if (isset($vat['vat'])) value="{{ $vat['vat'] }}" @endif required>
</div>
