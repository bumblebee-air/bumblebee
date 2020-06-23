@extends('templates.bumblebee_public')

@section('page-styles')
    <style>
        body {
            background: #eee;
            /*background: linear-gradient(to right, #0062E6, #33AEFF);*/
        }

        /*:root {
            --input-padding-x: 1.5rem;
            --input-padding-y: .75rem;
        }

        .card-signin {
            border: 0;
            border-radius: 1rem;
            background: #eee;
            /*box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .card-signin .card-title {
            margin-bottom: 2rem;
            font-weight: 300;
            font-size: 1.5rem;
        }

        .card-signin .card-body {
            padding: 2rem;
            color: #00479d;
        }

        .form-signin {
            width: 100%;
        }

        .form-signin .btn {
            /*font-size: 90%;
            border-radius: 5rem;
            /*letter-spacing: .1rem;
            font-weight: 700;
            padding: 1rem;
            transition: all 0.2s;
        }*/

        .form-label-group {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-label-group input {
            height: auto;
            border-radius: 2rem;
        }

        .form-label-group>input,
        .form-label-group>label {
            padding: var(--input-padding-y) var(--input-padding-x);
        }

        .form-label-group>label {
            position: absolute;
            top: 0;
            left: 0;
            display: block;
            width: 100%;
            margin-bottom: 0;
            /* Override default `<label>` margin */
            line-height: 1.5;
            color: #495057;
            border: 1px solid transparent;
            border-radius: .25rem;
            transition: all .1s ease-in-out;
        }

        .form-label-group input::-webkit-input-placeholder {
            color: transparent;
        }

        .form-label-group input:-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-ms-input-placeholder {
            color: transparent;
        }

        .form-label-group input::-moz-placeholder {
            color: transparent;
        }

        .form-label-group input::placeholder {
            color: transparent;
        }

        .form-label-group input:not(:placeholder-shown) {
            padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
            padding-bottom: calc(var(--input-padding-y) / 3);
        }

        .form-label-group input:not(:placeholder-shown)~label {
            padding-top: calc(var(--input-padding-y) / 3);
            padding-bottom: calc(var(--input-padding-y) / 3);
            font-size: 12px;
            color: #777;
        }

        .btn-google {
            color: white;
            background-color: #ea4335;
        }

        .btn-facebook {
            color: white;
            background-color: #3b5998;
        }

        .main-title {
            color: #FF2E1B;
        }
        .sub-title {
            color: #FF6602;
        }
        .sub-sub-title {
            color: #FF9203;
        }
        .btn.btn-rrra {
            background-color: #FF2E1B;
            border-color: #FF2E1B;
        }
        .btn.btn-rrra:hover, .btn.btn-rrra:active,
        .btn.btn-rrra:focus {
            background-color: #F7220E;
            border-color: #F7220E;
        }
        #batteries-section,
        #tyres-section {
            /*background-color: #fff;
            border-radius: 20px;*/
            margin-top: 20px;
        }
        #batteries-section .vehicle-info,
        #tyres-section .vehicle-info{
            background-color: #fff;
            border-radius: 20px;
        }
        #batteries-section .card,
        #tyres-section .card {
            margin: 5px;
        }
        #batteries-section .card .card-header,
        #tyres-section .card .card-header {
            padding: 15px;
        }
        #batteries-section .card .card-body,
        #tyres-section .card .card-body {
            padding-right: 15px;
            padding-left: 15px;
            padding-bottom: 15px;
        }
        #vehicle-reg-container .form-control-feedback {
            top: 0;
        }
        #vehicle-reg-container.has-success input {
            color: #4caf50;
        }
    </style>
    <link href="{{asset('css/ekko-lightbox.css')}}" type="text/css" rel="stylesheet" />
@endsection
@section('page-content')
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card" style="margin-bottom: 0">
                <div class="card-body">
                    <div class="form">
                        {{csrf_field()}}

                        <div id="vehicle-reg-container" class="form-group" style="padding-top:0">
                            <!--bmd-form-group<label class="bmd-label-floating" for="vehicle-reg">Vehicle Reg</label>-->
                            <input id="vehicle-reg" class="form-control" name="vehicle_reg" placeholder="Enter a Vehicle Registration" required>
                        </div>
                        <div class="form-group" id="vehicle-form" style="margin: 0px !important;">
                        </div>

                        <button class="btn btn-lg btn-rrra btn-block btn-round text-uppercase" id="vehicle-check" role="button">Submit</button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-4 col-4 align-self-center" style="text-align: center">
                    <h6>Powered by</h6>
                    <img class="img-fluid" src="{{asset('images/autodata-logo.svg')}}" alt="Autodata"/>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="batteries-section" class="col">
        </div>
    </div>
    <div class="row">
        <div id="tyres-section" class="col">
        </div>
    </div>
    <br/>
    <!--<div class="row">
        <div class="col">
            <a href="#" id="shogunfang" data-image-id="160413" data-image-reference="2">Two</a>
            <a href="https://unsplash.it/600.jpg?image=250" data-toggle="lightbox" data-title="A random title">
                <img src="https://unsplash.it/600.jpg?image=250" class="img-fluid">
            </a>
        </div>
    </div>-->
@endsection

@section('page-scripts')
    <script src="{{asset('js/ekko-lightbox.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        let mid = null;
        $(document).ready(function() {
            //Fixed scrolling bar to specified height
            $(window).scroll(function(){
                $("#fixed-vehicle-info-bar").css("margin-top",Math.max(-70,0-$(this).scrollTop()));
            });

            function vehicleInfoItem(label, value, name, hidden=false) {
                let html = '<div class="row vehicle-info" style="margin-bottom: 0">';
                if(!hidden)
                    html +='<label class="col-sm-5 control-label">' + label +'</label>' +
                    '<div class="col-sm-7">' +
                    '<div class="form-control-static">' + value + '</div>';
                html += '<input name="' + name + '" type="hidden" value="' + value + '"/>';
                if(!hidden)
                    html += '</div> </div>';
                return html
            }

            $('#vehicle-check').on('click',function () {
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
                            $('.vehicle-info').remove();
                            $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                '<label class="orange-header control-label">' +
                                '<i class="fa fa-times"></i> No data available for this vehicle' +
                                '</label>' +
                                '</div></div>');
                        } else {
                            if (response.error == '100' || response.error == '101' || response.error == '102' || response.error == '103' || response.error == '104' || response.error == '105') {
                                $('.vehicle-info').remove();
                                $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                    '<label class="orange-header control-label">' +
                                    '<i class="fa fa-times"></i> Could not retrieve vehicle info' +
                                    '</label>' +
                                    '</div></div>');
                            } else {
                                if (response.error == 1) {
                                    $('.vehicle-info').remove();
                                    /*$('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                        '<label class="orange-header control-label">' +
                                        'Error: ' + response.error_bag['response'] + '<br/>' + response.error_bag['error'] +
                                        '</label>' +
                                        '</div></div>');*/
                                    console.log(response.error_bag['response']);
                                    console.log(response.error_bag['error']);
                                    $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                        '<label class="orange-header control-label">' +
                                        '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                                        '</div></div>');
                                } else {
                                    var vehicle = response.vehicle;
                                    var make = vehicle.manufacturer;
                                    var model = vehicle.model;
                                    var version = vehicle.version;
                                    var engineSize = vehicle.engineSize;
                                    var fuel = vehicle.fuel;
                                    var transmission = vehicle.transmission;
                                    var colour = vehicle.colour;
                                    var external_id = vehicle.mid;
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
                                    mid = external_id;
                                    $('.vehicle-info').remove();
                                    $('#vehicle-form').after('<div style="margin-bottom: 10px"></div>');
                                    /*$('#vehicle-form').after(vehicleInfoItem('External ID', external_id, 'external_id', true));
                                    //$('#vehicle-form').after(vehicleInfoItem('Colour', colour, 'colour'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Transmission', transmission, 'transmission'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Fuel', fuel, 'fuel'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Version', version, 'version'));
                                    $('#vehicle-form').after(vehicleInfoItem('Model', model, 'model'));
                                    $('#vehicle-form').after(vehicleInfoItem('Make', make, 'make'));*/
                                    //$('#vehicle-form').after('<p><span style="text-align:center">'+make+' '+model+'</span></p>');

                                    /*$('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                                        '<h4 class="orange-header" style="font-weight: 400">Vehicle Details</h4>' +
                                        '</div>');*/
                                    $('#vehicle-reg-container').addClass('has-success');
                                    $('#vehicle-reg').after('<span class="material-icons form-control-feedback">done</span>');
                                    //Fixed scrolling vehicle info bar
                                    $('nav.navbar').after('<div id="fixed-vehicle-info-bar" ' +
                                        'style="position:fixed;top:70px;background-color:#F7F7F7; width: 100%; text-align: center;' +
                                            'box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3); z-index: 999;">' +
                                        '<h4>' + make + '  ' + model + '&nbsp;&nbsp;(' + reg + ')' + '</h4>' +
                                        '</div>');
                                    //'<i class="fas fa-arrow-alt-circle-up" style="cursor: pointer" onclick="scrollToTheTop()"></i></span>'
                                    //Retrieve tyre pressures and battery replacements information
                                    $('#tyres-section').html('<div class="form-group vehicle-info">' +
                                        '<div><label class="orange-header control-label">' +
                                        '<i class="fa fa-sync fa-spin"></i> Retrieving tyres information</label></div>' +
                                        '</div>');
                                    setTimeout(getTyreDetails,1000);
                                    $('#batteries-section').html('<div class="form-group vehicle-info">' +
                                        '<div><label class="orange-header control-label">' +
                                        '<i class="fa fa-sync fa-spin"></i> Retrieving batteries information</label></div>' +
                                        '</div>');
                                    setTimeout(getBatteryDetails,3000);
                                }
                            }
                        }
                    }).fail(function (response) {
                        console.log(response);
                        $('.vehicle-info').remove();
                        $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                            '<label class="orange-header control-label">' +
                            '<i class="fa fa-times"></i> Could not retrieve vehicle info</label>' +
                            '</div></div>');
                    });
                    $('#tyres-section').html('');
                    $('#batteries-section').html('');
                    $('.vehicle-info').remove();
                    $('#vehicle-form').after('<div class="form-group vehicle-info">' +
                        '<div><label class="orange-header control-label">' +
                        '<i class="fa fa-sync fa-spin"></i> Retrieving vehicle information</label></div>' +
                        '</div>');
                    $('#fixed-vehicle-info-bar').remove();
                    $('#vehicle-reg-container').removeClass('has-success').removeClass('has-danger');
                }
                /* else {
                    $('.vehicle-info').remove();
                }*/
            });
        });

        function getTyreDetails(){
            $.ajax({
                url: '{{url('api/get-tyres-info')}}',
                data: {
                    mid: mid,
                    csrfmiddlewaretoken: '{{ csrf_token() }}'
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    console.log(data);
                    let tyres_text = '<div id="accordion-tyres" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                        '<div class="card">' +
                        '<div class="card-header" role="tab" id="heading-tyres">' +
                        '<a data-toggle="collapse" data-parent="#accordion-tyres" href="#collapse-tyres" aria-controls="collapse-tyres">' +
                        'Tyres' + '<i class="material-icons">keyboard_arrow_down</i>' +
                        '</a>' + '</div>' +
                        '<div id="collapse-tyres" class="collapse" role="tabpanel" aria-labelledby="heading-tyres">' +
                        '<div id="tyres-area" class="card-body">';
                    let tyres_info = data.tyres_info;
                    let the_notes = tyres_info.__notes;
                    let notes_array = [];
                    the_notes.forEach(function(item,index){
                        let note_item = {};
                        note_item['name'] = item.name;
                        let note_item_array = [];
                        item.content.forEach(function(an_item,the_index){
                            note_item_array.push(an_item.value);
                        });
                        note_item['notes'] = note_item_array;
                        notes_array[item.id] = note_item;
                    });
                    let the_images = tyres_info.__images;
                    let images_array = [];
                    the_images.forEach(function(item,index){
                        //images_array[item.id] = item.graphic.url;
                        images_array.push({'id':item.id,'url':item.graphic.url});
                    });
                    console.log(notes_array);
                    let pressure_variants = tyres_info.pressure_variants;
                    tyres_text += '<div id="accordion-tyre-pressures" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                        '<div class="card">' +
                        '<div class="card-header" role="tab" id="heading-tyre-pressures">' +
                        '<a data-toggle="collapse" data-parent="#accordion-tyre-pressures" href="#collapse-tyre-pressures" aria-controls="collapse-tyre-pressures">' +
                        'Tyre Pressures' + '<i class="material-icons">keyboard_arrow_down</i>' +
                        '</a>' + '</div>' +
                        '<div id="collapse-tyre-pressures" class="collapse" role="tabpanel" aria-labelledby="heading-tyre-pressures">' +
                        '<div id="tyre-pressures-area" class="card-body">';
                    pressure_variants.forEach(function(item,index){
                        tyres_text += '<h3 class="sub-title">'+item.variant_description+' ('+item.year_range.year_range+')</h3>'+
                            'Show tyre pressure in ' +
                            '<select class="selectpicker" data-style="select-with-transition" id="pressure-select-'+index+'" onchange="changePressure('+index+',$(this).val())">' +
                            '<option value="bar">Bar</option>' +
                            '<option value="psi">Psi</option>' +
                            '</select>'+
                            '<div class="table-responsive"><table id="pressures-'+index+'" class="table table-bordered">'+
                            '<thead>'+
                            '<tr><td rowspan="2">Rim size</td><td rowspan="2">Tyre size</td><td rowspan="2">Model</td><td colspan="2">Unladen</td><td colspan="2">Laden</td></tr>' +
                            '<tr><td>Front</td><td>Rear</td><td>Front</td><td>Rear</td></tr>'+
                            '</thead>'+
                            '<tbody>';
                        item.pressures.forEach(function(pressure,the_index){
                            let pressure_description = pressure.description;
                            if(pressure.additional_description != null && pressure.additional_description != ''){
                                pressure_description += ' ('+pressure.additional_description+')';
                            }
                            tyres_text += '<tr>'+
                                '<td>'+pressure.rim_size+'</td>'+
                                '<td>'+pressure.tyre_size+'</td>'+
                                '<td>'+pressure_description+'</td>'+
                                '<td><span class="pressure-bar">'+pressure.unladen.front.bar+'</span>'+'<span class="pressure-psi" style="display: none">'+pressure.unladen.front.psi+'</span></td>'+
                                '<td><span class="pressure-bar">'+pressure.unladen.rear.bar+'</span>'+'<span class="pressure-psi" style="display: none">'+pressure.unladen.rear.psi+'</span></td>'+
                                '<td><span class="pressure-bar">'+pressure.laden.front.bar+'</span>'+'<span class="pressure-psi" style="display: none">'+pressure.laden.front.psi+'</span></td>'+
                                '<td><span class="pressure-bar">'+pressure.laden.rear.bar+'</span>'+'<span class="pressure-psi" style="display: none">'+pressure.laden.rear.psi+'</span></td>'+
                                '</tr>';
                        });
                        tyres_text += '</tbody></table></div>';
                    });
                    tyres_text += '</div></div></div></div>';
                    let jacking_points_images =tyres_info.illustrations.jacking_points;
                    if(jacking_points_images!=null) {
                        let jacking_points_html = '<div class="row">';
                        jacking_points_images.forEach(function(jacking_point_image,jacking_ind){
                            let jacking_points_image_id = jacking_point_image.value;
                            var jacking_points = images_array.filter(obj => {
                                return obj.id === jacking_points_image_id
                            });
                            jacking_points = jacking_points[0];
                            jacking_points_html += '<div class="col-6 col-sm-3"><a href="'+jacking_points.url+'" id="'+jacking_points.id+'" data-toggle="lightbox" data-title="Fig. '+jacking_points.id+'" class="tyres-image">' +
                                '<img src="'+jacking_points.url+'" class="img-fluid" alt="Fig. '+jacking_points.id+'">' +
                                '</a></div>';
                            //jacking_points_html += '<img class="img-fluid" src="' + jacking_points.url + '"/>';
                        });
                        jacking_points_html += '</div>';
                        tyres_text += '<div class="card"><div class="card-body"><h3 class="card-title main-title">Jacking points</h3>';
                        tyres_text += jacking_points_html;
                        tyres_text += '</div></div><br/>';
                    }
                    let technical_info = tyres_info.technical_information;
                    tyres_text += '<div class="card"><div class="card-body">';
                    technical_info.forEach(function(item,index){
                        tyres_text += '<h3 class="card-title main-title">'+item.group_name+'</h3>';
                        item.items.forEach(function(an_item,the_index){
                            tyres_text += '<h3 class="card-subtitle sub-title">'+an_item.description+'</h3>'+
                                '<h4>'+an_item.value+'</h4>';
                            if(an_item.note != null) {
                                tyres_text += ' <i class="material-icons" style="cursor: pointer;" onclick="$(\'#technical-notes-'+index+'\').toggle();">info</i>'+
                                    '<div id="technical-notes-'+index+'" style="display: none">';
                                notes_array[an_item.note].notes.forEach(function (item, index) {
                                    tyres_text += '<h5>' + item + '</h5>';
                                });
                                tyres_text += '</div>';
                            }
                        });
                    });
                    tyres_text += '</div></div><br/>';
                    let tyre_pressure_monitoring_systems = tyres_info.tyre_pressure_monitoring_systems;
                    tyres_text += '<div class="card"><div class="card-body"><h3 class="card-title main-title">Tyre pressure monitoring system</h3>';
                    tyre_pressure_monitoring_systems.forEach(function(item,index){
                        tyres_text += '<h3 class="sub-title">'+item.variant_description+'</h3>'+
                            '<div id="accordion-pressure-system-'+index+'" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                            '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-pressure-system-'+index+'-info">' +
                            '<a data-toggle="collapse" data-parent="#accordion-pressure-system-'+index+'" href="#collapse-pressure-system-'+index+'-info" aria-controls="collapse-pressure-system-'+index+'-info">' +
                            'General Information ' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-pressure-system-'+index+'-info" class="collapse" role="tabpanel" aria-labelledby="heading-pressure-system-'+index+'-info">' +
                            '<div class="card-body">' +
                            item.general_information +
                            '</div>' + '</div>' + '</div>'+
                            '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-pressure-system-'+index+'-tools">' +
                            '<a data-toggle="collapse" data-parent="#accordion-pressure-system-'+index+'" href="#collapse-pressure-system-'+index+'-tools" aria-controls="collapse-pressure-system-'+index+'-tools">' +
                            'Special tools ' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-pressure-system-'+index+'-tools" class="collapse" role="tabpanel" aria-labelledby="heading-pressure-system-'+index+'-tools">' +
                            '<div class="card-body">';
                        if(item.special_tools.length > 0) {
                            tyres_text += '<ul>';
                            item.special_tools.forEach(function (tool, the_index) {
                                tyres_text += '<li>' + tool.tool_name + '</li>';
                            });
                            tyres_text += '</ul>';
                        } else {
                            tyres_text += '<p>None</p>';
                        }
                        tyres_text += '</div>' + '</div>' + '</div>';

                        let system_operation = item.system_operation.value;
                        tyres_text += '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-pressure-system-'+index+'-operation">' +
                            '<a data-toggle="collapse" data-parent="#accordion-pressure-system-'+index+'" href="#collapse-pressure-system-'+index+'-operation" aria-controls="collapse-pressure-system-'+index+'-operation">' +
                            'System Operations ' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-pressure-system-'+index+'-operation" class="collapse" role="tabpanel" aria-labelledby="heading-pressure-system-'+index+'-operation">' +
                            '<div class="card-body"> <ul>';
                        system_operation.forEach(function(operation,the_index){
                            tyres_text += '<li> <p>';
                            if(operation.type == 'compound_text'){
                                let operation_text = processCompoundText(operation.value, 'tyres');
                                tyres_text += operation_text;
                            } else if(operation.type == 'text'){
                                tyres_text += operation.value + ' ';
                            } else if(operation.type == 'image'){
                                tyres_text += '<a href="#" class="tyres-image-link" data-image-id="'+operation.value+'" data-image-reference="'+operation.reference+'">( '+operation.reference+' )</a> ';
                            }
                            /*operation.value.forEach(function(operation_item,a_index){
                                if(operation_item.type == 'text'){
                                    tyres_text += operation_item.value + ' ';
                                } else if(operation_item.type == 'image'){
                                    tyres_text += '<a href="#" class="tyres-image-link" data-image-id="'+operation_item.value+'" data-image-reference="'+operation_item.reference+'">( '+operation_item.reference+' )</a> ';
                                }
                            });*/
                            tyres_text += '</p> </li>';
                        });
                        tyres_text += '</ul> </div>' + '</div>' + '</div>';

                        let procedure_groups = item.procedure_groups;
                        //tyres_text += '<h3 class="sub-sub-title">Procedures</h3>';
                        procedure_groups.forEach(function(procedure_group,the_index){
                            tyres_text += '<div class="card">' +
                                '<div class="card-header" role="tab" id="heading-pressure-system-'+index+'-procedure-'+the_index+'">' +
                                '<a data-toggle="collapse" data-parent="#accordion-pressure-system-'+index+'" href="#collapse-pressure-system-'+index+'-procedure-'+the_index+'" aria-controls="collapse-pressure-system-'+index+'-procedure-'+the_index+'">' +
                                procedure_group.title + '<i class="material-icons">keyboard_arrow_down</i>' +
                                '</a>' + '</div>' +
                                '<div id="collapse-pressure-system-'+index+'-procedure-'+the_index+'" class="collapse" role="tabpanel" aria-labelledby="heading-pressure-system-'+index+'-procedure-'+the_index+'">' +
                                '<div class="card-body">';
                            procedure_group.procedures.forEach(function(procedure,proc_index){
                                let procedure_text = processTyreProcedure(procedure, the_index, proc_index, 'procedure');
                                tyres_text += procedure_text;
                                /*tyres_text += '<h5 class="card-title">'+procedure.title+'</h5> <ul>';
                                procedure.steps.forEach(function(step,a_index){
                                    let the_step = step.value;
                                    let step_text = '';
                                    if(the_step.type == 'text'){
                                        step_text = the_step.value;
                                    } else if(the_step.type == 'image'){
                                        step_text += '<a href="#" class="tyres-image-link" data-image-id="'+the_step.value+'" data-image-reference="'+the_step.reference+'">( '+the_step.reference+' )</a> ';
                                    } else if(the_step.type == 'compound_text'){
                                        the_step.value.forEach(function(sub_step,b_index){
                                            if(sub_step.type == 'text'){
                                                step_text += sub_step.value;
                                            } else if(sub_step.type == 'image'){
                                                step_text += '<a href="#" class="tyres-image-link" data-image-id="'+sub_step.value+'" data-image-reference="'+sub_step.reference+'">( '+sub_step.reference+' )</a> ';
                                            }
                                        });
                                    }
                                    tyres_text += '<li>'+step_text+'</li>';
                                });
                                tyres_text += '</ul>';*/
                            });
                            tyres_text += '</div> </div> </div>';
                        });
                        tyres_text += '</div>';
                    });

                    tyres_text += '<div class="row">';
                    images_array.forEach(function(image, index) {
                        tyres_text += '<div class="col-3"><a href="'+image.url+'" id="'+image.id+'" data-toggle="lightbox" data-title="Fig. '+image.id+'" class="tyres-image">' +
                            '<img src="'+image.url+'" class="img-fluid" alt="Fig. '+image.id+'">' +
                            '</a></div>';
                    });
                    tyres_text += '</div>';
                    tyres_text += '</div></div></div>';

                    $('#tyres-section').html(tyres_text);

                    $('.tyres-image').on('click', function(event) {
                        event.preventDefault();
                        $(this).ekkoLightbox();
                    });
                    $('.tyres-image-link').on('click',function(e) {
                        e.preventDefault();
                        $('#'+($(this).data('image-id'))).click();
                        //console.log($(this).data('image-reference'));
                    });

                    $('.selectpicker').selectpicker();
                }
            });
        }

        function changePressure(index,val){
            var pressure_show = 'bar';
            var pressure_hide = 'psi';
            if(val=='psi'){
                pressure_show = 'psi';
                pressure_hide = 'bar';
            }
            $('#pressures-'+index+' .pressure-'+pressure_show).show();
            $('#pressures-'+index+' .pressure-'+pressure_hide).hide();
        }

        function getBatteryDetails(){
            $.ajax({
                url: '{{url('api/get-batteries-info')}}',
                data: {
                    mid: mid,
                    csrfmiddlewaretoken: '{{ csrf_token() }}'
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    let batteries_info = data.batteries_info;
                    let batteries_text = '<div id="accordion-battery-replacements" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                        '<div class="card">' +
                        '<div class="card-header" role="tab" id="heading-battery-replacements">' +
                        '<a data-toggle="collapse" data-parent="#accordion-battery-replacements" href="#collapse-battery-replacements" aria-controls="collapse-battery-replacements">' +
                        'Battery Replacements' + '<i class="material-icons">keyboard_arrow_down</i>' +
                        '</a>' + '</div>' +
                        '<div id="collapse-battery-replacements" class="collapse" role="tabpanel" aria-labelledby="heading-battery-replacements">' +
                        '<div id="battery-replacements-area" class="card-body">';
                    let only_one = false;
                    if(batteries_info.length == 1){
                        only_one = true;
                    }
                    batteries_info.forEach(function(battery, index){
                        let battery_description = 'Main';
                        if(battery.battery_replacement_description != ''){
                            battery_description = battery.battery_replacement_description;
                        }
                        if(only_one){
                            batteries_text +=
                                '<div id="battery-' + index + '-info-area">' +
                                battery.battery_replacement_id +
                                '</div>';
                        } else {
                            batteries_text +=
                                '<div id="accordion-battery-' + index + '" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                                '<div class="card">' +
                                '<div class="card-header" role="tab" id="heading-battery-' + index + '-info">' +
                                '<a data-toggle="collapse" data-parent="#accordion-battery-' + index + '" href="#collapse-battery-' + index + '-info" aria-controls="collapse-battery-' + index + '-info">' +
                                battery_description + '<i class="material-icons">keyboard_arrow_down</i>' +
                                '</a>' + '</div>' +
                                '<div id="collapse-battery-' + index + '-info" class="collapse" role="tabpanel" aria-labelledby="heading-battery-' + index + '-info">' +
                                '<div id="battery-' + index + '-info-area" class="card-body">' +
                                battery.battery_replacement_id +
                                '</div>' + '</div>' + '</div>' + '</div>';
                        }
                    });
                    batteries_text += '</div> </div> </div> </div>';
                    $('#batteries-section').html(batteries_text);
                    batteries_info.forEach(function(battery, index){
                        setTimeout(getSingleBatteryDetails(battery.battery_replacement_id,index) , 1000);
                    });
                }
            });
        }

        function getSingleBatteryDetails(battery_id,battery_index){
            $.ajax({
                url: '{{url('api/get-battery-info')}}',
                data: {
                    mid: mid,
                    variant_id: battery_id,
                    csrfmiddlewaretoken: '{{ csrf_token() }}'
                },
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    let battery_info = data.battery_info;
                    console.log(battery_info);
                    let battery_text = '';
                    let the_images = battery_info.__images;
                    let images_array = [];
                    the_images.forEach(function(item,index){
                        //images_array[item.id] = item.graphic.url;
                        images_array.push({'id':item.id,'url':item.graphic.url});
                    });
                    let battery_location =battery_info.battery_location;
                    if(battery_location!=null) {
                        battery_location = battery_location.value[0];
                        if (battery_location.type == 'compound_text') {
                            battery_location = battery_location.value;
                        }
                        battery_text += '<div id="accordion-battery-' + battery_index + '-location" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                            '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-battery-' + battery_index + '-location">' +
                            '<a data-toggle="collapse" data-parent="#accordion-battery-' + battery_index + '-location" href="#collapse-battery-' + battery_index + '-location" aria-controls="collapse-battery-' + battery_index + '-location">' +
                            'Battery location' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-battery-' + battery_index + '-location" class="collapse" role="tabpanel" aria-labelledby="heading-battery-' + battery_index + '-location">' +
                            '<div id="battery-' + battery_index + '-location-area" class="card-body">';
                        battery_location.forEach(function (batt_img_sect, ind) {
                            if (batt_img_sect.type == 'image') {
                                let battery_location_image_id = batt_img_sect.value;
                                var battery_location = images_array.filter(obj => {
                                    return obj.id === battery_location_image_id
                                });
                                battery_location = battery_location[0];
                                //battery_text += '<div class="card"><div class="card-body"><h2 class="card-title main-title">Battery location</h2>';
                                battery_text += '<img class="img-fluid" src="' + battery_location.url + '"/>';
                                //battery_text += '</div></div><br/>';
                            }
                        });
                        battery_text += '</div>' + '</div>' + '</div>' + '</div>';
                    }
                    let general_info = battery_info.general_information;
                    if(general_info!=null) {
                        battery_text += '<div id="accordion-battery-' + battery_index + '-general-info" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                            '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-battery-' + battery_index + '-general-info">' +
                            '<a data-toggle="collapse" data-parent="#accordion-battery-' + battery_index + '-general-info" href="#collapse-battery-' + battery_index + '-general-info" aria-controls="collapse-battery-' + battery_index + '-general-info">' +
                            'General information' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-battery-' + battery_index + '-general-info" class="collapse" role="tabpanel" aria-labelledby="heading-battery-' + battery_index + '-general-info">' +
                            '<div id="battery-' + battery_index + '-general-info-area" class="card-body">';
                        general_info.value.forEach(function (step, ind) {
                            if (step.type == 'compound_text') {
                                let step_text = processCompoundText(step.value, 'batteries', true);
                                battery_text += step_text;
                            } else if (step.type == 'text') {
                                battery_text += '<p>'+step.value+'</p>';
                            }
                        });
                        if(general_info.warnings != null && general_info.warnings.length > 0){
                            console.log(general_info.warnings);
                        }
                        battery_text += '</div>' + '</div>' + '</div>' + '</div>';
                    }
                    let precautions = battery_info.precautions;
                    if(precautions!=null) {
                        battery_text += '<div id="accordion-battery-' + battery_index + '-precautions" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                            '<div class="card">' +
                            '<div class="card-header" role="tab" id="heading-battery-' + battery_index + '-precautions">' +
                            '<a data-toggle="collapse" data-parent="#accordion-battery-' + battery_index + '-precautions" href="#collapse-battery-' + battery_index + '-precautions" aria-controls="collapse-battery-' + battery_index + '-precautions">' +
                            'Precautions' + '<i class="material-icons">keyboard_arrow_down</i>' +
                            '</a>' + '</div>' +
                            '<div id="collapse-battery-' + battery_index + '-precautions" class="collapse" role="tabpanel" aria-labelledby="heading-battery-' + battery_index + '-precautions">' +
                            '<div id="battery-' + battery_index + '-info-area" class="card-body">';
                        precautions.value.forEach(function (step, ind) {
                            if (step.type == 'compound_text') {
                                let step_text = processCompoundText(step.value, 'batteries', true);
                                battery_text += step_text;
                            } else if (step.type == 'text') {
                                battery_text += '<p>'+step.value+'</p>';
                            }
                        });
                        battery_text += '</div>' + '</div>' + '</div>' + '</div>';
                    }
                    let procedures = battery_info.procedures;
                    if(procedures!=null){
                        procedures.forEach(function(procedure, ind){
                            let procedure_text = processBatteryProcedure(procedure, battery_index, ind, 'procedure');
                            battery_text += procedure_text;
                        });
                    }

                    battery_text += '<div class="row">';
                    images_array.forEach(function(image, index) {
                        battery_text += '<div class="col-3"><a href="'+image.url+'" id="'+image.id+'" data-toggle="lightbox" data-title="Fig. '+image.id+'" class="batteries-image">' +
                            '<img src="'+image.url+'" class="img-fluid" alt="Fig. '+image.id+'">' +
                            '</a></div>';
                    });
                    battery_text += '</div>';

                    $('#battery-'+battery_index+'-info-area').html(battery_text);

                    $('.batteries-image').on('click', function(event) {
                        event.preventDefault();
                        $(this).ekkoLightbox();
                    });
                    $('.batteries-image-link').on('click',function(e) {
                        e.preventDefault();
                        $('#'+($(this).data('image-id'))).click();
                        //console.log($(this).data('image-reference'));
                    });
                }
            });
        }

        function processCompoundText(text_arr, link_type, new_lines=false){
            let step_text = '';
            text_arr.forEach(function(step,index){
                if(new_lines){
                    step_text += '<p>';
                }
                if(step.type == 'text'){
                    step_text += step.value;
                } else if(step.type == 'image'){
                    let image_ref_text = ''+step.value;
                    if(step.reference != null){
                        image_ref_text += ' ( '+step.reference+' )';
                    }
                    step_text += '<a href="#" class="'+link_type+'-image-link" data-image-id="'+step.value+'">'+image_ref_text+'</a> ';
                } else if(step.type == 'compound_text'){
                    let sub_step_text = processCompoundText(step.value, link_type, new_lines);
                    step_text += sub_step_text;
                }
                if(new_lines){
                    step_text += '</p>';
                }
            });
            return step_text;
        }

        function processCompoundStep(step_arr, link_type, new_lines=false){
            let step_text = '';
            step_arr.forEach(function(step,index){
                if(new_lines){
                    step_text += '<p>';
                }
                if(step.kind == 'step' || step.kind == 'substep'){
                    if(step.kind == 'substep') {
                        step_text += '<ul> <li>';
                    }
                    let step_val = step.value;
                    if(step_val.type == 'text'){
                        step_text += step_val.value;
                    } else if(step_val.type == 'image'){
                        let image_ref_text = ''+step_val.value;
                        if(step_val.reference != null){
                            image_ref_text += ' ( '+step_val.reference+' )';
                        }
                        step_text += '<a href="#" class="'+link_type+'-image-link" data-image-id="'+step_val.value+'">'+image_ref_text+'</a> ';
                    } else if (step_val.type == 'compund_text') {
                        let sub_step_text = processCompoundText(step_val.value, link_type, new_lines);
                        step_text += sub_step_text;
                    } else {
                        step_text += step.value;
                    }
                    if(step.kind == 'substep') {
                        step_text += ' </li> </ul>';
                    }
                } else if(step.kind == 'image'){
                    let image_ref_text = ''+step.value;
                    if(step.reference != null){
                        image_ref_text += ' ( '+step.reference+' )';
                    }
                    step_text += '<a href="#" class="'+link_type+'-image-link" data-image-id="'+step.value+'">'+image_ref_text+'</a> ';
                } else if(step.kind == 'compound_step' || step.kind == 'compound_text'){
                    let sub_step_text = processCompoundStep(step.value, link_type, new_lines);
                    step_text += sub_step_text;
                }
                if(new_lines){
                    step_text += '</p>';
                }
            });
            return step_text;
        }

        function processBatteryProcedure(procedure, battery_index, the_index, procedure_type){
            let battery_text = '';
            battery_text += '<div id="accordion-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                '<div class="card">' +
                '<div class="card-header" role="tab" id="heading-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '">' +
                '<a data-toggle="collapse" data-parent="#accordion-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '" href="#collapse-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '" aria-controls="collapse-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '">' +
                procedure.title + '<i class="material-icons">keyboard_arrow_down</i>' +
                '</a>' + '</div>' +
                '<div id="collapse-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '" class="collapse" role="tabpanel" aria-labelledby="heading-battery-' + battery_index + '-' + procedure_type + '-' + the_index + '">' +
                '<div id="battery-' + battery_index + '-' + procedure_type + '-' + the_index + '-area" class="card-body">';
            procedure.procedures.forEach(function(sub_procedure, sub_procedure_ind){
                let the_procedure_type = 'sub-procedure';
                if(procedure_type == 'sub-procedure'){
                    the_procedure_type = 'sub-sub-procedure';
                } else if (procedure_type == 'sub-sub-procedure'){
                    the_procedure_type = 'sub-sub-sub-procedure';
                }
                let sub_procedure_html = processBatteryProcedure(sub_procedure, battery_index, sub_procedure_ind, the_procedure_type);
                battery_text += sub_procedure_html;
            });
            procedure.steps.forEach(function(step, step_ind){
                let step_val = step.value;
                if (step.kind == 'step') {
                    if(step_val.type=='text') {
                        battery_text += '<p>'+step_val.value+'</p>';
                    } else if (step_val.type=='compound_text') {
                        let compound_text_html = processCompoundText(step_val.value, 'batteries');
                        battery_text += compound_text_html;
                    } else {
                        console.log('UNKNOWN BATTERY PROCEDURE STEP VALUE!:');
                        console.log(step);
                    }
                } else if (step.kind == 'note' || step.kind == 'warning') {
                    if(step_val.type=='text') {
                        battery_text += '<div class="alert alert-warning" role="alert">' +
                            step_val.value + '</div>';
                    } else if (step_val.type=='compound_text') {
                        let compound_text_html = processCompoundText(step_val.value, 'batteries');
                        battery_text += compound_text_html;
                    } else {
                        console.log('UNKNOWN BATTERY PROCEDURE NOTE VALUE!:');
                        console.log(step);
                    }
                } else if (step.kind == 'compound_step') {
                    let compound_text_html = processCompoundStep(step.value, 'batteries');
                    battery_text += compound_text_html;
                }
            });
            battery_text += '</div>' + '</div>' + '</div>' + '</div>';
            return battery_text;
        }

        function processTyreProcedure(procedure, tyre_index, the_index, procedure_type){
            let tyres_text = '';
            tyres_text += '<div id="accordion-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '" role="tablist" aria-multiselectable="true" class="card-collapse">' +
                '<div class="card">' +
                '<div class="card-header" role="tab" id="heading-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '">' +
                '<a data-toggle="collapse" data-parent="#accordion-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '" href="#collapse-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '" aria-controls="collapse-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '">' +
                procedure.title + '<i class="material-icons">keyboard_arrow_down</i>' +
                '</a>' + '</div>' +
                '<div id="collapse-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '" class="collapse" role="tabpanel" aria-labelledby="heading-tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '">' +
                '<div id="tyre-' + tyre_index + '-' + procedure_type + '-' + the_index + '-area" class="card-body">';
            procedure.procedures.forEach(function(sub_procedure, sub_procedure_ind){
                let the_procedure_type = 'sub-procedure';
                if(procedure_type == 'sub-procedure'){
                    the_procedure_type = 'sub-sub-procedure';
                } else if (procedure_type == 'sub-sub-procedure'){
                    the_procedure_type = 'sub-sub-sub-procedure';
                }
                let sub_procedure_html = processTyreProcedure(sub_procedure, tyre_index, sub_procedure_ind, the_procedure_type);
                tyres_text += sub_procedure_html;
            });
            procedure.steps.forEach(function(step, step_ind){
                let step_val = step.value;
                if (step.kind == 'step') {
                    if(step_val.type=='text') {
                        tyres_text += '<p>'+step_val.value+'</p>';
                    } else if (step_val.type=='compound_text') {
                        let compound_text_html = processCompoundText(step_val.value, 'tyres');
                        tyres_text += compound_text_html;
                    } else {
                        console.log('UNKNOWN TYRE PROCEDURE STEP VALUE!:');
                        console.log(step);
                    }
                } else if (step.kind == 'note' || step.kind == 'warning') {
                    if(step_val.type=='text') {
                        tyres_text += '<div class="alert alert-warning" role="alert">' +
                            step_val.value + '</div>';
                    } else if (step_val.type=='compound_text') {
                        let compound_text_html = processCompoundText(step_val.value, 'tyres');
                        tyres_text += compound_text_html;
                    } else {
                        console.log('UNKNOWN TYRE PROCEDURE NOTE VALUE!:');
                        console.log(step);
                    }
                } else if (step.kind == 'compound_step') {
                    let compound_text_html = processCompoundStep(step.value, 'tyres');
                    tyres_text += compound_text_html;
                }
            });
            tyres_text += '</div>' + '</div>' + '</div>' + '</div>';
            return tyres_text;
        }

        function scrollToTheTop(){
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
@endsection