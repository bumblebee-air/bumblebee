@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">Edit Vehicle</h3>
            <form id="vehicle-form" method="POST" action="{{url('vehicle/edit')}}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$vehicle->id}}">
                <div class="form-label-group">
                    <label for="vehicle-reg" class="control-label">Vehicle Reg.<span style="color: #ebbd1d;">*</span></label>
                    <input id="vehicle-reg" class="form-control" name="vehicle_reg" placeholder="Vehicle Reg" required
                        value="{{$vehicle->vehicle_reg}}">
                </div>
                <div class="form-label-group">
                    <label for="make" class="control-label">Make</label>
                    <input id="make" class="form-control" name="make"
                        value="{{$vehicle->make}}">
                </div>
                <div class="form-label-group">
                    <label for="model" class="control-label">Model</label>
                    <input id="model" class="form-control" name="model"
                        value="{{$vehicle->model}}">
                </div>
                <div class="form-label-group">
                    <label for="version" class="control-label">Version</label>
                    <input id="version" class="form-control" name="version"
                        value="{{$vehicle->version}}">
                </div>
                <div class="form-label-group">
                    <label for="fuel" class="control-label">Fuel</label>
                    <input id="fuel" class="form-control" name="fuel"
                        value="{{$vehicle->fuel}}">
                </div>
                <div class="form-label-group">
                    <label for="colour" class="control-label">Colour</label>
                    <input id="colour" class="form-control" name="colour"
                        value="{{$vehicle->colour}}">
                </div>
                <!--<div class="form-label-group">
                    <label for="transmission" class="control-label">Transmission</label>
                    <input id="transmission" class="form-control" name="transmission">
                </div>
                <div class="form-label-group">
                    <label for="engine-size" class="control-label">Engine size</label>
                    <input id="engine-size" class="form-control" name="engine_size">
                </div>-->
                <div class="form-label-group">
                    <label for="external-id" class="control-label">External ID<span style="color: #ebbd1d;">*</span></label>
                    <input id="external-id" class="form-control" name="external_id" placeholder="From vehicle info retrieval" required
                        value="{{$vehicle->external_id}}">
                </div>
                <br/>
                <button class="btn btn-lg text-uppercase" style="background-color: #ebbd1d; color: #FFF;
                    padding-left: 30px; padding-right: 30px;" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-sm">
            <div id="vehicle-status">
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">
        function vehicleInfoItem(label, value, id) {
            console.log('Filled' + label);
            $('#'+id).val(value);
        }

        $('#vehicle-reg').on('change',function () {
            let reg = $('#vehicle-reg').val();
            reg = reg.trim();
            if(reg!='') {
                $.ajax({
                    url: '{{url('vehicle-lookup')}}/' + reg,
                    async: true,
                    dataType: "json"
                }).done(function (response) {
                    console.log(response);
                    if (response.error == '10') {
                        $('#vehicle-status').html('');
                        $('#vehicle-status').html('<div class="form-group vehicle-info"><div>' +
                            '<label class="orange-header control-label">' +
                            '<i class="fa fa-times"></i> No data available for this vehicle' +
                            '</label>' +
                            '</div></div>');
                    } else {
                        if (response.error == '100' || response.error == '101' || response.error == '102' || response.error == '103' || response.error == '104' || response.error == '105') {
                            $('#vehicle-status').html('');
                            $('#vehicle-status').html('<div class="form-group vehicle-info"><div>' +
                                '<label class="orange-header control-label">' +
                                '<i class="fa fa-times"></i> Could not retrieve vehicle info' +
                                '</label>' +
                                '</div></div>');
                        } else {
                            if (response.error == 1) {
                                $('#vehicle-status').html('');
                                $('#vehicle-status').html('<div class="form-group vehicle-info"><div>' +
                                    '<label class="orange-header control-label">' +
                                    'Error: ' + response.error_bag['response'] + '<br/>' + response.error_bag['error'] +
                                    '</label>' +
                                    '</div></div>' +
                                    '<div class="form-group vehicle-info"><div>' +
                                    '<label class="orange-header control-label">' +
                                    '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                                    '</div></div>');
                            } else {
                                let vehicle = response.vehicle;
                                let make = vehicle.manufacturer;
                                let model = vehicle.model;
                                let version = vehicle.subbody;
                                let engineSize = vehicle.engineSize;
                                let fuel = vehicle.fuel;
                                let transmission = vehicle.transmission;
                                let colour = vehicle.colour;
                                let external_id = vehicle.mid;
                                if (make === '' || make == null)
                                    make = '-';
                                if (model === '' || model == null)
                                    model = '-';
                                if (version === '' || version == null)
                                    version = '-';
                                if (engineSize === '' || engineSize == null)
                                    engineSize = '-';
                                if (fuel === '' || fuel == null)
                                    fuel = '-';
                                if (transmission === '' || transmission == null)
                                    transmission = '-';
                                if (colour === '' || colour == null)
                                    colour = '-';
                                if (external_id === '' || external_id == null)
                                    external_id = '-';
                                $('#vehicle-status').html('');
                                vehicleInfoItem('External ID', external_id, 'external-id');
                                vehicleInfoItem('Colour', colour, 'colour');
                                //vehicleInfoItem('Transmission', transmission, 'transmission');
                                vehicleInfoItem('Fuel', fuel, 'fuel');
                                //vehicleInfoItem('Engine Size', engineSize, 'engine-size');
                                vehicleInfoItem('Version', version, 'version');
                                vehicleInfoItem('Model', model, 'model');
                                vehicleInfoItem('Make', make, 'make');

                                $('#vehicle-status').html('<div class="form-group vehicle-info"><div>' +
                                    '<label class="orange-header control-label">' +
                                    '<i class="fa fa-check"></i> Vehicle details retrieved successfully</label>' +
                                    '</div></div>');
                            }
                        }
                    }
                }).fail(function (response) {
                    console.log(response);
                    $('#vehicle-status').html('');
                    $('#vehicle-status').html('<div class="form-group vehicle-info"><div>' +
                        '<label class="orange-header control-label">' +
                        '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                        '</div></div>');
                });
                $('#vehicle-status').html('');
                $('#vehicle-status').html('<div class="form-group vehicle-info">' +
                    '<div><label class="orange-header control-label">' +
                    '<i class="fa fa-sync fa-spin"></i> Retrieving vehicle information</label></div>' +
                    '</div>');
            } else {
                $('#vehicle-status').html('');
            }
        });
    </script>
@endsection
