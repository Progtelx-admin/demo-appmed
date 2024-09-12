(function($){
    
    "use strict";

    //datatable
    table=$('#reports_table').DataTable( {
        "lengthMenu": [[10, 25, 50,100,500,1000, -1], [10, 25, 50,100,500,1000 ,"All"]],
        dom: "<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-4'i><'col-sm-8'p>>",
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="fas fa-copy"></i> '+trans("Copy"),
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> '+trans("Excel"),
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fas fa-file-csv"></i> '+trans("CVS"),
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> '+trans("PDF"),
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
        "bSort" : false,
          "ajax": {
              url:"get_laboratories"
          },
          // orderCellsTop: true,
          fixedHeader: true,
          "columns": [
            {data:"bulk_checkbox",searchable:false,sortable:false,orderable:false},
            {data:"ResultDetailPK",sortable:false,orderable:false},
            {data:"ResultMasterFK",sortable:false,orderable:false},
            {data:"AnalyzerNo",sortable:false,orderable:false},
            {data:"SampleNo",searchable:true,sortable:false,orderable:false},
            {data:"ResultTransferDtTm",sortable:false,orderable:false},
            {data:"ResultAnalysisDtTm",sortable:false,orderable:false},
            {data:"AnalyzerTestParam",sortable:false,orderable:false},
            {data:"ResultValue",sortable:false,orderable:false},
            {data:"ResultValue2",sortable:false,orderable:false},
            {data:"ResultValueFlag",sortable:false,orderable:false},
            {data:"SampleType",sortable:false,orderable:false},
            {data:"ResultUnit",sortable:false,orderable:false},
            {data:"ReferenceRange",sortable:false,orderable:false},
            {data:"IsResultValueRead",sortable:false,orderable:false},
            {data:"LIMSTestParam",sortable:false,orderable:false},
            {data:"LIMSData1",sortable:false,orderable:false},
            {data:"LIMSData2",sortable:false,orderable:false},
            {data:"LIMSData3",sortable:false,orderable:false},
            // {data:"action",sortable:false,searchable:false,orderable:false}
          ],
          "language": {
            "sEmptyTable":     trans("No data available in table"),
            "sInfo":           trans("Showing")+" _START_ "+trans("to")+" _END_ "+trans("of")+" _TOTAL_ "+trans("records"),
            "sInfoEmpty":      trans("Showing")+" 0 "+trans("to")+" 0 "+trans("of")+" 0 "+trans("records"),
            "sInfoFiltered":   "("+trans("filtered")+" "+trans("from")+" _MAX_ "+trans("total")+" "+trans("records")+")",
            "sInfoPostFix":    "",
            "sInfoThousands":  ",",
            "sLengthMenu":     trans("Show")+" _MENU_ "+trans("records"),
            "sLoadingRecords": trans("Loading..."),
            "sProcessing":     trans("Processing..."),
            "sSearch":         trans("Search")+":",
            "sZeroRecords":    trans("No matching records found"),
            "oPaginate": {
                "sFirst":    trans("First"),
                "sLast":     trans("Last"),
                "sNext":     trans("Next"),
                "sPrevious": trans("Previous")
            },
          }
    });
    
    //active
    $('#laboratories').addClass('active');


    //delete user
    $(document).on('click','.delete_laboratories',function(e){
        e.preventDefault();
        var el=$(this);
        swal({
            title: trans("Are you sure to delete laboratory ?"),
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: trans("Delete"),
            cancelButtonText: trans("Cancel"),
            closeOnConfirm: false
        },
        function(){
            $(el).parent().submit();
        });
    });

})(jQuery);