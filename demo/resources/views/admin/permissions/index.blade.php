@extends('layouts.app')

@section('title')
    {{ __('Permissions') }}
@endsection

@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-tasks"></i>
                        {{ __('Permissions') }}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Permissions') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                {{ __('Permissions table') }}
            </h3>
            @can('create_permission')
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm float-right">
                    <i class="fa fa-plus"></i> {{ __('Permissions') }}
                </a>
                <a style="margin-right: 5px" href="{{ route('admin.permissions.createModule') }}"
                    class="btn btn-primary btn-sm float-right">
                    <i class="fa fa-plus"></i> {{ __('Module') }}
                </a>
            @endcan
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="col-lg-12 table-responsive">
                <table id="myDataTable" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th width="10px">#</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Module') }}</th>
                            <th>{{ __('Key') }}</th>
                            <th width="100px">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $permission['id'] }}</td>
                                <td>{{ $permission['name'] }}</td>
                                <td>{{ $permission['module']['name'] }}</td>
                                <td>{{ $permission['key'] }}</td>
                                <td>
                                    @can('edit_permission')
                                        <a href="{{ route('admin.permissions.edit', $permission['id']) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('delete_permission')
                                        <form method="POST"
                                            action="{{ route('admin.permissions.destroy', $permission['id']) }}"
                                            class="d-inline">
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-danger btn-sm delete_permission">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <br>
@endsection
@section('scripts')

    {{-- <script src="{{ url('js/admin/workplaces.js') }}"></script> --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable({
                // Add your DataTable options here
                dom: 'lBfrtip',
                "iDisplayLength": 10,
                "lengthMenu": [10, 25, 30, 50, 75, 100, 200],
                // Add other options as needed
                "order": [
                    [0, "desc"]
                ] // Sort by the first column (index 0) in descending order
            });
        });
    </script>
@endsection
