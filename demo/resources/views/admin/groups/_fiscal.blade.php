@if($group['api'])
<div class="text-center"><i class="fa fa-check-double text-success"></i></div>
@else
<div class="text-center"><i class="fa fa-times-circle text-danger"></i></div>
@endif


<!--@if ($group['created_by_user']['pos_1_id'] == $group['pos'])-->
<!--    <div class="text-center">-->
<!--        <i class="fa fa-check-double text-success"></i>-->
<!--        <span class="d-block mt-2 text-success" style="font-size: 0.9em;">{{ $group['created_by_user']['pos_1_name'] }}</span>-->
<!--    </div>-->
<!--@elseif($group['created_by_user']['pos_2_id'] == $group['pos'])-->
<!--    <div class="text-center">-->
<!--        <i class="fa fa-check-double text-warning"></i>-->
<!--        <span class="d-block mt-2 text-warning" style="font-size: 0.9em;">{{ $group['created_by_user']['pos_2_name'] }}</span>-->
<!--    </div>-->
<!--@else-->
<!--    <div class="text-center">-->
<!--        <i class="fa fa-times-circle text-danger"></i>-->
<!--        <span class="d-block mt-2 text-danger" style="font-size: 0.9em;"></span>-->
<!--    </div>-->
<!--@endif-->

