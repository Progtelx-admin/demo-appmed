<div class="row">
    <div class="col-lg-4">
       <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1">
                    <i  class="fas fa-map-marked-alt nav-icon"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('Branch name')}}" name="name" id="name" @if(isset($branch)) value="{{$branch->name}}" @endif required>
        </div>
       </div>
    </div>

    

    <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-phone-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone" @if(isset($branch)) value="{{$branch->phone}}" @endif required>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($branch)) value="{{$branch->address}}" @endif required>
            </div>
        </div>
    </div>
    
        <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Email')}}" name="email" id="email" @if(isset($branch)) value="{{$branch->email}}" @endif required>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-print"></i>
                  </span>
                </div>
                <!--<input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($branch)) value="{{$branch->address}}" @endif required>-->
              <select class="form-control" name="fiskal_no" placeholder="{{__('Visit Type')}}" id="fiskal_no">
                <option value="" selected>{{__('Select Fiscal Number')}}</option>
                <option value="810519621"  @if(isset($branch)&&$branch['fiskal_no']=='810519621') selected @elseif(old('fiskal_no')=='810519621') selected  @endif>{{__('810519621')}}</option>
            </select>
            </div>
        </div>
    </div>
            <div class="col-lg-4">
        <div class="form-group">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-list-ol"></i>
                  </span>
                </div>
                <input type="text" class="form-control" placeholder="{{__('Protocol Number')}}" name="protocol_cert" id="protocol_cert" @if(isset($branch)) value="{{$branch->protocol_cert}}" @endif min="6" required>
            </div>
        </div>
    </div>

</div>




<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>{{__('Product')}}</th>
                    <th width="150px">{{__('Initial quantity')}}</th>
                    <th width="150px">{{__('Stock alert')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($branch))
                    @foreach($branch['products'] as $product)
                        <tr>
                            <td>
                                {{$product['product']['name']}}
                            </td>
                            <td>
                                <input type="number" class="form-control" name="products[{{$product['product_id']}}][initial_quantity]" id="product_initial_quantity_{{$product['product_id']}}" value="{{$product['initial_quantity']}}" required>
                            </td>
                            <td>
                                <input type="number" class="form-control"  name="products[{{$product['product_id']}}][alert_quantity]" id="product_alert_quantity_{{$product['product_id']}}" value="{{$product['alert_quantity']}}" required>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @foreach($products as $product)
                        <tr>
                            <td>
                                {{$product['name']}}
                            </td>
                            <td>
                                <input type="number" class="form-control"  name="products[{{$product['id']}}][initial_quantity]" id="branch_initial_quantity_{{$product['id']}}" value="0" required>
                            </td>
                            <td>
                                <input type="number" class="form-control"  name="products[{{$product['id']}}][alert_quantity]" id="branch_alert_quantity_{{$product['id']}}" value="0" required>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
