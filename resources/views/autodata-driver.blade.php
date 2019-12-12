@extends('templates.rrra')

@section('page-styles')
    <style>
        :root {
            --input-padding-x: 1.5rem;
            --input-padding-y: .75rem;
        }

        body {
            background: #eee;
            /*background: linear-gradient(to right, #0062E6, #33AEFF);*/
        }

        .card-signin {
            border: 0;
            border-radius: 1rem;
            background: #eee;
            /*box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);*/
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
            /*font-size: 90%;*/
            border-radius: 5rem;
            /*letter-spacing: .1rem;*/
            font-weight: 700;
            padding: 1rem;
            transition: all 0.2s;
        }

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
    </style>
    <link href="{{asset('css/ekko-lightbox.css')}}" type="text/css" rel="stylesheet" />
@endsection
@section('page-content')
    <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
            <div class="card card-signin my-1">
                <div class="card-body">
                    <div class="form-signin">
                        {{csrf_field()}}

                        <div class="form-label-group">
                            <input id="vehicle-reg" class="form-control" name="vehicle_reg" placeholder="Vehicle Reg" required>
                            <label for="vehicle-reg">Vehicle Reg</label>
                        </div>
                        <div class="form-label-group" id="vehicle-form" style="margin: 0px !important;">
                        </div>

                        <button class="btn btn-lg btn-primary btn-block text-uppercase" id="vehicle-check" role="button">Submit</button>
                    </div>
                </div>
            </div>
            <h3>Powered by</h3>
            <img class="img-fluid" src="{{asset('images/autodata-logo.svg')}}"/>
        </div>
    </div>
    <div class="row">
        <div id="tyres-section">
        </div>
    </div>
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
                                    $('#vehicle-form').after('<div class="form-group vehicle-info"><div>' +
                                        '<label class="orange-header control-label">' +
                                        'Error: ' + response.error_bag['response'] + '<br/>' + response.error_bag['error'] +
                                        '</label>' +
                                        '</div></div>');
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
                                    $('#vehicle-form').after(vehicleInfoItem('External ID', external_id, 'external_id', true));
                                    //$('#vehicle-form').after(vehicleInfoItem('Colour', colour, 'colour'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Transmission', transmission, 'transmission'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Fuel', fuel, 'fuel'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Engine Size', engineSize, 'engine-size'));
                                    //$('#vehicle-form').after(vehicleInfoItem('Version', version, 'version'));
                                    $('#vehicle-form').after(vehicleInfoItem('Model', model, 'model'));
                                    $('#vehicle-form').after(vehicleInfoItem('Make', make, 'make'));

                                    $('#vehicle-form').after('<div class="form-group vehicle-info" style="margin-bottom: 0">' +
                                        '<h4 class="orange-header" style="font-weight: 400">Vehicle Details</h4>' +
                                        '</div>');
                                    getTyreDetails();
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
                    $('.vehicle-info').remove();
                    $('#vehicle-form').after('<div class="form-group vehicle-info">' +
                        '<div><label class="orange-header control-label">' +
                        '<i class="fa fa-sync fa-spin"></i> Retrieving vehicle information</label></div>' +
                        '</div>');
                } else {
                    $('.vehicle-info').remove();
                }
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
                    let tyres_text = '';
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
                    tyres_text += '<h1 class="main-title">Tyre pressures</h1>';
                    pressure_variants.forEach(function(item,index){
                        tyres_text += '<h2 class="sub-title">'+item.variant_description+' ('+item.year_range.year_range+')</h2>'+
                            'Show tyre pressure in ' +
                            '<select class="selectpicker" id="pressure-select-'+index+'" onchange="changePressure('+index+',$(this).val())">' +
                            '<option value="bar">Bar</option>' +
                            '<option value="psi">Psi</option>' +
                            '</select>'+
                            '<table id="pressures-'+index+'" class="table table-bordered">'+
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
                        tyres_text += '</tbody></table>';
                    });
                    tyres_text += '<br/>';
                    let jacking_points_image_id =tyres_info.illustrations.jacking_points[0].value;
                    var jacking_points = images_array.filter(obj => {
                        return obj.id === jacking_points_image_id
                    });
                    jacking_points = jacking_points[0];
                    tyres_text += '<div class="card"><div class="card-body"><h2 class="card-title main-title">Jacking points</h2>';
                    tyres_text += '<img class="img-fluid" src="'+jacking_points.url+'"/>';
                    tyres_text += '</div></div><br/>';
                    let technical_info = tyres_info.technical_information;
                    tyres_text += '<div class="card"><div class="card-body">';
                    technical_info.forEach(function(item,index){
                        tyres_text += '<h2 class="card-title main-title">'+item.group_name+'</h2>';
                        item.items.forEach(function(an_item,the_index){
                            tyres_text += '<h2 class="card-subtitle sub-title">'+an_item.description+'</h2>'+
                                '<h3>'+an_item.value+'</h3>';
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
                    tyres_text += '<div class="card"><div class="card-body"><h2 class="card-title main-title">Tyre pressure monitoring system</h2>';
                    tyre_pressure_monitoring_systems.forEach(function(item,index){
                        tyres_text += '<h2 class="sub-title">'+item.variant_description+'</h2>'+
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
                            '<div class="card-body"> <ul>';
                        item.special_tools.forEach(function(tool,the_index){
                            tyres_text += '<li>'+tool.tool_name+'</li>';
                        });
                        tyres_text += '</ul> </div>' + '</div>' + '</div>';

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
                            operation.value.forEach(function(operation_item,a_index){
                                if(operation_item.type == 'text'){
                                    tyres_text += +operation_item.value+' ';
                                } else if(operation_item.type == 'image'){
                                    tyres_text += '<a href="#" class="tyres-image-link" data-image-id="'+operation_item.value+'" data-image-reference="'+operation_item.reference+'">( '+operation_item.reference+' )</a> ';
                                }
                            });
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
                                '<div class="card-body"> <ul>';
                            procedure_group.procedures.forEach(function(procedure,the_index){
                                tyres_text += '<h5 class="card-title">'+procedure.title+'</h5> <ul>';
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
                                tyres_text += '</ul>';
                            });
                            tyres_text += '</div> </div> </div>';
                        });
                    });

                    tyres_text += '<div class="row">';
                    images_array.forEach(function(image, index) {
                        tyres_text += '<div class="col-3"><a href="'+image.url+'" id="'+image.id+'" data-toggle="lightbox" data-title="Fig. '+image.id+'" class="tyres-image">' +
                            '<img src="'+image.url+'" class="img-fluid" alt="Fig. '+image.id+'">' +
                            '</a></div>';
                    });
                    tyres_text += '</>';

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
    </script>
@endsection