@extends('layouts.app')

@section('title')
{{ __('Create category') }}
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fa fa-tasks"></i>
                    {{__('Point Of Sales')}}
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.pointofsales.index')}}">{{ __('Point Of Sales') }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('Create POS') }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ __('Create POS') }}</h3>
    </div>
    <!-- /.card-header -->
    <form method="POST" action="{{route('admin.pointofsales.store')}}">
        @csrf
        <div class="card-body">
            <div class="col-lg-12">
                @include('admin.pointofsales._form')
            </div>
        </div>
        <div class="card-footer">
            <div class="col-lg-12">
                <button type="submit" class="btn btn-primary">
                  <i class="fa fa-check"></i>  {{__('Save')}}
                </button>
            </div>
        </div>
    </form>

    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/PointOfSales.js')}}"></script>
@endsection
