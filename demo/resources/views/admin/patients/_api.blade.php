@if($patient['api'])
<div class="text-center"><i class="fa fa-check-double text-success"></i></div>
@else
<div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
@endif

<!--@if($patient['due']>0)-->
<!--    <span class="text-danger text-bold">-->
<!--        {{formated_price($patient['due'])}}-->
<!--    </span>-->
<!--@else -->
<!--    <span class="text-success">-->
<!--        {{formated_price($patient['due'])}}-->
<!--    </span>-->
<!--@endif-->