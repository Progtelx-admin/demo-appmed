@if(!empty($group['signed_by']))
    <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
@elseif(!empty($group['signed_by2']))
    <div class="text-center"><i class="fa fa-check-double text-success"></i></div>
@else
    <div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
@endif