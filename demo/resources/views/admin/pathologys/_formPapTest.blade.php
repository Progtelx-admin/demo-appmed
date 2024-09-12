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

                  <div class="row">
                      <div class="col-lg-12">
                          <div class="form-group">
                              <label for="cytological_examination">{{ __('Cytological examination') }}</label>
                              <textarea name="cytological_examination" id="cytological_examination" rows="3" class="form-control"
                                  placeholder="{{ __('Cytological examination') }}">
@if (isset($pathology))
{{ $pathology['cytological_examination'] }}
@endif
</textarea>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-3">
                          <div class="form-group">
                              <div class="form-group">
                                  <label for="patient_id">{{ __('Lindje') }}</label>
                                  <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="{{ __('Lindje') }}"
                                          name="births" id="births"
                                          @if (isset($pathology)) value="{{ $pathology['births'] }}" @endif>
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
                                      @if (isset($pathology)) value="{{ $pathology['abortions'] }}" @endif>
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
                                      @if (isset($pathology)) value="{{ $pathology['menstrual_cycle'] }}" @endif>
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
                                      @if (isset($pathology)) value="{{ $pathology['pap_tests'] }}" @endif>
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
                                          placeholder="{{ __('Hysterektomia') }}" name="hysterectomy"
                                          id="hysterectomy"
                                          @if (isset($pathology)) value="{{ $pathology['hysterectomy'] }}" @endif>
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
                                      @if (isset($pathology)) value="{{ $pathology['chemotherapy'] }}" @endif>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <div class="form-group">
                              <label for="patient_id">{{ __('Rrezatim') }}</label>
                              <div class="input-group mb-3">
                                  <input type="text" class="form-control" placeholder="{{ __('Rrezatim') }}"
                                      name="radiation" id="radiation"
                                      @if (isset($pathology)) value="{{ $pathology['radiation'] }}" @endif>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-3">
                          <div class="form-group">
                              <label for="patient_id">{{ __('Terapi hormonale') }}</label>
                              <div class="input-group mb-3">
                                  <input type="text" class="form-control"
                                      placeholder="{{ __('Terapi hormonale') }}" name="hormonal_therapy"
                                      id="hormonal_therapy"
                                      @if (isset($pathology)) value="{{ $pathology['hormonal_therapy'] }}" @endif>
                              </div>
                          </div>
                      </div>

                  </div>
                  {{-- Blerina vazhdon  --}}

                  <hr style="background-color:white;">
                  <br>
                  <div class="row">

                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('I. LLOJI I MOSTRËS') }}</label>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_conventional" name="sample_conventional"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_conventional'] }}" 
                                       {{ $pathology['paptest']['sample_conventional'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Mostër konvencionale
                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_other" name="sample_other"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_other'] }}" 
                                       {{ $pathology['paptest']['sample_other'] != '' ? 'checked' : null }} @endif />
                                  &nbsp;
                                  &nbsp; Tjetër
                                  <input type="text" id="sample_other" name="sample_other"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_other'] }}" @endif>
                              </div>

                          </div>
                      </div>
                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('II. MOSTRA') }}</label>
                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_satisfactory" name="sample_satisfactory"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_satisfactory'] }}" 
                                  {{ $pathology['paptest']['sample_satisfactory'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; E kënaqshme për evaluim
                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_unsatisfactory" name="sample_unsatisfactory"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_unsatisfactory'] }}" 
                                     {{ $pathology['paptest']['sample_unsatisfactory'] != '' ? 'checked' : null }} @endif />
                                  &nbsp;
                                  &nbsp; E pakënaqshme
                                  <input type="text" id="sample_unsatisfactory" name="sample_unsatisfactory"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_unsatisfactory'] }}" @endif>
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('III. REZULTATI') }}</label>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_negative" name="sample_negative"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_negative'] }}" 
                                  {{ $pathology['paptest']['sample_negative'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  NEGATIV PËR LESION INTRAEPITELIAL APO
                                  MALINJITET (NILM)
                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="sample_abnormal" name="sample_abnormal"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['sample_abnormal'] }}" 
                                  {{ $pathology['paptest']['sample_abnormal'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  ABNORMALITETET E QELIZAVE EPITELIALE
                                  (shiko përshkrimin)
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('IV. PËRSHKRIMI') }}</label>
                              <h6>Mikroorganizmat:</h6>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="reactive_changes" name="reactive_changes"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['reactive_changes'] }}" 
                                  {{ $pathology['paptest']['reactive_changes'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Ndryshime reaktive qelizore të shoqëruara me:
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="inflammation" name="inflammation"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['inflammation'] }}" 
                                  {{ $pathology['paptest']['inflammation'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  inflamacion
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="checkbox" id="iud" name="iud"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['iud'] }}" 
                                  {{ $pathology['paptest']['iud'] == 1 ? 'checked' : null }} @endif />&nbsp;&nbsp;
                                  IUD
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="repair_changes" name="repair_changes"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['repair_changes'] }}" 
                                  {{ $pathology['paptest']['repair_changes'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  ndryshime reparatore
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="checkbox" id="radiation" name="radiation"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['radiation'] }}" 
                                  {{ $pathology['paptest']['radiation'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  radiacion
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="cylinder_cells" name="cylinder_cells"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['cylinder_cells'] }}" 
                                  {{ $pathology['paptest']['cylinder_cells'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Qelizat cilindrike pas histerektomisë
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="squamous_metaplasia" name="squamous_metaplasia"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['squamous_metaplasia'] }}" 
                                  {{ $pathology['paptest']['squamous_metaplasia'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Metaplazion squamoz
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="atrophy" name="atrophy"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['atrophy'] }}" 
                                  {{ $pathology['paptest']['atrophy'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Atrofi
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="pregnancy_related" name="pregnancy_related"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['pregnancy_related'] }}" 
                                  {{ $pathology['paptest']['pregnancy_related'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Ndryshime të lidhura me shtatëzani
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="hormonal_status" name="hormonal_status"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['hormonal_status'] }}" 
                                  {{ $pathology['paptest']['hormonal_status'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Statusi citohormonal nuk i përgjigjet moshës
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="endometrial_cells" name="endometrial_cells"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endometrial_cells'] }}" 
                                  {{ $pathology['paptest']['endometrial_cells'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Qeliza endometriale (te femrat ≥40 vjeç)
                              </div>

                              <h6>Abnormalitetet e qelizave epiteliale</h6>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="squamous_cells" name="squamous_cells"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['squamous_cells'] }}" 
                                  {{ $pathology['paptest']['squamous_cells'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Qelizat squamoze
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="atypical_squamous" name="atypical_squamous"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['atypical_squamous'] }}" 
                                  {{ $pathology['paptest']['atypical_squamous'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Qeliza squamoze atipike
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="ascus" name="ascus"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['ascus'] }}" 
                                  {{ $pathology['paptest']['ascus'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; me
                                  rëndësi të
                                  papërcaktuar (ASC–US)
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="asc-h" name="asc-h"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['asc-h'] }}" 
                                  {{ $pathology['paptest']['asc-h'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; nuk
                                  mund të
                                  përjashtohet HSIL (ASC–H)
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="lsil" name="lsil"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['lsil'] }}" 
                                  {{ $pathology['paptest']['lsil'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Lezion
                                  intraepitelial squamoz i shkallës së
                                  ulët
                                  <br> &nbsp;&nbsp;(LSIL) – (dizplazia e lehtë/HPV/CIN 1)
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="hsil" name="hsil"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['hsil'] }}" 
                                  {{ $pathology['paptest']['hsil'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Lezion
                                  intraepitelial squamoz i shkallës së
                                  lartë
                                  <br> &nbsp;&nbsp;(HSIL) – (displazi e mesme ose e rëndë)
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="suspicious_patterns" name="suspicious_patterns"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['suspicious_patterns'] }}" 
                                  {{ $pathology['paptest']['suspicious_patterns'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Me tipare që japin dyshim për invazion

                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="squamous_carcinoma" name="squamous_carcinoma"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['squamous_carcinoma'] }}" 
                                  {{ $pathology['paptest']['squamous_carcinoma'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Carcinoma squamocelulare

                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="glandular_cells" name="glandular_cells"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['glandular_cells'] }}" 
                                  {{ $pathology['paptest']['glandular_cells'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Qeliza glandulare
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="atypical_glandular" name="atypical_glandular"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['atypical_glandular'] }}" 
                                  {{ $pathology['paptest']['atypical_glandular'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Qeliza atipike:
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="endocervical" name="endocervical"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endocervical'] }}" 
                                  {{ $pathology['paptest']['endocervical'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  endocervikale
                                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="checkbox" id="endometrial" name="endometrial"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endometrial'] }}" 
                                  {{ $pathology['paptest']['endometrial'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  endometriale
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="glandular" name="glandular"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['glandular'] }}" 
                                  {{ $pathology['paptest']['glandular'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  glandulare
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="neoplastic_cells" name="neoplastic_cells"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['neoplastic_cells'] }}" 
                                  {{ $pathology['paptest']['neoplastic_cells'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; glanduare, i përngjajnë qelizave neoplastike
                                  (AGC)
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="endocervical_in" name="endocervical_in"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endocervical_in'] }}" 
                                  {{ $pathology['paptest']['endocervical_in'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Adenocarcinoma endocervikale in situ
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="adenocarcinoma" name="adenocarcinoma"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['adenocarcinoma'] }}" 
                                  {{ $pathology['paptest']['adenocarcinoma'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  Adenocarcinoma
                              </div>

                              <div style="margin-left: 10%" class="input-group mb-1">
                                  <input type="checkbox" id="endocervical_ade" name="endocervical_ade"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endocervical_ade'] }}" 
                                  {{ $pathology['paptest']['endocervical_ade'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  endocervikale&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="checkbox" id="endometrial_ade" name="endometrial_ade"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['endometrial_ade'] }}" 
                                  {{ $pathology['paptest']['endometrial_ade'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp;
                                  endometriale

                              </div>


                              <div style="margin-left: 10%" class="input-group mb-1">
                                <input type="checkbox" id="other_neoplasm" name="other_neoplasm"
                                    @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['other_neoplasm'] }}" 
                                     {{ $pathology['paptest']['other_neoplasm'] != '' ? 'checked' : null }} @endif />
                                &nbsp;
                                &nbsp; Tjetër neoplazi malinje:
                                <input type="text" id="other_neoplasm" name="other_neoplasm"
                                    @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['other_neoplasm'] }}" @endif>
                            </div>


                          </div>

                      </div>

                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('V. UDHËZIME') }}</label>
                              <div class="input-group mb-1">
                                  <input type="checkbox" id="repeat_treatment" name="repeat_treatment"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['repeat_treatment'] }}" 
                                  {{ $pathology['paptest']['repeat_treatment'] == 1 ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Të përsëritet analiza pas tretmanit

                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['repeat_date'] }}" 
                                  {{ $pathology['paptest']['repeat_date'] != '' ? 'checked' : null }} @endif />
                                  &nbsp;&nbsp; Të përsëritet analiza pas:
                                  <input type="text" id="repeat_date" name="repeat_date"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['repeat_date'] }}" @endif>

                              </div>

                              <div class="input-group mb-1">
                                  <input type="checkbox" id="hpv_typing1" name="hpv_typing1"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['hpv_typing1'] }}" 
                                  {{ $pathology['paptest']['hpv_typing1'] == 1 ? 'checked' : null }} @endif />&nbsp;&nbsp;Të
                                  bëhet:&nbsp;
                                  <input type="checkbox" id="hpv_typing2" name="hpv_typing2"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['hpv_typing2'] }}" 
                                  {{ $pathology['paptest']['hpv_typing2'] == 1 ? 'checked' : null }} @endif />HPV
                                  tipizimi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                  <input type="checkbox" id="hpv_typing3" name="hpv_typing3"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['hpv_typing3'] }}" 
                                  {{ $pathology['paptest']['hpv_typing3'] == 1 ? 'checked' : null }} @endif />Kolposkopia
                              </div>

                              <div style="margin-left: 5%" class="input-group mb-1">
                                  <input type="checkbox" id="biopsy" name="biopsy"
                                      @if (isset($pathology) && isset($pathology['paptest'])) value="{{ $pathology['paptest']['biopsy'] }}" 
                                  {{ $pathology['paptest']['biopsy'] == 1 ? 'checked' : null }} @endif />Biopsia
                              </div>
                          </div>
                      </div>

                      <div class="col-lg-4">
                          <div class="form-group">
                              <label for="patient_id">{{ __('Komenti:') }}</label>
                              <br>
                              <textarea name="comment" id="comment" cols="60" rows="7">
@if (isset($pathology))
{{ $pathology['paptest']['comment'] }}
@endif
                            </textarea>
                          </div>
                      </div>

                  </div>             
              </div>
          </div>
      </div>

      <input name="visit_type" id="visit_type" value="Clinic" hidden>
      <input name="report" id="report" value="Pap Test" hidden>
