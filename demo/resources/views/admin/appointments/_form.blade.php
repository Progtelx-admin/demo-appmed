    <!-- Patient details -->
    <div class="row patient_info">
        <div class="col-lg-12">
            <div class="form-group">
                <label for="patient_id">{{__('Select Patient')}}</label>
                @can('create_patient')
                    <button type="button" class="btn btn-warning btn-sm add_patient float-right"  data-toggle="modal" data-target="#patient_modal">
                        <i class="fa fa-exclamation-triangle"></i>  {{__('Not Listed ?')}}
                    </button>
                @endcan
                <select id="patient_id" name="patient_id" class="form-control" required>
                    @if(isset($appointment)&&isset($appointment['patient']))
                        <option value="{{$appointment['patient']['id']}}" selected>{{$appointment['patient']['name']}}</option>
                    @endif
                </select>
            </div>
        </div>            

        <div class="col-lg-4">
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-user"></i>
                    </span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{__('Patient Name')}}" name="name" id="name" @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['name']}}"  @endif disabled required>
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
                    <input type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone" @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['phone']}}"  @endif disabled required>
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
                    <input type="text" class="form-control" placeholder="{{__('National Id')}}" name="national_id" id="national_id" @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['national_id']}}"  @endif disabled required>
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
                    <input type="text" class="form-control" placeholder="{{__('Passport No')}}" name="passport_no" id="passport_no" @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['passport_no']}}"  @endif disabled required>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-mars"></i>
                        </span>
                        </div>
                        <select class="form-control" name="gender" placeholder="{{__('Gender')}}" id="gender" @if(isset($appointment)&&isset($appointment['patient']))  @endif disabled required>
                            <option value="" disabled selected>{{__('Select Gender')}}</option>
                            <option value="male"  @if(isset($appointment)&&$appointment['patient']['gender']=='male') selected @endif>{{__('Male')}}</option>
                            <option value="female"  @if(isset($appointment)&&$appointment['patient']['gender']=='female') selected @endif>{{__('Female')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['address']}}"  @endif disabled required>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-envelope"></i>
                        </span>
                        </div>
                        <input type="email" class="form-control" id="email" placeholder="{{__('Email')}}" name="email" required @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['email']}}"  @endif disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-baby"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control datepicker" id="dob" placeholder="{{__('Date of birth')}}" name="dob" required @if(isset($appointment)&&isset($appointment['patient'])) value="{{$appointment['patient']['dob']}}"  @endif style="z-index: 1000!important" disabled>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <!-- \Patient details -->

    <!-- Visit details -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">
                        {{__('Appointment details')}}
                    </h5>
                </div>
                <div class="card-body">
                      <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="cultures">{{__('Doctor')}}</label>
                                <select name="doctor_name" id="select_doctors" class="form-control">
                                    @if(isset($appointment))
                                        @foreach($appointment['doctors'] as $doctor)
                                            <option value="{{$doctor['testable_id']}}" selected>{{$doctor['doctor']['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                     </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                        </div>
                                        <input type="hidden" class="form-control flatpickr" id="visit_date" placeholder="{{__('Visit Date')}}" name="visit_date" required @if(isset($appointment)) value="{{$appointment['visit_date']}}" @endif style="z-index: 1000!important" readonly>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        
                        <!--<div class="col-lg-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <div class="form-group">-->
                        <!--            <div class="input-group mb-3">-->
                        <!--                <div class="input-group-prepend">-->
                        <!--                <span class="input-group-text" id="basic-addon1">-->
                        <!--                    <i class="fas fa-calendar"></i>-->
                        <!--                </span>-->
                        <!--                </div>-->
                        <!--                <input type="text" class="form-control flatpickr" id="from_date" placeholder="{{__('Appointment Date')}}" name="from_date" required @if(isset($appointment)) value="{{$appointment['from_date']}}" @endif style="z-index: 1000!important" readonly>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="col-lg-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <div class="form-group">-->
                        <!--            <div class="input-group mb-3">-->
                        <!--                <div class="input-group-prepend">-->
                        <!--                <span class="input-group-text" id="basic-addon1">-->
                        <!--                    <i class="fas fa-calendar"></i>-->
                        <!--                </span>-->
                        <!--                </div>-->
                        <!--                <input type="text" class="form-control flatpickr" id="to_date" placeholder="{{__('Free Date')}}" name="to_date" @if(isset($appointment)) value="{{$appointment['to_date']}}" @endif style="z-index: 1000!important" readonly>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <br />
                        <div class="col-lg-10">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        </div>
                                        <input value="1" type="text" class="form-control" id="visit_date" placeholder="{{__('Appointment address')}}" name="visit_address" @if(isset($appointment)) value="{{$appointment['branch_id']}}" @endif required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- \Visit details -->

    <!-- Location -->
    
    <!-- \Location -->

    <!-- Attachment -->
    
    <!-- \Attachment -->
    
