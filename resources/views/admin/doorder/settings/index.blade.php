@extends('templates.doorder_dashboard') @section('title', 'DoOrder |
Settings') @section('page-styles')
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css">
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
#settingsCardDiv .addBtn {
	font-family: Quicksand;
	font-size: 13px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: 0.72px;
	color: #ffffff;
	padding: 6px 1.2rem;
	border-radius: 11.2px 0;
	height: auto;
	max-width: 170px;
	text-transform: capitalize;
}

#navSettingsUl li a {
	font-family: Montserrat;
	font-size: 15px !important;
	font-weight: 600;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.19;
	letter-spacing: 0.8px;
	background: transparent;
	text-transform: uppercase;
	color: #5E5873;
}

#navSettingsUl li a.active, #navSettingsUl li a:hover {
	/* 	color: #d2b431 !important; */
	color: #5E5873 !important;
	background: #F7DC69;
	border-radius: 20px;
	box-shadow: none !important;
	background: #F7DC69;
}

.tab-space {
	padding: 0 !important;
}

.togglebutton {
	margin-top: -3px;
}

.togglebutton label .toggle, .togglebutton label input[type=checkbox][disabled]+.toggle
	{
	width: 45px;
	height: 20px;
	margin-left: 30px;
	background-color: #b2b2b2
}

.togglebutton label input[type=checkbox]+.toggle:after {
	border-color: #b2b2b2;
}

.togglebutton label input[type=checkbox]:checked+.toggle {
	background-color: #f7dc69;
	background-color: #E8CA49;
}

.togglebutton label .toggle:after {
	box-shadow: none;
	left: 0;
	top: 0px;
}

.toggleButtonConnectedApi label .toggle:after {
	top: 0 !important;
}

.togglebutton label input[type=checkbox]:checked+.toggle:after {
	border-color: #f7dc69;
	left: 24px;
}

.togglebutton label input[type=checkbox]+.toggle:active:after,
	.togglebutton label input[type=checkbox][disabled]+.toggle:active:after,
	.togglebutton label input[type=checkbox]:checked+.toggle:active:after {
	box-shadow: none !important;
}

.dropdown-menu .dropdown-item, .dropdown-menu li>a {
	font-size: 14px;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: normal;
	letter-spacing: normal;
	color: #494949;
	text-transform: inherit;
}

.filter-option-inner {
	text-transform: none;
}

.bootstrap-select .dropdown-item.active, .bootstrap-select .dropdown-item:hover
	{
	font-size: 14px;
	font-weight: 600;
	color: white;
	box-shadow: none !important;
}

.dropdown-menu .dropdown-item:focus, .dropdown-menu .dropdown-item:hover,
	.dropdown-menu a:active, .dropdown-menu a:focus, .dropdown-menu a:hover
	{
	background: #e8ca49;
}

.vue-treeselect__control {
	border: none !important;
	margin-top: -6px;
}

.vue-treeselect__menu {
	font-family: Montserrat;
	font-size: 13px !important;
	font-weight: normal;
	font-stretch: normal;
	font-style: normal;
	line-height: 16px;
	letter-spacing: normal;
	color: #494949;
	color: #717579
}

.vue-treeselect__menu li:hover {
	background: #faf4db;
	font-weight: bold;
	color: #4d4d4d;
	box-shadow: none !important;
}

.vue-treeselect__menu li:hover .vue-treeselect__label,
	.vue-treeselect__option--highlight .vue-treeselect__label,
	.vue-treeselect--single .vue-treeselect__option--selected .vue-treeselect__label
	{
	background: #faf4db !important;
	font-weight: bold !important;
	color: #4d4d4d !important;
	box-shadow: none !important;
}

.vue-treeselect__option--highlight, .vue-treeselect--single .vue-treeselect__option--selected
	{
	background: #faf4db !important;
	font-weight: bold !important;
	color: #4d4d4d !important;
	box-shadow: none !important;
	font-weight: bold !important;
	color: #4d4d4d !important;
}

.vue-treeselect__indent-level-0 .vue-treeselect__option {
	padding: 5px
}

.vue-treeselect__placeholder, .vue-treeselect__single-value {
	font-family: Montserrat;
	font-size: 16px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 20px !important;
	letter-spacing: 0.77px;
	color: #6e6b7b !important;
	padding: 11px 14px 11px 14px;
}

.vue-treeselect:not(.vue-treeselect--disabled) .vue-treeselect__multi-value-item:not(.vue-treeselect__multi-value-item-disabled):hover .vue-treeselect__multi-value-item:not(.vue-treeselect__multi-value-item-new) .vue-treeselect__multi-value-item:not(.vue-treeselect__multi-value-item-new):hover,
	.vue-treeselect__multi-value-item {
	background: #E9C21866 !important;
	font-weight: 600 !important;
	color: #4d4d4d !important;
}

.vue-treeselect__value-remove {
	color: #4d4d4d !important;
}

.vue-treeselect__checkbox--checked,
	.vue-treeselect__checkbox--indeterminate,
	.vue-treeselect__label-container:hover .vue-treeselect__checkbox--checked,
	.vue-treeselect__label-container:hover .vue-treeselect__checkbox--indeterminate
	{
	border-color: #E9C218;
	background: #E9C218;
}

.vue-treeselect__multi-value-item {
	font-family: Montserrat;
	font-size: 16px;
	font-weight: 500;
	font-stretch: normal;
	font-style: normal;
	line-height: 20px !important;
	letter-spacing: 0.77px;
	color: #6e6b7b !important;
}

.removeRatePropertySizeCircle {
	color: #df5353;
	cursor: pointer;
	margin-left: 5px;
	font-size: 16px
}

.addCircle {
	color: #e8ca49;
}

.nav-pills:not(.flex-column) .nav-item+.nav-item:not(:first-child) {
	margin-left: 0 !important;
}

.iti {
	width: 100%;
}

.card #usersTable tr td:first-child, .card #usersTable tr th:first-child
	{
	text-align: left;
}

#usersTable .nameSpan {
	font-weight: 700 !important;
	color: #4D4D4D !important;
	height: 1.5rem;
}
#add-user-modal #addUserBtn, #edit-user-modal #editUserBtn {
	height: 40px;
	text-transform: capitalize;
	padding: 8px;
}

.dataTables_empty {
	text-align: center !important;
}

/* 
.toggleButtonGeneralSettings label .toggle:after {
	top: 0 !important;
}
.toggleButtonGeneralSettings label .toggle, .toggleButtonGeneralSettings label input[type=checkbox][disabled]+.toggle
	{width: 50px !important;
	}

.toggleButtonGeneralSettings label input[type=checkbox]:checked+.toggle:after {
	border-color: #f7dc69;
	left: 35px;
	content: "on";
}	
.toggleButtonGeneralSettings label input[type=checkbox]+.toggle:after {
	content: "off";
}	 */
.btn-default.toggle-off, .btn-default.toggle-off:hover {
	background-color: #656565 !important;
	border-color: #656565 !important
}

.toggle-handle {
	background: white !important;
	border-radius: 50% !important;
	height: 95% !important;
	padding: 0 !important;
	width: 30px !important;
	top: 1px;
}

.toggle-handle:before {
	border-radius: 50% !important;
}

.toggle-on, .toggle-off, .toggle {
	border-radius: 25px !important;
}

.toggle .toggle-handle {
	left: -17px;
}

.toggle.off .toggle-handle {
	left: 17px;
}

.toggle-on.btn-sm {
	padding-right: 40px !important;
}

.toggle-off.btn-sm {
	padding-left: 40px !important;
}

label.toggle-on, label.toggle-off {
	font-family: Montserrat;
	font-style: normal;
	font-weight: 600;
	font-size: 14px !important;
	line-height: 18px;
	color: #FFFFFF;
}

#uploadButton {
	width: 40px;
	height: 40px !important;
	margin-top: 0;
	box-shadow: none;
	border-radius: 6px;
	padding: 0;
}

#uploadButton img {
	width: 100%;
	border-radius: 6px;
}

.display-inline-block {
	display: inline-block;
}
#usersTable tbody td{
    text-align: left;
}
#usersTable .actionsTd{
    text-align: center;
}
</style>

@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12" id="settingsCardDiv">
				<div class="card">
					<div class="card-header card-header-icon  row">
						<div class="col-12 col-xl-5 col-lg-4 col-md-3 col-sm-12">
							<h4 class="card-title my-md-4 mt-4 mb-md-1 mb-4">Settings</h4>
						</div>
					</div>
				</div>
				<div>
					<ul
						class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center"
						role="tablist" id="navSettingsUl">
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#generalSettings" role="tablist" aria-expanded="true">
								General Settings </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#profile" role="tablist" aria-expanded="false"> Profile </a>
						</li>
						<li class="nav-item"><a class="nav-link active" data-toggle="tab"
							href="#notificationsDiv" role="tablist" aria-expanded="false">
								Notifications </a></li>
						<li class="nav-item"><a class="nav-link " data-toggle="tab"
							href="#securityLogin" role="tablist" aria-expanded="false">
								Security & Login </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#users" role="tablist" aria-expanded="false"> Users </a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab"
							href="#connectedAPIs" role="tablist" aria-expanded="false">
								Connected APIs </a></li>
					</ul>
				</div>

				<div class="tab-content tab-space">
					<div class="tab-pane " id="generalSettings" aria-expanded="false">
						@include('admin.doorder.settings.general_settings')</div>
					<div class="tab-pane" id="profile" aria-expanded="false"></div>
					<div class="tab-pane active" id="notificationsDiv"
						aria-expanded="false">
						@include('admin.doorder.settings.notifications')</div>

					<div class="tab-pane " id="securityLogin" aria-expanded="false"></div>
					<div class="tab-pane " id="users" aria-expanded="false">
						@include('admin.doorder.settings.users')</div>
					<div class="tab-pane " id="connectedAPIs" aria-expanded="false">
						@include('admin.doorder.settings.connected_apis')</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.umd.min.js"></script>

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>

<!-- <script src="https://cdn.jsdelivr.net/npm/v-click-outside"></script> -->
<!-- <script type="module" -->
<!-- 	src="https://cdn.jsdelivr.net/npm/vue-cascader-select"></script> -->

<link
	href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
	rel="stylesheet">
<script
	src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script type="text/javascript">



function addIntelInput(input_id, input_name) {
            let phone_input = document.querySelector("#" + input_id);
            window.intlTelInput(phone_input, {
                hiddenInput: input_name,
                initialCountry: 'IE',
                separateDialCode: true,
                preferredCountries: ['IE', 'GB'],
                utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
            });
}  


$(document).ready(function() {

$("#retailerAutomaticCharging").change(function() {
	 console.log($("#retailerAutomaticCharging:checked").val());
	 if($("#retailerAutomaticCharging:checked").val()==1){
      			$("#dayOfMonthDiv").css("display","block");
     }else{
      			$("#dayOfMonthDiv").css("display","none");
      			$("#dayOfMonth").val("")
     }

});
$("#delivererPayout").change(function() {
	 console.log($("#delivererPayout:checked").val());
	 if($("#delivererPayout:checked").val()==1){
      			$("#dayOfWeekDiv").css("display","block");
     }else{
      			$("#dayOfWeekDiv").css("display","none");
      			$("#weekday").val("")
     }

});


// general settings 
addIntelInput('business_phone_number','business_phone_number');

$(".timeShift").datetimepicker({format:"hh:mm",
					icons: { time: "fa fa-clock",
                                    date: "fa fa-calendar",
                                    up: "fa fa-chevron-up",
                                    down: "fa fa-chevron-down",
                                    previous: 'fa fa-chevron-left',
                                    next: 'fa fa-chevron-right',
                                    today: 'fa fa-screenshot',
                                    clear: 'fa fa-trash',
                                    close: 'fa fa-remove'
            				},
            });


//////////////////// users tab
    var table= $('#usersTable').DataTable({
           		"pagingType": "full_numbers",
         		 fixedColumns: true,
                "lengthMenu": [
                  [-1,10, 25, 50,100],
                  ["All",10, 25, 50,100]
                ],
                "ordering": false,
                "language": {  
            		search: '',
        			"searchPlaceholder": "Search ",
        			
        			"paginate": {
                              "previous": "<i class='fas fa-angle-left'></i>",
                              "next": "<i class='fas fa-angle-right'></i>",
                              "first":"<i class='fas fa-angle-double-left'></i>",
                              "last":"<i class='fas fa-angle-double-right'></i>"
                            }
            	},
            	"columnDefs": [ {
                		"targets": [-1],
                		"orderable": false
            		},                        
                 ],
                scrollX:        true,
                scrollCollapse: true,
                fixedColumns:   {
                    leftColumns: 0,
                },
    });
    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
    
//       $(".filterhead").each(function (i) {
//                  if (i == 2 ) {
//                      var select = $('<select ><option value="">Select user type</option></select>')
//                          .appendTo($(this).empty())
//                          .on('change', function () {
//                              var term = $(this).val();
//                              table.column(i).search(term, false, false).draw();
//                          });
//                      table.column(i).data().unique().sort().each(function (d, j) {
//                          select.append('<option value="' + d + '">' + d + '</option>')
//                      });
//                  } else {
//                     $(this).empty();
//                  }
//              });
    
////////////////////// end users tab
} );

	 function changeToggleRetAutoCharging(){
	 		console.log($("#retailerAutomaticCharging:checked").val())
      		if($("#retailerAutomaticCharging:checked").val()==1){
      			$("#dayOfMonthDiv").css("display","block");
      		}else{
      			$("#dayOfMonthDiv").css("display","none");
      			$("#dayOfMonth").val("")
      		}
      }
      
      function changeToggleDelivererPayout(){
      		console.log($("#delivererPayout").val())
      		if($("#delivererPayout:checked").val()==1){
      			$("#dayOfWeekDiv").css("display","block");
      		}else{
      			$("#dayOfWeekDiv").css("display","none");
      			$("#weekday").val("")
      		}
      }
     
	Vue.use('vue-cascader-select');
	Vue.component('treeselect', VueTreeselect.Treeselect);
	Vue.component('treeselect2', VueTreeselect.Treeselect);
	Vue.component('treeselectuser', VueTreeselect.Treeselect);
	Vue.component('treeselectretailer', VueTreeselect.Treeselect);
        
       var app = new Vue({
            el: '#app',
            
             data: {
             	users: {!! $users !!},
             
             	//customNotifications:[{"customNotification":"","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":"","email":"","user_type":null,"notification_content":""}],
             	customNotifications: {!! count($savedNotifications) ? json_encode($savedNotifications) : '[{"id":null,"customNotification":"1","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":[{value: ""}],"email":[{value: ""}],"user_type":null,"retailer":null,"notification_content":""}]' !!},
                // define the default value
                 notification_type: null,
                 notification_channel:null,
                 user_type:null,
                 retailer:null,
        
                // define options
                options: [ {
                  id: 'registrations',
                  label: 'Registrations',
                  children: [ {
                    id: 'new_retailer',
                    label: 'New retailer',
                    customLabel: 'Registrations, New retailer'
                  }, {
                    id: 'new_deliverer',
                    label: 'New deliverer',
                    customLabel: 'Registrations, New deliverer'
                  } ],
                }, {
                  id: 'service_delivery',
                  label: 'Service Delivery',
                   children: [ {
                    id: 'new_order',
                    label: 'New order',
                    customLabel: 'Service Delivery, New order'
                  }, {
                    id: 'order_completed',
                    label: 'Order completed',
                    customLabel: 'Service Delivery, Order completed'
                  }, {
                    id: 'collection_delay',
                    label: 'Collection delay',
                    customLabel: 'Service Delivery, Collection delay'
                  }, {
                    id: 'external_store_fulfillment',
                    label: 'External store fulfillment',
                    customLabel: 'Service Delivery, External store fulfillment'
                  } ],
                }, {
                  id: 'payments',
                  label: 'Payments',
                    customLabel: 'Payments'
                } ],
                
                optionschannel:[{
                	 id: 'sms',
                  	label: 'SMS',
                    },{
                    	 id: 'email',
                      	label: 'Email',
                    },{
                    	 id: 'platform',
                      	label: 'Platform notification',
                    }
                
                ],
                optionsusers:[
                	{
                    	id: 'admin',
                      	label: 'Admin',
                      	children: {!! $adminOptions !!}
                    },
					{
                    	id: 'call_center',
                      	label: 'Call center',
                      	children: {!! $callCenterOptions !!}
                    }
                
                ],
				 optionsretailer: {!! $retailersOptions !!}

      },
		   mounted() {
            	//Intl input
			   // setTimeout(() => {
				//    for (let notification of this.customNotifications) {
				// 	   let notification_index = this.customNotifications.indexOf(notification);
				// 	   let channel_type = this.customNotifications[notification_index].notification_channel;
				// 	   let phone_numbers = this.customNotifications[notification_index].phone_number;
				// 	   if (channel_type === 'sms') {
				// 		   let phone_index = 0;
				// 		   for (let phone of phone_numbers) {
				// 			   this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]');
				// 			   phone_index++;
				// 		   }
				// 	   }
				//    }
			   // });
		   },
		   methods: {
			normalizer(node) {
			 	return {
					id: node.id,
					label: node.label,
					customLabel: node.customLabel,
					children: node.children,
				}
			},
			clickAddNotification() {
				this.customNotifications.push({
					id: null,
					customNotification: '1',
					notification_type: null,
					notification_name: '',
					notification_channel: null,
					phone_number: [{value:''}],
					email: [{value:''}],
					user_type: null,
					retailer: null,
					notification_content: ''
				})
			},
			removeNotification(index){
			this.customNotifications.splice(index, 1);
			},
			addEmail(notification_index) {
				this.customNotifications[notification_index].email.push({value:""});
			},
		    removeEmail(notification_index, item_index) {
			    this.customNotifications[notification_index].email.splice(item_index, 1);
		    },
		    addPhone(notification_index) {
				this.customNotifications[notification_index].phone_number.push({value:""});
				//Intlinput code
				// setTimeout(() => {
				// 	let phone_index = this.customNotifications[notification_index].phone_number.length -1;
				// 	this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]')
				// }, 300);
			},
		    removePhone(notification_index, item_index) {
			    this.customNotifications[notification_index].phone_number.splice(item_index, 1);
		    },
		   onChangeChannel(notification_index) {
				//Intlinput
				// setTimeout(() => {
				// 	let channel_type = this.customNotifications[notification_index].notification_channel;
				// 	let phone_numbers = this.customNotifications[notification_index].phone_number;
				// 	if (channel_type === 'sms') {
				// 		let phone_index = 0;
				// 		for (let phone of phone_numbers) {
				// 			this.addIntlPhoneInput('phone_number' + notification_index + '_' + phone_index, 'phone_number' + notification_index + '[]');
				// 			phone_index++;
				// 		}
				// 	}
				// }, 300);
		   },
		   addIntlPhoneInput(input_id, name) {
			   let phone_input = document.getElementById(input_id);
			   intlTelInput(phone_input, {
				   hiddenInput: name,
				   initialCountry: 'IE',
				   separateDialCode: true,
				   preferredCountries: ['IE', 'GB'],
				   utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
			   });
		   },
		   clickEditUser(user_id,name, email, user_type){
		   		console.log("edit user ",user_id,name, email, user_type);
		   		
		   		$("#edit-user-modal").modal('show');
		   		$("#edit-user-modal #userId").val(user_id);
		   		$("#edit-user-modal #user_nameEdit").val(name);
		   		$("#edit-user-modal #emailEdit").val(email);
		   		$("#edit-user-modal #userTypeSelectEdit").val(user_type);
		   		$('#edit-user-modal .selectpicker').selectpicker('refresh')
		   },
		   clickDeleteUser(userId){
		   		console.log("delete user ",userId);
                		   		
                $('#delete-user-modal').modal('show')
                $('#delete-user-modal #userId').val(userId);
		   },
		   clickAddUser(){
		   		console.log("click add user");
		   		$("#add-user-modal").modal('show');
		   }
      	}
        });
        
 /* function changeNotificationType(){
 	var notificationType = $('#notificationTypeSelect').val();
 	console.log(notificationType);
 	
 	if(notificationType=="registrations"){
 	
 		$("#notificationSubTypeDiv").html('<select name="notification_sub_type"  required="required" id="notificationSubTypeSelect" '
 									+' data-style="select-with-transition" class="form-control selectpicker">'
 									+ '<option value="new_retailer">New retailer</option>'
 									+ '<option value="new_deliverer">New deliverer</option>'
 									+ '</select>');
 									$('#notificationSubTypeSelect').selectpicker();
 	}else if(notificationType=="service_delivery"){
 	
 		$("#notificationSubTypeDiv").html('<select name="notification_sub_type"  required="required" id="notificationSubTypeSelect" '
 									+' data-style="select-with-transition" class="form-control selectpicker">'
 									+ '<option value="new_order">New order</option>'
 									+ '<option value="order_completed">Order completed</option>'
 									+ '<option value="collection_delay">Collection delay</option>'
 									+ '</select>');
 									$('#notificationSubTypeSelect').selectpicker();
 	}else{
 		$("#notificationSubTypeDiv").html('');
 	}
 } */ 

 function changeNotificationSubType(){
 	var notificationChannel = $('#notificationChannelSelect').val();
 	console.log(notificationChannel);
 	
 	if(notificationChannel=='sms'){
 		$('#notificationChannelDataDiv').html('<label>Phone number</label><input type="tel" class="form-control" name="phone_number" />')
 	}else if(notificationChannel=='email'){
 		$('#notificationChannelDataDiv').html('<label>Email</label><input type="email" class="form-control" name="email" />')
 	}else if(notificationChannel=='platform'){
 		$('#notificationChannelDataDiv').html('platform')
 	}else{
 		$('#notificationChannelDataDiv').html('')
 	}
 }      
 
function addFile(id) {
                    $('#' + id).click();
                }
function onChangeFile(e, id) {
console.log($(e));
console.log($(e).files)
                    $("#" + id).val(e.target.files[0].name);
                }
            
</script>

@endsection

