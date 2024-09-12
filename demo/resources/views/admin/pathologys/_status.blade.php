@if($pathology['status'])
    <input type="checkbox" class="change_visit_status" id="change_status_{{$pathology['id']}}" visit-id='{{$pathology['id']}}' checked netliva-switch data-active-text="{{__('Completed')}}" data-passive-text=" {{__('Pending')}}"/>
@else 
    <input type="checkbox" class="change_visit_status" id="change_status_{{$pathology['id']}}" visit-id='{{$pathology['id']}}' netliva-switch data-active-text="{{__('Completed')}}" data-passive-text="{{__('Pending')}}"/>
@endif