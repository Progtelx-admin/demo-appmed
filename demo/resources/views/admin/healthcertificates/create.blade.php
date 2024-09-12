@extends('layouts.app')

@section('title')
{{ __('Create Health Certificate') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/datetimepicker/css/jquery.datetimepicker.min.css')}}">  
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
                        <a href="{{route('admin.healthcertificates.index')}}">{{ __('Health Certificate') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Create Health Certificate') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Create Health Certificate') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.healthcertificates.store')}}" enctype="multipart/form-data" id="healthcertificate_form">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.healthcertificates._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('Save')}}
                </button>
            </div>
        </div>
    </form>
    <!-- /.card-body -->
</div>

@include('admin.healthcertificates._patient_modal')

@endsection
@section('scripts')
    <script src="{{url('plugins/datetimepicker/js/jquery.datetimepicker.full.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{$api_keys['google_map']}}&callback=initMap&libraries=places&v=weekly" defer></script>
    <script src="{{url('js/admin/healthcertificates.js')}}"></script>
@endsection