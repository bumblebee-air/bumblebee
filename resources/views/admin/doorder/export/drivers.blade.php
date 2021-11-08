
<table class="table table-bordered text-center">
    <tr>
        <th colspan="18" style="font-size: 16px;text-align: center;font-weight: bold;padding: 10px;">retailers Report</th>
    </tr>
<thead>
    <tr >
        <th style="width:120px">User name</th>
        <th style="width:120px">Email</th>
        <th style="width:120px">Phone</th>
        <th style="width:120px">Date Of Birth</th>
        <th style="width:120px">Address</th>
        <th style="width:120px">Postcode</th>
        <th style="width:120px" >PPS Number</th>
        <th style="width:120px" >Emergency Contact Name</th>
        <th style="width:120px" >Emergency Contact Number</th>
        <th style="width:120px" >Transport</th>
        <th style="width:120px" >Max Package Size</th>
        <th style="width:120px" >Max Package Weight</th>
        <th style="width:120px" >Work Location</th>
        <th style="width:120px" >Legal WordEvidence</th>
        <th style="width:120px" >driver_license</th>
        <th style="width:120px" >driver_license_back</th>
        <th style="width:120px" >insurance_proof</th>
        <th style="width:120px" >address_proof</th>
    </tr>
    </thead>
    <tbody>
    @if(count($items))
        @foreach($items as $item)
            <tr>
                <td style="width:120px" >{{$item->user->name}}</td>
                <td style="width:120px" >{{$item->user->email}}</td>
                <td style="width:120px" >{{$item->user->phone}}</td>
                <td style="width:120px" >{{$item->dob}}</td>
                <td style="width:120px" >{{$item->address}}</td>
                <td style="width:120px" >{{$item->postcode}}</td>
                <td style="width:120px" >{{$item->pps_number}}</td>
                <td style="width:120px" >{{$item->emergency_contact_name}}</td>
                <td style="width:120px" >{{$item->emergency_contact_number}}</td>
                <td style="width:120px" >{{$item->transport}}</td>
                <td style="width:120px" >{{$item->max_package_size}}</td>
                <td style="width:120px" >{{$item->max_package_weight}}</td>
                <td style="width:120px" >{{json_decode($item->work_location)->name}}</td>
                <td style="width:120px" ><a href="{{ asset($item->legal_word_evidence)}}">Download</a></td>
                <td style="width:120px" ><a href="{{ asset($item->driver_license)}}">Download</a></td>
                <td style="width:120px" ><a href="{{ asset($item->driver_license_back)}}">Download</a></td>
                <td style="width:120px" ><a href="{{ asset($item->insurance_proof)}}">Download</a></td>
                <td style="width:120px" ><a href="{{ asset($item->address_proof)}}">Download</a></td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>
            

