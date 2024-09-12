<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{__('Action')}}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      @can('edit_healthcertificates')
        <a href="{{route('admin.healthcertificates.edit',$healthcertificate['id'])}}" class="dropdown-item">
          <i class="fa fa-edit"></i> {{__('Edit')}}
        </a>
      @endcan
      @can('create_healthcertificates')
            <!--<a class="dropdown-item" href="{{route('admin.healthcertificates.report_healthcertificate',$healthcertificate['id'])}}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{__('PDF')}}-->
            <!--</a>-->
            <a class="dropdown-item" href="{{ route('admin.healthcertificates.hc-pdf' , $healthcertificate['id']) }}"
                target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Printo Certifikaten') }}
            </a>
      @endcan
  
      @can('delete_healthcertificates')
        <form method="POST" action="{{route('admin.healthcertificates.destroy',$healthcertificate['id'])}}"  class="d-inline">
            <input type="hidden" name="_method" value="delete">
            <a href="#" class="dropdown-item delete_visit">
              <i class="fa fa-trash"></i>
              {{__('Delete')}}
            </a>
        </form>
      @endcan
    </div>
  </div>