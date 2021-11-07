
                <table class="table table-bordered text-center">
                        <tr>
                            <th colspan="7" style="font-size: 16px;text-align: center;font-weight: bold;padding: 10px;">retailers Report</th>
                        </tr>
                    <thead>
                    <tr style="background-color:#c4c4c4;color:#000">
                        <th style="vertical-align: middle;width: 15%;text-align: center">User name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Email</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Phone</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Company Name</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Company Website</th>
                        <th style="vertical-align: middle;width: 15%;text-align: center">Business Type</th>
                        <th colspan="4" style="vertical-align: middle;width: 15%;text-align: center">Location</th>
                        <th colspan="4" style="vertical-align: middle;width: 15%;text-align: center">Contact Information</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($items))
                        @foreach($items as $item)
                            <tr>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->name}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->email}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->user->phone}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->name}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->company_website}}</td>
                                <td style="vertical-align: middle;text-align: center">{{$item->business_type}}</td>
                               <td colspan="4" style="vertical-align: middle;text-align: center">
                                    <div>
                                        @foreach (json_decode($item->locations_details) as $location)
                                            <ul>
                                                <li>Address : {{$location->address}}</li>
                                                <li>Eircode : {{$location->eircode}}</li>
                                                <li>Country : {{$location->country}}</li>
                                                <li>County : {{json_decode($location->county)->name}}</li>
                                            </ul>
                                            
                                        @endforeach
                                    </div>
                                </td>
                                <td colspan="4" style="vertical-align: middle;text-align: center">
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
            

