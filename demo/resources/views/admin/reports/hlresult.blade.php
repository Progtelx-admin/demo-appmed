@extends('layouts.app')

@section('title')
  {{__('High Low Result Report')}}
@endsection

@section('breadcrumb')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">
          <i class="nav-icon fas fa-chart-bar"></i>
          {{__('Reports')}}
        </h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
          <li class="breadcrumb-item active">{{__('High Low Result Report')}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
    <div class="card card-primary">
        <!-- card-header -->
        <div class="card-header">
            <h3 class="card-title">{{ __('High Low Result Report') }}</h3>
        </div>
        <!-- /.card-header -->
        <!-- card-body -->
        <div class="card-body">
        <!-- Tools -->
        <div id="accordion">
          <div class="card card-info">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary" aria-expanded="true">
              <i class="fas fa-file-excel"></i>
              {{__('Export')}}
            </a>
            <div id="collapseOne" class="panel-collapse in collapse show"> 
                      <!-- date range -->
                      <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">-->
                      <!--    <label>{{__('Date range')}}:</label>-->
                      <!--    <div class="input-group">-->
                      <!--        <div class="input-group-prepend">-->
                      <!--            <span class="input-group-text">-->
                      <!--                <i class="far fa-calendar-alt"></i>-->
                      <!--            </span>-->
                      <!--        </div>-->
                      <!--        <input type="text" name="date" class="form-control float-right datepickerrange"-->
                      <!--            @if(request()->has('date')) value="{{request()->get('date')}}" @endif id="date" required>-->
                      <!--    </div>-->
                      <!--</div>-->
                      <!-- \date range -->
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <a class="btn btn-success" href="{{route('admin.results.export')}}">
                      <i class="fa fa-file-excel"></i>
                      {{__('Export')}}
                    </a>

                  </div>
                  <div class="col-lg-12">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- \Tools -->
@endsection
@section('scripts')
    <script src="{{url('plugins/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('js/admin/product_report.js')}}"></script>
@endsection