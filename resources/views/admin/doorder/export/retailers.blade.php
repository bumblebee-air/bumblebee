
                <table class="table table-bordered text-center">
                        <tr>
                            <th colspan="7" style="font-size: 16px;text-align: center;font-weight: bold;padding: 10px;">Retailers Report</th>
                        </tr>
                    <thead>
                    <tr style="background-color:#c4c4c4;color:#000">
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">User name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">Email</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">Phone</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">Company Name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">Company Website</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center;width:160px">Business Type</th>
                        <th colspan="4" style="vertical-align: middle;width: 15%;text-align: center;width:160px; ">Location</th>
                        <th colspan="4" style="vertical-align: middle;width: 15%;text-align: center;width:160px; ">Contact Information</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($items))
                        @foreach($items as $item)
                            <tr>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->user->name}}</td>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->user->email}}</td>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->user->phone}}</td>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->name}}</td>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->company_website}}</td>
                                <td style="vertical-align: middle;text-align: center;width:160px">{{$item->business_type}}</td>
                               <td colspan="4" style="vertical-align: middle;text-align: center;width:160px; height:250px">
                                    <div>
                                        @foreach (json_decode($item->locations_details) as $location)
                                            <ul>
                                                <li>Address : {{$location->address}}</li>
                                                <li>Eircode : {{$location->eircode}}</li>
                                                <li>Country : {{$location->country}}</li>
                                                <li>County : {{optional(json_decode($location->county))->name}}</li>
                                            </ul>
                                            
                                        @endforeach
                                    </div>
                                </td>
                                <td colspan="4" style="vertical-align: middle;text-align: center;width:160px; height:250px">
                                    <div>
                                        @foreach (json_decode($item->contacts_details) as $contact)
                                            <ul>
                                                <li>Name : {{ $contact->contact_name }}</li>
                                                <li>Phone : {{ $contact->contact_phone }}</li>
                                                <li>Email : {{ $contact->contact_email }}</li>
                                                <li>Location : {{ $contact->contact_location }}</li>
                                            </ul>
                                        @endforeach
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            

