<div class="form-group">
    <label for="name">{{__('Name')}}</label>
    <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" @if(isset($category)) value="{{$category['name']}}" @endif required>
</div>

<div class="form-group">
    <label for="Grupi">{{__('Grupi')}}</label>
    <select class="form-control" name="category">
        <option value="">None</option>        
        <option value="Antibiotik">Antibiotik</option>                        
    </select>
</div>

<div class="form-group">
    <label for="parent_id">{{__('Parent Category')}}</label>
    <select class="form-control" name="parent_id">
        <option value="">None</option>
        @foreach ($categories as $parent)
            <option value="{{ $parent->id }}" @if(isset($category) && $category->parent_id == $parent->id) selected @endif>{{ $parent->name }}</option>
        @endforeach
    </select>
</div>