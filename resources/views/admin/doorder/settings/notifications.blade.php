

<form method="POST"
	action="{{route('doorder_postSaveNotification', 'doorder')}}"
	method="POST" id="save_notification_settings_form">
	{{csrf_field()}}
	<div class="card" v-for="(notification, index) in customNotifications"
		:id="'notificationCardDiv'+(index)">
		<div class="card-body">
			<div class="container " style="width: 100%; max-width: 100%;">
				<div class="row">
					<div class="col-12 col-lg-7 col-md-6 d-flex form-head pl-3">
						<span> @{{index+1}} </span>
						<h5 class="singleViewSubTitleH5">Custom Notification @{{index+1}}</h5>
						<div class="togglebutton">
							<label> <input type="checkbox"
								:name="'customNotification' + (index)"
								:id="'customNotification' + (index)"
								v-model="notification.customNotification" value="1"> <span
								class="toggle"></span>
							</label>
						</div>
					</div>
					<div class="col-12 col-lg-5 col-md-6 mt-md-2 ">
						<div class="row justify-content-end float-sm-right">
							<span v-if="index==0">
								<button type="button"
									class=" btn btn-primary doorder-btn-lg doorder-btn addBtn"
									@click="clickAddNotification()">Add Notification</button>
							</span> <span v-else> <i
								class="fas fa-minus-circle removeRatePropertySizeCircle"
								@click="removeNotification(index)"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="notificationTypeSelect">Notification type </label>

							<div id="component_notification_type">
								<template>
									<treeselect class="form-control"
										v-model="notification.notification_type"
										:name="'notification_type' + (index)"
										:id="'notification_type' + (index)" placeholder="Select type"
										:multiple="false" :options="options" :clearable="true"
										:searchable="true" :openOnClick="true"
										:disable-branch-nodes="true" :closeOnSelect="true"
										:flat="true" :open-on-focus="true" :always-open="false"
										:normalizer="normalizer">
									<div slot="value-label" slot-scope="{ node }">@{{node.raw.customLabel}}</div>

									</treeselect>
								</template>
							</div>


						</div>

					</div>
					<!-- <div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label></label>
							<div id="notificationSubTypeDiv"></div>
						</div>
					</div> -->
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">
							<label for="notification_name">Notification name </label> <input
								type="text" class="form-control"
								:name="'notification_name' + (index)"
								:id="'notification_name' + (index)"
								v-model="notification.notification_name" value=""
								placeholder="Notification name" required>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group bmd-form-group">

							<label for="notification_channel">Notification channel </label>
							<treeselect2 class="form-control"
								:name="'notification_channel' + (index)"
								:id="'notification_channel' + (index)"
								v-model="notification.notification_channel"
								placeholder="Select channel" :multiple="false"
								:options="optionschannel" :clearable="true" :searchable="true"
								:openOnClick="true" :disable-branch-nodes="true"
								:closeOnSelect="true" :flat="false" :open-on-focus="true"
								:always-open="false" />
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='sms'">
							<label>Phone number</label><input type="tel" class="form-control"
								:name="'phone_number' + (index)" :id="'phone_number' + (index)"
								v-model="notification.phone_number" />
						</div>
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='email'">
							<label>Email</label><input type="email" class="form-control"
								:name="'email' + (index)" :id="'email' + (index)"
								v-model="notification.email" />
						</div>
						<div class="form-group bmd-form-group"
							v-if="notification.notification_channel=='platform'">
							<label>User type</label>
							<treeselectuser class="form-control"
								:name="'user_type' + (index)" :id="'user_type' + (index)"
								v-model="notification.user_type"
								placeholder="Select user type" :multiple="false"
								:options="optionsusers" :clearable="true" :searchable="true"
								:openOnClick="true" :disable-branch-nodes="true"
								:closeOnSelect="true" :flat="false" :open-on-focus="true"
								:always-open="false" search-nested :normalizer="normalizer">
							<div slot="value-label" slot-scope="{ node }">@{{node.raw.customLabel}}</div>

							</treeselect>
						
						</div>
						<div class="form-group bmd-form-group"
							v-else ></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group bmd-form-group">
							<label for="notification_content">Notification content </label>
							<textarea class="form-control"
								:name="'notification_content' + (index)"
								:id="'notification_content' + (index)"
								v-model="notification.notification_content" rows="5"
								placeholder="Notification content" required></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row ">
		<div class="col text-center">


			<button class="btn bt-submit">Save</button>

		</div>
	</div>
</form>
@section('page-scripts')

<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.umd.min.js"></script>
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/@riophae/vue-treeselect@^0.4.0/dist/vue-treeselect.min.css">

<!-- <script src="https://cdn.jsdelivr.net/npm/v-click-outside"></script> -->
<!-- <script type="module" -->
<!-- 	src="https://cdn.jsdelivr.net/npm/vue-cascader-select"></script> -->


<script type="text/javascript">
	$( document ).ready(function() {
         
     }); 
     
Vue.use('vue-cascader-select');
        Vue.component('treeselect', VueTreeselect.Treeselect);
        Vue.component('treeselect2', VueTreeselect.Treeselect);
        Vue.component('treeselectuser', VueTreeselect.Treeselect);        
        
       var app = new Vue({
            el: '#app',
            
             data: {
             	//customNotifications:[{"customNotification":"","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":"","email":"","user_type":null,"notification_content":""}],
             	customNotifications: {!! count($savedNotifications) ? json_encode($savedNotifications) : '[{"customNotification":"","notification_type":null,"notification_name":"","notification_channel":null,"phone_number":"","email":"","user_type":null,"notification_content":""}]' !!},            
                // define the default value
                 notification_type: null,
                 notification_channel:null,
                 user_type:null,
        
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
                    },{
                    	id: 'call_center',
                      	label: 'Call center',
                      	children: {!! $callCenterOptions !!}
                    }
                
                ]
        
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
					customNotification: '',
					notification_type: null,
					notification_name: '',
					notification_channel: null,
					phone_number: '',
					email: '',
					user_type: null,
					notification_content: ''
				})
			},
			removeNotification(index){
				this.customNotifications.splice(index, 1);
			},
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
</script>

@endsection
