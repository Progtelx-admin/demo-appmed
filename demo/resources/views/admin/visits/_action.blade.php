<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{ __('Action') }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <!--@can('view_visit')
    -->
            <!--  <a href="{{ route('admin.visits.show', $visit['id']) }}" class="dropdown-item">-->
            <!--    <i class="fa fa-eye"></i> {{ __('Show') }}-->
            <!--  </a>-->
            <!--
@endcan-->
        <!--@can('edit_visit')
    -->
            <!--  <a href="{{ route('admin.visits.edit', $visit['id']) }}" class="dropdown-item">-->
            <!--    <i class="fa fa-edit"></i> {{ __('Edit') }}-->
            <!--  </a>-->
            <!--
@endcan-->
        <!--@can('sign_medical_report')
    -->
            <!--  <a class="dropdown-item" href="{{ route('admin.visits.sign', $visit['id']) }}">-->
            <!--      <i class="fas fa-signature" aria-hidden="true"></i>-->
            <!--         {{ __('Sign Report') }} -->
            <!--      </a>-->
            <!--
@endcan-->
        <!--@can('view_group')
    -->
            <!--  <a href="{{ route('admin.visit_reports.visit-pdf', $visit['id']) }}" class="dropdown-item" target="_blank">-->
            <!--      <i class="fas fa-file-word" aria-hidden="true"></i>-->
            <!--      {{ __('Save Report') }}-->
            <!--   </a>-->
            <!--
@endcan-->
        <!--@can('edit_visit')
    -->
            <!--  <a href="{{ route('admin.visits.edit', $visit['id']) }}" class="dropdown-item">-->
            <!--    <i class="fa fa-edit"></i> {{ __('Edit 2') }}-->
            <!--  </a>-->
            <!--
@endcan-->
        @can('create_group')
            <a href="{{ route('admin.visits.create_tests', $visit['id']) }}" class="dropdown-item">
                <i class="fas fa-file-invoice-dollar"></i> {{ __('Create invoice') }}
            </a>
        @endcan
        @can('view_pdf_visit_rec')
            <a href="{{ route('admin.visit_reports2.visit-pdf', $visit['id']) }}" class="dropdown-item" target="_blank">
                <i class="fas fa-file-word" aria-hidden="true"></i>
                {{ __('Save Report Recepsion') }}
            </a>
        @endcan
        <!--@can('view_group')
    -->
            <!--  <a href="{{ route('admin.visits.report_visit2', $visit['id']) }}" class="dropdown-item">-->
            <!--      <i class="fas fa-file-word" aria-hidden="true"></i>-->
            <!--      {{ __('Save Report') }}-->
            <!--   </a>-->
            <!--
@endcan-->
        <!--@can('view_group')
    -->
            <!--  <a href="{{ route('admin.visits.report_visit', $visit['id']) }}" class="dropdown-item">-->
            <!--      <i class="fas fa-file-word" aria-hidden="true"></i>-->
            <!--      {{ __('Print Report Visit') }}-->
            <!--   </a>-->
            <!--
@endcan-->
        <!--@can('view_group')
    -->
            <!--  <a href="{{ route('admin.visits.report_visit3', $visit['id']) }}" class="dropdown-item">-->
            <!--      <i class="fas fa-file-word" aria-hidden="true"></i>-->
            <!--      {{ __('Save Report 2') }}-->
            <!--   </a>-->
            <!--
@endcan-->
        <!--@can('view_group')
    -->
            <!--  <a href="{{ route('admin.visits.report_visit4', $visit['id']) }}" class="dropdown-item">-->
            <!--      <i class="fas fa-file-word" aria-hidden="true"></i>-->
            <!--      {{ __('Print Report Visit 2') }}-->
            <!--   </a>-->
            <!--
@endcan-->

        @can('delete_visit')
            <form method="POST" action="{{ route('admin.visits.destroy', $visit['id']) }}" class="d-inline">
                <input type="hidden" name="_method" value="delete">
                <a href="#" class="dropdown-item delete_visit">
                    <i class="fa fa-trash"></i>
                    {{ __('Delete') }}
                </a>
            </form>
        @endcan
        <!--fiskalizimi-->
        @can('edit_group')
            @if ($group->api == 0)
                <a href="{{ route('admin.groups.apipantheon', $group['id']) }}" class="dropdown-item">
                    <i class="fa fa-print"></i>
                    {{ __('Fiskalizo') }}
                </a>
            @else
            @endif
            @if (auth()->guard('admin')->user()->name == 'ad_lindor' && $group->api == 1)
                <a style="margin-top: 5px; border-radius: 0px" href="{{ route('admin.groups.apipantheon', $group['id']) }}"
                    class="dropdown-item">
                    <i class="fa fa-print"> Ridergo</i>
                </a>
            @else
            @endif
        @endcan
    </div>
</div>
