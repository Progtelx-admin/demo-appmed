(function($){

    "use strict";
    
    //active
    $('#prices').addClass('menu-open');
    $('#prices_link').addClass('active');
    $('#microbiology_tests_prices').addClass('active');

    //change hidden microbiology tests prices
    $(document).on('change','.price',function(){
        var test_id=$(this).attr('test_id');
        var price=$(this).val();

        $('#test_'+test_id).val(price);
    });

    //datatable
    var microbiology_tests_table=$('#microbiology_tests_prices_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
         dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
         "<'row'<'col-sm-12'tr>>" +
         "<'row'<'col-sm-4'i><'col-sm-8'p>>",
         buttons: [
             {
                 extend:    'copyHtml5',
                 text:      '<i class="fas fa-copy"></i> Copy',
                 titleAttr: 'Copy'
             },
             {
                 extend:    'excelHtml5',
                 text:      '<i class="fas fa-file-excel"></i> Excel',
                 titleAttr: 'Excel'
             },
             {
                 extend:    'csvHtml5',
                 text:      '<i class="fas fa-file-csv"></i> CVS',
                 titleAttr: 'CSV'
             },
             {
                 extend:    'pdfHtml5',
                 text:      '<i class="fas fa-file-pdf"></i> PDF',
                 titleAttr: 'PDF'
             },
             {
               extend:    'colvis',
               text:      '<i class="fas fa-eye"></i>',
               titleAttr: 'PDF'
             }
         ],
         "processing": true,
         "serverSide": true,
         fixedHeader: true,
         "ajax": {
             url: "microbiology_tests"
         },
         fixedHeader: true,
         "columns": [
            {data:"id",sortable:true,orderable:true},
            {data:"test.name",sortable:false,orderable:false},
            {data:"test.category.name",sortable:false,orderable:false},
            {data:"price",sortable:false,orderable:false},
         ],
         "language": {
             "sEmptyTable":     "No data available in table",
             "sInfo":           "Showing _START_ to _END_ of _TOTAL_ records",
             "sInfoEmpty":      "Showing 0 to 0 of 0 records",
             "sInfoFiltered":   "(filtered from _MAX_ total records)",
             "sInfoPostFix":    "",
             "sInfoThousands":  ",",
             "sLengthMenu":     "Show _MENU_ records",
             "sLoadingRecords": "Loading...",
             "sProcessing":     "Processing...",
             "sSearch":         "Search:",
             "sZeroRecords":    "No matching records found",
             "oPaginate": {
                 "sFirst":    "First",
                 "sLast":     "Last",
                 "sNext":     "Next",
                 "sPrevious": "Previous"
             },
         }
     });

    $(document).on('change','.test_price',function(){
       var price=$(this).val(); 
       if(price<0)
       {
           $(this).val(0);
           price=0;
       }
       var test_id=$(this).attr('test_id');
       if($('#hidden_microbiology_tests_prices').find('#test_price_'+test_id).length>0)
       {
            $('#hidden_microbiology_tests_prices').find('#test_price_'+test_id).val(price);
       }
       else{
            $('#hidden_microbiology_tests_prices').append(`
                <input type="hidden" class="hidden_price" test_id="`+test_id+`" name="tests[`+test_id+`]" value="`+price+`" id="test_price_`+test_id+`">
            `);
       }
    });

    microbiology_tests_table.on( 'draw', function () {
        $('#hidden_microbiology_tests_prices .hidden_price').each(function(){
            var test_id=$(this).attr('test_id');
            var price=$(this).val();

            $('#microbiology_tests_prices_table #test_'+test_id).val(price);
        });
    });


})(jQuery);
