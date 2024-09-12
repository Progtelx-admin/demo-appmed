<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="fa fa-user"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultDetailPK')}}" name="ResultDetailPK" @if(isset($laboratory)) value="{{$laboratory['ResultDetailPK']}}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="fa fa-user"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultMasterFK')}}" name="ResultMasterFK" @if(isset($laboratory)) value="{{$laboratory['ResultMasterFK']}}" @endif required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('AnalyzerNo')}}" name="AnalyzerNo" @if(isset($laboratory)) value="{{$laboratory['AnalyzerNo']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('SampleNo')}}" name="SampleNo" @if(isset($laboratory)) value="{{$laboratory['SampleNo']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultTransferDtTm')}}" name="ResultTransferDtTm" @if(isset($laboratory)) value="{{$laboratory['ResultTransferDtTm']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultAnalysisDtTm')}}" name="ResultAnalysisDtTm" @if(isset($laboratory)) value="{{$laboratory['ResultAnalysisDtTm']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('AnalyzerTestParam')}}" name="AnalyzerTestParam" @if(isset($laboratory)) value="{{$laboratory['AnalyzerTestParam']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultValue')}}" name="ResultValue" @if(isset($laboratory)) value="{{$laboratory['ResultValue']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultValue2')}}" name="ResultValue2" @if(isset($laboratory)) value="{{$laboratory['ResultValue2']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultValueFlag')}}" name="ResultValueFlag" @if(isset($laboratory)) value="{{$laboratory['ResultValueFlag']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('SampleType')}}" name="SampleType" @if(isset($laboratory)) value="{{$laboratory['SampleType']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ResultUnit')}}" name="ResultUnit" @if(isset($laboratory)) value="{{$laboratory['ResultUnit']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('ReferenceRange')}}" name="ReferenceRange" @if(isset($laboratory)) value="{{$laboratory['ReferenceRange']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('IsResultValueRead')}}" name="IsResultValueRead" @if(isset($laboratory)) value="{{$laboratory['IsResultValueRead']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('LIMSTestParam')}}" name="LIMSTestParam" @if(isset($laboratory)) value="{{$laboratory['LIMSTestParam']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('LIMSData1')}}" name="LIMSData1" @if(isset($laboratory)) value="{{$laboratory['LIMSData1']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('LIMSData2')}}" name="LIMSData2" @if(isset($laboratory)) value="{{$laboratory['LIMSData2']}}" @endif required>
        </div>
    </div>
</div>

<div class="col-lg-12">
        <div class="input-group form-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
              </span>
            </div>
            <input type="text" class="form-control" placeholder="{{__('LIMSData3')}}" name="LIMSData3" @if(isset($laboratory)) value="{{$laboratory['LIMSData3']}}" @endif required>
        </div>
    </div>
</div>