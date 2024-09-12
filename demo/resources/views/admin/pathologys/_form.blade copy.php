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
        <select id="patient_id" name="patient_id" class="form-control" required>
            @if (isset($pathology) && isset($pathology['patient']))
                <option value="{{ $pathology['patient']['id'] }}" selected>{{ $pathology['patient']['name'] }}
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
                id="name" @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['name'] }}" @endif
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
                id="phone" @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['phone'] }}" @endif
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
                    @if (isset($pathology) && isset($pathology['patient']))  @endif disabled required>
                    <option value="" disabled selected>{{ __('Select Gender') }}</option>
                    <option value="male" @if (isset($pathology) && $pathology['patient']['gender'] == 'male') selected @endif>
                        {{ __('Male') }}</option>
                    <option value="female" @if (isset($pathology) && $pathology['patient']['gender'] == 'female') selected @endif>{{ __('Female') }}
                    </option>
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
                    @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['address'] }}" @endif
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
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                <input type="email" class="form-control" id="email" placeholder="{{ __('Email') }}"
                    name="email" required
                    @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['email'] }}" @endif disabled>
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
                <input type="text" class="form-control datepicker" id="dob"
                    placeholder="{{ __('Date of birth') }}" name="dob" required
                    @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['dob'] }}" @endif
                    style="z-index: 1000!important" disabled>
            </div>
        </div>
    </div>
</div>

</div>
<hr style="background-color:white;">


<div class="row patient_info">
<div class="col-lg-6">
    <div class="form-group">
        <div class="form-group">
            <label for="patient_id">{{ __('Reference') }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-edit"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="{{ __('Reference') }}" name="reference"
                    id="reference" @if (isset($pathology)) {{ $pathology['reference'] }} @endif>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="form-group">
        <label for="patient_id">{{ __('Doctor') }}</label>

        <select name="doctor_id" id="select_doctors" placeholder="{{ __('Select Doctors') }}"
            class="form-control">
            @if (isset($pathology))
                @foreach ($pathology['doctors'] as $doctor)
                    <option value="{{ $doctor['id'] }}" selected>{{ $doctor['doctor']['name'] }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="col-lg-12">
    <div class="form-group">
        <div class="form-group">
            <label for="patient_id">{{ __('Clinical diagnoses') }}</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-diagnoses"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="{{ __('Diagnoza Klinike') }}"
                    name="clinical_diagnosis" id="clinical_diagnosis"
                    @if (isset($pathology)) {{ $pathology['clinical_diagnosis'] }} @endif>
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
            <h5 class="card-title" style="padding-top:32px;">
                {{ __('Visit details') }}
            </h5>

            <div class="card-body">
                <div class="col-lg-4" style="text-align:right;float:right; ">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <select name="report" class="form-control" id="SelectA" onclick="display();"
                                style="background:transparent; color:white">
                                <option value="1">Select report</option>
                                <option value="pathology">Patologjik</option>
                                <option value="cytological">Citologjik</option>
                                <option value="pathology2">Patologjik 2</option>
                            </select>
                            <script>
                                function display() {
                                    var x = document.getElementById('SelectA').value;

                                    if (x == "pathology") {
                                        document.getElementById('a').style.display = "block";
                                        document.getElementById('b').style.display = "none";
                                        document.getElementById('c').style.display = "none";
                                    } else if (x == "cytological") {
                                        document.getElementById('a').style.display = "none";
                                        document.getElementById('b').style.display = "block";
                                        document.getElementById('c').style.display = "none";

                                    } else if (x == "pathology2") {
                                        document.getElementById('a').style.display = "none";
                                        document.getElementById('b').style.display = "none";
                                        document.getElementById('c').style.display = "block";

                                    } else {

                                        document.getElementById('1').style.display = "block";
                                        document.getElementById('a').style.display = "none";
                                        document.getElementById('b').style.display = "none";
                                        document.getElementById('c').style.display = "none";

                                    }

                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <!--Empty-->
            <div id="1" style="display: none;">
            </div>
            <!--Patologjik-->
            <div id="a" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="microscopic_examination">{{ __('Microscopic examination') }}</label>
                            <textarea name="microscopic_examination" id="microscopic_examination" rows="3" class="form-control"
                                placeholder="{{ __('Microscopic examination') }}">@if (isset($pathology)) {{ $pathology['microscopic_examination'] }}  @endif</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="macroscopic_examination">{{ __('Macroscopic examination') }}</label>
                            <textarea name="macroscopic_examination" id="macroscopic_examination" rows="3" class="form-control"
                            placeholder="{{ __('Macroscopic examination') }}">@if (isset($pathology)) 
                            {{ $pathology['macroscopic_examination'] }} @endif</textarea>
                        </div>
                    </div>
                </div>
                <!--<div class="row">-->
                <!--    <div class="col-lg-12">-->
                <!--        <div class="form-group">-->
                <!--            <label for="sample">{{ __('Sample') }}</label>-->
                <!--            <textarea name="sample" id="sample" rows="1" class="form-control" placeholder="{{ __('Sample') }}">-->
                <!--                @if (isset($pathology))-->
                <!--                   {{ $pathology['sample'] }}-->
                <!--                @endif-->
                <!--                </textarea>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->


            </div>
            <!--Citologjik-->
            <div id="b" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="cytological_examination">{{ __('Cytological examination') }}</label>
                            <textarea name="cytological_examination" id="cytological_examination" rows="3" class="form-control" 
                            placeholder="{{ __('Cytological examination') }}">@if (isset($pathology)) 
                            {{ $pathology['cytological_examination'] }}  @endif</textarea>
                        </div>
                    </div>
                </div>
                <!--<div class="row">-->
                <!--    <div class="col-lg-12">-->
                <!--        <div class="form-group">-->
                <!--            <label for="sample">{{ __('Sample') }}</label>-->
                <!--            <textarea name="sample" id="sample" rows="1" class="form-control" placeholder="{{ __('Sample') }}">-->
                <!--                @if (isset($pathology))-->
                <!--                     {{ $pathology['sample'] }}-->
                <!--                @endif-->
                <!--                </textarea>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="patient_id">{{ __('Lindje') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="{{ __('Lindje') }}"
                                        name="births" id="births"
                                        @if (isset($pathology)) {{ $pathology['births'] }} @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('Aborte') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="{{ __('Aborte') }}"
                                    name="abortions" id="abortions"
                                    @if (isset($pathology)) {{ $pathology['abortions'] }} @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('Menstruacionet e fundit') }}</label>
                            <div class="input-group mb-3">
                                <input type="date" class="form-control"
                                    placeholder="{{ __('Menstruacionet e fundit') }}" name="menstrual_cycle"
                                    id="menstrual_cycle"
                                    @if (isset($pathology)) {{ $pathology['menstrual_cycle'] }} @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('PAP-teste te mehershme') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"
                                    placeholder="{{ __('PAP-teste te mehershme') }}" name="pap_tests"
                                    id="pap_tests"
                                    @if (isset($pathology)) {{ $pathology['pap_tests'] }} @endif>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="patient_id">{{ __('Hysterektomia') }}</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('Hysterektomia') }}" name="hysterectomy" id="hysterectomy"
                                        @if (isset($pathology)) {{ $pathology['hysterectomy'] }} @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('Kimioterapi') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="{{ __('Kimioterapi') }}"
                                    name="chemotherapy" id="chemotherapy"
                                    @if (isset($pathology)) {{ $pathology['chemotherapy'] }} @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('Rrezatim') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="{{ __('Rrezatim') }}"
                                    name="radiation" id="radiation"
                                    @if (isset($pathology)) {{ $pathology['radiation'] }} @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="patient_id">{{ __('Terapi hormonale') }}</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"
                                    placeholder="{{ __('Terapi hormonale') }}" name="hormonal_therapy" id="hormonal_therapy"
                                    @if (isset($pathology)) {{ $pathology['hormonal_therapy'] }} @endif>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Patologjik 2-->
            <div id="c" style="display: none;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="histopathological">{{ __('Histopathological diagnosis') }}</label>
                            <textarea name="histopathological" id="histopathological" rows="1" class="form-control" 
                            placeholder="{{ __('Histopathological') }}" >@if (isset($pathology)) {{ $pathology['histopathological'] }} 
                                @endif</textarea>
                        </div>
                    </div>
                </div>
                <hr style="height:4px; background: grey;"><br><br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="microscopic_examination">{{ __('Microscopic examination') }}</label>
                            <textarea name="microscopic_examination" id="microscopic_examination" rows="3" class="form-control" 
                            placeholder="{{ __('Microscopic examination') }}">@if (isset($pathology)) {{ $pathology['microscopic_examination'] }}
                                        @endif</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="macroscopic_examination">{{ __('Macroscopic examination') }}</label>
                            <textarea name="macroscopic_examination" id="macroscopic_examination" rows="3" class="form-control" 
                            placeholder="{{ __('Macroscopic examination') }}">@if (isset($pathology))
                                    {{ $pathology['macroscopic_examination'] }}
                                @endif</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <br><br>
            
             <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="sample">{{ __('Sample') }}</label>
                            <textarea name="sample" id="sample" rows="1" class="form-control" placeholder="{{ __('Sample') }}"
                            >@if (isset($pathology)) {{ $pathology['sample'] }}  @endif</textarea>
                        </div>
                    </div>
                </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="anamnesis">{{ __('Patologu') }}</label>
                        <input type="text" class="form-control"
                            value="Prof. Ass. Dr. Labinot Shahini, MD, PhD" name="pathologist" id="pathologist"
                            @if (isset($pathology)) {{ $pathology['pathologist'] }} @endif readonly>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<input name="visit_type" id="visit_type" value="Pathology" hidden>
