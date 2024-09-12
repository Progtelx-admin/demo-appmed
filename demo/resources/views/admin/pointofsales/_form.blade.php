<div class="form-group">
    <label for="pos_name">{{__('POS Name')}}</label>
    <input type="text" class="form-control" placeholder="{{__('POS Name')}}" name="pos_name" @if(isset($pointOfSale)) value="{{$pointOfSale->pos_name}}" @endif required>
</div>

<div class="form-group">
    <label for="pos_location">{{__('POS Location')}}</label>
    <input type="text" class="form-control" placeholder="{{__('POS Location')}}" name="pos_location" @if(isset($pointOfSale)) value="{{$pointOfSale->pos_location}}" @endif required>
</div>

<div class="form-group">
    <label for="cash_in_hand">{{__('Cash in Hand')}}</label>
    <input type="number" class="form-control" placeholder="{{__('Cash in Hand')}}" name="cash_in_hand" @if(isset($pointOfSale)) value="{{$pointOfSale->cash_in_hand}}" @endif required>
</div>
<div class="form-group">
    <label for="pantheon_id">{{__('Pantheon ID')}}</label>
    <input type="text" class="form-control" placeholder="{{__('Pantheon ID')}}" name="pantheon_id" @if(isset($pointOfSale)) value="{{$pointOfSale->pantheon_id}}" @endif required>
</div>
<div class="form-group">
    <label for="issuer_id">{{__('Issuer ID')}}</label>
    <input type="text" class="form-control" placeholder="{{__('Issuer ID')}}" name="issuer_id" @if(isset($pointOfSale)) value="{{$pointOfSale->issuer_id}}" @endif required>
</div>

