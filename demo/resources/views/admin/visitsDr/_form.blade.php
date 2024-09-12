    <!-- Patient details -->
    <div class="row patient_info">

        <div class="col-lg-12">
            <div class="form-group">
                <label for="patient_id">{{ __('Select Patient') }}</label>
                <!--@can('create_patient')-->
                <!--    <button type="button" class="btn btn-warning btn-sm add_patient float-right" data-toggle="modal"-->
                <!--        data-target="#patient_modal">-->
                <!--        <i class="fa fa-exclamation-triangle"></i> {{ __('Not Listed ?') }}-->
                <!--    </button>-->
                <!--@endcan-->
                <select id="patient_id" name="patient_id" class="form-control"  disabled required>
                    @if (isset($visit) && isset($visit['patient']))
                        <option value="{{ $visit['patient']['id'] }}" selected>{{ $visit['patient']['name'] }}</option>
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
                        id="name" @if (isset($visit) && isset($visit['patient'])) value="{{ $visit['patient']['name'] }}" @endif
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
                        id="phone" @if (isset($visit) && isset($visit['patient'])) value="{{ $visit['patient']['phone'] }}" @endif
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
                            @if (isset($visit) && isset($visit['patient']))  @endif disabled required>
                            <option value="" disabled selected>{{ __('Select Gender') }}</option>
                            <option value="male" @if (isset($visit) && $visit['patient']['gender'] == 'male') selected @endif>
                                {{ __('Male') }}</option>
                            <option value="female" @if (isset($visit) && $visit['patient']['gender'] == 'female') selected @endif>
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
                            @if (isset($visit) && isset($visit['patient'])) value="{{ $visit['patient']['address'] }}" @endif
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
                            @if (isset($visit) && isset($visit['patient'])) value="{{ $visit['patient']['email'] }}" @endif disabled>
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
                            @if (isset($visit) && isset($visit['patient'])) value="{{ $visit['patient']['dob'] }}" @endif
                            style="z-index: 1000!important" disabled>
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
                        {{ __('Visit details') }}
                    </h5>
                </div>
                <div class="card-body">
                    <!--<div class="col-lg-4">-->
                    <!--<div class="form-group">-->
                    <!--    <div class="form-group">-->
                    <!--        <div class="input-group mb-3">-->
                    <!--            <div class="input-group-prepend">-->
                    <!--            <span class="input-group-text" id="basic-addon1">-->
                    <!--                <i class="fas fa-map-marker-alt"></i>-->
                    <!--            </span>-->
                    <!--            </div>-->
                    <!--            <select class="form-control" name="visit_type" placeholder="{{ __('Visit Type') }}" id="visit_type" required>-->
                    <!--                <option value="" selected>{{ __('Select Visit Type') }}</option>-->
                    <!--                <option value="Home"  @if (isset($visit) && $visit['visit_type'] == 'home') selected @elseif(old('visit_type') == 'home') selected @endif>{{ __('Home') }}</option>-->
                    <!--                <option value="Clinic"  @if (isset($visit) && $visit['visit_type'] == 'clinic') selected @elseif(old('visit_type') == 'clinic') selected @endif>{{ __('Clinic') }}</option>-->
                    <!--            </select>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <input name="visit_type" value="Clinic" hidden>
                    <div class="row">

                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="cultures">{{ __('Doctor') }}</label>
                                <select name="doctors[]" id="select_doctors" class="form-control" multiple>
                                    @if (isset($visit))
                                        @foreach ($visit['doctors'] as $doctor)
                                            <option value="{{ $doctor['testable_id'] }}" selected>
                                                {{ $doctor['doctor']['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="cultures">{{ __('Visit Date') }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control flatpickr" id="visit_date"
                                            placeholder="{{ __('Visit Date') }}" name="visit_date" required
                                            @if (isset($visit)) value="{{ $visit['visit_date'] }}" @endif
                                            style="z-index: 1000!important" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="branches">{{ __('Branch') }}</label>
                                <select name="branch_id" class="form-control" id="branch-select"required>
                                    <!--<option value="">Select a branch</option>-->
                                     <option @if (isset($visit)) value="{{ $visit['branch_id'] }}" @endif>{{ $visit->branch->name ?? 'Select a branch' }}</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">


                        <!--<div class="col-lg-8">-->
                        <!--    <div class="form-group">-->
                        <!--        <div class="form-group">-->
                        <!--            <div class="input-group mb-3">-->
                        <!--                <div class="input-group-prepend">-->
                        <!--                <span class="input-group-text" id="basic-addon1">-->
                        <!--                    <i class="fas fa-map-marker-alt"></i>-->
                        <!--                </span>-->
                        <!--                </div>-->
                        <!--                <input type="text" class="form-control" id="visit_date" placeholder="{{ __('Visit address') }}" name="visit_address" @if (isset($visit)) value="{{ $visit['visit_address'] }}" @endif required>-->
                        <!--            </div>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="tests">{{ __('Tests') }}</label>
                                <select name="tests[]" id="select_tests" class="form-control" multiple>
                                    @if (isset($visit))
                                        @foreach ($visit['tests'] as $test)
                                            <option value="{{ $test['testable_id'] }}" selected>
                                                {{ $test['test']['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="cultures">{{ __('Cultures') }}</label>
                                <select name="cultures[]" id="select_cultures" class="form-control" multiple>
                                    @if (isset($visit))
                                        @foreach ($visit['cultures'] as $culture)
                                            <option value="{{ $culture['testable_id'] }}" selected>
                                                {{ $culture['culture']['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="packages">{{ __('Packages') }}</label>
                                <select name="packages[]" id="select_packages" class="form-control" multiple>
                                    @if (isset($visit))
                                        @foreach ($visit['packages'] as $package)
                                            <option value="{{ $package['testable_id'] }}" selected>
                                                {{ $package['package']['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="antibiotics">{{ __('Antibiotics & Therapy') }}</label>
                                <select name="antibiotics[]" id="select_antibiotics" class="form-control" multiple>
                                  @if (isset($visit['antibiotics']) && is_array($visit['antibiotics']))
    @foreach ($visit['antibiotics'] as $antibiotic)
        <option value="{{ $antibiotic['testable_id'] }}" selected>
            {{ $antibiotic['antibiotic']['name'] }}
        </option>
    @endforeach
@endif

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" style="display: none;">
                            <div class="form-group">
                                <label for="services">{{ __('Services') }}</label>
                                <select name="services[]" id="select_services" class="form-control" multiple>
                                    @if (isset($visit))
                                        @foreach ($visit['services'] as $service)
                                            <option value="{{ $service['testable_id'] }}" selected>
                                                {{ $service['service']['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">


                            <div class="form-group">
                                <label for="anamnesis">{{ __('Anamnesis / Patient complaints') }}</label>
                                <textarea name="anamnesis" id="anamnesis" rows="3" class="form-control"
                                    placeholder="{{ __('Anamnesis / Patient complaints') }}">
@if (isset($visit))
{{ $visit['anamnesis'] }}
@endif
</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="examination">{{ __('Examination') }}</label>
                                <textarea name="examination" id="examination" rows="3" class="form-control"
                                    placeholder="{{ __('Examination') }}">
@if (isset($visit))
{{ $visit['examination'] }}
@endif
</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="diagnosis">{{ __('Diagnosis') }}</label>
                                <textarea name="diagnosis" id="diagnosis" rows="3" class="form-control" placeholder="{{ __('Diagnosis') }}">
@if (isset($visit))
{{ $visit['diagnosis'] }}
@endif
</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="therapy">{{ __('Therapy') }}</label>
                                <textarea name="therapy" id="therapy" rows="3" class="form-control" placeholder="{{ __('Therapy') }}">
@if (isset($visit))
{{ $visit['therapy'] }}
@endif
</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="diagnosis">{{ __('Recommendation') }}</label>
                                <textarea name="recommendation" id="recommendation" rows="3" class="form-control"
                                    placeholder="{{ __('Recommendation') }}">
@if (isset($visit))
{{ $visit['recommendation'] }}
@endif
</textarea>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- \Visit details -->

    <!-- Location -->
    <!--<div class="row">-->
    <!--    <div class="col-lg-12">-->
    <!--        <div class="card card-danger">-->
    <!--            <div class="card-header">-->
    <!--                <h5 class="card-title">-->
    <!--                    <i  class="fas fa-map-marked-alt nav-icon"></i>-->
    <!--                    {{ __('Location on map') }}-->
    <!--                </h5>-->
    <!--            </div>-->

    <!--            <div class="card-body p-0">-->
    <!--                <input-->
    <!--                id="pac-input"-->
    <!--                class="form-control"-->
    <!--                type="text"-->
    <!--                placeholder="{{ __('Search for address') }}"-->
    <!--                class="form-control"-->
    <!--                />-->
    <!--                <input type="hidden" name="lat" id="visit_lat" @if (isset($visit)) value="{{ $visit['lat'] }}" @endif>-->
    <!--                <input type="hidden" name="lng" id="visit_lng" @if (isset($visit)) value="{{ $visit['lng'] }}" @endif>-->
    <!--                <input type="hidden" name="zoom_level" id="zoom_level" @if (isset($visit)) value="{{ $visit['zoom_level'] }}" @endif>-->
    <!--                <div id="map" style="min-height:500px"></div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- \Location -->

    <!-- Attachment -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-danger">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-file-pdf nav-icon"></i>
                        {{ __('Attachment') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputFile">
                            {{ __('Attachment Image') }} ({{ __('optional') }})
                            @if (!empty($visit) && !empty($visit['attach']))
                                <a href="{{ url('uploads/visits/' . $visit['attach']) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endif
                        </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="attach" accept="image/*" class="custom-file-input"
                                    id="attachment">
                                <label class="custom-file-label" for="attachment">{{ __('Choose file') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- \Attachment -->
