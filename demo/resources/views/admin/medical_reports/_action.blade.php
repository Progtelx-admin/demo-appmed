<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        @can('edit_medical_report')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.edit', $group['id']) }}">
                <i class="fa fa-flask" aria-hidden="true"></i>
                {{ __('Edit Report') }}
            </a>
            @if ($group['all_tests']->contains('test_id', 405))
                <a class="dropdown-item" href="{{ route('admin.medical_reports.edit_blood', $group['id']) }}">
                    <i class="fa fa-flask" aria-hidden="true"></i>
                    {{ __('Edit Blood') }}
                </a>
            @endif
            @if ($group['all_tests']->contains('test_id', 790))
                <a class="dropdown-item" href="{{ route('admin.medical_reports.edit_pcr', $group['id']) }}">
                    <i class="fa fa-flask" aria-hidden="true"></i>
                    {{ __('Edit PCR') }}
                </a>
            @endif
        @endcan
        @can('sign_medical_report')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.sign', $group['id']) }}">
                <i class="fas fa-signature" aria-hidden="true"></i>
                {{ __('Sign by Doctor Biokimi') }}
            </a>
        @endcan
        @can('sign_medical_report2')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.sign2', $group['id']) }}">
                <i class="fas fa-signature" aria-hidden="true"></i>
                {{ __('Sign by Laboratory Bikimi') }}
            </a>
        @endcan
        @can('sign_medical_report3')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.sign3', $group['id']) }}">
                <i class="fas fa-signature" aria-hidden="true"></i>
                {{ __('Sign by Doctor Mikro') }}
            </a>
        @endcan
        @can('sign_medical_report4')
            <a class="dropdown-item" href="{{ route('admin.medical_reports.sign4', $group['id']) }}">
                <i class="fas fa-signature" aria-hidden="true"></i>
                {{ __('Sign by Laboratory Mikro') }}
            </a>
        @endcan
        @can('view_medical_report')

            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.confirm_report', $group['id']) }}" target="_blank" rel="noopener">-->
            <!--   <i class="fas fa-signature" aria-hidden="true"></i>-->
            <!--   {{ __('Confirm Sending') }} -->
            <!--</a>-->
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.called_patient', $group['id']) }}" target="_blank" rel="noopener">-->
            <!--   <i class="fas fa-signature" aria-hidden="true"></i>-->
            <!--   {{ __('Confirm Call') }} -->
            <!--</a>-->
            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal"
                class="dropdown-item print_barcode" group_id="{{ $group['id'] }}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{ __('Print barcode') }}
            </a>
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.print_report', $group['id']) }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Save') }}-->
            <!--</a>-->
            <!-- <a class="dropdown-item" href="{{ $group['report_pdf'] }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Save') }}-->
            <!--</a>-->
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.print_report5', $group['id']) }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Print') }}-->
            <!--</a>-->
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.trombofili-pdf', $group['id']) }}"-->
            <!--    target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Trombo PDF') }}-->
            <!--</a>-->
            <a class="dropdown-item" href="{{ route('admin.medical_reports.test-pdf', $group['id']) }}" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Tests PDF') }}
            </a>

            @if ($group['all_tests']->contains('test_id', 405))
                <a class="dropdown-item" href="{{ route('admin.medical_reports.blood-pdf', $group['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Blood PDF') }}
                </a>
            @endif
            @if ($group['all_tests']->contains('test_id', 790))
                <a class="dropdown-item" href="{{ route('admin.medical_reports.pcr-pdf', $group['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('PCR PDF') }}
                </a>
            @endif
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.test-pdf2', $group['id']) }}"-->
            <!--    target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Print Tests PDF') }}-->
            <!--</a>-->
            <a class="dropdown-item" href="{{ route('admin.medical_reports.culture-pdf', $group['id']) }}"
                target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Cultures PDF') }}
            </a>
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.culture-pdf2', $group['id']) }}"-->
            <!--    target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Print Cultures PDF') }}-->
            <!--</a>-->


            <!-- <a class="dropdown-item" href="{{ $group['report_pdf2'] }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Print') }}-->
            <!--</a>-->
            <!--   <a class="dropdown-item" href="{{ route('admin.medical_reports.print_report5', $group['id']) }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('PDF Lab') }}-->
            <!--</a>-->

            @if ($group['uploaded_report1'])
                <a class="dropdown-item" href="{{ $group['report_uploaded'] }}" target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Print uploaded Report') }}
                </a>
            @endif

            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.show', $group['id']) }}">-->
            <!--    <i class="fa fa-eye" aria-hidden="true"></i>-->
            <!--    {{ __('Show') }}-->
            <!--</a>-->
            <a class="dropdown-item" href="{{ route('admin.medical_reports.show2', $group['id']) }}">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{ __('Show new') }}
            </a>
            @if ($whatsapp['report']['active'] && isset($group['report_pdf']))
                <!--<a target="_blank" href="{{ whatsapp_notification($group, 'report') }}" class="dropdown-item" target="_blank">-->
                <!--    <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>-->
                <!--    {{ __('Send Report') }}-->
                <!--</a>-->
            @endif
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.print_reportgr', $group['id']) }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Ref2 Save') }}-->
            <!--</a>-->
            <!--<a class="dropdown-item" href="{{ $group['report_pdf3'] }}" target="_blank">-->
            <!--     <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--     {{ __('Ref2 Save') }}-->
            <!-- </a>-->
            <!--<a class="dropdown-item" href="{{ route('admin.medical_reports.print_reportgr2', $group['id']) }}" target="_blank">-->
            <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
            <!--    {{ __('Ref2 Print') }}-->
            <!--</a>-->
            @can('edit_group')
                <a href="{{ route('admin.groups.edit', $group['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i>
                    {{ __('X') }}
                </a>
            @endcan


            @if ($email['report']['active'] && isset($group['report_pdf']))
                <form action="{{ route('admin.medical_reports.send_report_mail', $group['id']) }}" method="POST"
                    class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                        {{ __('Send Report') }}
                    </button>
                </form>
            @endif
        @endcan

        @can('delete_group')
            <form method="POST" action="{{ route('admin.medical_reports.destroy', $group['id']) }}" class="d-inline">
                <input type="hidden" name="_method" value="delete">
                <a href="#" class="dropdown-item delete_medical_report">
                    <i class="fa fa-trash"></i>
                    {{ __('Delete') }}
                </a>
            </form>
        @endcan
        <!-- <a class="dropdown-item" href="{{ route('admin.medical_reports.print_report', $group['id']) }}" target="_blank">-->
        <!--    <i class="fa fa-print" aria-hidden="true"></i>-->
        <!--    {{ __('PDF Save') }}-->
        <!--</a>-->

    </div>
</div>
