<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{__('Action')}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      @can('view_visitdr')
        <a href="{{route('admin.visitsDr.show',$visit['id'])}}" class="dropdown-item">
          <i class="fa fa-eye"></i> {{__('Show')}}
        </a>
      @endcan
      @can('delete_visitdr')
        <a href="{{route('admin.visitsDr.edit',$visit['id'])}}" class="dropdown-item">
          <i class="fa fa-edit"></i> {{__('Edit')}}
        </a>
      @endcan
      @can('sign_medical_report')
        <a class="dropdown-item" href="{{route('admin.visitsDr.sign',$visit['id'])}}">
            <i class="fas fa-signature" aria-hidden="true"></i>
               {{__('Sign Report')}} 
            </a>
      @endcan
      @can('view_group')
        <a href="{{route('admin.visit_reports.visit-pdf',$visit['id'])}}" class="dropdown-item" target="_blank">
            <i class="fas fa-file-word" aria-hidden="true"></i>
            {{__('Save Report')}}
         </a>
      @endcan     
      @can('create_group')
        <a href="{{route('admin.visits.create_tests',$visit['id'])}}" class="dropdown-item">
          <i class="fas fa-file-invoice-dollar"></i> {{__('Create invoice')}}
        </a>
      @endcan            
      @can('delete_visitdr')
        <form method="POST" action="{{route('admin.visitsDr.destroy',$visit['id'])}}"  class="d-inline">
            <input type="hidden" name="_method" value="delete">
            <a href="#" class="dropdown-item delete_visit">
              <i class="fa fa-trash"></i>
              {{__('Delete')}}
            </a>
        </form>
      @endcan
    </div>
  </div>