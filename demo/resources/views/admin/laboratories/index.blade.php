@extends('layouts.app')

@section('title')
    {{__('Laboratories')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-user-circle"></i>
            {{__('Laboratories')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active"><a href="#">{{__('Laboratories')}}</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')

<div class="card card-primary card-outline">
    <div class="card-header">
      <h3 class="card-title">
        {{__('Laboratories Table')}}
      </h3>
      @can('create_laboratory')
        <a href="{{route('admin.laboratories.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="col-lg-12 table-responsive">
          <table id="reports_table" class=" table table table-striped table-bordered"  width="100%">
            <thead>
            <tr>
              <th width="10px">
                <input type="checkbox" class="check_all" name="" id="">
              </th>
              <th width="10px">#</th>
              <th>{{__('ResultDetailPK')}}</th>
              <th>{{__('ResultMasterFK')}}</th>
              <th>{{__('AnalyzerNo')}}</th>
              <th>{{__('SampleNo')}}</th>
              <th>{{__('ResultTransferDtTm')}}</th>
              <th>{{__('ResultAnalysisDtTm')}}</th>
              <th>{{__('AnalyzerTestParam')}}</th>
              <th>{{__('ResultValue')}}</th>
              <th>{{__('ResultValue2')}}</th>
              <th>{{__('ResultValueFlag')}}</th>
              <th>{{__('SampleType')}}</th>
              <th>{{__('ResultUnit')}}</th>
              <th>{{__('ReferenceRange')}}</th>
              <th>{{__('IsResultValueRead')}}</th>
              <th>{{__('LIMSTestParam')}}</th>
              <th>{{__('LIMSData1')}}</th>
              <th>{{__('LIMSData2')}}</th>
              <th>{{__('LIMSData3')}}</th>
              <!--<th width="100px">{{__('Action')}}</th>-->
            </tr>
            </thead>
            <tbody>
               
            </tbody>
          </table>
       </div>
    </div>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_laboratory')true @else false @endcan
  </script>
  <script src="{{url('js/admin/laboratories.js')}}"></script>
@endsection