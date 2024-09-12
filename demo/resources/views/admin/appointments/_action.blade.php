<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{__('Action')}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      @can('view_visit')
        <a href="{{route('admin.appointments.show',$appointment['id'])}}" class="dropdown-item">
          <i class="fa fa-eye"></i> {{__('Show')}}
        </a>
      @endcan
      @can('edit_visit')
        <a href="{{route('admin.appointments.edit',$appointment['id'])}}" class="dropdown-item">
          <i class="fa fa-edit"></i> {{__('Edit')}}
        </a>
      @endcan
      @can('create_group')
        <a href="{{route('admin.appointments.create_tests',$appointment['id'])}}" class="dropdown-item">
          <i class="fas fa-file-invoice-dollar"></i> {{__('Create invoice')}}
        </a>
      @endcan
      @can('view_group')
        <a href="{{route('admin.appointments.report_appointment2',$appointment['id'])}}" class="dropdown-item">
            <i class="fas fa-file-word" aria-hidden="true"></i>
            {{__('Save Appointment Visit')}}
         </a>
      @endcan
      @can('view_group')
        <a href="{{route('admin.appointments.report_appointment',$appointment['id'])}}" class="dropdown-item">
            <i class="fas fa-file-word" aria-hidden="true"></i>
            {{__('Print Appointment Visit')}}
         </a>
      @endcan
      
      @can('delete_visit')
        <form method="POST" action="{{route('admin.appointments.destroy',$appointment['id'])}}"  class="d-inline">
            <input type="hidden" name="_method" value="delete">
            <a href="#" class="dropdown-item delete_visit">
              <i class="fa fa-trash"></i>
              {{__('Delete')}}
            </a>
        </form>
      @endcan
    </div>
  </div>