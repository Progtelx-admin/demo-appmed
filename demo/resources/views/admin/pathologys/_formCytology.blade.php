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
                      id="name"
                      @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['name'] }}" @endif disabled
                      required>
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
                      @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['phone'] }}" @endif disabled
                      required>
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
                          @if (isset($pathology) && isset($pathology['patient'])) value="{{ $pathology['patient']['email'] }}" @endif
                          disabled>
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
                      <input type="text" class="form-control" placeholder="{{ __('Reference') }}"
                          name="reference" id="reference"
                          @if (isset($pathology)) value="{{ $pathology['reference'] }}" @endif>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-lg-6">
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
                          @if (isset($pathology)) value="{{ $pathology['clinical_diagnosis'] }}" @endif>
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
                  <!--Patologjik -->
                  {{-- <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label for="histopathological">{{ __('Histopathological diagnosis') }}</label>
                              <input type="text" class="form-control"
                              placeholder="{{ __('Histopathological Diagnosis') }}" name="histopathological"
                              id="clinical_diagnosis"
                              @if (isset($pathology)) value="{{ $pathology['histopathological'] }}" @endif>
                          </div>
                      </div>
                  </div>
                  <hr style="height:4px; background: grey;"><br><br> --}}
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label for="microscopic_examination">{{ __('Microscopic examination') }}</label>
<textarea name="microscopic_examination" id="microscopic_examination" rows="3" class="form-control"
placeholder="{{ __('Microscopic examination') }}">
@if (isset($pathology))
{{ $pathology['microscopic_examination'] }}
@endif
</textarea>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label for="macroscopic_examination">{{ __('Macroscopic examination') }}</label>
<textarea name="macroscopic_examination" id="macroscopic_examination" rows="3" class="form-control"
placeholder="{{ __('Macroscopic examination') }}">
@if (isset($pathology))
{{ $pathology['macroscopic_examination'] }}
@endif
</textarea>
                          </div>
                      </div>
                  </div>      

                  <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label for="sample">{{ __('Sample') }}</label>
<textarea name="sample" id="sample" rows="3" class="form-control" placeholder="{{ __('Sample') }}">
@if (isset($pathology))
{{ $pathology['sample'] }}
@endif
</textarea>
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
  <input name="visit_type" id="visit_type" value="Clinic" hidden>
  <input name="report" id="report" value="Cytology" hidden>
