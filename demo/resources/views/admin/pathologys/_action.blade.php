<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-cog"></i> {{ __('Action') }}
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <!--@can('view_pathologys')
    -->
            <!--  <a href="{{ route('admin.pathologys.show', $pathology['id']) }}" class="dropdown-item">-->
            <!--    <i class="fa fa-eye"></i> {{ __('Show') }}-->
            <!--  </a>-->
            <!--
@endcan-->
        @can('edit_pathologys')
            @if ($pathology['report'] == 'Pathology')
                <a href="{{ route('admin.pathologys.edit', $pathology['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            @endif
            @if ($pathology['report'] == 'Cytology')
                <a href="{{ route('admin.pathologys.editCytology', $pathology['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            @endif
            @if ($pathology['report'] == 'Pap Test')
                <a href="{{ route('admin.pathologys.editPapTest', $pathology['id']) }}" class="dropdown-item">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            @endif
        @endcan
        @can('view_pathologys')
            @if ($pathology['report'] == 'Pathology')
                <a class="dropdown-item" href="{{ route('admin.pathologys.pathology-pdf', $pathology['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Pathologys PDF') }}
                </a>
            @endif
            @if ($pathology['report'] == 'Pap Test')
                <a class="dropdown-item" href="{{ route('admin.pathologys.paptest-pdf', $pathology['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Pap Test PDF') }}
                </a>
            @endif
            @if ($pathology['report'] == 'Cytology')
                <a class="dropdown-item" href="{{ route('admin.pathologys.cytological-pdf', $pathology['id']) }}"
                    target="_blank">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    {{ __('Cytological PDF') }}
                </a>
            @endif
        @endcan
    </div>
</div>
