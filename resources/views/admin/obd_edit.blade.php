@extends('templates.aviva')

@section('page-styles')
@endsection
@section('page-content')
    <div class="row align-items-center">
        <div class="col-sm">
            <h3 style="color: #12a0c1; border-bottom: 1px solid #12a0c1;">Edit OBD device</h3>
            <form method="POST" action="{{url('obd/edit')}}">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$obd_device->id}}"/>
                <div class="form-label-group">
                    <label for="the-id" class="control-label">The ID<span style="color: #ebbd1d;">*</span></label>
                    <input id="the-id" class="form-control" name="the_id" placeholder="The ID" required
                        value="{{$obd_device->the_id}}">
                </div>
                <div class="form-label-group">
                    <label for="name" class="control-label">Name</label>
                    <input id="name" class="form-control" name="name" placeholder="Name (optional)"
                        value="{{$obd_device->name}}">
                </div>
                <div class="form-label-group">
                    <label for="notes" class="control-label">Notes</label>
                    <input id="notes" class="form-control" name="notes" placeholder="Notes (optional)"
                        value="{{$obd_device->notes}}">
                </div>
                <br/>
                <button class="btn btn-lg text-uppercase" style="background-color: #ebbd1d; color: #FFF;
                    padding-left: 30px; padding-right: 30px;" type="submit">Submit</button>
            </form>
        </div>
        <div class="col-sm">
            <div id="bth-status">
                <h3>Connect to the OBD device to get the device ID</h3>
                <button type="button" id="bth-btn" class="btn btn-lg btn-primary">Connect to OBD</button>
                <p></p>
            </div>
        </div>
    </div>
@endsection
@section('page-scripts')
    <script type="text/javascript">
        let bth_btn = document.getElementById('bth-btn');
        let status_p = $('div#bth-status p');
        $(document).ready(function() {
            bth_btn.addEventListener('click', function(event) {
                navigator.bluetooth.requestDevice({
                    filters: [{
                        services: ['0000fff0-0000-1000-8000-00805f9b34fb']
                    }]
                })
                .then(device => {
                    obd_device = device;
                    //device.addEventListener('gattserverdisconnected', onDisconnected);
                    console.log('Bluetooth Device connected with the following data:');
                    console.log(device);
                    status_p.html('Device ID: '+device.id);
                })
            });
        });
    </script>
@endsection
