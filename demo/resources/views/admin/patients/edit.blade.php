@extends('layouts.app')

@section('title')
{{__('Edit patient')}}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="nav-icon fas fa-user-injured"></i>
            {{__('Patients')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.patients.index')}}">{{__('Patients')}}</a></li>
            <li class="breadcrumb-item active">{{__('Edit patient')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Edit patient')}}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.patients.update',$patient->id)}}" id="patient_form" enctype="multipart/form-data">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @method('put')
            @include('admin.patients._form')
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
        </div>
        <br />
    </form>
    <!-- /.card-body -->
  
  
 <!--table-result-->
 <div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">{{ __('Medical reports') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
       <div class="row">
            <div class="col-lg-12 table-responsive">
                <table id="medical_reports_table" class="table table-striped table-bordered"  width="100%">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th width="10px">{{__('Created By')}}</th>
                            <th width="10px">{{__('Barcode')}}</th>
                            <th width="200px">{{ __('Tests') }}</th>
                            <th width="100px">{{ __('Date') }}</th>
                            <th width="100px">{{ __('Date Updated') }}</th>
                            <th class="text-center" width="10px">{{__('Done')}}</th>
                            <th class="text-center" width="10px">{{__('Signed')}}</th>
                            <th width="100px">{{__('Signed By user')}}</th>
                            <th width="100px">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($groups as $group  )
                         <tr>
                             <td> {{ $group->id }}</td>
                            <td >{{ $group->created_by_user['name'] }}</td> 
                            <td>{{ $group->barcode }} </td> 
                            <td>
                            @foreach($group['all_tests'] as $test)
                             <li class="@if($test['done']) text-success @endif">{{$test['test']['name']}}</li>
                            @endforeach
                            </td>
                           
                            <td>{{ $group->created_at }}</td>
                            <td>{{ $group->updated_at }}</td>
                            <td>
                                @if($group['done'])
                                    <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
                                @else
                                    <div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
                                @endif
                            </td>
                            <td>
                                @if(!empty($group['signed_by']))
                                    <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
                                @elseif(!empty($group['signed_by2']))
                                    <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
                                @else
                                    <div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
                                @endif
                            </td>
                            <td >{{isset( $group->signed_by_user['name']) }}</td> 
                            <td>
                                  @can('view_medical_report')
                                    <a class="dropdown-item" href="{{route('admin.medical_reports.print_report',$group->id)}}" target="_blank">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                        {{__('Save')}}
                                    </a>
                                    <a class="dropdown-item" href="{{route('admin.medical_reports.print_report5',$group->id)}}" target="_blank">
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                        {{__('Print')}}
                                    </a>
                                    <a class="dropdown-item" href="{{route('admin.medical_reports.show',$group['id'])}}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        {{__('Show')}}
                                    </a>
                                @endcan
                            </td> 
                        </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 <!--/.table-result-->
 
  <!--table-result-->
 <div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">{{ __('Visit reports') }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="col-lg-12 table-responsive">
            <table id="visits_table" class="table table-striped table-bordered"  width="100%">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{__('Visit Type')}}</th>
                  <th>{{__('Visit Date')}}</th>
                  <th width="200px">{{__('Action')}}</th>
                </tr>
              </thead>
                    <tbody>
                            @foreach ($visits as $visit  )
                         <tr>
                            <td>{{$visit->id}}</td>
                            <td>{{$visit->visit_type}}</td>
                            <td >{{$visit->created_at}}</td> 
                            <td>
                            @can('view_medical_report')
                                <a class="dropdown-item" href="{{route('admin.visits.report_visit2',$visit['id'])}}" target="_blank">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                {{__('Save')}}
                                </a>
                                <a class="dropdown-item" href="{{route('admin.visits.report_visit',$visit['id'])}}" target="_blank">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                {{__('Print')}}
                                    </a>
                            @endcan
                            </td> 
                        </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 <!--/.table-result-->
   
</div>
  
  </div>

@endsection
@section('scripts')
  <script src="{{url('js/admin/patients.js')}}"></script>
  @cannot('bulk_action_patient')
  <script>
    $(document).ready(function(){
      table.on('init',function(){
        $(document).find('#bulk_action_section').remove();
      });
    });
  </script>
  @endcan
@endsection