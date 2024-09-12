<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="fa fa-user"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('Name')}}" name="name" @if(isset($user)) value="{{$user['name']}}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('Model')}}" name="model" @if(isset($instrument)) value="{{$instrument['model']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('Comment')}}" name="comment" @if(isset($instrument)) value="{{$instrument['comment']}}" @endif required>
        </div>
    </div>
</div>


@if(!isset($instrument)||(isset($instrument))&&$instrument['id']!=1)
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-map-marked-alt"></i>
              </span>
            </div>
            <select name="branches[]" id="branches_assign" placeholder="{{__('Branches')}}" class="form-control select2" multiple required>
                <option value="" disabled>{{__('Branches')}}</option>
                @foreach($branches as $branch)
                     <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                @endforeach
             </select>
        </div>
    </div>
</div>
@endif