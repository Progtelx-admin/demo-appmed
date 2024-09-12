<div class="row">




                    <div class="col-lg-3">
                        <div class="form-group ">
                            <label for="branches">{{ __('Category') }}</label>
                            <select name="category_id" class="form-control select2" id="category" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $categorie)
                                    <option value="{{ $categorie->id }}"
                                        {{ isset($currentCategoryId) && $categorie->id == $currentCategoryId ? 'selected' : '' }}>
                                        {{ $categorie->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

    <div class="col-lg-4">
     <div class="form-group">
      <label for="name">{{__('Name')}}</label>
      <input type="text" class="form-control" name="name" id="name" @if(isset($service)) value="{{$service->name}}" @endif required>
     </div>
    </div>
    <div class="col-lg-4">
       <div class="form-group">
        <label for="shortcut">{{__('Shortcut')}}</label>
        <input type="text" class="form-control" name="shortcut" id="shortcut" @if(isset($service)) value="{{$service->shortcut}}" @endif required>
       </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group" style="color: #f9bf3b">
        <label for="name">{{__('Pantheon Code')}}</label>
        <input style="border-color: #f9bf3b !important" type="text" class="form-control" name="pantheon_id" id="pantheon_id" @if(isset($service)) value="{{$service['pantheon_id']}}" @endif required>
      </div> 
    </div>
    <div class="col-lg-12">
        <div class="form-group">
             <label for="commercial_name">{{__('Commercial Name')}}</label>
             <textarea name="commercial_name" id="commercial_name" rows="1" class="form-control" placeholder="{{__('Commercial Name')}}">@if(isset($service)){{$service['commercial_name']}}@endif</textarea>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="price" min="0" id="price" @if(isset($service)) value="{{$service['price']}}" @endif placeholder="{{__('Price')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
