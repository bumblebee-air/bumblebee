@extends('templates.dashboard') @section('page-styles')
<link rel="stylesheet" href="{{asset('css/open_insurance_styles.css')}}">

<style>
.custom-file-label {
	box-shadow: 0 2px 48px 0 rgb(0 0 0/ 8%);
	background-color: #ffffff;
	border-radius: 10px;
	line-height: 2 !important;
}

.custom-file-label:after {
	background: #e9ecef;
	padding-top: 0.8rem;
	height: 100%;
}
</style>
@endsection @section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="">
			<form id="customer-form" action="{{url('save_claim')}}"
				enctype="multipart/form-data" method="post">
				{{ csrf_field() }}
				<div class="card">
					<div class="card-header card-header-rose card-header-icon">
						<div class="card-icon">
							<i class="material-icons">add_circle_outline</i>
						</div>
						<h4 class="card-title">Claim</h4>
					</div>

					<div class="card-body ">


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_number">* Claim number</label> <input
										name="claim_number" type="text" class="form-control"
										id="claim_number" placeholder="Enter claim number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="first_notice_of_loss">* First notice of loss</label>
									<input name="first_notice_of_loss" type="text"
										class="form-control" id="first_notice_of_loss"
										placeholder="Enter date" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="loss_date">* Loss date</label> <input
										name="loss_date" type="text" class="form-control"
										id="loss_date" placeholder="Enter date" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_type_select" class="formLabel">* Claim type</label>
									<select id="claim_type_select" name="claim_type"
										class="form-control" required><option value="">Select type</option>
										@foreach($claimTypes as $type)
										<option value="{{$type->id}}">{{$type->name}}</option>
										@endforeach

									</select>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="location">* Location</label> <input name="location"
										type="text" class="form-control" id="location"
										placeholder="Enter location" required> <input type="hidden"
										name="location_lat" id="location_lat" value=""> <input
										type="hidden" name="location_lon" id="location_lon" value="">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="loss_cause_select" class="formLabel">* Loss cause</label>
									<select id="loss_cause_select" name="loss_cause"
										class="form-control" required><option value="">Select loss
											cause</option> @foreach($perils as $peril)
										<option value="{{$peril->id}}">{{$peril->name}}</option>
										@endforeach

									</select>
								</div>
							</div>

						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="description_loss_cause">* Description of loss cause
									</label>
									<textarea name="description_loss_cause" rows="5"
										class="form-control" id="description_loss_cause"
										placeholder="Enter description_loss_cause" required></textarea>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="liability_share">* Liability share</label> <input
										name="liability_share" type="number" class="form-control"
										id="liability_share" placeholder="Enter liability share"
										required>
								</div>
								<div class="form-group bmd-form-group">
									<label for="reserve">* Reserve</label> <input name="reserve"
										type="number" class="form-control" id="reserve"
										placeholder="Enter reserve" required>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="claim_status_select" class="formLabel">* Claim
										status</label> <select id="claim_status_select"
										name="claim_status" class="form-control" required><option
											value="">Select claim status</option>
										@foreach($claimStatusList as $status)
										<option value="{{$status->id}}">{{$status->name}}</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="last_update"> Last update</label> <input
										name="last_update" type="text" class="form-control"
										id="last_update" placeholder="Enter date">
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="reopen_date">* Reopen date</label> <input
										name="reopen_date" type="text" class="form-control"
										id="reopen_date" placeholder="Enter date" required>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="excess_amount">* Excess amount</label> <input
										name="excess_amount" type="number" class="form-control"
										id="excess_amount" placeholder="Enter excess amount" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label for="payment_method_select"> Payment method</label> <select
										id="payment_method_select" name="payment_method"
										class="form-control">
										<option value="">Select payment method</option>
										@foreach($paymentMethods as $paymentMethod)
										<option value="{{$paymentMethod->id}}">
											{{$paymentMethod->name}}</option> @endforeach

									</select>
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group bmd-form-group">
									<label>Documents <span style="font-size: x-small;"> accident
											image, police report etc.</span>
									</label>
									<div class="custom-file">
										<input type="file" name="files[]" multiple
											class="custom-file-input form-control" id="customFile"> <label
											class="custom-file-label" for="customFile">Choose file</label>
									</div>
									<ul id="uploadFilesUl"></ul>
								</div>

							</div>
						</div>



					</div>

				</div>

				<div class="row text-center">
					<div class="col-md-12">
						<button type="submit" id="saveButton"
							class="btn btn-fill btn-rose">Save</button>

					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection @section('page-scripts')

<script type="text/javascript">
  

$(document).ready(function() {
	$("#claim_type_select").select2({ allowClear: true,placeholder:'Select claim type'}).trigger('change');
	$("#loss_cause_select").select2({ allowClear: true,placeholder:'Select loss cause'}).trigger('change');
	$("#claim_status_select").select2({ allowClear: true,placeholder:'Select claim status'}).trigger('change');
	$("#payment_method_select").select2({ allowClear: true,placeholder:'Select payment method'}).trigger('change');


    $("#first_notice_of_loss,#loss_date").datetimepicker({	
    });
    $("#last_update,#reopen_date").datetimepicker({	
    		format: 'YYYY-MM-DD ',
    });
    
    
    $('input[type="file"]').on("change", function() {
        let filenames = [];
        let files = this.files;
        $("#uploadFilesUl").html('');
        if (files.length > 1) {
          filenames.push("Total Files (" + files.length + ")");
          //} else {
          for (let i in files) {
            if (files.hasOwnProperty(i)) {
              //filenames.push(files[i].name);
               $("#uploadFilesUl").append('<li>'+ files[i].name +'</li>')
            }
          }
        }
        $(".custom-file-label")
          .html(filenames.join(","));
 	});
  

});

                function addFile(id) {
                    $('#' + id).click();
                }
                function onChangeFile(e ,id) {
                	console.log(e.val())
                    $("#" + id).val(e.target.files[0].name);
                }

        function initMap() {
            let location_input = document.getElementById('location');
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
						document.getElementById("location_lat").value = place_lat.toFixed(5);
						document.getElementById("location_lon").value = place_lon.toFixed(5);
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
