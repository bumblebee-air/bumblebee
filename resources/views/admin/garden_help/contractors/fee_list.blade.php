@extends('templates.garden_help-dashboard') @section('title',
'GardenHelp | Jobs Table') @section('page-styles')
<style>
.DTFC_ScrollWrapper{
    height: auto !important;
}
.swal-title {
    font-size: 23px
}
.swal-button {
    display: none;
}
</style>

@endsection @section('page-content')

<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row">
							<div class="col-12 ">
								<h4 class="card-title  my-md-4 mt-4 mb-1 ">Contractors Fees</h4>
							</div>
						</div>

					</div>
					<div class="card">
						<div class="card-body">
							<div class="container">
								<div class="table-responsive">
									<table id="contractorsFees"
										class="table table-no-bordered table-hover gardenHelpTable jobsListTable"
										cellspacing="0" width="100%" style="width: 100%">
										<thead>
											<tr>
												<th style="display: none;"> ID</th>
												<th width="20%">Years of Experience</th>
												<th width="20%">Fee Percentage</th>
												<th width="20%" class="disabled-sorting ">Actions</th>
											</tr>
										</thead>
										<tbody>
											<tr class="order-row" v-for="item in settings">
												<td style="display: none">@{{item.id}} </td>
												<td>@{{item.display_name}} </td>
												<td>@{{item.the_value}}</td>
												<td class=""><button type="button" class="edit btnActions"
														@click="clickEditFee(event,item.name)">
														<img src="{{asset('images/gardenhelp/edit-icon.png')}}">
													</button></td>
											</tr>

										</tbody>
									</table>
									<nav aria-label="pagination" class="float-right"></nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
$(document).ready(function() {
    var table= $('#contractorsFees').DataTable({
    	fixedColumns: true,
          "lengthChange": false,
          "searching": false,
  		  "info": false,
  		  "ordering": false,
  		  "paging": false,
  		   "responsive":true,
    	
    	"columnDefs": [ {
    		targets: -1,
    		"orderable": false,
    		 width: 150
    			},
    			{targets:0, width:120},
    			{targets:1, width:120},],
    	scrollX:        true,
        scrollCollapse: true,
        fixedColumns:   {
            leftColumns: 0,
        },
        "columns": [{"data":"id"},
                    { "data": "display_name" },
                    { "data": "the_value","class":"editable text displayValue"  },
                    { render: function (data, type, row) {    
                    		console.log(row)
                    		return createButton('edit', row.id);    
                		}     
                	}
        ],
    });
   
   $('#contractorsFees').on('click', 'tbody td .edit', function (e) {    
    	console.log("edit")
    	console.log(e)
        fnResetControls();    
        var dataTable = $('#contractorsFees').DataTable();    
        var clickedRow = $($(this).closest('td')).closest('tr');    
        $(clickedRow).find('td').each(function () {    
            // do your cool stuff    
            if ($(this).hasClass('editable')) {    
                if ($(this).hasClass('text')) {   
                	if ($(this).hasClass('displayName')) { 
                        var html = fnCreateTextBox($(this).html(), 'name');    
                        $(this).html($(html))    
                    }    
                    else { 
                        var html = fnCreateTextBox($(this).html(), 'value');    
                        $(this).html($(html))    
                    }    
                }    
            }    
        });     
        
        
        $('#contractorsFees tbody tr td .update').removeClass('update btn-gardenhelp-filter').addClass('edit btnActions').html('<img src="{{asset('images/gardenhelp/edit-icon.png')}}">');    
        $('#contractorsFees tbody tr td .cancel').removeClass('cancel btn-gardenhelp-danger-filter d-inline-block').addClass('delete d-none').html('Delete');    
        $(clickedRow).find('td .edit').removeClass('edit btnActions').addClass('update  btn-gardenhelp-filter ').html('Edit');    
        $(clickedRow).find('td .delete').removeClass('delete d-none').addClass('cancel btn-gardenhelp-danger-filter d-inline-block').html('Cancel');    
        
    });
    
    $('#contractorsFees').on('click', 'tbody td .update', function (e) {    
    	console.log("click update")
    	console.log(e)
    	console.log($($($(this).closest('td')).closest('tr')).find("td:first").html() )
       var openedTextBox = $('#contractorsFees').find('input');    
       $.each(openedTextBox, function (k, $cell) {    
           fnUpdateDataTableValue($cell, $cell.value);    
           $(openedTextBox[k]).closest('td').html($cell.value);    
       })    
    
       $('#contractorsFees tbody tr td .update').removeClass('update btn-gardenhelp-filter').addClass('edit btnActions').html('<img src="{{asset('images/gardenhelp/edit-icon.png')}}">');    
       $('#contractorsFees tbody tr td .cancel').removeClass('cancel btn-gardenhelp-danger-filter d-inline-block').addClass('delete d-none').html('Delete');    
   });   
   $('#contractorsFees').on('click', 'tbody td .cancel', function (e) {    
        fnResetControls();    
        $('#contractorsFees tbody tr td .update').removeClass('update btn-gardenhelp-filter').addClass('edit btnActions').html('<img src="{{asset('images/gardenhelp/edit-icon.png')}}">');    
        $('#contractorsFees tbody tr td .cancel').removeClass('cancel btn-gardenhelp-danger-filter d-inline-block').addClass('delete d-none').html('Delete');    
    });    
                             
    
} );
    function createButton(buttonType, rowID) {    
    	 return '<button class="edit btnActions" type="button"><img src="{{asset('images/gardenhelp/edit-icon.png')}}"></button> <button class="delete d-none" type="button">Delete</button>';    
    } 

   function fnResetControls() {    
        var openedTextBox = $('#contractorsFees').find('input');    
        $.each(openedTextBox, function (k, $cell) {    
        	console.log(k)  
        	console.log($($cell).val())
        	console.log($($cell).attr('old-value'))
            $(openedTextBox[k]).closest('td').html($($cell).attr('old-value'));    
        })    
    }  
     
    function fnCreateTextBox(value, fieldprop) {   
    	console.log("fieldprop "+fieldprop) 
    	if(fieldprop == 'name'){
        	return '<input class="form-control" data-field="' + fieldprop + '" type="text" value="' + value + '" ></input>';  
        }
        else{
        	return '<input class="form-control" data-field="' + fieldprop + '" type="number" name="the_value" old-value="' + value + '" value="' + value + '" ></input>';  
        }	  
    } 

    function fnUpdateDataTableValue($inputCell, value) {  
    	console.log($inputCell)  
    	console.log(value)
    	var id = $($($($inputCell).closest('td')).closest('tr')).find("td:first").html();
    	console.log(id)
           var dataTable = $('#contractorsFees').DataTable();    
           var rowIndex = dataTable.row($($inputCell).closest('tr')).index();    
           var fieldName = $($inputCell).attr('data-field');    
           dataTable.rows().data()[rowIndex][fieldName] = value;   
           
			var token = '{{csrf_token()}}';
           $.ajax({
                   type:'POST',
                   url: '{{url("garden-help/contractors/update_fee")}}',
                   data:{
						_token: token,
						id : id,
						the_value : value
								},
                   success:function(data) {
                      console.log(data);
                      swal({
                          icon: 'success',
                          title: data.message,
//                           showConfirmButton: true,
                           timer: 2000
                        })
                   }
           });            
    }
       
            
var app = new Vue({
            el: '#app',
            data: {
                settings:  {!! json_encode($settings) !!},
            },
            mounted() {
            },
            methods: {
                clickEditFee(e,name){
                	console.log($(e))
                	console.log($(e).closest('tr'))
                	var tt = $(e).closest('tr')
                	console.log($(tt))
                	$(tt).css('background','red')
                	//window.location.href = "{{url('garden-help/contractors/edit_fee?fee_name=')}}"+name;
                },                
            }
        });

    </script>
@endsection

