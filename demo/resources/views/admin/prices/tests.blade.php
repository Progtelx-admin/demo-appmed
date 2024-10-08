@extends('layouts.app')

@section('title')
{{ __('Tests Price List') }}
@endsection

@section('css')

@endsection

@section('breadcrumb')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    <i class="fa fa-list"></i>
                    {{__('Tests Price List')}}
                </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index')}}">{{__('Home')}}</a></li>
                    <li class="breadcrumb-item active">{{ __('Tests Price List') }}</li>
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
            {{ __('Tests Table') }}
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <!-- Tool -->
        <div class="row">
            <div class="col-lg-12">
                <div id="accordion">
                    <div class="card card-info">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                            class="btn btn-primary collapsed" aria-expanded="false">
                            <i class="fas fa-file-excel"></i>
                            {{__('Import / Export')}}
                        </a>
                        <div id="collapseOne" class="panel-collapse in collapse">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <a href="{{route('admin.prices.tests_prices_export')}}" class="btn btn-success">
                                            <i class="fa fa-file-excel"></i>
                                            {{__('Export')}}
                                        </a>
                                    </div>
                                    <div class="col-lg-12">
                                        <!-- import form -->
                                        <form action="{{route('admin.prices.tests_prices_import')}}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="card card-primary">
                                                        <div class="card-header">
                                                            <h5 class="card-title">{{__('Import tests')}}</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                        id="exampleInputFile" name="import">
                                                                    <label class="custom-file-label"
                                                                        for="exampleInputFile">{{__('Choose file')}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fa fa-check"></i>
                                                                {{__('Import')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- /import form -->
                                    </div>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-auto text-center">
            <form action="{{ route('admin.prices.updateTestPrices') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-warning mx-2" data-toggle="tooltip" data-placement="top" title="Update test prices in the system">
                    <i class="fas fa-sync-alt"></i>
                    {{ __('Update Test Prices') }}
                </button>
            </form>
        </div>
        <div class="col-auto text-center">
            <form action="{{ route('admin.price_update.contracts') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-warning mx-2" data-toggle="tooltip" data-placement="top" title="Update contract prices from base tables">
                    <i class="fas fa-sync-alt"></i>
                    {{ __('Update Contract Prices From Base Tables') }}
                </button>
            </form>
        </div>
        <div class="col-auto text-center">
            <form action="{{ route('admin.prices.api-updateTestPrices') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-warning mx-2" data-toggle="tooltip" data-placement="top" title="Update API test prices">
                    <i class="fas fa-sync-alt"></i>
                    {{ __('Update API Test Prices') }}
                </button>
            </form>
        </div>
        <div class="col-auto text-center">
            <form action="{{ route('admin.prices.api-updateTestPricesContract') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="btn btn-warning mx-2" data-toggle="tooltip" data-placement="top" title="Update subject API test prices">
                    <i class="fas fa-sync-alt"></i>
                    {{ __('Update SUBJECT API Test Prices') }}
                </button>
            </form>
        </div>
    </div>
</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- \Tool -->

        <div class="row">
            <div class="col-lg-12  p-0">
                <form action="{{route('admin.prices.tests_submit')}}" method="POST">
                    @csrf
                    <table id="tests_prices_table" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="10px">#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th width="200px">{{ __('Price') }}</th>
                            </tr>
                        </thead>
    
                        <tbody>
                           
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">
                                    <button type="submit" class="btn btn-primary">
                                        {{__('Update')}}
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="hidden_prices">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

@endsection
@section('scripts')
    <script src="{{url('js/admin/tests_prices.js')}}"></script>
@endsection