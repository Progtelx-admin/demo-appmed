@can('edit_instrument')
    <a href="{{route('admin.instruments.edit',$instrument['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_instrument')
    <form method="POST" action="{{route('admin.instruments.destroy',$instrument['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_user">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan