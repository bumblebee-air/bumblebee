
                <table class="table table-bordered text-center">
                        <tr>
                            <th colspan="7" style="font-size: 16px;text-align: center;font-weight: bold;padding: 10px;">retailers Report</th>
                        </tr>
                    <thead>
                    <tr style="background-color:#c4c4c4;color:#000">
                        <th style="vertical-align: middle;width: 15%;text-align: center">User name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Email</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Phone</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Date Of Birth</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Address</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Postcode</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">PPS Number</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Emergency Contact Name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Emergency Contact Number</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Transport</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Max Package Size</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Max Package Weight</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Work Location</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Legal WordEvidence</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">driver_license</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">driver_license_back</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">insurance_proof</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">address_proof</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($items))
                        @foreach($items as $item)
                            <tr>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->name}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->email}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->phone}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->dob}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->address}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->postcode}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->pps_number}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->emergency_contact_name}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->emergency_contact_number}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->transport}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->max_package_size}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->max_package_weight}}</td>
                                <td style="vertical-align: middle;text-align: center">{{json_decode($item->work_location)->name}}</td>
                                <td style="vertical-align: middle;text-align: center"><a href="{{ asset($item->legal_word_evidence)}}">Download</a></td>
                                <td style="vertical-align: middle;text-align: center"><a href="{{ asset($item->driver_license)}}">Download</a></td>
                                <td style="vertical-align: middle;text-align: center"><a href="{{ asset($item->driver_license_back)}}">Download</a></td>
                                <td style="vertical-align: middle;text-align: center"><a href="{{ asset($item->insurance_proof)}}">Download</a></td>
                                <td style="vertical-align: middle;text-align: center"><a href="{{ asset($item->address_proof)}}">Download</a></td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            

