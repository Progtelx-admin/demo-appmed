<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="">{{__('Category')}}</label>
            <select name="category_id" class="form-control" id="category">
                @if(isset($antibiotic)&&isset($antibiotic['category']))
                    <option value="{{$antibiotic['category_id']}}" selected>{{$antibiotic['category']['name']}}</option>
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-6">
     <div class="form-group">
      <label for="name">{{__('Name')}}</label>
      <input type="text" class="form-control" name="name" id="name" @if(isset($antibiotic)) value="{{$antibiotic->name}}" @endif required>
     </div>
    </div>
    <div class="col-lg-6">
       <div class="form-group">
        <label for="shortcut">{{__('Shortcut')}}</label>
        <input type="text" class="form-control" name="shortcut" id="shortcut" @if(isset($antibiotic)) value="{{$antibiotic->shortcut}}" @endif required>
       </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
             <label for="commercial_name">{{__('Commercial Name')}}</label>
             <textarea name="commercial_name" id="commercial_name" rows="1" class="form-control" placeholder="{{__('Commercial Name')}}">@if(isset($antibiotic)){{$antibiotic['commercial_name']}}@endif</textarea>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="price" min="0" id="price" @if(isset($antibiotic)) value="{{$antibiotic['price']}}" @endif placeholder="{{__('Price')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
