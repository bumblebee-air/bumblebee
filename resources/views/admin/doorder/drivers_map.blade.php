@extends('templates.dashboard') @section('page-styles')
<style>
h3 {
	margin-top: 0;
	font-weight: bold;
}

audio {
	height: 32px;
	margin-top: 8px;
}

.swal2-popup .swal2-styled:focus {
	box-shadow: none !important;
}

div[data-toggle='collapse'] {
	cursor: pointer;
}

.deliverers-container .deliverer-card {
	cursor: pointer;
}

.deliverers-container .deliverer-card .deliverer-details {
	color: #3c4858;
}

.deliverers-container .deliverer-card .deliverer-details:hover,
	.deliverers-container .deliverer-card .deliverer-details:focus,
	.deliverer-name {
	color: #f7dc69;
}

.modal-dialog-header {
	font-size: 25px;
	font-weight: 500;
	line-height: 1.2;
	text-align: center;
	color: #cab459;
}

.modal-content {
	/*padding: 51px 51px 112px 51px;*/
	border-radius: 30px !important;
	border: solid 1px #979797 !important;
	background-color: #ffffff;
}

@media ( min-width : 576px) {
	.modal-dialog {
		max-width: 972px !important;
		margin-left: 16.75rem !important;
		margin-right: 16.75rem !important;
	}
}

.modal-header .close {
	width: 15px;
	height: 15px;
	margin: 39px 37px 95px 49px;
	background-color: #e8ca49;
	border-radius: 30px;
	color: white !important;
	top: -20px !important;
	padding: 0.6rem;
}

.modal-header .close i {
	font-size: 10px !important;
	margin: -5px;
}

.map-control {
  background-color: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 2px 2px rgba(33, 33, 33, 0.4);
  font-family: "Roboto", "sans-serif";
  margin: 10px;
  /* Hide the control initially, to prevent it from appearing
           before the map loads. */
  display: none;
}

/* Display the control once it is inside the map. */
#map .map-control {
  display: block;
}

.selector-control {
  font-size: 14px;
  line-height: 30px;
  padding-left: 5px;
  padding-right: 5px;
}
</style>
@endsection @section('title','DoOrder | View Order')
@section('page-content')
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12" id="map-container">
				<div class="card">
					<div class="card-header card-header-icon card-header-rose">
						<div class="card-icon">
							{{-- <i class="material-icons">home_work</i>--}} <img
								class="page_icon"
								src="{{asset('images/map_icon_card_white.png')}}">
						</div>
						<h4 class="card-title ">Map</h4>
					</div>

					<div class="card-body">
						<div id="style-selector-control" class="map-control">
							<select id="style-selector" class="selector-control">
								<option value="default">Default</option>
								<option value="silver">Silver</option>
								<option value="night">Night mode</option>
								<option value="retro" selected="selected">Retro</option>
								<option value="hiding">Hide features</option>
							</select>
						</div>
						<div id="map"
							style="width: 100%; height: 100%; min-height: 400px; margin-top: 0; border-radius: 6px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @section('page-scripts')
<script src="{{asset('js/bootstrap-selectpicker.js')}}"></script>
<script>
        let map;
        let deliverers_array = JSON.parse('{!! $drivers_arr !!}');
        let deliverer_markers = [];
        console.log(deliverers_array);

		const styles = {
  default: [],
  silver: [
    {
      elementType: "geometry",
      stylers: [{ color: "#f5f5f5" }],
    },
    {
      elementType: "labels.icon",
      stylers: [{ visibility: "off" }],
    },
    {
      elementType: "labels.text.fill",
      stylers: [{ color: "#616161" }],
    },
    {
      elementType: "labels.text.stroke",
      stylers: [{ color: "#f5f5f5" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "labels.text.fill",
      stylers: [{ color: "#bdbdbd" }],
    },
    {
      featureType: "poi",
      elementType: "geometry",
      stylers: [{ color: "#eeeeee" }],
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{ color: "#757575" }],
    },
    {
      featureType: "poi.park",
      elementType: "geometry",
      stylers: [{ color: "#e5e5e5" }],
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [{ color: "#ffffff" }],
    },
    {
      featureType: "road.arterial",
      elementType: "labels.text.fill",
      stylers: [{ color: "#757575" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{ color: "#dadada" }],
    },
    {
      featureType: "road.highway",
      elementType: "labels.text.fill",
      stylers: [{ color: "#616161" }],
    },
    {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
    {
      featureType: "transit.line",
      elementType: "geometry",
      stylers: [{ color: "#e5e5e5" }],
    },
    {
      featureType: "transit.station",
      elementType: "geometry",
      stylers: [{ color: "#eeeeee" }],
    },
    {
      featureType: "water",
      elementType: "geometry",
      stylers: [{ color: "#c9c9c9" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9e9e9e" }],
    },
  ],
  night: [
    { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
    { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
    { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
    {
      featureType: "administrative.locality",
      elementType: "labels.text.fill",
      stylers: [{ color: "#d59563" }],
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{ color: "#d59563" }],
    },
    {
      featureType: "poi.park",
      elementType: "geometry",
      stylers: [{ color: "#263c3f" }],
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{ color: "#6b9a76" }],
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [{ color: "#38414e" }],
    },
    {
      featureType: "road",
      elementType: "geometry.stroke",
      stylers: [{ color: "#212a37" }],
    },
    {
      featureType: "road",
      elementType: "labels.text.fill",
      stylers: [{ color: "#9ca5b3" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{ color: "#746855" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry.stroke",
      stylers: [{ color: "#1f2835" }],
    },
    {
      featureType: "road.highway",
      elementType: "labels.text.fill",
      stylers: [{ color: "#f3d19c" }],
    },
    {
      featureType: "transit",
      elementType: "geometry",
      stylers: [{ color: "#2f3948" }],
    },
    {
      featureType: "transit.station",
      elementType: "labels.text.fill",
      stylers: [{ color: "#d59563" }],
    },
    {
      featureType: "water",
      elementType: "geometry",
      stylers: [{ color: "#17263c" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{ color: "#515c6d" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.stroke",
      stylers: [{ color: "#17263c" }],
    },
  ],
  retro: [
    { elementType: "geometry", stylers: [{ color: "#ebe3cd" }] },
    { elementType: "labels.text.fill", stylers: [{ color: "#523735" }] },
    { elementType: "labels.text.stroke", stylers: [{ color: "#f5f1e6" }] },
    {
      featureType: "administrative",
      elementType: "geometry.stroke",
      stylers: [{ color: "#c9b2a6" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "geometry.stroke",
      stylers: [{ color: "#dcd2be" }],
    },
    {
      featureType: "administrative.land_parcel",
      elementType: "labels.text.fill",
      stylers: [{ color: "#ae9e90" }],
    },
    {
      featureType: "landscape.natural",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "poi",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "poi",
      elementType: "labels.text.fill",
      stylers: [{ color: "#93817c" }],
    },
    {
      featureType: "poi.park",
      elementType: "geometry.fill",
      stylers: [{ color: "#a5b076" }],
    },
    {
      featureType: "poi.park",
      elementType: "labels.text.fill",
      stylers: [{ color: "#447530" }],
    },
    {
      featureType: "road",
      elementType: "geometry",
      stylers: [{ color: "#f5f1e6" }],
    },
    {
      featureType: "road.arterial",
      elementType: "geometry",
      stylers: [{ color: "#fdfcf8" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry",
      stylers: [{ color: "#f8c967" }],
    },
    {
      featureType: "road.highway",
      elementType: "geometry.stroke",
      stylers: [{ color: "#e9bc62" }],
    },
    {
      featureType: "road.highway.controlled_access",
      elementType: "geometry",
      stylers: [{ color: "#e98d58" }],
    },
    {
      featureType: "road.highway.controlled_access",
      elementType: "geometry.stroke",
      stylers: [{ color: "#db8555" }],
    },
    {
      featureType: "road.local",
      elementType: "labels.text.fill",
      stylers: [{ color: "#806b63" }],
    },
    {
      featureType: "transit.line",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "transit.line",
      elementType: "labels.text.fill",
      stylers: [{ color: "#8f7d77" }],
    },
    {
      featureType: "transit.line",
      elementType: "labels.text.stroke",
      stylers: [{ color: "#ebe3cd" }],
    },
    {
      featureType: "transit.station",
      elementType: "geometry",
      stylers: [{ color: "#dfd2ae" }],
    },
    {
      featureType: "water",
      elementType: "geometry.fill",
      stylers: [{ color: "#b9d3c2" }],
    },
    {
      featureType: "water",
      elementType: "labels.text.fill",
      stylers: [{ color: "#92998d" }],
    },
  ],
  hiding: [
    {
      featureType: "poi.business",
      stylers: [{ visibility: "off" }],
    },
    {
      featureType: "transit",
      elementType: "labels.icon",
      stylers: [{ visibility: "off" }],
    },
  ],
};	

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: {lat: 53.346324, lng: -6.258668},
                mapTypeControl: false,
            });
            
             // Add a style-selector control to the map.
              const styleControl = document.getElementById("style-selector-control");
              map.controls[google.maps.ControlPosition.TOP_LEFT].push(styleControl);
              // Set the map's style to the initial value of the selector.
              const styleSelector = document.getElementById("style-selector");
              map.setOptions({ styles: styles[styleSelector.value] });
              // Apply new JSON when the user selects a different style.
              styleSelector.addEventListener("change", () => {
                map.setOptions({ styles: styles[styleSelector.value] });
              });
            
            /*customer_marker = new google.maps.Marker({
                map: map,
                label: 'D',
                anchorPoint: new google.maps.Point(0, -29)
            });
            customer_marker.setVisible(false);
            let customer_address_lat = $("#customer_lat").val();
            let customer_address_lon = $("#customer_lon").val();
            if(customer_address_lat!=null && customer_address_lat!='' &&
                customer_address_lon!=null && customer_address_lon!=''){
                customer_marker.setPosition({lat: parseFloat(customer_address_lat),lng: parseFloat(customer_address_lon)});
                customer_marker.setVisible(true);
            }*/
            let deliverer_marker = {
                url: "{{asset('images/doorder_driver_assets/deliverer-location-pin.png')}}",
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };
            if(deliverers_array.length > 0){
                deliverers_array.forEach(function(deliverer,index){
                    let del_lat = parseFloat(deliverer.lat);
                    let del_lon = parseFloat(deliverer.lon);
                    let deliverer_latlng = {lat: del_lat, lng: del_lon};
                    let dlvrr_mrkr = new google.maps.Marker({
                        map: map,
                        icon: deliverer_marker,
                        //anchorPoint: new google.maps.Point(del_lat, del_lon),
                        position: deliverer_latlng
                    });
                    let contentString = '<h3 style="font-weight: 400">' +
                        '<span class="deliverer-name">' + deliverer.driver.name + '</span></h3>' +
                        '<span style="font-weight: 400; font-size: 16px">' +
                        'Last updated: ' + deliverer.timestamp;
                    contentString += '</span>';
                    let infowindow = new google.maps.InfoWindow({
                        content: contentString
                    });
                    dlvrr_mrkr.addListener('click', function () {
                        infowindow.open(map, dlvrr_mrkr);
                    });
                    deliverer_markers[deliverer.driver.id] = dlvrr_mrkr;
                });
            }
        }
    </script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=<?php echo config('google.api_key'); ?>&libraries=geometry,places&callback=initMap"></script>
@endsection
