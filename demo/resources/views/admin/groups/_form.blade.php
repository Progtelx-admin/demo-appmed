<!-- Patient Info -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            {{ __('Patient Info') }}
        </h3>
        @can('create_patient')
            <button type="button" class="btn btn-primary btn-sm add_patient float-right" data-toggle="modal"
                data-target="#patient_modal">
                <i class="fa fa-exclamation-triangle"></i> {{ __('Not Listed ?') }}
            </button>
        @endcan
        @can('edit_patient')
            <button type="button" class="btn btn-warning btn-sm mr-1 float-right" id="edit_patient">
                <i class="fa fa-edit"></i> {{ __('Edit patient') }}
            </button>
        @endcan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="text-center m-0 p-0">
                            {{ __('Avatar') }}
                        </h5>
                    </div>
                    <div class="card-body m-0 p-0">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <a href="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                                    data-toggle="lightbox" data-title="Avatar">
                                    <img src="@if (isset($group) && !empty($group['patient']['avatar'])) {{ url('uploads/patient-avatar/' . $group['patient']['avatar']) }}@else{{ url('img/avatar.png') }} @endif"
                                        class="img-thumbnail" id="patient_avatar" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger btn-sm float-right" id="delete_patient_avatar"
                            style="width:100%"
                            patient_id="@if (isset($patient)) {{ $patient['id'] }} @endif">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Code') }}</label>
                            <select id="code" name="patient_id" class="form-control" required>
                                @if (isset($group) && isset($group['patient']))
                                    <option value="{{ $group['patient']['id'] }}" selected>
                                        {{ $group['patient']['code'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Name') }}</label>
                            <select id="name" name="patient_id" class="form-control" required>
                                @if (isset($group) && isset($group['patient']))
                                    <option value="{{ $group['patient']['id'] }}" selected>
                                        {{ $group['patient']['name'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Parent Name') }}</label>
                            <input class="form-control" id="passport_no"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['passport_no'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    {{--   <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Nationality')}}</label>-->
                    <!--        <input class="form-control" id="nationality" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['country']['nationality']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>--> --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('National ID') }}</label>
                            <input class="form-control" id="national_id"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['national_id'] }}" @endif
                                readonly>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Date of birth') }}</label>
                            <input class="form-control" id="dob"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['dob'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Age') }}</label>
                            <input class="form-control" id="age"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['age'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input class="form-control" id="phone"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['phone'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input class="form-control" id="email"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['email'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Gender') }}</label>
                            <input class="form-control" id="gender"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['gender'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <input class="form-control" id="address"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['address'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    <div class="col-lg-3" style="display:none">
                        <div class="form-group">
                            <label>{{ __('City') }}</label>
                            <input class="form-control" id="city"
                                @if (isset($group) && isset($group['patient'])) value="{{ $group['patient']['city'] }}" @endif
                                readonly>
                        </div>
                    </div>
                    {{--  <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Vaccinated')}}</label>-->
                    <!--        <input class="form-control" id="vaccinated" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['vaccinated']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>-->
                    <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Vaccine Model')}}</label>-->
                    <!--        <input class="form-control" id="vaccinemodel" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['vaccinemodel']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>-->
                    <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Date of 1st Vaccine')}}</label>-->
                    <!--        <input class="form-control" id="datevaccine1" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['datevaccine1']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>-->
                    <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Date of 2nd Vaccine')}}</label>-->
                    <!--        <input class="form-control" id="datevaccine2" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['datevaccine2']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>-->
                    <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{__('Date of 3rd Vaccine')}}</label>-->
                    <!--        <input class="form-control" id="datevaccine3" @if (isset($group) && isset($group['patient'])) value="{{$group['patient']['datevaccine3']}}" @endif readonly>-->
                    <!--    </div> -->
                    <!--</div>--> --}}
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Doctor') }}</label>
                            @can('create_doctor')
                                <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                    data-target="#doctor_modal"><i class="fa fa-exclamation-triangle"></i>
                                    {{ __('Not Listed ?') }}</button>
                            @endcan
                            <select class="form-control" name="doctor_id" id="doctor">
                                @if (isset($group) && isset($group['doctor']))
                                    <option value="{{ $group['doctor']['id'] }}" selected>
                                        {{ $group['doctor']['name'] }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <!--<div class="col-lg-3">-->
                    <!--    <div class="form-group">-->
                    <!--        <label>{{ __('Contract') }}</label>-->
                    <!--        <select class="form-control" name="contract_id" id="contract_id">-->
                    <!--            @if (isset($group) && isset($group['contract']))
-->
                    <!--                <option value="{{ $group['contract']['id'] }}" selected>{{ $group['contract']['title'] }}</option>-->
                    <!--
@endif-->
                    <!--        </select>-->
                    <!--    </div> -->
                    <!--</div>-->

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Contract') }}</label>
                            <select class="form-control" name="contract_id" id="contract_id">
                                <!-- Check if the group is set and has an associated contract -->
                                @if (isset($group) && isset($group->contract))
                                    <option value="{{ $group->contract->id }}" selected>{{ $group->contract->title }}
                                    </option>
                                    <!-- Check if $defaultContract is set and use it as fallback -->
                                @elseif(isset($defaultContract))
                                    <option value="{{ $defaultContract->id }}">{{ $defaultContract->title }}</option>
                                @endif
                                <!-- Optional: List other contracts here -->
                            </select>
                        </div>
                    </div>




                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Sample collection date') }}</label>

                            <input type="text" class="form-control flatpickr" name="sample_collection_date"
                                id="sample_collection_date"
                                @if (isset($group)) value="{{ $group['sample_collection_date'] }}" @else value="{{ date('Y-m-d H:i:s') }}" @endif>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>{{ __('Reference') }}</label>
                            <input type="text" class="form-control" name="reference" id="reference"
                                @if (isset($group)) value="{{ $group['reference'] }}" @endif>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>{{ __('Comment') }}</label>
                            <input type="text" class="form-control" name="comment" id="comment"
                                @if (isset($group)) value="{{ $group['comment'] }}" @endif>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /patient info-->

<!-- Tests -->
<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Biokimi') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_test" class="form-control" multiple></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{ __('Name') }}
                            </th>
                            <th width="30%">
                                {{ __('Category') }}
                            </th>
                            <th>
                                {{ __('Price') }}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_tests">
                        @if (isset($group))
                            @foreach ($group['tests'] as $test)
                                <tr class="selected_test" id="test_{{ $test['test_id'] }}"
                                    default_price="{{ $test['test']['test_price']['price'] }}">
                                    <td>
                                        {{ $test['test']['name'] }}
                                        <input type="hidden" class="tests_id"
                                            name="tests[{{ $test['test_id'] }}][id]" value="{{ $test['test_id'] }}">
                                    </td>
                                    <td>
                                        {{ $test['test']['category']['name'] }}
                                    </td>
                                    <td class="test_price">
                                        {{ $test['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price" name="tests[{{ $test['test_id'] }}][price]"
                                        value="{{ $test['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Mikrobiologji') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_culture" class="form-control" multiple></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{ __('Name') }}
                            </th>
                            <th width="30%">
                                {{ __('Category') }}
                            </th>
                            <th>
                                {{ __('Price') }}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_cultures">
                        @if (isset($group))
                            @foreach ($group['cultures'] as $culture)
                                <tr class="selected_culture" id="culture_{{ $culture['culture_id'] }}"
                                    default_price="{{ $culture['culture']['culture_price']['price'] }}">
                                    <td>
                                        {{ $culture['culture']['name'] }}
                                        <input type="hidden" class="cultures_id"
                                            name="cultures[{{ $culture['culture_id'] }}][id]"
                                            value="{{ $culture['culture_id'] }}">
                                    </td>
                                    <td>
                                        {{ $culture['culture']['category']['name'] }}
                                    </td>
                                    <td class="culture_price">
                                        {{ $culture['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price"
                                        name="cultures[{{ $culture['culture_id'] }}][price]"
                                        value="{{ $culture['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Packages') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_package" class="form-control" multiple></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{ __('Name') }}
                            </th>
                            <th>
                                {{ __('Price') }}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_packages">
                        @if (isset($group))
                            @foreach ($group['packages'] as $package)
                                <tr class="selected_package" id="package_{{ $package['package_id'] }}"
                                    default_price="{{ $package['package']['package_price']['price'] }}">
                                    <td>
                                        {{ $package['package']['name'] }}
                                        <input type="hidden" class="packages_id"
                                            name="packages[{{ $package['package_id'] }}][id]"
                                            value="{{ $package['package_id'] }}">
                                    </td>
                                    <td class="package_price">
                                        {{ $package['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price"
                                        name="packages[{{ $package['package_id'] }}][price]"
                                        value="{{ $package['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Antibiotics & Therapy') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_antibiotic" class="form-control"></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{ __('Name') }}
                            </th>
                            <th width="30%">
                                {{ __('Comercial Name') }}
                            </th>
                            <th>
                                {{ __('Price') }}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_antibiotics">
                        @if (isset($group))
                            @foreach ($group['antibiotics'] as $antibiotic)
                                <tr class="selected_antibiotic" id="antibiotic_{{ $antibiotic['antibiotic_id'] }}"
                                    default_price="{{ $antibiotic['antibiotic']['antibiotic_price']['price'] }}">
                                    <td>
                                        {{ $antibiotic['antibiotic']['name'] }}
                                        <input type="hidden" class="antibiotic_id"
                                            name="antibiotics[{{ $antibiotic['antibiotic_id'] }}][id]"
                                            value="{{ $antibiotic['antibiotic_id'] }}">
                                    </td>
                                    <td>
                                        {{ $antibiotic['antibiotic']['comercial']['name'] }}
                                    </td>
                                    <td class="antibiotic_price">
                                        {{ $antibiotic['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price"
                                        name="antibiotics[{{ $antibiotic['antibiotic_id'] }}][price]"
                                        value="{{ $antibiotic['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--Services-->

    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{ __('Services') }}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_service" class="form-control"></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{ __('Name') }}
                            </th>
                            <th width="30%">
                                {{ __('Category') }}
                            </th>
                            <th>
                                {{ __('Price') }}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_services">
                        @if (isset($group))
                            @foreach ($group['services'] as $service)
                                <tr class="selected_service" id="service_{{ $service['service_id'] }}"
                                    default_price="{{ $service['service']['service_price']['price'] }}">
                                    <td>
                                        {{ $service['service']['name'] }}
                                        <input type="hidden" class="services_id"
                                            name="services[{{ $service['service_id'] }}][id]"
                                            value="{{ $service['service_id'] }}">
                                    </td>
                                    <td>
                                        {{ $service['service']['category']['name'] }}
                                    </td>
                                    <td class="service_price">
                                        {{ $service['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price"
                                        name="services[{{ $service['service_id'] }}][price]"
                                        value="{{ $service['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                        @if (isset($visit))
                            @foreach ($visit['services'] as $service)
                                <tr class="selected_service" id="service_{{ $service['service_id'] }}"
                                    default_price="{{ $service['service']['service_price']['price'] }}">
                                    <td>
                                        {{ $service['service']['name'] }}
                                        <input type="hidden" class="services_id"
                                            name="services[{{ $service['service_id'] }}][id]"
                                            value="{{ $service['service_id'] }}">
                                    </td>
                                    <td>
                                        {{ $service['service']['category']['name'] }}
                                    </td>
                                    <td class="service_price">
                                        {{ $service['price'] }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <input type="hidden" class="price"
                                        name="services[{{ $service['service_id'] }}][price]"
                                        value="{{ $service['price'] }}">
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('Microbiology Tests')}}
                </h5>
            </div>
            <div class="card-header">
                <select name="" id="select_microbiology_test" class="form-control" multiple></select>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="50%">
                                {{__('Name')}}
                            </th>
                            <th width="30%">
                                {{__('Category')}}
                            </th>
                            <th>
                                {{__('Price')}}
                            </th>
                            <th width="10px">
                            </th>
                        </tr>
                    </thead>
                    <tbody id="selected_microbiology_tests">
                        @if(isset($group))
                            @foreach($group['microbiology_tests'] as $microbiology_test)
                            <tr class="selected_microbiology_test" id="microbiology_test_{{$microbiology_test['test_id']}}" default_price="{{$microbiology_test['microbiologyTest']['test_price']['price']}}">
                                <td>
                                {{$microbiology_test['microbiologyTest']['name']}}
                                <input type="hidden" class="microbiology_tests_id" name="microbiology_tests[{{$microbiology_test['test_id']}}][id]" value="{{$microbiology_test['test_id']}}">
                                </td>
                                <td>
                                    {{$microbiology_test['microbiologyTest']['category']['name']}}
                                </td>
                                <td class="microbiology_test_price">
                                    {{$microbiology_test['price']}}
                                </td>
                                <td>
                                <button type="button" class="btn btn-danger btn-sm delete_selected_row">
                                    <i class="fa fa-trash"></i>
                                </button>
                                </td>
                                <input type="hidden" class="price" name="microbiology_tests[{{$microbiology_test['test_id']}}][price]" value="{{$microbiology_test['price']}}">
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- End Services-->
<!-- \Tests -->

{{-- <!-- test -->
<div class="row">
    <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title">
                    {{__('Tests')}}
                </h5>
            </div>
            <div class="card-body tests">
                <table class="table table-striped table-sm invoice-datatable" width="100%">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th width="10px">#</th>
                            <th>{{__('Test Name')}}</th>
                            <th>{{__('Category')}}</th>
                            <th>{{__('Price')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tests as $test)
                            <tr>
                                <td class="order">

                                </td>
                                <td>
                                    <input type="checkbox"  class="test" id="test_{{$test['id']}}" value="{{$test['id']}}" price="{{$test['test_price']['price']}}" default_price="{{$test['test_price']['price']}}">
                                </td>
                                <td>
                                    <label for="test_{{$test['id']}}">{{$test['name']}}</label>
                                </td>
                                <td>
                                    {{$test['category']['name']}}
                                </td>
                                <td class="table_price">
                                    {{formated_price($test['test_price']['price'])}}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
       <div class="card card-danger">
           <div class="card-header">
               <h5 class="card-title text-center">
                   {{__('Cultures')}}
               </h5>
           </div>
           <div class="card-body cultures">
                <table class="table table-striped table-sm invoice-datatable" width="100%">
                    <thead>
                        <tr>
                            <td>Order</td>
                            <th width="10px">#</th>
                            <th>{{__('Culture Name')}}</th>
                            <th>{{__('Category')}}</th>
                            <th>{{__('Price')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cultures as $culture)
                            <tr>
                                <td class="order">

                                </td>
                                <td>
                                    <input type="checkbox" class="culture" id="culture_{{$culture['id']}}" value="{{$culture['id']}}" price="{{$culture['culture_price']['price']}}" default_price="{{$culture['culture_price']['price']}}">
                                </td>
                                <td>
                                    <label for="culture_{{$culture['id']}}">{{$culture['name']}}</label>
                                </td>
                                <td>
                                    {{$culture['category']['name']}}
                                </td>
                                <td class="table_price">
                                    {{formated_price($culture['culture_price']['price'])}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
           </div>
       </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title text-center">
                    {{__('Packages')}}
                </h5>
            </div>
            <div class="card-body packages">
                 <table class="table table-striped table-sm invoice-datatable" width="100%">
                     <thead>
                         <tr>
                             <td>Order</td>
                             <th width="10px">#</th>
                             <th>{{__('Package name')}}</th>
                             <th>{{__('Price')}}</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($packages as $package)
                             <tr>
                                <td class="order">

                                </td>
                                <td>
                                    <input type="checkbox" class="package" id="package_{{$package['id']}}" value="{{$package['id']}}" price="{{$package['package_price']['price']}}" default_price="{{$package['package_price']['price']}}">
                                </td>
                                <td>
                                    <label for="package_{{$package['id']}}">{{$package['name']}}</label>
                                </td>
                                <td class="table_price">
                                    {{formated_price($package['package_price']['price'])}}
                                </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title text-center">
                    {{__('Antibiotics & Therapy')}}
                </h5>
            </div>
            <div class="card-body antibiotics">
                 <table class="table table-striped table-sm invoice-datatable" width="100%">
                     <thead>
                         <tr>
                             <td>Order</td>
                             <th width="10px">#</th>
                             <th>{{__('Antibiotic name')}}</th>
                             <th>{{__('Price')}}</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($antibiotics as $antibiotic)
                             <tr>
                                <td class="order">

                                </td>
                                <td>
                                    <input type="checkbox" class="antibiotic" id="antibiotic_{{$antibiotic['id']}}" value="{{$antibiotic['id']}}" price="{{$antibiotic['antibiotic_price']['price']}}" default_price="{{$antibiotic['antibiotic_price']['price']}}">
                                </td>
                                <td>
                                    <label for="antibiotic_{{$antibiotic['id']}}">{{$antibiotic['name']}}</label>
                                </td>
                                <td class="table_price">
                                    {{formated_price($antibiotic['antibiotic_price']['price'])}}
                                </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
            </div>
        </div>
    </div>
        <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title text-center">
                    {{__('Service')}}
                </h5>
            </div>
            <div class="card-body services">
                 <table class="table table-striped table-sm invoice-datatable" width="100%">
                     <thead>
                         <tr>
                             <td>Order</td>
                             <th width="10px">#</th>
                             <th>{{__('Service name')}}</th>
                             <th>{{__('Price')}}</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($services as $service)
                             <tr>
                                <td class="order">

                                </td>
                                <td>
                                    <input type="checkbox" class="service" id="service_{{$service['id']}}" value="{{$service['id']}}" price="{{$service['service_price']['price']}}" default_price="{{$service['service_price']['price']}}">
                                </td>
                                <td>
                                    <label for="service_{{$service['id']}}">{{$service['name']}}</label>
                                </td>
                                <td>
                                    {{$service['name']}}
                                </td>
                                <td class="table_price">
                                    {{formated_price($service['service_price']['price'])}}
                                </td>
                            </tr>
                         @endforeach
                     </tbody>
                 </table>
            </div>
        </div>
    </div>
 </div>
<!-- \End test --> --}}

<div class="row">
    <div class="col-lg-6">
        <!-- Receipt -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    {{ __('Receipt') }}
                </h3>
            </div>
            <div class="card-body p-0" id="receipt">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-stripped" id="receipt_table">
                            <tbody>

                                <tr>
                                    <td width="100px">{{ __('Subtotal') }}</td>
                                    <td width="300px">
                                        <input type="number" id="subtotal" name="subtotal"
                                            @if (isset($group)) value="{{ $group['subtotal'] }}" @else value="0" @endif
                                            readonly class="form-control">
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ __('Discount') }} %</td>
                                    <td>
                                        <input type="number" class="form-control" id="discount" name="discount"
                                            @if (isset($group)) value="{{ $group['discount'] }}" @else value="0" @endif>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ __('Discount Fix') }}</td>
                                    <td>
                                        <input type="number" class="form-control" id="discount_fix"
                                            name="discount_fix"
                                            @if (isset($group)) value="{{ $group['discount_fix'] }}" @else value="0" @endif>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ __('Total') }}</td>
                                    <td>
                                        <input type="number" id="total" name="total" class="form-control"
                                            @if (isset($group)) value="{{ $group['total'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Paid') }}</td>
                                    <td>
                                        <input type="number" id="paid" name="paid" min="0"
                                            class="form-control"
                                            @if (isset($group)) value="{{ $group['paid'] }}" @else value="0" @endif
                                            readonly required>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Due') }}</td>
                                    <td>
                                        <input type="number" id="due" name="due" class="form-control"
                                            @if (isset($group)) value="{{ $group['due'] }}" @else value="0" @endif
                                            readonly>
                                    </td>
                                    <td>
                                        {{ get_currency() }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- \Receipt -->
    </div>
    <div class="col-lg-6">
        <!-- Payments -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="card-title">
                            {{ __('Payments') }}
                        </h5>
                        <button type="button" class="btn btn-primary d-inline float-right" id="add_payment">
                            <i class="fa fa-plus"></i> {{ __('Payment') }}
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" class="btn btn-warning d-inline" id="create_payment_method_button"
                            data-toggle="modal" data-target="#create_payment_method_modal">
                            <i class="fa fa-plus"></i> {{ __('Payment method') }}
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 table-responsive">
                        @php
                            $payments_count = 0;
                        @endphp
                        <table class="table table-striped table-bordered" id="payments_table">
                            <thead>
                                <th width="30%">{{ __('Date') }}</th>
                                <th width="30%">{{ __('Amount') }}</th>
                                <th>{{ __('Payment method') }}</th>
                                <th width="10px"></th>
                            </thead>
                            <tbody>
                                @if (isset($group))
                                    @foreach ($group['payments'] as $payment)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control new_datepicker"
                                                    name="payments[{{ $payments_count }}][date]"
                                                    value="{{ $payment['date'] }}"
                                                    placeholder="{{ __('Date') }}" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control amount"
                                                    name="payments[{{ $payments_count }}][amount]"
                                                    value="{{ $payment['amount'] }}" id="" required>
                                            </td>
                                            <td>
                                                <select name="payments[{{ $payments_count }}][payment_method_id]"
                                                    id="" class="form-control payment_method_id" required>
                                                    <option value="" disabled selected>
                                                        {{ __('Select payment method') }}</option>
                                                    <option value="{{ $payment['payment_method_id'] }}" selected>
                                                        {{ $payment['payment_method']['name'] }}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger delete_payment">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php
                                            $payments_count++;
                                        @endphp
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <input type="hidden" id="payments_count" value="{{ $payments_count }}">
                    </div>
                </div>
            </div>
        </div>
        <!--\Payments -->
    </div>

</div>


<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <button type="submit" class="btn btn-primary form-control">{{ __('Save') }}</button>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <button type="button" onclick="generatePDF()"
            class="btn btn-primary form-control">{{ __('Generate Simple Invoice') }}</button>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <a href="{{ route('admin.groups.index') }}"
            class="btn btn-danger form-control cancel_form">{{ __('Cancel') }}</a>
    </div>
</div>


<br>


<!-- Include pdfmake library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

<script>
    function generatePDF() {
        function calculateTotalPrice() {
            var subtotal = parseFloat(document.getElementById('subtotal').value);
            var discount = parseFloat(document.getElementById('discount').value);
            var total = parseFloat(document.getElementById('total').value);
            var totalPrice = subtotal - discount;
            return totalPrice;
        }

        var content = [{
                text: 'Invoice',
                style: 'header'
            },
            {
                text: 'Item Details',
                style: 'subheader'
            },
            getTableContent('selected_tests'),
            getTableContent('selected_cultures'),
            getTableContent('selected_services'),
            getTableContent('selected_packages'),
            // Add more space above the Pricing Details section
            {
                text: '\n\n\n'
            },
            // { text: 'Pricing Details', style: 'subheader', alignment: 'right' },
            {
                columns: [{
                        width: '*',
                        text: 'Subtotal:',
                        style: 'label',
                        alignment: 'right'
                    },
                    {
                        width: 'auto',
                        text: document.getElementById('subtotal').value + ' €',
                        style: 'value',
                        alignment: 'right'
                    }
                ]
            },
            {
                columns: [{
                        width: '*',
                        text: 'Discount:',
                        style: 'label',
                        alignment: 'right'
                    },
                    {
                        width: 'auto',
                        text: parseFloat(document.getElementById('discount').value).toFixed(2) + ' €',
                        style: 'value',
                        alignment: 'right'
                    }
                ]
            },
            // {
            //   columns: [
            //     { width: '*', text: 'Total:', style: 'label', alignment: 'right' },
            //     { width: 'auto', text: document.getElementById('total').value + ' €', style: 'value', alignment: 'right' }
            //   ]
            // },
            // Add an overline above the total price
            {
                text: 'Total Price: ' + calculateTotalPrice().toFixed(2) + ' €',
                style: 'total',
                alignment: 'right',
                decoration: 'overline',
            }
        ];

        var docDefinition = {
            content: content,
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    alignment: 'center',
                    margin: [0, 0, 0, 10]
                },
                subheader: {
                    fontSize: 16,
                    bold: true,
                    margin: [0, 10, 0, 5]
                },
                label: {
                    fontSize: 14,
                    bold: true,
                    margin: [0, 0, 10, 5],
                    alignment: 'right'
                },
                value: {
                    fontSize: 14,
                    margin: [0, 0, 10, 5],
                    alignment: 'right'
                },
                total: {
                    fontSize: 14,
                    bold: true,
                    margin: [0, 10, 0, 0],
                    decorationColor: 'black',
                    decorationStyle: 'solid'
                }
            }
        };

        pdfMake.createPdf(docDefinition).download('invoice.pdf');
    }

    function getTableContent(tableId) {
        var tableData = getTableData(tableId);
        if (tableData.length > 0) {
            return {
                table: {
                    headerRows: 1,
                    widths: ['50%', '30%', '*', '10%'],
                    body: tableData
                }
            };
        }
        return null;
    }

    function getTableData(tableId) {
        var tableData = [];
        var rows = document.querySelectorAll('#' + tableId + ' tr');

        rows.forEach(function(row) {
            var rowData = [];
            var columns = row.querySelectorAll('td');

            columns.forEach(function(column) {
                rowData.push(column.innerText.trim());
            });

            tableData.push(rowData);
        });

        return tableData;
    }
</script>
