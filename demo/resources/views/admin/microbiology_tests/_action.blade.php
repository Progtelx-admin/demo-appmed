@can('edit_test')
    @if($microbiologyTest['parent_id'])
        <a href="{{route('admin.microbiology_tests.edit',$microbiologyTest['parent_id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @else
        <a href="{{route('admin.microbiology_tests.edit',$microbiologyTest['id'])}}" class="btn btn-primary btn-sm">
            <i class="fa fa-edit"></i>
        </a>
    @endif
@endcan

@can('edit_test')
    @if($microbiologyTest['parent_id'])
        <a href="{{route('admin.microbiology_tests.consumptions',$microbiologyTest['parent_id'])}}" class="btn btn-warning btn-sm">
            <i class="fa fa-tools"></i>
        </a>
    @else
        <a href="{{route('admin.microbiology_tests.consumptions',$microbiologyTest['id'])}}" class="btn btn-warning btn-sm">
            <i class="fa fa-tools"></i>
        </a>
    @endif
@endcan


