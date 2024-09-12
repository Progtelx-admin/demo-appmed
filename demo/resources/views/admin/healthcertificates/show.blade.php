@extends('layouts.app')

@section('title')
{{ __('Show health certificate') }}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fa fa-home"></i>
                    {{__('Health Certificate')}}
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.visits.index')}}">{{ __('Health Certificate') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Show health certificate') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')

@can('create_group')
<div class="row mb-3">
    <div class="col-lg-12">
        <a href="{{route('admin.visits.create_tests',$healthcertificate['id'])}}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-file-invoice-dollar"></i> {{__('Create invoice')}}
        </a>
    </div>
</div>
@endcan

<!-- Patient details -->
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">{{ __('Patient details') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
               <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">
                          <i class="fa fa-user"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" @if(isset($healthcertificate['patient'])) value="{{$healthcertificate['patient']['name']}}" @endif disabled>
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
                        <input type="text" class="form-control" @if(isset($healthcertificate['patient']))  value="{{$healthcertificate['patient']['phone']}}" @endif disabled>
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
                            <input type="text" @if(isset($healthcertificate['patient'])) value="{{$healthcertificate['patient']['gender']}}" @endif class="form-control" disabled>
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
                                <i class="fas fa-map-marker-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control"  id="address" @if(isset($healthcertificate['patient'])) value="{{$healthcertificate['patient']['address']}}" @endif disabled>
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
                            <input type="text" class="form-control" @if(isset($healthcertificate['patient'])) value="{{$healthcertificate['patient']['email']}}" @endif disabled>
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
                            <input type="text" class="form-control" @if(isset($healthcertificate['patient'])) value="{{$healthcertificate['patient']['dob']}}" @endif disabled>
                        </div>
                    </div>
                </div>
            </div>

        </div>        
        
    </div>
</div>
<!-- \Patient details -->

<!-- Visit details -->
<div class="card card-primary">
    <div class="card-header">
        <h5 class="card-title">
            {{__('Health Certificate details')}}
        </h5>
    </div>
    <div class="card-body">
        <div class="col-lg-4">
                <div class="form-group">
                    <label for="">Certificate Type</label>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-clock"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control"  value="{{$healthcertificate['visit_type']}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            
        <div class="row">

            <div class="col-lg-4">
                <div class="form-group">
                    <label for="">Certificate date</label>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-clock"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control"  value="{{$healthcertificate['visit_date']}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-lg-8">
                <div class="form-group">
                    <label for="">Address</label>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">
                                <i class="fas fa-map-marker-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control"  value="{{$healthcertificate['visit_address']}}" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Doctor')}}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0">
                            @foreach($healthcertificate['doctors'] as $doctor)
                                <li>
                                    {{$healthcertificate['doctor']['name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Tests')}}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0">
                            @foreach($healthcertificate['tests'] as $test)
                                <li>
                                    {{$healthcertificate['test']['name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
    
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Cultures')}}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0">
                            @foreach($healthcertificate['cultures'] as $culture)
                                <li>
                                    {{$culture['culture']['name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Packages')}}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0">
                            @foreach($healthcertificate['packages'] as $package)
                                <li>
                                    {{$package['package']['name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">{{__('Antibiotics & Therapy')}}</h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0">
                            @foreach($healthcertificate['antibiotics'] as $antibiotic)
                                <li>
                                    {{$antibiotic['antibiotic']['name']}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                            <div class="form-group">
                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" class="form-control" id="diagnosis" placeholder="{{__('Diagnosis')}}" name="diagnosis" @if(isset($healthcertificate)) value="{{$healthcertificate['diagnosis']}}" @endif required>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
</div>
<!-- \Visit details -->

<!-- Location -->
<div class="row">
    <div class="col-lg-12">
         <div class="card card-danger">
             <div class="card-header">
                 <h5 class="card-title">
                     <i  class="fas fa-map-marked-alt nav-icon"></i>
                     {{__('Location on map')}}
                 </h5>
             </div>
            
             <div class="card-body p-0">
                <input type="hidden" name="lat" id="visit_lat" @if(isset($healthcertificate)) value="{{$healthcertificate['lat']}}" @endif>
                <input type="hidden" name="lng" id="visit_lng" @if(isset($healthcertificate)) value="{{$healthcertificate['lng']}}" @endif>
                <input type="hidden" name="zoom_level" id="zoom_level" @if(isset($healthcertificate)) value="{{$healthcertificate['zoom_level']}}" @endif>
                <div id="map" style="min-height:500px"></div>
             </div>
         </div>
    </div>
</div>
<!-- \Location -->

<!-- Attachment -->
@if(!empty($healthcertificate)&&!empty($healthcertificate['attach']))
<div class="row">
    <div class="col-lg-12">
        <div class="card card-danger">
            <div class="card-header">
                <h5 class="card-title">
                     <i  class="fas fa-file-pdf nav-icon"></i>
                    {{__('Attachment')}}
                </h5>
            </div>
            <div class="card-body">
                @if(!empty($healthcertificate)&&!empty($healthcertificate['attach']))
                    <a href="{{url('uploads/healthcertificates/'.$healthcertificate['attach'])}}" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
<!-- \Attachment -->

 
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{$api_keys['google_map']}}&callback=initMapShow&libraries=&v=weekly" defer></script>
    <script src="{{url('js/admin/healthcertificates.js')}}"></script>
@endsection