<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GardenHelp Contractors Registration</title>

    <!--    <link href="public/css/bootstrap.min.css" rel="stylesheet">-->

    <style>
        html, body {
            /*height: 100%;*/
            margin: 0px;
        }
        .main {
            height: 100%;
            padding-top: 60px;
            padding-bottom: 60px;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            border-radius: 20px;
            box-shadow: 0 20px 20px 0 rgba(0, 0, 0, 0.08);
            background-color: #ffffff;

            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 720px;
        }
        .container-header {
            text-align: center;
            padding-bottom: 25px;
            border-bottom: 1px solid #f2f2f2;
        }

        .container-header img {
            margin-top: -30px;
        }

        .container-body {
            text-align: center;
            padding-bottom: 60px;
        }

        tr {
            height: 25px;
        }

        td{
            text-align: start;
        }

        th {
            color: #8a6d3c;
            text-align: start;
        }

        .download-btn {

        }

        .body-titles {
            font-size: 21px;
            font-weight: 500;
            font-stretch: normal;
            font-style: normal;
            line-height: 2.14;
            letter-spacing: 0.2px;
            color: #60a244;
        }

        .content {
            padding-left: 75px;
        }
    </style>
</head>
<body>
<section class="main">
    <div class="container">
        <div class="container-header">
            <img src="{{asset('images/Garden-Help-Logo.png')}}" alt="GardenHelp">
        </div>
        <br>
        <div class="container-body">
            <section class="body-titles">
                <h3>
                    Contractor Registration Data
                </h3>
            </section>
            <section class="content">
                <table style="width:100%">
                    <tr>
                        <th>Name:</th>
                        <td>{{$contractor_registration->name}}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>
                            <a href="mailto:{{$contractor_registration->email}}">{{$contractor_registration->email}}</a>
                        </td>
                    </tr>
                    <tr>
                        <th>Experience Level:</th>
                        <td>{{$contractor_registration->experience_level}}</td>
                    </tr>

                    @if($contractor_registration->age_proof)
                        <tr>
                            <th>Age Proof:</th>
                            <td>
                                <a href="{{asset('age_proof')}}" class="download-btn">
                                    Click to Download Age proof file
                                </a>
                            </td>
                        </tr>
                    @endif

                    @if($contractor_registration->type_of_work_exp)
                        <tr>
                            <th>Type Of Experience:</th>
                            <td>{{$contractor_registration->type_of_work_exp}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->cv)
                        <tr>
                            <th>CV:</th>
                            <td>
                                <a href="{{asset($contractor_registration->cv)}}" class="download-btn">
                                    Click to Download cv file
                                </a>
                            </td>
                        </tr>
                    @endif

                    @if($contractor_registration->job_reference)
                        <tr>
                            <th>Job Reference:</th>
                            <td>
                                <a href="{{asset($contractor_registration->job_reference)}}" class="download-btn">
                                    Click to Download job reference file
                                </a>
                            </td>
                        </tr>
                    @endif

                    @if($contractor_registration->available_equipments)
                        <tr>
                            <th>Available Equipments:</th>
                            <td>{{$contractor_registration->available_equipments}}</td>
                        </tr>
                    @endif

                    <tr>
                        <th>Address:</th>
                        <td>{{$contractor_registration->address}}</td>
                    </tr>

                    <tr>
                        <th>Company Number:</th>
                        <td>{{$contractor_registration->company_number}}</td>
                    </tr>

                    <tr>
                        <th>Vat Number:</th>
                        <td>{{$contractor_registration->vat_number}}</td>
                    </tr>

                    @if($contractor_registration->insurance_document)
                        <tr>
                            <th>Insurance Document:</th>
                            <td>
                                <a href="{{asset($contractor_registration->insurance_document)}}" class="download-btn">
                                    Click to Download insurance document file
                                </a>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <th>Has a smartphone?:</th>
                        <td>{{$contractor_registration->has_smartphone ? 'Yes' : 'No'}}</td>
                    </tr>

                    @if($contractor_registration->type_of_transport)
                        <tr>
                            <th>Type of transport:</th>
                            <td>{{$contractor_registration->type_of_transport}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->charge_type)
                        <tr>
                            <th>Charge Type:</th>
                            <td>{{$contractor_registration->charge_type}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->charge_rate)
                        <tr>
                            <th>Charge Rate:</th>
                            <td>{{$contractor_registration->charge_rate}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->has_callout_fee)
                        <tr>
                            <th>Has a callout fee?:</th>
                            <td>{{$contractor_registration->has_callout_fee ? 'Yes' : 'No'}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->callout_fee_value)
                        <tr>
                            <th>Callout fee charge?:</th>
                            <td>{{$contractor_registration->callout_fee_value}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->rate_of_green_waste)
                        <tr>
                            <th>Green waste collection waste:</th>
                            <td>{{$contractor_registration->rate_of_green_waste}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->green_waste_collection_method)
                        <tr>
                            <th>Green waste collection method:</th>
                            <td>{{$contractor_registration->green_waste_collection_method}}</td>
                        </tr>
                    @endif

                    @if($contractor_registration->social_profile)
                        <tr>
                            <th>Social Profile:</th>
                            <td>
                                <a href="{{$contractor_registration->social_profile}}">
                                    {{$contractor_registration->social_profile}}
                                </a>
                            </td>
                        </tr>
                    @endif

                    @if($contractor_registration->website)
                        <tr>
                            <th>Website:</th>
                            <td>
                                <a href="{{asset($contractor_registration->website)}}">
                                    {{$contractor_registration->social_profile}}
                                </a>
                            </td>
                        </tr>
                    @endif
                </table>
            </section>
        </div>

    </div>
</section>
</body>
</html>
