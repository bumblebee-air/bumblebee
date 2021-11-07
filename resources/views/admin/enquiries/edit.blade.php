@extends('templates.dashboard')
@section('page-styles')
    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap4.min.css')}}"/>
    <style>
        h3 {
            margin-top: 0;
            margin-bottom: 25px;
            font-weight: bold;
        }
        div.card-btns {
            margin: 0 15px 10px;
            padding: 0;
            padding-top: 10px;
        }
        div.iti {
            width: 100%;
        }
        a.supplier-name:not([href]):not([tabindex]) {
            color: #0a6ebd;
            cursor: pointer;
            text-decoration: underline;
        }
</style>
@endsection
@section('page-content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card match-height" style="margin-top: 0">
                    <div class="card-header card-header-rose card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h4 class="card-title">Edit General Enquiry</h4>
                    </div>
                    <form id="customer-form" action="{{url('general-enquiry')}}" method="post">
                        <div class="card-body ">
                            {{ csrf_field() }}
                            <input type="hidden" name="enquiry_id" value="{{$enquiry->id}}"/>

                            <div class="form-group bmd-form-group" style="@if($is_client==true) display: none; @endif">
                                <label for="client">Client *</label>
                                <select id="client" name="client_id" class="form-control selectpicker" required>
                                    <option value="">Select client</option>
                                    @if($is_client==true)
                                        <option value="{{$clients->id}}" selected>{{$clients->name}}</option>
                                    @else
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}" @if($enquiry->client_id==$client->id) selected @endif>{{$client->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="name">Customer name *</label>
                                <input name="customer_name" type="text" class="form-control" id="name" placeholder="Enter customer name" value="{{ ($enquiry->customer_name!=null)? $enquiry->customer_name : old('name') }}" required>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="phone">Customer phone *</label>
                                <input name="customer_phone" type="text" class="form-control" id="phone" placeholder="Enter customer phone" value="{{ ($enquiry->customer_phone_international!=null)? $enquiry->customer_phone_international : (($enquiry->customer_phone!=null)? $enquiry->customer_phone : old('phone')) }}" required>
                                <p id="customer-phone-intl-output"></p>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="email">Email</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Enter email address" value="{{ ($enquiry->customer_email!=null)? $enquiry->customer_email : old('email') }}">
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="location">Customer location *</label>
                                <input id="location" name="customer_location" class="form-control" placeholder="Type for autocomplete"
                                    @if($enquiry->location!=null) value="{{$enquiry->location}}" @endif required/>
                                <input type="hidden" id="location-lat" name="location_lat" class="form-control"
                                    @if($enquiry->location_lat!=null) value="{{$enquiry->location_lat}}" @endif />
                                <input type="hidden" id="location-lon" name="location_lon" class="form-control"
                                    @if($enquiry->location_lon!=null) value="{{$enquiry->location_lon}}" @endif />
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="enquiry">Enquiry *</label>
                                <textarea name="enquiry" class="form-control" id="enquiry" required>@if($enquiry->enquiry!=null){{$enquiry->enquiry}}@endif</textarea>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="contractor">Contractor</label>
                                <select id="contractor" name="contractor" class="form-control">
                                    <option value="">Select contractor</option>
                                    @foreach(json_decode($suppliers) as $supplier)
                                        <option value="{{$supplier->id}}" @if($enquiry->contractor==$supplier->id) selected @endif>{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group bmd-form-group">
                                <label for="whatsapp-template">Whatsapp Template</label>
                                <select id="whatsapp-template" name="whatsapp_template" class="form-control">
                                    <option value="">Select template</option>
                                    @foreach($whatsapp_templates as $template)
                                        <option value="{{$template->id}}">{{$template->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-btns">
                            <button type="submit" class="btn btn-fill btn-rose">Save</button>
                            <a href="{{ url('general-enquiry') }}" class="btn">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <div id="map-container" class="col-md-6 match-height" style="height: 300px;">
                <div id="map" style="width:100%; height: 100%;margin-top:0;border-radius:6px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
<script src="{{ asset('js/bootstrap-selectpicker.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery.matchHeight.js') }}" type="text/javascript"></script>
<script src="{{asset('js/intlTelInput/intlTelInput.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        let customer_phone = document.querySelector("#phone");
        customer_phone = window.intlTelInput(customer_phone, {
            hiddenInput: 'customer_phone_international',
            initialCountry: 'IE',
            separateDialCode: true,
            preferredCountries: ['IE', 'GB'],
            utilsScript: "{{asset('js/intlTelInput/utils.js')}}"
        });
        let customer_phone_jq = $('#phone');
        let customer_phone_intl_output = $('#customer-phone-intl-output');
        customer_phone_jq.on("keyup change", function() {
            let intlNumber = customer_phone.getNumber();
            if (intlNumber) {
                customer_phone_intl_output.text("International: " + intlNumber);
            } else {
                customer_phone_intl_output.text("Please enter a number below");
            }
        });

        $('#contractor').select2({
            theme: 'bootstrap4',
        });
        $('#whatsapp-template').select2({
            theme: 'bootstrap4',
        });
    });

    let suppliers = {!! $suppliers !!};
    let supplier_markers = [];

    function useSupplier(supplier_id){
        //console.log('Supplier ID: '+supplier_id);
        let contractor_field = $('#contractor');
        contractor_field.val(supplier_id);
        contractor_field.change();
    }

    let map;
    let customer_marker;
    let customer_latlng = null;
    let contractor_latlng = null;

    $('.match-height').matchHeight({
        byRow: false
    });

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat: 53.346324, lng: -6.258668}
        });

        let customer_location = document.getElementById('location');
        //Mutation observer hack for chrome address autofill issue
        let observerHackAddress = new MutationObserver(function() {
            observerHackAddress.disconnect();
            customer_location.setAttribute("autocomplete", "new-password");
        });
        observerHackAddress.observe(customer_location, {
            attributes: true,
            attributeFilter: ['autocomplete']
        });
        let autocomplete = new google.maps.places.Autocomplete(customer_location);
        autocomplete.setComponentRestrictions({'country': ['ie','gb']});
        
        customer_marker = new google.maps.Marker({
            map: map,
            label: 'C',
            anchorPoint: new google.maps.Point(0, -29)
        });
        customer_marker.setVisible(false);
        @if($enquiry->location_lat!=null && $enquiry->location_lon!=null)
            customer_marker.setPosition({lat: parseFloat('{{$enquiry->location_lat}}'),lng: parseFloat('{{$enquiry->location_lon}}')});
            customer_marker.setVisible(true);
            map.setCenter({lat: parseFloat('{{$enquiry->location_lat}}'),lng: parseFloat('{{$enquiry->location_lon}}')});
            map.setZoom(12);
        @endif

        autocomplete.addListener('place_changed', function() {
            customer_marker.setVisible(false);
            let place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            } else {
                let place_lat = place.geometry.location.lat();
                let place_lon = place.geometry.location.lng();
                document.getElementById("location-lat").value = place_lat.toFixed(5);
                document.getElementById("location-lon").value = place_lon.toFixed(5);
                customer_latlng = place.geometry.location;
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(12);
            }
            customer_marker.setPosition(place.geometry.location);
            customer_marker.setVisible(true);
        });

        suppliers.forEach(function (item, index) {
            let position_lat_lng = {lat: parseFloat(item.latitude), lng: parseFloat(item.longitude)};
            let supplier_marker = new google.maps.Marker({
                position: position_lat_lng,
                map: map
            });
            let contentString = '<h3 style="font-weight: 400">' +
                '<a class="supplier-name" onclick="useSupplier(\''+item.id+'\')">' +
                item.name+'</a></h3>' +
                '<p style="font-weight: 400; font-size: 16px">' +
                item.phone + '<br/>' + item.email + '<br/> Co. ' + item.county;
            if(item.notes != null ){
                contentString += '<br/>' + item.notes + '<br/>';
            }
            contentString += '</p>';
            let infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            supplier_marker.addListener('click', function () {
                infowindow.open(map, supplier_marker);
            });
            supplier_markers.push(supplier_marker);
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap">
</script>
@endsection