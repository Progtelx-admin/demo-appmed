


    <!-- Patient details -->
    <div class="row patient_info">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="patient_id">{{ __('Select Patient') }}</label>
            @can('create_patient')
            <button type="button" class="btn btn-warning btn-sm add_patient float-right" data-toggle="modal"
                data-target="#patient_modal">
                <i class="fa fa-exclamation-triangle"></i> {{ __('Not Listed ?') }}
            </button>
            @endcan

        <label for="patient_id">{{ __('Patient') }}</label>
        <select name="patient_id" id="patient_id" class="form-control" required
            @can('disable_patientfields') disabled @else @endif>
            @if (isset($healthcertificate) && isset($healthcertificate['patient']))
                <option value="{{ $healthcertificate['patient']['id'] }}" selected>
                    {{ $healthcertificate['patient']['name'] }}
                </option>
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
                    <input type="text" class="form-control" placeholder="{{ __('Patient Name') }}" name="name"
                        id="name"
                        @if (isset($healthcertificate) && isset($healthcertificate['patient'])) value="{{ $healthcertificate['patient']['name'] }}" @endif
                        disabled required>
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
                    <input type="text" class="form-control" placeholder="{{ __('Phone number') }}" name="phone"
                        id="phone"
                        @if (isset($healthcertificate) && isset($healthcertificate['patient'])) value="{{ $healthcertificate['patient']['phone'] }}" @endif
                        disabled required>
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
                        <select class="form-control" name="gender" placeholder="{{ __('Gender') }}" id="gender"
                            @if (isset($healthcertificate) && isset($healthcertificate['patient']))  @endif disabled required>
                            <option value="" disabled selected>{{ __('Select Gender') }}</option>
                            <option value="male" @if (isset($healthcertificate) && $healthcertificate['patient']['gender'] == 'male') selected @endif>
                                {{ __('Male') }}</option>
                            <option value="female" @if (isset($healthcertificate) && $healthcertificate['patient']['gender'] == 'female') selected @endif>
                                {{ __('Female') }}</option>
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
                        <input type="text" class="form-control" placeholder="{{ __('Address') }}" name="address"
                            id="address"
                            @if (isset($healthcertificate) && isset($healthcertificate['patient'])) value="{{ $healthcertificate['patient']['address'] }}" @endif
                            disabled required>
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
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="national_id"
                            placeholder="{{ __('Personalid') }}" name="national_id" required
                            @if (isset($healthcertificate) && isset($healthcertificate['patient'])) value="{{ $healthcertificate['patient']['national_id'] }}" @endif
                            disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-baby"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control datepicker" id="dob"
                            placeholder="{{ __('Date of birth') }}" name="dob" required
                            @if (isset($healthcertificate) && isset($healthcertificate['patient'])) value="{{ $healthcertificate['patient']['dob'] }}" @endif
                            style="z-index: 1000!important" disabled>
                    </div>
                </div>
            </div>
        </div>
         <div class="col-lg-2">
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fas fa-file-contract"></i>
                    </span>
                  </div>
                  <select name="contract_id" id="patient_contract_id" class="form-control">
                    <option value="" selected disabled>{{__('Select contract')}}</option>
                  </select>
                </div>
              </div>
            </div>
            
            <!--<div class="col-lg-4">-->
            <!--<div class="form-group">-->
            <!--    <label for="doctor_id">{{ __('Doctor') }}</label>-->
            <!--    <select name="doctor_id" id="doctor_id" class="form-control">-->
            <!--        <option value="">Select a Doctor</option>-->
            <!--        @foreach ($doctors as $doctor)-->
            <!--            <option value="{{ $doctor->id }}"-->
            <!--                @if (isset($healthcertificate) && $healthcertificate->doctor_id == $doctor->id) selected @endif-->
            <!--            >-->
            <!--                {{ $doctor->name }}-->
            <!--            </option>-->
            <!--        @endforeach-->
            <!--    </select>-->
            <!--</div>-->
            <!--</div>-->
            
            <div class="col-lg-4">
            <div class="form-group">
                <label for="doctor_id">{{ __('Doctor') }}</label>
                <select name="doctor_id" id="doctor_id" class="form-control" required
                    @can('disable_patientfields') disabled @else @endif>
                    <option value="">Select a Doctor</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            @if (isset($healthcertificate) && $healthcertificate->doctor_id == $doctor->id) selected @endif
                        >
                            {{ $doctor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
            <div class="col-lg-4">
<div class="form-group">
    <label for="branch_id">{{ __('Branch') }}</label>
    <select name="branch_id" id="branch_id" class="form-control" required @can('disable_patientfields') disabled @endcan>
        <option value="">Select a Branch</option>
        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}"
                @if(isset($healthcertificate) && $healthcertificate->branch_id == $branch->id) selected @endif
            >
                {{ $branch->name }}
            </option>
        @endforeach
    </select>
</div>


        </div>



    </div>
    <!-- \Patient details -->
@can('view_doctorfields')
    <!-- Visit details -->
  
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title">
                        {{ __('Health Certificate Details') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!--<div class="col-lg-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <label for="cultures">{{ __('Doctor') }}</label>-->
                        <!--        <select name="doctor_id" id="select_doctors" class="form-control">-->
                        <!--            @if (isset($healthcertificate) && isset($healthcertificate['doctor'])))-->
                        <!--                @foreach ($healthcertificate['doctors'] as $doctor)-->
                        <!--                    <option value="{{ $doctor['testable_id'] }}" selected>-->
                        <!--                        {{ $doctor['doctor']['name'] }}</option>-->
                        <!--                @endforeach-->
                        <!--            @endif-->
                        <!--        </select>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="cultures">{{ __('Institucion Type') }}</label>
                                <select class="form-control" name="visit_type"
                                    placeholder="{{ __('Institution Type') }}" id="visit_type" required>
                                    <option value="" selected>{{ __('Select Institution') }}</option>
                                    <option value="Publik"
                                        @if (isset($healthcertificate) && $healthcertificate['visit_type'] == 'Publik') selected @elseif(old('visit_type') == 'Publik') selected @endif>
                                        {{ __('Publik') }}</option>
                                    <option value="Privat"
                                        @if (isset($healthcertificate) && $healthcertificate['visit_type'] == 'Privat') selected @elseif(old('visit_type') == 'Privat') selected @endif>
                                        {{ __('Privat') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="cultures">{{ __('Alergy') }}</label>
                                <select class="form-control" name="alergy" placeholder="{{ __('Alergy') }}"
                                    id="alergy">
                                    <option value="" selected>{{ __('Zgjedh') }}</option>
                                    <option value="Mohon"
                                        @if (isset($healthcertificate) && $healthcertificate['alergy'] == 'Mohon') selected @elseif(old('alergy') == 'Mohon') selected @endif>
                                        {{ __('Mohon') }}</option>
                                    <option value="Pohon"
                                        @if (isset($healthcertificate) && $healthcertificate['alergy'] == 'Pohon') selected @elseif(old('alergy') == 'Pohon') selected @endif>
                                        {{ __('Pohon') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                               
                                <input placeholder="{{ __('Nr Reg') }}" value="{{ isset($healthcertificate['protocol_no2']) ? $healthcertificate['protocol_no2'] : '' }}" name="protocol_no2" id="protocol_no2" class="form-control">

                                <input value="00{{$generate_no}}" name="reg_no" id="reg_no" class="form-control">
                            </div>
                        </div>
                            <div>
                            <div>
                                <input name="visit_date" type="text" class="form-control datepicker_month" id="filter_income" value="{{get_system_date('','d-m-Y')}}" hidden>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
                        <!--<div class="col-lg-4">-->
                        <!--    <div class="form-group">-->
                        <!--        <label for="reg_no">{{ __('Reg No') }}</label>-->
                        <!--        <input name="reg_no" id="reg_no" class="form-control"-->
                        <!--            @if (isset($healthcertificate['branch']['protocol_cert']))
                                            {{ $healthcertificate['branch']['protocol_cert'] }}
                                        @endif>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="ta">{{ __('Ta') }}</label>
                                <input name="ta" id="ta" class="form-control"
                                    placeholder="{{ __('Ta') }}"@if (isset($healthcertificate)) {{ $healthcertificate['ta'] }} value="{{ $healthcertificate['ta'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="spo2">{{ __('SPO2') }}</label>
                                <input name="spo2" id="spo2" class="form-control"
                                    placeholder="{{ __('SPO2') }}"@if (isset($healthcertificate)) {{ $healthcertificate['spo2'] }} value="{{ $healthcertificate['spo2'] }}" @endif>
                            </div>

                            <div class="form-group">
                                <label for="fc">{{ __('FC') }}</label>
                                <input name="fc" id="fc" class="form-control"
                                    placeholder="{{ __('FC') }}"@if (isset($healthcertificate) && isset($healthcertificate)) value="{{ $healthcertificate['fc'] }}" @endif>
                            </div>
                        </div>

                        <div class="col-lg-12">
<div class="form-group">
    <label for="comment">{{ __('Comment') }}</label>
    <input value="Në bazë të anamnezës, ekzaminimit psiko fizik, historisë mjekësore,  ekzaminimeve laboratorike dhe EKG-së, konstatoj se gjendja e përgjithme shëndetësore e kandidatit/es është e mirë dhe është i/e aftë për punë.<br><br>
                    Certifikata e lëshuar mund të përdoret vetëm për çështje punësimi" 
        name="comment" id="comment" rows="3" class="form-control" @if(isset($healthcertificate)){{ $healthcertificate['comment'] }}@endif >
</div>               </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endcan  

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
    $('#doctor_id').select2();
});

    $(document).ready(function () {
    $('#branch_id').select2();
});

</script>

