<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('css/favicon.png') }}"/>
    <title>Accounting Portal : Celeb Media</title>

    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
    <link href="{{ asset('css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fixedHeader.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fixedColumns.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

<script src="{{ asset('css/jquery-3.5.1.js') }}"></script>
<script src="{{ asset('css/jquery-ui.js') }}"></script> 
<script type="text/javascript" src="{{ asset('css/bootstrap.min.js') }}"></script>

<script src="{{ asset('css/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('css/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('css/jszip.min.js') }}"></script>
<script src="{{ asset('css/pdfmake.min.js') }}"></script>
<script src="{{ asset('css/vfs_fonts.js') }}"></script>
<script src="{{ asset('css/buttons.html5.min.js') }}"></script>
<script src="{{ asset('css/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('css/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('css/dataTables.fixedColumns.min.js') }}"></script>

<script src="{{ asset('css/dataTables.searchHighlight.min.js') }}"></script>
<link href="{{ asset('css/dataTables.searchHighlight.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('css/jquery.highlight.js') }}"></script>
<script src="{{ asset('css/popper.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

<style type="text/css">
.td_nowrap {
	white-space: nowrap;
}

.td_breakword {
        word-wrap: break-word;
	width: 125px;
}

.tooltip-wrapper {
    min-width: max-content;
}

.pl-4, .px-4 {
    padding-left: 1rem !important;
}
.pr-4, .px-4 {
    padding-right: 1rem !important;
}

.tbl_list tbody th, .tbl_list tbody td
    {
      padding: 3px 5px !important;
    }
.tbl_list tr:nth-child(odd) {
  // background-color: #e9e9e9;
  background-color: #c8dce7;
}

.tbl_list td:first-child {
  // font-weight: bold;
}

.tooltip-basic {  position: relative; }

.tooltip-basic-message {
  position: absolute;
  display: none;
  background: #FFF;
  color: #000;
  border:1px solid #000;
  padding: 5px;
  z-index: 1;
  left: -160%;
  width: max-content;
  text-align: left;
}
.tip { width: 100%; }

.tooltipTop{
  top: 20px;
  display: block;
}

.tooltipBottom{
	top: -25px;
	display: block;
}

/* Popup Modal */
#list_modal {
	z-index: 1;
}
.close {
    opacity: 1; background-color: #FFF;
}
button.close {
    background-color: #FFF; width: 25px;
}
.modal-header {
    border-bottom: 0px;
}
.modal-content {
    padding: 5px;
}
.fade:not(.show) {
    opacity: 0.8;
}

.modal-dialog {
    max-width: 600px;
    margin: 1.75rem auto;
}

// Scroll to Top
#btn-back-to-top {
  position: fixed;
  display: none;
}

#myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  /* background-color: #8d00003d; */
  background-color: #8d0000; 
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 4px;
}
</style>
</head>
<body class=" bg-red-200 min-h-screen font-base">

<button onclick="topFunction()" id="myBtn" title="Go to top"><svg baseProfile="tiny" height="24px" id="Layer_1" version="1.2" viewBox="0 0 24 24" width="24px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M12,21c-1.654,0-3-1.346-3-3v-4.764c-1.143,1.024-3.025,0.979-4.121-0.115c-1.17-1.169-1.17-3.073,0-4.242L12,1.758   l7.121,7.121c1.17,1.169,1.17,3.073,0,4.242c-1.094,1.095-2.979,1.14-4.121,0.115V18C15,19.654,13.654,21,12,21z M11,8.414V18   c0,0.551,0.448,1,1,1s1-0.449,1-1V8.414l3.293,3.293c0.379,0.378,1.035,0.378,1.414,0c0.391-0.391,0.391-1.023,0-1.414L12,4.586   l-5.707,5.707c-0.391,0.391-0.391,1.023,0,1.414c0.379,0.378,1.035,0.378,1.414,0L11,8.414z"/></g></svg></button>

<div id="app">
    
    <div class="flex flex-col md:flex-row"> 

        @include('includes.sidebar')

        <div class="w-full md:flex-1">

 <nav class="hidden md:flex justify-between items-center bg-white p-4 shadow-md h-16">
	 <div>
	<input class="px-4 py-2 bg-gray-200 border border-gray-300 rounded focus:outline-none" type="text"
               placeholder="Search.." style='display: none;'/>
    </div>
    <div class="relative">
        <button class="mx-2 btn btn-default" onclick="toggleDropdown()" style='width:200px; color:white; background-color:#880009; border-radius:50px;'> <svg class="h-8 w-8 text-black-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="float: left; background: transparent; fill: transparent;">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <circle cx="12" cy="7" r="4" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>{{ Auth::user()->name }}
        </button>

        <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden" style="position:absolute;margin-left: 20px;width: 180px;">
            <button  onclick="location.href='{{ route('changepassword') }}'" title="Change Password"
            class="block w-full px-2 py-2 text-left text-gray-800 hover:bg-gray-100 focus:outline-none">Change Password</button>
            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout"
            class="block w-full px-4 py-2 text-left text-gray-800 hover:bg-gray-100 focus:outline-none">Logout</button>
        </div>
    </div>
</nav>
            <main>
                <!-- Replace with your content -->
                <div class="px-8 py-6">
                    @yield('content')
                </div>
                <!-- /End replace -->
            </main>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>
@php
    $userRoleId = Auth::user()->user_master_id;
@endphp
<script>
  $(function () {
var invoice_table= $('#invoice_data-table').DataTable( {
        dom: 'lBfrtip',  
        fixedHeader: {
        header: true,
        footer: true
    },
    scrollCollapse: true,
    scrollX: true,
    scrollY: 700,      
	colReorder: true,
        order: [[2, "desc"]],
        buttons: [
		{
			"extend": 'excel',
			"text": 'EXCEL',
			"titleAttr": 'EXCEL',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		},
		{
			"extend": 'csv',
			"text": 'CSV',
			"titleAttr": 'CSV',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		},
		{
			"extend": 'pdfHtml5',
			"text": 'PDF',
			"titleAttr": 'PDF',
			"orientation": 'landscape',
                	"pageSize": 'sra3',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		}, 'colvis'
        ], 
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('invoice') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            }
            
          },
          columns: [
             {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" },
             {data:'invoice_sr_num',name:'ai.invoice_sr_no', className:'td_nowrap' },
              {data:'received_dates',name:'ai.received_date', className:'td_nowrap text-center' },

              {data:'activity_details', name:'activity_details'},
              {data:'quantity',name:'quantity', className: "text-right" },
          {data:'rate_format',name:'rate_format', className: "text-right" },
          {data:'sub_total_amount_format', name:'sub_total_amount_format', className: "text-right" },
          {data:'gst_amount_format',name:'gst_amount_format', className: "text-right" },
          {data:'total_amount_format',name:'total_amount_format', className: "text-right" },
	  {data:'gst_no',name:'gst_no', className: "text-right" },
	  {data:'action',name:'action', className: "text-center" },
      @if(Auth::user()->user_master_id == 3)
      {data:'gst_statuses',name:'gst_statuses', className: "text-center" },
      @endif
      {data:'filing_upload',name:'filing_upload', className: "text-center" },
     
          ],
	rowCallback: function(row, data) {
        if(data['gst_statuses'] == 'GST NOT FILED') {
                        $(row).find('td:eq(10)').css('color', '#880009');
			$(row).find('td:eq(10)').css('font-weight', 'bold');
                } else {
                        $(row).find('td:eq(10)').css('color', 'black');
			$(row).find('td:eq(10)').css('font-weight', 'bold');
                }
	},
    
      }); 
$('#invoice_data-table tbody').on('mouseenter', 'td', function () {
        var colIdx = invoice_table.cell(this).index().column;

        $(invoice_table.cells().nodes()).removeClass('highlight');
        $(invoice_table.column(colIdx).nodes()).addClass('highlight');
	
    });

 $('#detail_approved').change(function(){
        invoice_table.draw();
        }); 
 $('#detail_get_filter').click(function(){            
            invoice_table.draw();
  });
	invoice_table.on( 'draw', function () {
                var body = $( invoice_table.table().body() );
                body.unhighlight();
                body.highlight( invoice_table.search() );
        });

});

function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
</script>


<script type="text/javascript">//<![CDATA[
$(function () {
var summary_table= $('#summary_data-table').DataTable( {
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
        dom: 'lBfrtip',
    fixedHeader: {
        header: true,
        footer: true
    },
  //  fixedColumns: {
    //    left: 4
   // },
    scrollCollapse: true,
    scrollX: true,
    scrollY: 700,
        colReorder: true,
        order: [[2, "desc"]],
        buttons: [
		{
			"extend": 'excel',
			"text": 'EXCEL',
			"titleAttr": 'EXCEL',
			"action": newexportaction,
			exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

		},
		{
			"extend": 'csv',
			"text": 'CSV',
			"titleAttr": 'CSV',
			"action": newexportaction,
			exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

		},
		{
			"extend": 'pdfHtml5',
			"text": 'PDF',
			"titleAttr": 'PDF',
			"orientation": 'landscape',
                	"pageSize": 'sra2',
			"action": newexportaction,
			exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }

		}, 'colvis'
        ], 
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('summary_list') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            }
            
          },
          columns: [
	  {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
          {data:'financial_year',name:'ai.financial_year'},
          {data:'quotation_sr_no',name:'ai.quotation_sr_no', className:'td_nowrap'},
	  {data:'submit_date', name:'ai.submit_date'},
	  {data:'quotation_submitted_by', name:'ai.quotation_submitted_by'},
          {data:'po_detail',name:'ai.po_details'},
          {data:'invoice_sr_num',name:'ai.invoice_sr_no', className:'td_nowrap'},
          {data:'received_dates',name:'ai.received_date', className:'td_nowrap'},
	  {data:'invoice_submitted_by', name:'ai.invoice_submitted_by'},

	  {data:'activity_gst',name:'activity_gst'},
          {data:'company_location',name:'ai.company_location', className: "uppercase"},
          {data:'contact_person',name:'ai.contact_person'},
          {data:'activity_details',name:'ai.activity_details', className: "text-left"},
          {data:'quantity', name:'ai.quantity', className: "text-right"},
          {data:'rate', name:'ai.rate', className: "text-right"},
          {data:'sub_total_amount_format',name:'ai.sub_total_amount', className: "text-right"},
          {data:'gst_amount_format', name:'ai.gst_amount', className: "text-right"},
          {data:'total_amount_format', name:'ai.total_amount', className: "text-right"},
          {data:'campaign_date', name:'campaign_date'},
          {data:'submit_date', name:'ai.submit_date', className:'td_nowrap'},
	  {data:'download', name:'download'},
          {data:'gst_statuses', name:'gst_statuses'},
          {data:'days_diff', name:'days_diff'},
          // {data:'payment_dates', name:'ai.payment_date'},
          // {data:'payment_methoded', name:'payment_methoded'},
          // {data:'remark', name:'ai.remarks', className: "text-left"},
          // {data:'payment_attach', name:'payment_attach'},
	  {data:'raise_invoice', name:'raise_invoice'},
          {data:'action', name:'action'},          
	  {data:'actions', name:'actions'},
          ],
	  "columnDefs": [
		{ "visible": false, "targets": [3,4,5,7,8,9,10,11,16,18,19,23] }
  	],
	rowCallback: function(row, data) {
		console.log("=="+data['days_diff']+"=="+data['gst_statuses']+"==");
		if(data['days_diff'] == 'RECEIVED') {
			$(row).find('td:eq(11)').css('color', 'blue');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
		} else if(data['days_diff'] == '&lt; 30') {
                        $(row).find('td:eq(11)').css('color', 'green');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
                } else if(data['days_diff'] == '&lt; 60') {
                        $(row).find('td:eq(11)').css('color', '#e400ff');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
                } else if(data['days_diff'] == '&lt; 90') {
                        $(row).find('td:eq(11)').css('color', 'orange');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
                } else if(data['days_diff'] == '&gt; 90') {
                        $(row).find('td:eq(11)').css('color', '#880009');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
                } else if(data['days_diff'] == 'INVOICE NOT GENERATED') {
                        $(row).find('td:eq(11)').css('color', '#0062ff');
			$(row).find('td:eq(11)').css('font-weight', 'bold');
                }

		if(data['gst_statuses'] == 'GST NOT FILED') {
                        $(row).find('td:eq(10)').css('color', '#880009');
			$(row).find('td:eq(10)').css('font-weight', 'bold');
                } else {
                        $(row).find('td:eq(10)').css('color', 'black');
			$(row).find('td:eq(10)').css('font-weight', 'bold');
                }
		$('td', row).eq(11).attr('title', '<div class="tip"><table class="tbl_list" style="width: 450px"><tr><td style="width: 37%;">Quotation No </td><td style="width: 63%;">: <b>'+data['quotation_sr_no']+'</b></td></tr><tr><td>Quotation Date </td><td>: '+data['submit_date']+'</td></tr><tr><td style="width: 30%">Month </td><td style="width: 70%">: '+data['financial_year']+'</td></tr><tr><td>PO Details </td><td>: '+data['po_detail']+'</td></tr><tr><td>Invoice No </td><td>: '+data['invoice_sr_num']+'</td></tr><tr><td>Invoice Date </td><td>: '+data['received_dates']+'</td></tr><tr><td>Company Name </td><td>: '+data['activity']+'</td></tr><tr><td>Location </td><td>: '+data['company_location']+'</td></tr><tr><td>Contact Person </td><td>: '+data['contact_person']+'</td></tr><tr><td>Particulars </td><td>: '+data['activity_details']+'</td></tr><tr><td>Quantity </td><td>: '+data['quantity']+'</td></tr><tr><td>Rate </td><td>: '+data['rate']+'</td></tr><tr><td>Sub Total </td><td>: '+data['sub_total_amount_format']+'</td></tr><tr><td>GST Amount </td><td>: '+data['gst_amount_format']+'</td></tr><tr><td>Total Amount </td><td>: '+data['total_amount_format']+'</td></tr><tr><td>Campaign Date </td><td>: '+data['campaign_date']+'</td></tr><tr><td>Submit Date </td><td>: '+data['submit_date']+'</td></tr><tr><td>GST Status </td><td>: '+data['gst_statuses']+'</td></tr><tr><td>Payment Status </td><td>: '+data['days_diff']+'</td></tr><tr><td>Received Date </td><td>: '+data['payment_dates']+'</td></tr><tr><td>Payment Mode </td><td>: '+data['payment_methoded']+'</td></tr><tr><td>Remarks </td><td>: '+data['remark']+'</td></tr></table></div>');
		$('td', row).eq(11).attr('class', "tooltip-basic");
 	  },

	  /* "fnDrawCallback": function (oSettings) {
                $('#summary_data-table tbody tr').each(function () {
                    var sTitle;
                    // var nTds = $('tr', this);
		    var nTds = $('td', this);
// console.log("td:"+$(this).html()); console.log("td:"+$(this).text());
                    var s0 = $(nTds[0]).text();
                    var s1 = $(nTds[1]).text();
                    var s2 = $(nTds[2]).text();
                    var s3 = $(nTds[3]).text();
                    var s4 = $(nTds[4]).text();
                    var s5 = $(nTds[5]).text();

                    sTitle = "<div class='tip'><h1>"+s0+"</h1><h1>"+s2+"</h1>";
		    sTitle += "<table><tbody><tr><td>"+s0+"</td><td>"+s1+"</td><td>"+s2+"</td><td>"+s3+"</td></tr></tbody></table></div>";

                    this.setAttribute('rel', 'tooltip');
                    this.setAttribute('title', sTitle);

		    $(this).attr('data-te-toggle', 'tooltip');
		    $(this).attr('data-te-html', 'true');
		    $(this).attr('data-te-ripple-init', '');
		    $(this).attr('data-te-ripple-color', 'dark');
		    $(this).attr('title', sTitle);
                    console.log(this);
                    // console.log($(this));
		    // $('#default-Modal').modal('show');

                    $(this).tooltip({
			selector: '[data-te-toggle="tooltip"]',
			placement: 'left',
			trigger: 'hover',
			html: true,
			// sanitize: false,
			container: 'body',
			title: sTitle,
                    });

                });
	   }, */
      }); 

$('#summary_data-table tbody').on("click", "tr td:nth-child(12)", function (){
	var colIdx = summary_table.cell(this).index().column;

        // Rollover Popup screen
        /* if(colIdx == 22) {
                var title = $(this).attr('title');
                $('#mdl').html(title);
                $('#success_msg').modal('show');
        } */

	var title = $(this).attr('title');
	$(this).data('title', title).removeAttr('title');
	$('<p class="tooltip-basic-message"></p>').html(title).appendTo(this).fadeIn('slow');

});

$('#summary_data-table tbody').on('mouseenter', 'td', function (e) {
        var colIdx = summary_table.cell(this).index().column;
        $(summary_table.cells().nodes()).removeClass('highlight');
        $(summary_table.column(colIdx).nodes()).addClass('highlight');
	if(colIdx == 22) {
		$(this).css('cursor', 'pointer');
	}

	/* // Rollover Popup screen
	if(colIdx == 3) {
       		var title = $(this).attr('title');
		$('#mdl').html(title);
		$('#success_msg').modal('show');
	} */
});

$('#summary_data-table tbody').on('mouseleave', 'td', function () {
	$(this).attr('title', $(this).data('title'));
	$('.tooltip-basic-message').remove();   
});

 $('#detail_approved').change(function(){
        summary_table.draw();
        }); 
 $('#detail_get_filter').click(function(){            
            summary_table.draw();
  });

	summary_table.on( 'draw', function () {
                var body = $( summary_table.table().body() );
                body.unhighlight();
                body.highlight( summary_table.search() );
        });
});

function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
//]]></script>

<script>
  $(function () {
var invoice_table= $('#home_data-table').DataTable( {
        dom: 'lBfrtip',        
	colReorder: true,
        order: [[2, "desc"]],
        buttons: [
		{
			"extend": 'excel',
			"text": 'EXCEL',
			"titleAttr": 'EXCEL',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		},
		{
			"extend": 'csv',
			"text": 'CSV',
			"titleAttr": 'CSV',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		},
		{
			"extend": 'pdfHtml5',
			"text": 'PDF',
			"titleAttr": 'PDF',
			"orientation": 'landscape',
                	"pageSize": 'sra3',
			"action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
		}, 'colvis'
        ], 
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('invoice1') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            },
	    "dataSrc": function(json) {
                if(json.data.length > 0) {
                        $('#success_msg').css("display", "block");
                        $('#success_msg').modal('show');
                } else {
                        $('#success_msg').css("display", "none");
                        $('#success_msg').modal('hide');
                }
		return json.data;
            }
          },
          columns: [
             {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center" },

             {data:'invoice_sr_num',name:'ai.invoice_sr_no', className:'td_nowrap' },
              {data:'received_dates',name:'ai.received_date', className:'td_nowrap text-center' },

              {data:'activity_details', name:'activity_details'},
	      {data:'gst_no', name:'gst_no'},
              {data:'quantity',name:'quantity', className: "text-right" },
          {data:'rate_format',name:'rate_format', className: "text-right" },
          {data:'sub_total_amount_format', name:'sub_total_amount_format', className: "text-right" },
          {data:'gst_amount_format',name:'gst_amount_format', className: "text-right" },
          {data:'total_amount_format',name:'total_amount_format', className: "text-right" },
          {data:'days_diff',name:'days_diff', className: "text-center" },

          ],

        rowCallback: function(row, data) {
		console.log("=="+data['days_diff']+"==");
		if(data['days_diff'] == 'RECEIVED') {
			$(row).find('td:eq(9)').css('color', 'blue');
		} else if(data['days_diff'] == '&lt; 30') {
                        $(row).find('td:eq(9)').css('color', 'green');
                } else if(data['days_diff'] == '&lt; 60') {
                        $(row).find('td:eq(9)').css('color', '#e400ff');
                } else if(data['days_diff'] == '&lt; 90') {
                        $(row).find('td:eq(9)').css('color', 'orange');
                } else if(data['days_diff'] == '&gt; 90') {
                        $(row).find('td:eq(9)').css('color', '#880009');
                } else if(data['days_diff'] == 'INVOICE NOT GENERATED') {
                        $(row).find('td:eq(9)').css('color', '#0062ff');
                }
            } 

      }); 
$('#invoice_data-table tbody').on('mouseenter', 'td', function () {
        var colIdx = invoice_table.cell(this).index().column;

        $(invoice_table.cells().nodes()).removeClass('highlight');
        $(invoice_table.column(colIdx).nodes()).addClass('highlight');
	
    });

 $('#detail_approved').change(function(){
        invoice_table.draw();
        }); 
 $('#detail_get_filter').click(function(){            
            invoice_table.draw();
  });
	invoice_table.on( 'draw', function () {
                var body = $( invoice_table.table().body() );
                body.unhighlight();
                body.highlight( invoice_table.search() );
        });

});

function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
</script>

<script>
  $(function () {
var customer_table= $('#customer_data-table').DataTable( {
        dom: 'lBfrtip',
        colReorder: true,
        fixedHeader: {
        header: true,
        footer: true
    },
    scrollCollapse: true,
    scrollX: true,
    scrollY: 700,
        order: [[8, "desc"]],
        buttons: [
		{
			"extend": 'excel',
			"text": 'EXCEL',
			"titleAttr": 'EXCEL',
			"action": newexportaction,
		    	exportOptions: {
                        	columns: "thead th:not(.noExport)"
                    	}
		},
		{
			"extend": 'csv',
			"text": 'CSV',
			"titleAttr": 'CSV',
			"action": newexportaction,
                        exportOptions: {
                                columns: "thead th:not(.noExport)"
                        }
		},
		{
			"extend": 'pdfHtml5',
			"text": 'PDF',
			"titleAttr": 'PDF',
			"orientation": 'landscape',
                	"pageSize": 'sra3',
			"action": newexportaction,
                        exportOptions: {
                                columns: "thead th:not(.noExport)"
                        }
		}, 'colvis'
        ], 
          processing: true,
	  fixedHeader: true,
          serverSide: true,
          ajax: {
            url: "{{ route('customer') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            }
          },
          columns: [
              {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: "text-center"},
              {data:'company_name',name:'cm.company_name', orderable: true, searchable: true, className: "uppercase" },
	      {data:'user_address', name:'user_address', orderable: true, searchable: true, className: "uppercase"},
              {data:'gst_no',name:'cm.gst_no', className: "text-center uppercase", orderable: true, searchable: true},
	      {data:'company_contact_user',name:'cm.company_contact_user', className: "text-center uppercase", orderable: true, searchable: true},
	      {data:'company_email',name:'cm.company_email', orderable: true, searchable: true},
	      {data:'company_phone',name:'cm.company_phone', className: "text-center", orderable: true, searchable: true},
	      {data:'submitted_name',name:'cm.submitted_name', className: "text-center", orderable: true, searchable: true},
	      {data:'company_entry_date', name:'company_entry_date', orderable: true, searchable: true,className: "text-center td_breakword"},
	      {data:'add_edit', name:'add_edit', className: "text-center", orderable: true, searchable: true},
          ],
	  "columnDefs": [
		{ "visible": false, "targets": [7, 8] }
  	  ],
	  rowCallback: function(row, data) {

	  }
      }); 
$('#customer_data-table tbody').on('mouseenter', 'td', function () {
        var colIdx = customer_table.cell(this).index().column;

        $(customer_table.cells().nodes()).removeClass('highlight');
        $(customer_table.column(colIdx).nodes()).addClass('highlight');

    });

 $('#detail_approved').change(function(){
        customer_table.draw();
        }); 
 $('#detail_get_filter').click(function(){
            customer_table.draw();
  });

	customer_table.on( 'draw', function () {
                var body = $( customer_table.table().body() );
                body.unhighlight();
                body.highlight( customer_table.search() );
        });
});

function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
</script>


<script>
$(function () {
var document_table= $('#document_data-table').DataTable( {
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
        dom: 'lBfrtip',
        fixedHeader: {
        header: true,
        footer: true
    },
    scrollCollapse: true,
    scrollX: true,
    scrollY: 700,
        buttons: [
                {
                        "extend": 'excel',
                        "text": 'EXCEL',
                        "titleAttr": 'EXCEL',
                        "action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                        "extend": 'csv',
                        "text": 'CSV',
                        "titleAttr": 'CSV',
                        "action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                        "extend": 'pdfHtml5',
                        "text": 'PDF',
                        "titleAttr": 'PDF',
                        "orientation": 'landscape',
                        "pageSize": 'sra3',
                        "action": newexportaction,
			 exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                }, 'colvis'
        ],
          processing: true,
          serverSide: true,
	  ajax: {
            url: "{{ route('document') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            }
          },
          columns: [
              {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data:'document_details', name:'document_details'},
              {data:'action', name:'action'},
          ]
      });
$('#document_data-table tbody').on('mouseenter', 'td', function () {
        var colIdx = document_table.cell(this).index().column;

        $(document_table.cells().nodes()).removeClass('highlight');
        $(document_table.column(colIdx).nodes()).addClass('highlight');
    });

	$('#detail_approved').change(function(){
        	document_table.draw();
	});
	$('#detail_get_filter').click(function(){
		document_table.draw();
        });
	document_table.on( 'draw', function () {
        	var body = $( document_table.table().body() );
	        body.unhighlight();
       		body.highlight( document_table.search() );
	});
});



$(function () {

var product_table= $('#product_data-table').DataTable( {
      "columnDefs": [
        {"className": "dt-center", "targets": "_all"}
      ],
        dom: 'lBfrtip',
	colReorder: true,
	order: [[1, "asc"]],
        buttons: [
		{
			"extend": 'excel',
			"text": 'EXCEL',
			"titleAttr": 'EXCEL',
			"action": newexportaction
		},
		{
			"extend": 'csv',
			"text": 'CSV',
			"titleAttr": 'CSV',
			"action": newexportaction
		},
		{
			"extend": 'pdfHtml5',
			"text": 'PDF',
			"titleAttr": 'PDF',
			"orientation": 'landscape',
                	"pageSize": 'sra3',
			"action": newexportaction
		}, 'colvis'
        ], 
          processing: true,
          serverSide: true,
          ajax: {
            url: "{{ route('product') }}",
            data: function (d) {
                d.detail_approved = $('#detail_approved').val(),
                d.detail_to_date=$('#detail_to_date').val(),
                d.detail_from_date=$('#detail_from_date').val(),
                d.detail_search=$('#detail_search').val()
            }
            
          },
          columns: [
              {data:'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
              {data:'product_master_name',name:'pm.product_master_name'},
          {data:'product_master_details',name:'pm.product_master_details'},
          {data:'product_qty', name:'pm.product_qty'},
          {data:'product_rate', name:'pm.product_rate'},
          {data:'product_gst', name:'pm.product_gst'},
          {data:'product_status',name:'pm.product_status'},
          ],
	rowCallback: function(row, data) {
		$('td', row).eq(1).attr('title', '<div class="tip"><table class="tbl_list" style="width: 100%"><tr><td>Product Name </td><td>: <b>'+data['product_master_name']+'</b></td></tr><tr><td>Product Details </td><td>: '+data['product_master_details']+'</td></tr><tr><td style="width: 30%">Per Piece Rate </td><td style="width: 70%">: '+data['product_rate']+'</td></tr><tr><td>GST Percentage </td><td>: '+data['product_gst']+'</td></tr></table></div>');
		$('td', row).eq(1).attr('class', "tooltip-basic");
	}
      }); 
$('#product_data-table tbody').on('mouseenter', 'td', function () {
        var colIdx = product_table.cell(this).index().column;

        $(product_table.cells().nodes()).removeClass('highlight');
        $(product_table.column(colIdx).nodes()).addClass('highlight');
	
	if(colIdx == 1) {
       		var title = $(this).attr('title');
		$('#mdl').html(title);
		$('#success_msg').modal('show');
	}
    });

 $('#detail_approved').change(function(){
        product_table.draw();
        }); 
 $('#detail_get_filter').click(function(){
            
            product_table.draw();
        });

product_table.on( 'draw', function () {
        var body = $( product_table.table().body() );
 
        body.unhighlight();
        body.highlight( product_table.search() );  
});

});

function newexportaction(e, dt, button, config) {
         var self = this;
         var oldStart = dt.settings()[0]._iDisplayStart;
         dt.one('preXhr', function (e, s, data) {
             // Just this once, load all data from the server...
             data.start = 0;
             data.length = 2147483647;
             dt.one('preDraw', function (e, settings) {
                 // Call the original action function
                 if (button[0].className.indexOf('buttons-copy') >= 0) {
                     $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                     $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                     $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                     $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                         $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                         $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                 } else if (button[0].className.indexOf('buttons-print') >= 0) {
                     $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                 }
                 dt.one('preXhr', function (e, s, data) {
                     // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                     // Set the property to what it was before exporting.
                     settings._iDisplayStart = oldStart;
                     data.start = oldStart;
                 });
                 // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                 setTimeout(dt.ajax.reload, 0);
                 // Prevent rendering of the full data to the DOM
                 return false;
             });
         });
         // Requery the server with the new one-time export settings
         dt.ajax.reload();
     }
</script>

<script>
    function toggleDropdown() {
console.log("!!");
        var dropdownMenu = document.getElementById("dropdown-menu");
console.log("@@");
        dropdownMenu.classList.toggle("hidden");
    }

    // Close the dropdown menu if clicked outside
    window.addEventListener('click', function(event) {
console.log("##");
        var dropdownMenu = document.getElementById("dropdown-menu");
        var profileButton = document.querySelector('.text-gray-700');
console.log("$$"+profileButton.contains(event.target)+"$$");
        if (!profileButton.contains(event.target)) {
console.log("%%");
            dropdownMenu.classList.add('hidden');
        }
    });

// Get the button
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}
</script>
</body>
</html>

