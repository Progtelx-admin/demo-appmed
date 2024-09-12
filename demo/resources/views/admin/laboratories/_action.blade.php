@can('edit_laboratory')
    <a href="{{route('admin.laboratories.edit',$laboratory['id'])}}" class="btn btn-primary btn-sm">
        <i class="fa fa-edit"></i>
    </a>
@endcan

@can('delete_laboratory')
    <form method="POST" action="{{route('admin.laboratories.destroy',$laboratory['id'])}}"  class="d-inline">
        <input type="hidden" name="_method" value="delete">
        <button type="submit" class="btn btn-danger btn-sm delete_user">
            <i class="fa fa-trash"></i>
        </button>
    </form>
@endcan