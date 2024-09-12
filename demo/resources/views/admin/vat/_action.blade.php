@can('edit_vat')
    <a href="{{ route('admin.vat.edit', $vat['id']) }}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_vat')
    <form method="POST" action="{{ route('admin.vat.destroy', $vat['id']) }}" class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_vat">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan
