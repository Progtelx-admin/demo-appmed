(function($){

    "use strict";
    

    //active
    $('#reports').addClass('active menu-open');
    $('#reports_link').addClass('active');
    $('#accounting_report').addClass('active');
     //Medical reports datatables
        table=$('#accounting_report_table').DataTable( {
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
            "order": [[ 1, "desc" ]],
            "ajax": {
                url: "accounting",
                data:function(data)
                {
                    
                }
            },
            fixedHeader: true,
            "columns": [
                //{data:"bulk_checkbox",orderable:false,sortable:false},
                {data:"id",orderable:false,sortable:true},
                // {data:"branch_id",orderable:false,sortable:false},
                {data:"done",orderable:false,sortable:false},
                {data:"barcode",orderable:false,sortable:false},
                // {data:"created_at",orderable:false,sortable:false},
                {data:"patient.name",orderable:false,sortable:false},
                {data:"doctor.name",orderable:false,sortable:false},
                {data:"patient.gender",orderable:false,sortable:false},
                {data:"patient.dob",searchable:false,orderable:false,sortable:false},
                {data:"patient.city",searchable:false,orderable:false,sortable:false},
                {data:"patient.phone",orderable:false,sortable:false},
                {data:"patient.address",orderable:false,sortable:false},
                {data:"patient.profession",orderable:false,sortable:false},
                {data:"patient.national_id",orderable:false,sortable:false},
                {data:"group.tests",searchable:false,orderable:false,sortable:false},
                {data:"discount",searchable:false,orderable:false,sortable:false},
                {data:"comment",searchable:false,orderable:false,sortable:false},
                {data:"test.result",searchable:false,sortable:false,orderable:false},
                {data:"patient.vaccinemodel",orderable:false,sortable:false},
                {data:"patient.datevaccine1",orderable:false,sortable:false},
                {data:"patient.datevaccine2",orderable:false,sortable:false},
                {data:"patient.datevaccine3",orderable:false,sortable:false},
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

    //get doctor select2 intialize
    $('#doctor').select2({
      width:"100%",
      placeholder:trans("Doctor"),
      multiple: true,
      ajax: {
       beforeSend:function()
       {
          $('.preloader').show();
          $('.loader').show();
       },
       url:"/ajax/get_doctors",
       processResults: function (data) {
             return {
                   results: $.map(data, function (item) {
                      return {
                         text: item.name,
                         id: item.id
                      }
                   })
             };
          },
          complete:function()
          {
             $('.preloader').hide();
             $('.loader').hide();
          }
       }
    });

    //get test select2 intialize
    $('#test').select2({
        width:"100%",
        placeholder:trans("Test"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:'/ajax/get_tests_select2',
           processResults: function (data) {
                 return {
                       results: $.map(data, function (item) {
                          return {
                             text: item.name,
                             id: item.id
                          }
                       })
                 };
              },
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
           }
    });

    //get culture select2 intialize
    $('#culture').select2({
        width:"100%",
        placeholder:trans("Culture"),
        multiple: true,
        ajax: {
           beforeSend:function()
           {
              $('.preloader').show();
              $('.loader').show();
           },
           url:'/ajax/get_cultures_select2',
           processResults: function (data) {
                 return {
                       results: $.map(data, function (item) {
                          return {
                             text: item.name,
                             id: item.id
                          }
                       })
                 };
              },
              complete:function()
              {
                 $('.preloader').hide();
                 $('.loader').hide();
              }
           }
    });

    //get culture select2 intialize
    $('#package').select2({
         width:"100%",
         placeholder:trans("Package"),
         multiple: true,
         ajax: {
            beforeSend:function()
            {
               $('.preloader').show();
               $('.loader').show();
            },
            url: "ajax/get_packages_select2",
            processResults: function (data) {
                  return {
                        results: $.map(data, function (item) {
                           return {
                              text: item.name,
                              id: item.id
                           }
                        })
                  };
               },
               complete:function()
               {
                  $('.preloader').hide();
                  $('.loader').hide();
               }
            }
    });

    //get culture select2 intialize
    $('#branch').select2({
      width:"100%",
      placeholder:trans("Branch"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:"/ajax/get_branches_select2",
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.name,
                           id: item.id
                        }
                     })
               };
                  },
                  complete:function()
                  {
                     $('.preloader').hide();
                     $('.loader').hide();
                  }
               }
      });

    //get culture select2 intialize
    $('#contract').select2({
      width:"100%",
      placeholder:trans("Contract"),
      multiple: true,
      ajax: {
         beforeSend:function()
         {
            $('.preloader').show();
            $('.loader').show();
         },
         url:"/ajax/get_contracts",
         processResults: function (data) {
               return {
                     results: $.map(data, function (item) {
                        return {
                           text: item.title,
                           id: item.id
                        }
                     })
               };
            },
            complete:function()
            {
               $('.preloader').hide();
               $('.loader').hide();
            }
         }
  });

})(jQuery);