
<table class="table table-bordered text-center">
    <tr>
        <th colspan="18" style="font-size: 16px;text-align: center;font-weight: bold;padding: 10px;">Dreiver Report</th>
    </tr>
<thead>
    <tr >
        <th style="width:160px">User name</th>
        <th style="width:160px">Email</th>
        <th style="width:160px">Phone</th>
        <th style="width:160px">Date Of Birth</th>
        <th style="width:160px">Address</th>
        <th style="width:160px">Postcode</th>
        <th style="width:160px" >PPS Number</th>
        <th style="width:160px" >Emergency Contact Name</th>
        <th style="width:160px" >Emergency Contact Number</th>
        <th style="width:160px" >Transport</th>
        <th style="width:160px" >Max Package Size</th>
        <th style="width:160px" >Max Package Weight</th>
        <th style="width:160px" >Work Location</th>
        <th style="width:160px" >Legal WordEvidence</th>
        <th style="width:160px" >driver_license</th>
        <th style="width:160px" >driver_license_back</th>
        <th style="width:160px" >insurance_proof</th>
        <th style="width:160px" >address_proof</th>
    </tr>
    </thead>
    <tbody>
    @if(count($items))
        @foreach($items as $item)
            <tr>
                <td style="width:160px" >{{$item->user->name}}</td>
                <td style="width:160px" >{{$item->user->email}}</td>
                <td style="width:160px" >{{$item->user->phone}}</td>
                <td style="width:160px" >{{$item->dob}}</td>
                <td style="width:160px" >{{$item->address}}</td>
                <td style="width:160px" >{{$item->postcode}}</td>
                <td style="width:160px" >{{$item->pps_number}}</td>
                <td style="width:160px" >{{$item->emergency_contact_name}}</td>
                <td style="width:160px" >{{$item->emergency_contact_number}}</td>
                <td style="width:160px" >{{$item->transport}}</td>
                <td style="width:160px" >{{$item->max_package_size}}</td>
                <td style="width:160px" >{{$item->max_package_weight}}</td>
                <td style="width:160px" >{{json_decode($item->work_location)->name}}</td>
                <td style="width:160px" ><a href="{{ asset($item->legal_word_evidence)}}">Download</a></td>
                <td style="width:160px" ><a href="{{ asset($item->driver_license)}}">Download</a></td>
                <td style="width:160px" ><a href="{{ asset($item->driver_license_back)}}">Download</a></td>
                <td style="width:160px" ><a href="{{ asset($item->insurance_proof)}}">Download</a></td>
                <td style="width:160px" ><a href="{{ asset($item->address_proof)}}">Download</a></td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>
            

