(function($){
    //active
    $('#translations').addClass('active');

    //change status
    $(document).on('click','.netliva-switch label',function(){
        var id=$(this).prev('input').attr('lang-id');
        $.ajax({
            type:'post',
            url:"/ajax/change_lang_status/"+id,
            success:function(message)
            {
                toastr.success(message);
            }
        });
     });

})(jQuery);
