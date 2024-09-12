@can('edit_service')
<a href="{{route('admin.services.edit',$service['id'])}}" class="btn btn-primary btn-sm">
  <i class="fa fa-edit"></i>
</a>
@endcan

@can('delete_service')
<form method="POST" action="{{route('admin.services.destroy',$service['id'])}}" class="d-inline">
  <input type="hidden" name="_method" value="delete">
  <button type="submit" class="btn btn-danger btn-sm delete_antibiotic">
      <i class="fa fa-trash"></i>
  </button>
</form>
@endcan