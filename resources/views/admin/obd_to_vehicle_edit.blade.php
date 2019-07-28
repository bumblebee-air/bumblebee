@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">Edit OBD to vehicle connection</h3>
            <form method="POST" action="{{url('obd-to-vehicle/edit')}}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$obd_to_vehicle->id}}">
                <div class="form-label-group">
                    <label for="obd-id" class="control-label">OBD</label>
                    <select id="obd-id" class="form-control" name="obd_id" required>
                        <option value=""></option>
                        @foreach($obd_devices as $obd)
                            <option value="{{$obd->id}}"
                                @if($obd_to_vehicle->obd_id==$obd->id) selected @endif
                            >{{$obd->the_id}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-label-group">
                    <label for="vehicle-id" class="control-label">Vehicle</label>
                    <select id="vehicle-id" class="form-control" name="vehicle_id" required>
                        <option value=""></option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{$vehicle->id}}"
                                @if($obd_to_vehicle->vehicle_id==$vehicle->id) selected @endif
                            >{{$vehicle->vehicle_reg}}</option>
                        @endforeach
                    </select>
                </div>
                <br/>
                <button class="btn btn-lg text-uppercase" style="background-color: #ebbd1d; color: #FFF;
                    padding-left: 30px; padding-right: 30px;" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-sm">
            <div id="connection-status">
                <p id="obd-status"></p>
                <p id="vehicle-status"></p>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#obd-id').on('change', function() {
                let obd_id = $(this).val();
                if(obd_id.trim()!=='') {
                    $.ajax({
                        url: '{{url('api/check-obd-vehicle-connection')}}',
                        data: {
                            type: 'obd',
                            id: obd_id,
                            csrfmiddlewaretoken: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function (data) {
                            if (data.found === 1) {
                                $('#connection-status #obd-status').html('<span style="color:darkred">This OBD is already connected to the vehicle: ' + data.vehicle.vehicle_reg + '</span>');
                            } else {
                                $('#connection-status #obd-status').html('This OBD is currently free');
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Unable to retrieve OBD to vehicle connection!<br/>" + "Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                        }
                    });
                    $('#connection-status #obd-status').html('<i class="fa fa-sync fa-spin"></i> Retrieving OBD availability</label></div>');
                }
            });

            $('#vehicle-id').on('change', function() {
                let vehicle_id = $(this).val();
                if(vehicle_id.trim()!='') {
                    $.ajax({
                        url: '{{url('api/check-obd-vehicle-connection')}}',
                        data: {
                            type: 'vehicle',
                            id: vehicle_id,
                            csrfmiddlewaretoken: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        method: 'POST',
                        success: function (data) {
                            if (data.found === 1) {
                                $('#connection-status #vehicle-status').html('<span style="color:darkred">This vehicle is already connected to the OBD: ' + data.obd.the_id + '</span>');
                            } else {
                                $('#connection-status #vehicle-status').html('This vehicle is currently free');
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Unable to retrieve OBD to vehicle connection!<br/>" + "Status: " + textStatus + "<br/>" + "Error: " + errorThrown);
                        }
                    });
                    $('#connection-status #vehicle-status').html('<i class="fa fa-sync fa-spin"></i> Retrieving vehicle availability</label></div>');
                }
            });
        });
    </script>
@endsection
