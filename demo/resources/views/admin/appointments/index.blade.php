@extends('layouts.app')

@section('title')
    {{__('Appointments')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/swtich-netliva/css/netliva_switch.css')}}">
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-home"></i>
            {{__('Appointments')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active"><a href="#">{{__('Appointments')}}</a></li>
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
        {{__('Appointments table')}}
      </h3>
      @can('create_visit')
        <a href="{{route('admin.appointments.create')}}" class="btn btn-primary btn-sm float-right">
          <i class="fa fa-plus"></i> {{ __('Create') }}
        </a>
      <button style="margin-right: 5px" type="submit" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#contohModal"><i class="fa fa-calendar"></i> Calendar</button>
      @endcan
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div id="accordion">
          <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
          <div class="card card-info">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="btn btn-primary collapsed" aria-expanded="false">
              <i class="fas fa-filter"></i> {{__('Filters')}}
            </a>
            <div id="collapseOne" class="panel-collapse in collapse">
              <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-3">
                      <div class="form-group">
                          <label for="filter_status">{{__('Status')}}</label>
                          <select name="filter_status" id="filter_status" class="form-control select2">
                            <option value="" selected>{{__('All')}}</option>
                            <option value="1">{{__('Completed')}}</option>
                            <option value="0">{{__('Pending')}}</option>
                          </select>
                      </div>
                    </div>
        
                    <div class="col-lg-3">
                      <div class="form-group">
                          <label for="filter_read">{{__('Viewed')}}</label>
                          <select name="filter_read" id="filter_read" class="form-control select2">
                            <option value="" selected>{{__('All')}}</option>
                            <option value="1">{{__('Viewed')}}</option>
                            <option value="0">{{__('Pending')}}</option>
                          </select>
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group">
                          <label for="filter_branch">{{__('Branch')}}</label>
                          <select name="filter_branch" id="filter_branch" class="form-control select2">
                            <option value="" selected>{{__('All')}}</option>
                            <option value="1">{{__('Viewed')}}</option>
                            <option value="0">{{__('Pending')}}</option>
                          </select>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
          
        <div class="col-lg-12 table-responsive">
            <table id="appointments_table" class="table table-striped table-bordered"  width="100%">
              <thead>
                <tr>
                  <th width="10px">
                    <input type="checkbox" class="check_all" name="" id="">
                  </th>
                  <th width="10px">#</th>
                  <th>{{__('Branch')}}</th>
                  <th>{{__('Visit Type')}}</th>
                  <th>{{__('Doctor Name')}}</th>
                  <th>{{__('Patient Name')}}</th>
                  <th>{{__('Phone')}}</th>
                  <th>{{__('Address')}}</th>
                  <th>{{__('Visit Date')}}</th>
                  <th class="text-center">{{__('Viewed')}}</th>
                  <th>{{__('Status')}}</th>
                  <th class="text-center" width="100px">{{__('Action')}}</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>

    </div>
    <div class="modal fade" id="contohModal" role="dialog" arialabelledby="modalLabel" area-hidden="true">
              <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                     <div id='calendar'></div>
                </div>
              </div>
            </div>
    <!-- /.card-body -->
  </div>

@endsection
@section('scripts')
  <script>
    var can_delete=@can('delete_appointments')true @else false @endcan
  </script>
  <script src="{{url('js/admin/appointments.js')}}"></script>
  <!-- Switch -->
  <script src="{{url('plugins/swtich-netliva/js/netliva_switch.js')}}"></script>
  <!--new script-->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
  <!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>

  <script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            theme: true,
            //selectable:true,
            height:1150,
            //aspectRatio: 2,
            //showNonCurrentDates:false,
            editable:true,
           // defaultView:'month',
            yearColumns: 3,
            header: {
                left: 'prev,next', //note no "buttons
                center: 'title',
                right: 'year,agendaDay,agendaWeek,month,timelineCustom'
              
            },
           
            events : [
                @foreach($tasks as $task)
                {
                    title : "\n {{ $task->doctor_name }}",
                    start : '{{ $task->visit_date }}',
                    //  end: '{{ $task->to_date }}',
                    description:"{{ $task['patient']['name'] }}",
                   
                    
                    @if($task->status == 0)
                        color: "#f26a53",
                        textColor: "black",
                    @elseif($task->status == 1)
                        color: "#4cb4e6",
                        textColor: "black",
                    @endif
                    
                    url : '{{ route('admin.appointments.edit', $task->id) }}'
                   
                },
                @endforeach
            ],
            //  backgroundColor: '#1abc9c',
            
             
            
             eventRender: function(event, element) {

        // To append if is description in next line
        if(event.description != '' && typeof event.description  !== "undefined")
        {  
            element.find(".fc-title").append("<br/><b>"+event.description+"</b>" );
        }

       
    }, 
    
        })
    });
</script>


@endsection