<div class="row">

    
    <div class="col-lg-2">

        <div class="card card-primary">
            <div class="card-header">
                <h5 class="text-center m-0 p-0">
                    {{__('Avatar')}}
                </h5>
            </div>
            <div class="card-footer m-0 p-0 pt-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar" class="custom-file-input" id="avatar">
                                <label class="custom-file-label">{{__('Choose avatar')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body m-0 p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="@if(!empty($patient['avatar'])){{url('uploads/patient-avatar/'.$patient['avatar'])}}@else{{url('img/avatar.png')}}@endif" data-toggle="lightbox" data-title="Avatar">
                            <img src="@if(!empty($patient['avatar'])){{url('uploads/patient-avatar/'.$patient['avatar'])}}@else{{url('img/avatar.png')}}@endif"  class="img-thumbnail" id="patient_avatar" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger btn-sm float-right" id="delete_avatar" style="width:100%" patient_id="@if(isset($patient)){{$patient['id']}}@endif">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            
        </div>

    </div>

    <div class="col-lg-10">

        <div class="row">

            <div class="col-lg-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fa fa-user"></i>
                        </span>
                        </div>
                        <input type="text" class="form-control" placeholder="{{__('Patient Name  *')}}" name="name" id="name" @if(isset($patient)) value="{{$patient->name}}" @elseif(old('name')) value="{{old('name')}}" @endif required>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-passport"></i>
                    </span>
                    </div>
                    <input onkeypress="return event.charCode != 32" type="text" class="form-control" placeholder="{{__('Parent Name *')}}" name="passport_no" id="passport_no" @if(isset($patient)) value="{{$patient->passport_no}}" @elseif(old('passport_no')) value="{{old('passport_no')}}" @endif required>
                </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-globe"></i>
                            </span>
                            </div>
                            <select class="form-control" name="country_id" id="country_id">
                                <option value="" disabled selected>{{__('Select nationality')}}</option>
                                @if(isset($patient)&&isset($patient['country']))
                                    <option value="{{$patient['country_id']}}" selected>{{$patient['country']['nationality']}}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-id-card"></i>
                    </span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{__('National ID')}}" name="national_id" id="national_id" @if(isset($patient)) value="{{$patient->national_id}}" @elseif(old('national_id')) value="{{old('national_id')}}" @endif>
                </div>
                </div>
            </div>

            

            <div class="col-lg-4">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-envelope"></i>
                        </span>
                        </div>
                        <input type="email" class="form-control" placeholder="{{__('Email Address')}}" name="email" id="email" @if(isset($patient)) value="{{$patient->email}}" @elseif(old('email')) value="{{old('email')}}" @endif>
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
                        <input onkeypress="return event.charCode != 32" type="text" class="form-control" placeholder="{{__('Phone number')}}" name="phone" id="phone"  @if(isset($patient)) value="{{$patient->phone}}" @elseif(old('phone')) value="{{old('phone')}}" @endif>
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
                            <select class="form-control" name="gender" placeholder="{{__('Gender')}}" id="gender" required>
                                <option value="" disabled selected>{{__('Select Gender *')}}</option>
                                <option value="male"  @if(isset($patient)&&$patient['gender']=='male') selected @elseif(old('gender')=='male') selected  @endif>{{__('Male')}}</option>
                                <option value="female"  @if(isset($patient)&&$patient['gender']=='female') selected @elseif(old('gender')=='female') selected @endif>{{__('Female')}}</option>
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
                                <i class="fas fa-baby"></i>
                            </span>
                            </div>
                            <input type="text" class="form-control" placeholder="{{__('Date of birth *')}}" name="dob" id="dob" required @if(isset($patient)) value="{{$patient['dob']}}" @elseif(old('dob')) value="{{old('dob')}}" @endif>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pr-0">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-baby"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control" name="age" id="age" placeholder="{{__('Age *')}}" @if(!isset($patient)&&old('age')) value="{{old('age')}}" @endif>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pl-0">
                        <div class="input-group mb-3">
                            <select class="form-control" name="age_unit" id="age_unit" required>
                                <option value="" disabled selected>{{__('Select age unit *')}}</option>
                                <option value="years" @if(!isset($patient)&&old('age_unit')=='years') selected @endif>{{__('Years')}}</option>
                                <option value="months" @if(!isset($patient)&&old('age_unit')=='months') selected @endif>{{__('Months')}}</option>
                                <option value="days" @if(!isset($patient)&&old('age_unit')=='days') selected @endif>{{__('Days')}}</option>
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
                            <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address" id="address" @if(isset($patient)) value="{{$patient->address}}" @elseif(old('address')) value="{{old('address')}}" @endif>
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
                            <input type="text" class="form-control" placeholder="{{__('Profession')}}" name="profession" id="profession" @if(isset($patient)) value="{{$patient->profession}}" @elseif(old('profession')) value="{{old('profession')}}" @endif>
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
                            <input type="text" class="form-control" placeholder="{{__('City')}}" name="city" id="city" @if(isset($patient)) value="{{$patient->city}}" @elseif(old('city')) value="{{old('city')}}" @endif>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-file-contract"></i>
                    </span>
                    </div>
                    <select name="contract_id" id="contract_id" class="form-control">
                        <option value="" selected disabled>{{__('Select contract')}}</option>
                        @if(isset($patient)&&isset($patient['contract']))
                            <option value="{{$patient['contract_id']}}" selected>{{$patient['contract']['title']}}</option>
                        @elseif(old('contract_id'))
                            @php 
                                $contract=\App\Models\Contract::find(old('contract_id'));
                            @endphp
                            <option value="{{old('contract_id')}}" selected>{{$contract['title']}}</option>
                        @endif
                    </select>
                </div>
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
                                <i class="fas fa-mars"></i>
                            </span>
                            </div>
                            <select class="form-control" name="vaccinated" placeholder="{{__('Vaccinated')}}" id="vaccinated">
                                <option value="" disabled selected>{{__('Vaccinated *')}}</option>
                                <option value="Yes"  @if(isset($patient)&&$patient['vaccinated']=='Yes') selected @elseif(old('vaccinated')=='Yes') selected  @endif>{{__('Yes')}}</option>
                                <option value="No"  @if(isset($patient)&&$patient['vaccinated']=='No') selected @elseif(old('vaccinated')=='No') selected @endif>{{__('No')}}</option>
                            </select>
                        </div>
                    </div>
<div class="row">
<div class="col-lg-4">
                <div class="form-group">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-mars"></i>
                            </span>
                            </div>
                            <select class="form-control" name="vaccinemodel" placeholder="{{__('Select Vaccine Model')}}" id="vaccinemodel">
                                <option value="" disabled selected>{{__('Select Vaccine Model')}}</option>
                                <option value="Pfizer/BioNtech"  @if(isset($patient)&&$patient['vaccinemodel']=='Pfizer/BioNtech') selected @elseif(old('vaccinemodel')=='Pfizer/BioNtech') selected  @endif>{{__('Pfizer/BioNtech')}}</option>
                                <option value="AstraZeneca/Oxford"  @if(isset($patient)&&$patient['vaccinemodel']=='AstraZeneca/Oxford') selected @elseif(old('vaccinemodel')=='AstraZeneca/Oxford') selected @endif>{{__('AstraZeneca/Oxford')}}</option>
                                <option value="Johnson&Johnson"  @if(isset($patient)&&$patient['vaccinemodel']=='Johnson&Johnson') selected @elseif(old('vaccinemodel')=='Johnson&Johnson') selected @endif>{{__('Johnson&Johnson')}}</option>
                                <option value="Sanofi/GSK"  @if(isset($patient)&&$patient['vaccinemodel']=='Sanofi/GSK') selected @elseif(old('vaccinemodel')=='Sanofi/GSK') selected @endif>{{__('Sanofi/GSK')}}</option>
                                <option value="Moderna"  @if(isset($patient)&&$patient['vaccinemodel']=='Moderna') selected @elseif(old('vaccinemodel')=='Moderna') selected @endif>{{__('Moderna')}}</option>
                                <option value="Curevac"  @if(isset($patient)&&$patient['vaccinemodel']=='Curevac') selected @elseif(old('vaccinemodel')=='Curevac') selected @endif>{{__('Curevac')}}</option>
                            </select>
                        </div>
                    </div>
                </div>
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
                                <i class="fas fa-baby"></i>
                            </span>
                            </div>
                            <input type="text" class="form-control datepicker" placeholder="{{__('Date of 1st Vaccine')}}" name="datevaccine1" id="datevaccine1" @if(isset($patient)) value="{{$patient['datevaccine1']}}" @elseif(old('datevaccine1')) value="{{old('datevaccine1')}}" @endif>
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
                            <input type="text" class="form-control datepicker" placeholder="{{__('Date of 2nd Vaccine')}}" name="datevaccine2" id="datevaccine2" @if(isset($patient)) value="{{$patient['datevaccine2']}}" @elseif(old('datevaccine2')) value="{{old('datevaccine2')}}" @endif>
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
                            <input type="text" class="form-control datepicker" placeholder="{{__('Date of 3rd Vaccine')}}" name="datevaccine3" id="datevaccine3" @if(isset($patient)) value="{{$patient['datevaccine3']}}" @elseif(old('datevaccine3')) value="{{old('datevaccine3')}}" @endif>
                        </div>
                    </div>
                </div>
                       <!--API-->
                        <?php
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => 'http://46.99.206.7:8091/api/Subject',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 10,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_HTTPHEADER => [
                                'Accept: application/json',
                                'Content-Type: application/json',
                                'Authorization: Basic UEFXUzoxMjNQQVdTMQ==',
                                'Content-Length: 0'
                            ],
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        ?>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    @if ($response != '' )
                                    <input type="text" class="form-control" placeholder="{{__('api')}}" name="api" id="api" value="1" @if(isset($patient)) value="{{$patient->api}}" @elseif(old('api')) value="{{old('api')}}" @endif hidden>
                                    @else
                                    <input type="text" class="form-control" placeholder="{{__('api')}}" name="api" id="api" value="0" @if(isset($patient)) value="{{$patient->api}}" @elseif(old('api')) value="{{old('api')}}" @endif hidden>
                                    @endif

                                </div>

                            </div>
                        </div>
				
				</div>
				</div>
				</div>

    </div>

</div>

<script>
        var dateInput = document.getElementById("dob");
        dateInput.addEventListener('input', function(event) {
        var inputText = event.target.value;
        var inputNums = inputText.replace(/[^0-9]/g, '');
        var day = inputNums.substring(0, 2);
        var month = inputNums.substring(2, 4);
        var year = inputNums.substring(4, 8);
        var dateNum = day + '-' + month + '-' + year;
        dateInput.value = dateNum;
        });
</script>
