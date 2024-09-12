<div class="modal fade" id="patient_modal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">{{__('Create Patient')}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form action="{{route('ajax.create_patient')}}" method="POST" id="create_patient">
        @csrf
        <div class="text-danger" id="patient_modal_error"></div>
        <div class="modal-body" id="create_patient_inputs">
          <div class="row">
            <div class="col-lg-4">
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" placeholder="{{__('Patient Name *')}}" name="name"
                    id="create_name" required>
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
                  <input onkeypress="return event.charCode != 32" type="text" class="form-control" placeholder="{{__('Parent Name  *')}}" name="passport_no"
                    id="create_passport_no" required>
                </div>
              </div>
            </div>

            <!--<div class="col-lg-4">-->
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-globe"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <select class="form-control" name="country_id" id="create_country_id">-->
            <!--          <option value="" disabled selected>{{__('Select nationality')}}</option>-->
            <!--        </select>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->

            <div class="col-lg-4">
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                      <i class="fa fa-id-card"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" placeholder="{{__('National ID')}}" name="national_id"
                    id="create_national_id">
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
                  <input type="email" class="form-control" placeholder="{{__('Email Address')}}" name="email"
                    id="create_email">
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
                  <input onkeypress="return event.charCode != 32" type="number" class="form-control" placeholder="{{__('Phone number')}} *" name="phone"
                    id="create_phone" required>
                </div>
              </div>

            </div>

            <div class="col-lg-4" >
              <div class="form-group">
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-map-marker-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{__('Address')}}" name="address"
                      id="create_address">
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
                    <input type="text" class="form-control" placeholder="{{__('Profession')}}" name="profession"
                      id="create_profession">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4" style="display:none">
              <div class="form-group">
                <div class="form-group">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-map-marker-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="{{__('City')}}" name="city"
                      id="create_city">
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
                        <i class="fas fa-mars"></i>
                      </span>
                    </div>
                    <select class="form-control" name="gender" placeholder="{{__('Gender')}}" id="create_gender"
                      required>
                      <option value="" disabled selected>{{__('Select Gender *')}}</option>
                      <option value="male">{{__('Male')}}</option>
                      <option value="female">{{__('Female')}}</option>
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
                    <input type="text" class="form-control datepicker" placeholder="{{__('Date of birth *')}}" name="dob" id="create_dob" required>
                    <!--<input type="text" class="form-control" placeholder="{{__('Date of birth *')}}" name="dob" id="create_dob" required>-->
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
                    <input type="number" class="form-control" name="age" id="create_age" placeholder="{{__('Age *')}}"
                      required>
                  </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 col-md-6 pl-0">
                  <div class="input-group mb-3">
                    <select class="form-control" name="age_unit" id="create_age_unit" required>
                      <option value="" disabled selected>{{__('Select age unit *')}}</option>
                      <option value="years">{{__('Years')}}</option>
                      <option value="months">{{__('Months')}}</option>
                      <option value="days">{{__('Days')}}</option>
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
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-mars"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <select class="form-control" name="vaccinated" placeholder="{{__('Vaccinated')}}" id="create_vaccinated">-->
            <!--          <option value="" disabled selected>{{__('Vaccinated *')}}</option>-->
            <!--          <option value="Yes">{{__('Yes')}}</option>-->
            <!--          <option value="No">{{__('No')}}</option>-->
            <!--        </select>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->

            <!--</div>-->
            
            <!--<div class="col-lg-4">-->
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-mars"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <select class="form-control" name="vaccinemodel" placeholder="{{__('Select Vaccine Model')}}" id="create_vaccinemodel">-->
            <!--          <option value="" disabled selected>{{__('Select Vaccine Model')}}</option>-->
            <!--          <option value="Pfizer/BioNtech">{{__('Pfizer/BioNtech')}}</option>-->
            <!--          <option value="AstraZeneca/Oxford">{{__('AstraZeneca/Oxford')}}</option>-->
            <!--          <option value="Johnson&Johnson">{{__('Johnson&Johnson')}}</option>-->
            <!--          <option value="Sanofi/GSK">{{__('Sanofi/GSK')}}</option>-->
            <!--          <option value="Moderna">{{__('Moderna')}}</option>-->
            <!--          <option value="Curevac">{{__('Curevac')}}</option>-->
                      
            <!--        </select>-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->

            <!--</div>-->
            
            <!--<div class="col-lg-4">-->
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-baby"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <input type="text" class="form-control datepicker" placeholder="{{__('Date of 1st Vaccine')}}" name="datevaccine1"-->
            <!--          id="create_datevaccine1">-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->
            
            <!--<div class="col-lg-4">-->
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-baby"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <input type="text" class="form-control datepicker" placeholder="{{__('Date of 2nd Vaccine')}}" name="datevaccine2"-->
            <!--          id="create_datevaccine2">-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->
            
            <!--<div class="col-lg-4">-->
            <!--  <div class="form-group">-->
            <!--    <div class="form-group">-->
            <!--      <div class="input-group mb-3">-->
            <!--        <div class="input-group-prepend">-->
            <!--          <span class="input-group-text" id="basic-addon1">-->
            <!--            <i class="fas fa-baby"></i>-->
            <!--          </span>-->
            <!--        </div>-->
            <!--        <input type="text" class="form-control datepicker" placeholder="{{__('Date of 3rd Vaccine')}}" name="datevaccine3"-->
            <!--          id="create_datevaccine3">-->
            <!--      </div>-->
            <!--    </div>-->
            <!--  </div>-->
            <!--</div>-->

            <div class="col-lg-4">
              <div class="form-group">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="create_avatar">
                    <input type="hidden" id="create_patient_avatar_hidden" name="avatar">
                    <label class="custom-file-label">{{__('Choose avatar')}}</label>
                  </div>
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
                      CURLOPT_TIMEOUT => 500,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_HTTPHEADER => [
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Basic cGF3czoxMjNQQVdTMQ==',
                        'Content-Length: 0'
                      ],
                    ]);
                    
                    $response = curl_exec($curl);
                    curl_close($curl);
                        //echo $response;
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
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- <script>-->
<!--  var dateInput = document.getElementById("create_dob");-->
<!--  dateInput.addEventListener('input', function(event) {-->
<!--    var inputText = event.target.value;-->
<!--    var inputNums = inputText.replace(/[^0-9]/g, '');-->
<!--    var day = inputNums.substring(0, 2);-->
<!--    var month = inputNums.substring(2, 4);-->
<!--    var year = inputNums.substring(4, 8);  var dateNum = year + '-' + month + '-' + day; -->
<!--    dateInput.value = dateNum;-->
<!--  });-->
<!--</script>-->
 <!-- 
<script>
        var dateInput = document.getElementById("create_dob");
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
 -->
 
<!-- <script>-->
<!--  var dateInput = document.getElementById("create_dob");-->
  
<!--  dateInput.addEventListener('blur', function(event) {-->
<!--    var inputText = event.target.value;-->
<!--    var inputNums = inputText.replace(/[^0-9]/g, '');-->
    
<!--    if (inputNums.length === 8) {-->
<!--      var year = inputNums.substring(4, 8);-->
<!--      var month = inputNums.substring(2, 4);-->
<!--      var day = inputNums.substring(0, 2);-->
<!--      var formattedDate = year + '-' + month + '-' + day;-->
      

<!--      event.target.value = formattedDate;-->
<!--    }-->
<!--  });-->

<!--  var form = document.getElementById("create_patient");-->
<!--  form.addEventListener("submit", function(event) {-->

<!--    var dobInput = document.getElementById("create_dob");-->
<!--    var inputText = dobInput.value;-->
<!--    var inputNums = inputText.replace(/[^0-9]/g, '');-->
    
<!--    if (inputNums.length === 8) {-->
<!--      var year = inputNums.substring(4, 8);-->
<!--      var month = inputNums.substring(2, 4);-->
<!--      var day = inputNums.substring(0, 2);-->
<!--      var formattedDate = year + '-' + month + '-' + day;-->
      
<!--      dobInput.value = formattedDate;-->
<!--    }-->
<!--  });-->
<!--</script>-->

<script>
  var dateInput = document.getElementById("create_dob");

  dateInput.addEventListener('input', function(event) {
    var inputText = event.target.value;
    
    // Remove any non-numeric characters from the input
    var inputNums = inputText.replace(/[^0-9]/g, '');
    
    // Check if the input has at least 8 digits (DDMMYYYY)
    if (inputNums.length >= 8) {
      var day = inputNums.substring(0, 2);
      var month = inputNums.substring(2, 4);
      var year = inputNums.substring(4, 8);
      
      // Format the date with hyphens
      var formattedDate = day + '-' + month + '-' + year;
      
      // Set the formatted date back to the input field
      event.target.value = formattedDate;
    }
  });

  // Add an event listener to the form for when it's submitted
  var form = document.getElementById("create_patient");
  form.addEventListener("submit", function(event) {
    // Before submitting the form, convert the value to YYYY-MM-DD format
    var dobInput = document.getElementById("create_dob");
    var inputText = dobInput.value;
    
    // Remove any non-numeric characters from the input
    var inputNums = inputText.replace(/[^0-9]/g, '');
    
    // Check if the input has at least 8 digits (DDMMYYYY)
    if (inputNums.length >= 8) {
      var day = inputNums.substring(0, 2);
      var month = inputNums.substring(2, 4);
      var year = inputNums.substring(4, 8);
      
      // Format the date in YYYY-MM-DD format
      var formattedDate = year + '-' + month + '-' + day;
      
      // Set the formatted date back to the input field
      dobInput.value = formattedDate;
    }
  });
</script>



 

