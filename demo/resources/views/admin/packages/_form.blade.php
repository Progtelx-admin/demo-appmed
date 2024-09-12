<div class="row">
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">{{__('Package name')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Package name')}}" name="name" @if(isset($package)) value="{{$package['name']}}" @endif required>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="">{{__('Shortcut')}}</label>
            <input type="text" class="form-control" placeholder="{{__('Shortcut')}}" name="shortcut" @if(isset($package)) value="{{$package['shortcut']}}" @endif>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_tests">{{__('Tests')}}</label>
            <select class="form-control" name="tests[]" id="select_tests" placeholder="{{__('Tests')}}" multiple>
                @if(isset($package))
                    @foreach($package['tests'] as $test)
                        <option value="{{$test['testable_id']}}" selected>{{$test['test']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_microbiology_tests">{{__('Microbiology Tests')}}</label>
            <select class="form-control" name="microbiology_tests[]" id="select_microbiology_tests" placeholder="{{__('Microbiology Tests')}}" multiple>
                @if(isset($package))
                    @foreach($package['microbiology_tests'] as $microbiology_test)
                        <option value="{{$microbiology_test['testable_id']}}" selected>{{$microbiology_test['microbiologyTest']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="select_cultures">{{__('Cultures')}}</label>
            <select class="form-control" name="cultures[]" id="select_cultures" placeholder="{{__('Cultures')}}" multiple>
                @if(isset($package))
                    @foreach($package['cultures'] as $culture)
                        <option value="{{$culture['testable_id']}}" selected>{{$culture['culture']['name']}}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
            <label for="price">{{__('Price')}}</label>
            <div class="input-group form-group mb-3">
                <input type="number" class="form-control" name="price" min="0" id="price" @if(isset($package)) value="{{$package['price']}}" @endif placeholder="{{__('Price')}}" required>
                <div class="input-group-append">
                    <span class="input-group-text">
                        {{get_currency()}}
                    </span>
                </div>
            </div>
        </div>
    </div>
          <div class="col-lg-3">
      <div class="form-group" style="color: #f9bf3b">
        <label for="name">{{__('Pantheon Code')}}</label>
        <input style="border-color: #f9bf3b !important" type="text" class="form-control" name="pantheon_id" id="pantheon_id" @if(isset($package)) value="{{$package['pantheon_id']}}" @endif required>
      </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
             <label for="precautions">{{__('Precautions')}}</label>
             <textarea name="precautions" id="precautions" rows="3" class="form-control" placeholder="{{__('Precautions')}}">@if(isset($package)){{$package['precautions']}}@endif</textarea>
        </div>
    </div>
</div>

