<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i>
    </button>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

        @can('edit_group')
            @if ($group['api'] == '')
                <a href="{{ route('admin.groups.edit', $group['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i>
                    {{ __('Edit') }}
                </a>
            @else
                <!--    <a href="{{ route('admin.groups.edit', $group['id']) }}" class="dropdown-item">-->
                <!--   <i class="fa fa-edit"></i>-->
                <!--   {{ __('Edit') }}-->
                <!--</a>-->
            @endif
        @endcan

        @can('view_group')
            <a style="cursor: pointer" data-toggle="modal" data-target="#print_barcode_modal"
                class="dropdown-item print_barcode" group_id="{{ $group['id'] }}">
                <i class="fa fa-barcode" aria-hidden="true"></i>
                {{ __('Print barcode') }}
            </a>
            <a href="{{ route('admin.groups.working_paper', $group['id']) }}" class="dropdown-item">
                <i class="fas fa-file-word" aria-hidden="true"></i>
                {{ __('Working paper') }}
            </a>
            <a href="{{ route('admin.groups.working_paper_pdf', $group['id']) }}" class="dropdown-item" target="_blank">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
                {{ __('Working paper PDF') }}
            </a>
            <a href="{{ route('admin.groups.print_80mm', $group['id']) }}" class="dropdown-item">
                <i style="color: brown" class="fas fa-print" aria-hidden="true"></i>
                {{ __('Print 80mm') }}
            </a>
            <a href="{{ route('admin.groups.order-tests', $group['id']) }}" class="dropdown-item" target="_blank">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
                {{ __('ORDER') }}
            </a>
            <a href="{{ $group['receipt_pdf'] }}" class="dropdown-item" target="_blank">
                <i class="fa fa-print" aria-hidden="true"></i>
                {{ __('Print receipt') }}
            </a>
            <a href="{{ route('admin.groups.show', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-eye" aria-hidden="true"></i>
                {{ __('Show receipt') }}
            </a>
            @if ($whatsapp['receipt']['active'] && isset($group['receipt_pdf']))
                <a target="_blank" href="{{ whatsapp_notification($group, 'receipt') }}" class="dropdown-item">
                    <i class="fab fa-whatsapp" aria-hidden="true" class="text-success"></i>
                    {{ __('Send receipt') }}
                </a>
            @endif
            @if ($email['receipt']['active'] && isset($group['receipt_pdf']))
                <form action="{{ route('admin.groups.send_receipt_mail', $group['id']) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fa fa-envelope" aria-hidden="true" class="text-success"></i>
                        {{ __('Send receipt') }}
                    </button>
                </form>
            @endif
        @endcan

        @can('edit_medical_report')
            <a href="{{ route('admin.medical_reports.edit', $group['id']) }}" class="dropdown-item">
                <i class="fa fa-flag"></i>
                {{ __('Enter report') }}
            </a>
        @endcan

        @can('delete_group')
            <form method="POST" action="{{ route('admin.groups.destroy', $group['id']) }}" class="d-inline">
                <input type="hidden" name="_method" value="delete">
                <a href="#" class="dropdown-item delete_group">
                    <i class="fa fa-trash"></i>
                    {{ __('Delete') }}
                </a>
            </form>
        @endcan
        <!--fiskalizimi-->
        @can('edit_group')
            @if ($group->api == 0 || $group->api == '')
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
