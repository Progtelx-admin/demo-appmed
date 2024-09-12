@extends('layouts.app')

@section('title')
{{__('Create Microbiology Test')}}
@endsection

@section('css')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.css')}}">
@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">
            <i class="fa fa-flask"></i>
            {{__('Microbiology Tests')}}
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item "><a href="{{route('admin.microbiology_tests.index')}}">{{__('Microbiology Tests')}}</a></li>
            <li class="breadcrumb-item active">{{__('Create Microbiology Test')}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">{{__('Create Microbiology Test')}}</h3>
    </div>
    <form method="POST" action="{{route('admin.microbiology_tests.store')}}" id="microbiology_test_form">
        <!-- /.card-header -->
        <div class="card-body">
            @csrf
            @include('admin.microbiology_tests._form')
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"> <i class="fa fa-check"></i> {{__('Save')}}</button>
        </div>
    </form>

</div>
@endsection
@section('scripts')

<script src="{{url('js/admin/microbiology_tests.js')}}"></script>
@endsection
