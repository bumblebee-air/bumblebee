@extends('templates.garden_help')

@section('title', 'GardenHelp | Jobs Board')

@section('styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto Slab" rel="stylesheet">
    <style>
        body {
            background-color: white;
            font-family: "Roboto Slab";
        }
        .main-text-color {
            color: #94B52E;
        }
        .location-icon {
            width: 47px;
            height: 42px;
        }
        .job-details-title {
            font-style: normal;
            font-weight: 500;
            font-size: 13px;
            line-height: 21px;
            color: #979797;
        }
        .job-details-value {
            font-style: normal;
            font-weight: 500;
            font-size: 18px;
            line-height: 21px;
        }

        .job-details {
            border: 1px solid #94B52E;
            border-radius: 20px;
        }
        .type-of-work {
            border-left: 1px solid #94B52E;
        }
        .service-details-section {

        }
        .estimated-price-title {
            font-style: normal;
            font-weight: 600;
            font-size: 12px;
            line-height: 18px;
            color: #656565;
        }
        .card {
            border: 5px solid #F2F2F2;
            box-sizing: border-box;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        a {
            font-style: normal;
            font-weight: bold;
            font-size: 14px;
            line-height: 21px;
            color: #94B52E;
        }

        .pagination {
            background-color: #F3F2F7;
            border-radius: 16px;
        }

        .pagination>.page-item.active>a, .pagination>.page-item.active>a:focus, .pagination>.page-item.active>a:hover, .pagination>.page-item.active>span, .pagination>.page-item.active>span:focus, .pagination>.page-item.active>span:hover {
            background-color: #30BB30;
            border-color: #30BB30;
            color: #fff;
            box-shadow: none;
        }

        .card-img-top {
            object-fit: cover;
            /*width: 299.06px;*/
            width: 100%;
            height: 221.71px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pt-4">
        <h2>Jobs <span class="main-text-color font-weight-bold">List</span></h2>
        <div class="row">
            <div class="col-md-3 col-sm-12 d-flex align-items-stretch" v-for="job in jobs.data">
                <div class="card">
                    <img :src="getImagePath(job.property_photo)" class="card-img-top" alt="job image" v-if="job.property_photo">
                    <img :src="getImagePath('/images/no-image.png')" class="card-img-top" alt="job image" v-else>
                    <div class="card-body">
                        <div class="row job-details">
                            <div class="col d-flex pt-2">
                                <img src="{{asset('images/gardenhelp_icons/commercail-location-image.png/')}}" alt="location" class="location-icon">
                                <div class="pl-2">
                                    <span class="job-details-title">
                                        Location
                                    </span>
                                    <p class="job-details-value">@{{ job.work_location }}</p>
                                </div>
                            </div>
                            <div class="col type-of-work pt-2">
                                <span class="job-details-title">
                                    Type of work
                                </span>
                                <p class="job-details-value">
                                    @{{ job.type_of_work }}
                                </p>
                            </div>
                        </div>
                        <div class="row service-details-section mt-2 mb-2">
                            <div class="col-12 font-weight-bold pl-1 pr-1">
                                Service Details
                            </div>
                            <div class="col-12 pl-1 pr-1">
                                <div class="list-group">
                                    <div class="list-group-item list-group-item-action p-0" v-for="service in JSON.parse(job.services_types_json)">
                                        <i class="fas fa-check-circle main-text-color"></i>
                                        @{{ service.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row b-0">
                            <div class="col-12 pl-1 pr-1">
                                <span class="estimated-price-title">Estimated Price</span>
                                <span class="font-weight-bold main-text-color">@{{ getTotalPrice(job) }}</span>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col pl-1">
                                <span class="estimated-price-title">Property Size</span>
                                <p>
                                    @{{ job.property_size }}
                                </p>
                            </div>
                            <div class="col pr-1">
                                <a href="{{route('getCustomerRegistration', ['garden-help'])}}" class="float-right" v-if="job.contractor_id && job.contractor">
                                    ASSIGNED
                                    <span class="text-gray">
                                        @{{ job.contractor.name }}
                                    </span>
                                </a>
                                <a href="{{route('getCustomerRegistration', ['garden-help'])}}" class="float-right" v-else>APPLY FOR JOB <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            {{$jobs->links()}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data() {
                return {
                    jobs: {!! json_encode($jobs) !!}
                }
            },
            methods: {
                getImagePath(image) {
                    return location.protocol + '//' +location.hostname + '/' + image;
                },
                getTotalPrice(job) {
                    let property_size = job.property_size;
                    property_size = property_size.replace(' Square Meters', '');
                    let total_price = 0
                    let services_types = job.services_types_json ? JSON.parse(job.services_types_json) : [];
                    console.log(services_types);
                    for (let type of services_types) {
                        let rate_property_sizes = JSON.parse(type.rate_property_sizes);
                        for (let rate of rate_property_sizes) {
                            let size_from = rate.max_property_size_from;
                            let size_to = rate.max_property_size_to;
                            let rate_per_hour = rate.rate_per_hour;
                            if (parseInt(property_size) >= parseInt(size_from) && parseInt(property_size) <= parseInt(size_to)) {
                                let service_price = parseInt(rate_per_hour) * parseInt(type.min_hours);
                                total_price += service_price;
                            }
                        }
                    }
                    this.percentage = (total_price / 100) * 20;
                     return this.getTotalAverage(parseFloat(total_price));
                },
                getTotalAverage(totalValue) {
                    let percentage = (20 * totalValue) / 100;
                    return '€'+ (totalValue - percentage) + ' - ' + (totalValue + percentage);
                }
            }
        });
    </script>
@endsection
