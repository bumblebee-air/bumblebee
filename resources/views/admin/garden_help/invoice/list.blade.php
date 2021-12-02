@extends('templates.dashboard') @section('page-styles')

    <link rel="stylesheet"
          href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css">
    <style>
        .page_icon {
            width: 40px !important;
        }

        .invoiceIconSpan i {
            font-size: 18px;
            color: #60a244;
        }

        .invoiceIconSpan.completed i {
            color: #60a244;
        }

        .invoiceIconSpan.not-completed i {
            color: #f7dc69;
        }

        .invoiceIconSpan.no-account i {
            color: #838383;
        }

        .doorderTable>tbody>tr>td, .doorderTable>tbody>tr>th, .doorderTable>tfoot>tr>td,
        .doorderTable>tfoot>tr>th, .doorderTable>thead>tr>td, .doorderTable>thead>tr>th
        {
            padding: 10px 5px !important;
        }

        div.dt-datetime {
            padding: 0 !important;
        }

        div.dt-datetime div.dt-datetime-title {
            padding: 5px !important;
        }

        div.dt-datetime table {
            margin: 0 !important;
        }

        div.dt-datetime table th {
            padding: 5px;
            font-size: 12px !important;
        }

        div.dt-datetime table td, div.datepicker-days table td {
            min-width: 20px !important;
            max-width: 20px !important;
            width: 20px !important;
            padding: 2px !important;
        }

        div.dt-datetime table td.selectable.selected button {
            padding: 6px !important;
        }

        .form-control:read-only {
            background-image: none !important;
        }

        select.form-control:not([size]):not([multiple]) {
            height: 36px !important;
            padding: 8px 14px 8px 14px;
            border-radius: 5px;
            box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
            background-color: #ffffff;
            font-family: Quicksand;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            font-style: normal;
            letter-spacing: 0.77px;
            color: #4d4d4d;
            width: 100%;
            height: auto;
        }

        .card-body {
            padding-top: 10px !important;
        }

        #dashboardCardDiv .btn, #exportButton {
            height: auto;
            padding: 8px;
        }

        #retailerNameP {
            height: 50px;
        }

        table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:before {
            top: 30% !important;
        }

        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc_disabled:after {
            top: 30% !important;
        }

        /* td:hover{
          overflow: visible;
          white-space: normal;
          height: auto;} */
        .bootstrap-datetimepicker-widget table td span.active, .datepicker-days table td.active div{
            background-color: #e8ca49;
        }
        .datepicker-days table td.today>div:before{
            border-bottom-color: #e8ca49
        }
        .datepicker-days table td.active:hover>div, .datepicker-days table td.active>div{
            background-color: #e8ca49;
        }

        .bootstrap-datetimepicker-widget table td span {
            color: #a5a5a5
        }
    </style>
@endsection @section('title', 'DoOrder | Invoice')
@section('page-content')
    <div class="content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon card-header-rose row">
                                <div class="col-12 col-lg-5 col-md-6">
                                    <div class="card-icon">
                                        <img class="page_icon"
                                             src="{{asset('images/doorder_icons/Invoice-white.png')}}">
                                    </div>
                                    <h4 class="card-title ">Contractors Invoice</h4>
                                </div>

                                <div class="col-12 col-lg-7 col-md-6">
                                    <div class="status text-right">
                                        <div class="status_item">
										<span class=" invoiceIconSpan completed"> <i
                                                    class="fas fa-file-invoice"></i></span> Completed stripe
                                            profile

                                        </div>
                                        <div class="status_item">
										<span class=" invoiceIconSpan not-completed"> <i
                                                    class="fas fa-file-invoice"></i></span> Not completed stripe
                                            profile

                                        </div>
                                        <div class="status_item">
										<span class=" invoiceIconSpan no-account"> <i
                                                    class="fas fa-file-invoice"></i></span> No stripe profile

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="invoiceListTable"
                                           class="table table-no-bordered table-hover doorderTable"
                                           cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="10%">Last Payout Date</th>
                                            <th width="10%">Contractor Name</th>
                                            <th width="10%">Status</th>
                                            <th width="10%">Charges (€)</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-for="invoice in invoiceList" class="order-row"
                                            @click="clickInvoice(invoice.driver_id, invoice.last_payout_date)">
                                            <td>@{{invoice.last_payout_date}}</td>
                                            <td>@{{invoice.driver_name}}</td>
                                            <td><span :class="invoice.status+' invoiceIconSpan'"> <i
                                                            class="fas fa-file-invoice"></i>
											</span></td>
                                            <td>@{{ invoice.charges != 'N/A' ? '€'+invoice.charges : invoice.charges }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- no account modal -->
    <div class="modal fade" id="no-account-modal" tabindex="-1"
         role="dialog" aria-labelledby="no-account-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close d-flex justify-content-center"
                            data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-dialog-header deleteHeader">This driver doesn't
                        have last payout date. Please select date</div>

                    <div>

                        <form method="POST" id="updateLastPayoutDate"
                              action="{{url('garden-help/update_contractor_last_payout_date')}}"
                              style="margin-bottom: 0 !important;">
                            @csrf <input type="hidden" id="driver_id" name="contractor_id"
                                         value="" />

                            <div class="row">
                                <div class="col-10 offset-1">
                                    <div class="form-group bmd-form-group">
                                        <label for="date">Date </label> <input type="text"
                                                                               class="form-control" name="date" id="date"
                                                                               placeholder="Date" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-sm-6">
                        <button type="button"
                                class="btn btn-primary doorder-btn-lg doorder-btn"
                                onclick="$('form#updateLastPayoutDate').submit()">Yes</button>
                    </div>
                    <div class="col-sm-6">
                        <button type="button"
                                class="btn btn-danger doorder-btn-lg doorder-btn"
                                data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end no account modal -->


@endsection @section('page-scripts')

    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script
            src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
    <script type="text/javascript">
        var minDate, maxDate;

        // // Custom filtering function which will search data in column four between two values
        // $.fn.dataTable.ext.search.push(
        //     function( settings, data, dataIndex ) {
        //     	console.log("search")

        // 		var dateInput =$('#date').val();
        //         var min =  moment(dateInput,'MMM YYYY').toDate();

        //  //       console.log(dateInput +" -- "+ min)
        //         var date = moment(data[0],'MMM YYYY').toDate();
        //   //		console.log(data[0])
        //   //		console.log(date)
        //   //		console.log("sasasasa")

        //         if (
        //             (dateInput==='') ||
        //             ( min <= date && date<=min )
        //         ) {
        //             return true;
        //         }

        //         return false;
        //     }
        // );

        $(document).ready(function() {

            $("#date").datetimepicker({
                format: 'L',
                debug:true
            });

            // Create date inputs
//     minDate = new DateTime($('#startDate'), {
//          format: 'MMM YYYY'
//     });
//     maxDate = new DateTime($('#endDate'), {
//          format: 'MMM YYYY'
//     });

// $("#startDate,#endDate").datetimepicker({
// 		 viewMode: 'years',
//          format: 'MMM YYYY',
// });
// $('#startDate,#endDate').on('dp.change', function(e){table.draw(); });
// $('#startDate,#endDate').on("dp.show", function(e) {
//    $(e.target).data("DateTimePicker").viewMode("months");
// });

// $("#date").datetimepicker({
// 		 viewMode: 'years',
//          format: 'MMM YYYY',

// });
// $('#date').on('dp.change', function(e){table.draw(); });
// $('#date').on("dp.show", function(e) {
//    $(e.target).data("DateTimePicker").viewMode("months");
// });


            var table= $('#invoiceListTable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50,100, -1],
                    [10, 25, 50,100, "All"]
                ],
                responsive:true,
                "language": {
                    search: '',
                    "searchPlaceholder": "Search ",
                },


                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },

//          initComplete: function () {
//          	var column = this.api().column(1);
// 			var select = $('<select id="selectFilter" class="form-control" name="retailer"><option value="">Select driver </option></select>')
// 			.appendTo( $('#driverNameP').empty().text('') )
// 			.on( 'change', function () {
// 				var val = $.fn.dataTable.util.escapeRegex(
// 					$(this).val()
// 				);
// 			column
// 			.search( val ? '^'+val+'$' : '', true, false )
// 			.draw();

// 			} );
// 			column.data().unique().sort().each( function ( d, j ) {
// 			select.append( '<option value="'+d+'">'+d+'</option>' );
// 			} );
//         }
            });



        } );

        Vue.use(VueToast);
        var app = new Vue({
            el: '#app',
            data: {
                invoiceList: {!! json_encode($invoiceList) !!}
            },
            mounted() {

            },
            methods: {
                parseDateTime(date) {
                    console.log(date);
                    let dateTime = '';
                    //let parseDate = new Date();
                    let date_moment = new moment();
                    if(date!=null && date!=''){
                        //parseDate = new Date(date);
                        date_moment = new moment(date);
                    } console.log(date_moment);
                    dateTime = date_moment.format('MM/YYYY');
                    console.log(date);
                    return dateTime;
                },

                clickInvoice(driver_id, last_payout_date) {
                    if(last_payout_date == 'N/A'){
                        console.log("no date");
                        $('#no-account-modal').modal('show')
                        $('#no-account-modal #driver_id').val(driver_id);
                    }
                    else{
                        console.log("go to single invoice")
                        window.location = "{{url('garden_help/invoice/view/')}}/"+driver_id
                    }

                }
            }
        });
    </script>
@endsection
