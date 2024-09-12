<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @can('edit_medical_report')
            <a class="dropdown-item" href="{{route('admin.medical_reports.edit',$group['id'])}}">
               <i class="fa fa-flask" aria-hidden="true"></i>
               {{__('Edit Report')}} 
            </a>
        @endcan
        @can('sign_medical_report')
            <a class="dropdown-item" href="{{route('admin.medical_reports.sign',$group['id'])}}">
               <i class="fas fa-signature" aria-hidden="true"></i>
               {{__('Sign Report')}} 
            </a>
        @endcan
        @can('sign_medical_report2')
            <a class="dropdown-item" href="{{route('admin.medical_reports.sign2',$group['id'])}}">
               <i class="fas fa-signature" aria-hidden="true"></i>
               {{__('Sign 2 Report')}} 
            </a>
        @endcan
        @can('view_medical_report')
            <a class="dropdown-item" href="{{route('admin.medical_reports.confirm_report',$group['id'])}}" target="_blank" rel="noopener">
               <i class="fas fa-signature" aria-hidden="true"></i>
               {{__('Confirm Sending')}} 
            </a>
            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal" class="dropdown-item print_barcode" group_id="{{$group['id']}}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{__('Print barcode')}}
            </a>
            <a class="dropdown-item" href="{{route('admin.medical_reports.print_report',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Save')}}
            </a>
            <a class="dropdown-item" href="{{route('admin.medical_reports.print_report5',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Print')}}
            </a>
            
            @if($group['uploaded_report1'])
            <a class="dropdown-item" href="{{$group['report_uploaded']}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Print uploaded Report')}}
            </a>
            @endif
            
            <a class="dropdown-item" href="{{route('admin.medical_reports.show',$group['id'])}}">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{__('Show')}}
            </a>
            @if($whatsapp['report']['active']&&isset($group['report_pdf']))
                <a target="_blank" href="{{whatsapp_notification($group,'report')}}" class="dropdown-item" target="_blank">
                    <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                    {{__('Send Report')}}
                </a>
            @endif
            <a class="dropdown-item" href="{{route('admin.medical_reports.print_reportgr',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Ref2 Save')}}
            </a>
            <a class="dropdown-item" href="{{route('admin.medical_reports.print_reportgr2',$group['id'])}}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{__('Ref2 Print')}}
            </a>
            
        
            @if($email['report']['active']&&isset($group['report_pdf']))
                <form action="{{route('admin.medical_reports.send_report_mail',$group['id'])}}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                    {{__('Send Report')}}
                </button>
                </form>
            @endif
        @endcan

        @can('delete_group')
          <form method="POST" action="{{route('admin.medical_reports.destroy',$group['id'])}}" class="d-inline">
             <input type="hidden" name="_method" value="delete">
             <a href="#" class="dropdown-item delete_medical_report">
                <i class="fa fa-trash"></i>
                {{__('Delete')}}
             </a>
          </form>
       @endcan
    </div>
</div>