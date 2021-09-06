@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">
<style>
.iti {
	width: 100%;
}

.fa-check-circle {
	color: #b1b1b1;
	line-height: 3;
	font-size: 20px
}

.card-title.customerProfile {
	display: inline-block;
}

.addContactDetailsCircle {
	color: #d58242;
	font-size: 18px;
}

.removeContactDetailsCircle {
	color: #df5353;
	font-size: 18px;
}

.btn-import {
	box-shadow: none !important;
}

#navProductUl li a {
	font-family: 'Roboto', sans-serif;
	font-size: 17px;
	font-weight: 600;
	font-stretch: normal;
	font-style: normal;
	text-transform: capitalize !important;
	line-height: 1.19;
	letter-spacing: 0.8px;
	color: #7b7b7b !important;
	background: transparent;
}

#navProductUl li a.active, #navProductUl li a:hover {
	color: #d58242 !important;
	background: transparent !important;
	box-shadow: none !important;
}

.tab-space {
	padding: 0 !important;
}

.card-sub-title {
	margin-top: 0 !important;
}

form .form-group select.form-control {
	position: inherit !important;
	top: 0;
}

.sendReminderLabel {
	font-family: Roboto;
	font-size: 13px;
	font-weight: bold;
	font-stretch: normal;
	font-style: normal;
	line-height: 1.38;
	letter-spacing: 1.3px;
	color: #656565;
}

input[type="checkbox"] {
	display: none;
}

.sendReminderLabel i {
	color: aaa;
	font-size: 18x;
}

input[type="checkbox"]:checked+label i {
	color: #d58242
}
</style>
@endsection @section('title','Unified | Add Product | Customer ' .
$customer->name) @section('page-content')
<div class="content" id="app">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-icon  row ">
							<div class="col-12">
								<div class="card-icon p-3">
									<img class="page_icon"
										src="{{asset('images/unified/Add Service Form.png')}}">
								</div>
								<h4 class="card-title">
									<span class="card-title-grey">Add Product /</span>
									{{$customer->name}}
								</h4>
							</div>
						</div>

						<div class="card-body"></div>
					</div>

					<div>
						<ul
							class="nav nav-pills nav-pills-primary justify-content-start justify-content-md-center"
							role="tablist" id="navProductUl">
							<li class="nav-item"><a class="nav-link" data-toggle="tab"
								href="#hosted_cpbx_div" role="tablist" aria-expanded="true">
									Hosted/Cpbx </a></li>
							<li class="nav-item"><a class="nav-link " data-toggle="tab"
								href="#access_control_div" role="tablist" aria-expanded="false">
									Access Control </a></li>
							<li class="nav-item"><a class="nav-link " data-toggle="tab"
								href="#cctv_div" role="tablist" aria-expanded="false"> CCTV </a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab"
								href="#fire_alarm_div" role="tablist" aria-expanded="false">
									Fire Alarm</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab"
								href="#intruder_alarm_div" role="tablist" aria-expanded="false">
									Intruder Alarm </a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab"
								href="#wifi_data_div" role="tablist" aria-expanded="false">
									Wifi/Data </a></li>
							<li class="nav-item"><a class="nav-link active" data-toggle="tab"
								href="#structured_cabling_systems_div" role="tablist"
								aria-expanded="false"> Structured Cabling Systems </a></li>
						</ul>
					</div>

					<div class="tab-content tab-space">
						<div class="tab-pane " id="hosted_cpbx_div" aria-expanded="false">
							@include('admin.unified.customers.products.hosted_cpbx')</div>
						<div class="tab-pane " id="access_control_div"
							aria-expanded="false">
							@include('admin.unified.customers.products.access_control')</div>
						<div class="tab-pane" id="cctv_div" aria-expanded="false">
							@include('admin.unified.customers.products.cctv')</div>
						<div class="tab-pane " id="fire_alarm_div" aria-expanded="false">
							@include('admin.unified.customers.products.fire_alarm')</div>
						<div class="tab-pane " id="intruder_alarm_div" aria-expanded="false">
							@include('admin.unified.customers.products.intruder_alarm')</div>
						<div class="tab-pane " id="wifi_data_div" aria-expanded="false">
							@include('admin.unified.customers.products.wifi_data')</div>
						<div class="tab-pane active" id="structured_cabling_systems_div" aria-expanded="false">
							@include('admin.unified.customers.products.structured_cabling_systems')</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection @section('page-scripts')

<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script>


$( document ).ready(function() {

// 	$("#serviceTypeSelect").select2({
// 	  placeholder: 'Select product type',
// 	  tags: true
// 	}).val({!! json_encode($customer->selectedServiceType) !!}).change();
	
     
	$('.dateInput').datetimepicker({
                         format: 'L', 
                        icons: { time: "fa fa-clock",
                                                date: "fa fa-calendar",
                                                up: "fa fa-chevron-up",
                                                down: "fa fa-chevron-down",
                                                previous: 'fa fa-chevron-left',
                                                next: 'fa fa-chevron-right',
                                                today: 'fa fa-screenshot',
                                                clear: 'fa fa-trash',
                                                close: 'fa fa-remove'
                        }
                     });                
	
	

});
        function initMap() {
        	autoLocationMap('cctv_location');
        	autoLocationMap('fire_panel_location');
        	autoLocationMap('intruder_panel_location');            
        }
        
        function autoLocationMap(inputId){
        	let location_input = document.getElementById(inputId);
            //Mutation observer hack for chrome address autofill issue
            let observerHackAddress = new MutationObserver(function() {
                observerHackAddress.disconnect();
				location_input.setAttribute("autocomplete", "new-password");
            });
            observerHackAddress.observe(location_input, {
                attributes: true,
                attributeFilter: ['autocomplete']
            });
            let autocomplete = new google.maps.places.Autocomplete(location_input);
            autocomplete.setComponentRestrictions({'country': ['ie']});
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                if (!place.geometry) {
                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                } else {
                	
					console.log(place)
						let place_lat = place.geometry.location.lat();
						let place_lon = place.geometry.location.lng();
						document.getElementById(inputId+"_lat").value = place_lat.toFixed(5);
						document.getElementById(inputId+"_lon").value = place_lon.toFixed(5);
						//address_input.value = eircode_value.long_name;
						// if (customer_address_input.value != '') {
						//	address_input.value = place.formatted_address;
						// }
					
                }
            });
        }
</script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>

@endsection
