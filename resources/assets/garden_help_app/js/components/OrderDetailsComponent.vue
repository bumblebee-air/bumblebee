<template>
    <div style="height: 100%; overflow-y: hidden;">
        <loading-component></loading-component>
        <nav class="navbar navbar-light bg-light d-flex justify-content-center">
            <a class="navbar-brand d-flex justify-content-center order-status my-auto" href="#">
                <div v-for="(status, index) in job_status" v-if="job_data.status == status.status">
                    <i class="fas fa-circle" :style="'color:' + status.color "></i>
                    {{status.text}}
                  {{job_data.kpi_timestamps ?  (status.status == 'assigned' ? job_data.kpi_timestamps.assigned : (status.status == 'accepted' ? job_data.kpi_timestamps.accepted : (status.status == 'on_route' ? job_data.kpi_timestamps.on_the_way_first : (status.status == 'arrived' ? job_data.kpi_timestamps.arrived_first : '' )))) : '' }}
                </div>
            </a>
            <i class="fas fa-arrow-left back-btn" @click="$router.push({name: 'orders-list'})"></i>
        </nav>
        <div style="height: 100%">
            <GmapMap
                    ref="gmap"
                    :center="map_center"
                    :zoom="7"
                    map-type-id="roadmap"
                    style="width: 100%; height: 70%;"
                    :options = "{
                   zoomControl: false,
                   mapTypeControl: false,
                   scaleControl: false,
                   streetViewControl: false,
                   rotateControl: false,
                   fullscreenControl: true,
                   disableDefaultUi: false,
                   gestureHandling: 'cooperative',
                }"
            >
                <GmapMarker
                        v-for="(marker, index) in markers"
                        v-if="markers[index].position != ''"
                        :key="index"
                        :position="markers[index].position"
                        :clickable="true"
                        :draggable="false"
                        :icon="{
                            url: markers[index].icon,
                            scaledSize: { height: 29, width: 25 },
                        }"
                        @click="toggleInfoWindow(markers[index],index)"
                />

                <gmap-info-window
                        :options="infoOptions"
                        :position="infoWindowPos"
                        :opened="infoWinOpen"
                        @closeclick="infoWinOpen=false"
                >
                    <div v-html="infoContent"></div>
                </gmap-info-window>
            </GmapMap>
        </div>
        <div class="order-card-container">
            <div class="order-details-cart" id="expanded-card" :style="'height: '+minHeight+'em'" v-touch:start="touchStartHandler" v-touch:moving="movingHandler" v-touch:end="movedHandler">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="card-drag"></div>
                    </div>
                    <div class="col-12 order-details-container" style="overflow-x: auto; height: 635px;">
                        <div class="row">
                            <div class="col-10">
                                <p class="delivery-info">
                                    Job Information
                                </p>
<!--                                <p class="order-number">-->
<!--                                    {{this.job_data.order_id}}-->
<!--                                </p>-->
                                <p class="request-date">
                                  <i class="fas fa-calendar-alt"></i>
                                  {{ job_data.created_at | moment("dddd, MMMM Do YYYY, h:mm a")}}
                                </p>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-items-center">
                                <div class="time-distance">
<!--                                    <div class="d-flex delivery-time-container justify-content-center">-->
<!--                                        <img class="delivery-time" src="images/doorder_driver_assets/delivery-time.png" alt="delivery time">-->
<!--                                        {{durationTime}}-->
<!--                                    </div>-->
                                    <div class="delivery-distance">
                                        {{distance}} Away
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <img src="images/garden_help_driver_assets/location.png" class="pickup-icon" alt="pickup-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                    Job Location
                                </p>
                                <p class="order-address-value">
                                  {{job_data.location}}
                                  <a href="#" @click="redirectToGoogleMaps(job_data.location_coordinates)">(Open on maps)</a>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <img src="images/garden_help_driver_assets/first_time.png" class="service-icon" alt="service-type-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                  First time to do this service for the property?
                                </p>
                                <p class="order-address-value">
                                  {{ job_data.is_first_time == 1 ? 'Yes' : 'no' }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <img src="images/garden_help_driver_assets/last_time.png" class="service-icon" alt="service-type-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                  Last time was
                                </p>
                                <p class="order-address-value">
                                  {{job_data.last_service ? job_data.last_service : 'N/A'}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <img src="images/garden_help_driver_assets/site_details.png" class="service-icon" alt="service-type-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                  Site details
                                </p>
                                <p class="order-address-value">
                                  {{job_data.site_details ? job_data.site_details : 'N/A'}}
                                </p>
                            </div>
                        </div>

                      <div class="row">
                        <div class="col-2">
                          <img src="images/garden_help_driver_assets/site_details.png" class="service-icon" alt="service-type-icon">
                        </div>
                        <div class="col-10 order-address-row">
                          <p class="order-address-title">
                            Job Types
                          </p>
                          <p class="order-address-value">
                            <span v-for="service in job_service_types">{{service.name}}</span>
                          </p>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-2">
                          <img src="images/garden_help_driver_assets/site_details.png" class="service-icon" alt="service-type-icon">
                        </div>
                        <div class="col-10 order-address-row">
                          <p class="order-address-title">
                            Min Working Hours
                          </p>
                          <p class="order-address-value">
                            <span>{{calcMinHours()}}</span>
                          </p>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-2">
                          <img src="images/garden_help_driver_assets/parking_site.png" class="service-icon" alt="service-type-icon">
                        </div>
                        <div class="col-10 order-address-row">
                          <p class="order-address-title">
                            Parking access on site?
                          </p>
                          <p class="order-address-value">
                            {{job_data.is_parking_access == 1 ? 'Yes' : 'No'}}
                          </p>
                        </div>
                      </div>
                      <div class="row" v-if="job_data.property_photo">
                        <div class="col-10 order-address-row">
                          <p class="order-address-value">
                            <img :src="job_data.property_photo" alt="Property Image" style="width: 100%; height: 100%">
                          </p>
                        </div>
                      </div>

<!--                        <div class="row" v-if="job_data.status != 'ready' && job_data.status != 'assigned'">-->
<!--                            <div class="col-2">-->
<!--                                <img src="images/doorder_driver_assets/pickup-address-pin.png" class="pickup-icon" alt="pickup-icon">-->
<!--                            </div>-->
<!--                            <div class="col-10 order-address-row">-->
<!--                                <p class="order-address-title">-->
<!--                                    Delivery Address-->
<!--                                </p>-->
<!--                                <p class="order-address-value">-->
<!--                                    {{job_data.customer_address}}-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="row">-->
<!--                            <div class="col-2">-->
<!--                                <img src="images/doorder_driver_assets/time.png" class="package-details-icon" alt="pickup-icon">-->
<!--                            </div>-->
<!--                            <div class="col-10 order-address-row">-->
<!--                                <p class="order-address-title">-->
<!--                                    Estimated Arrival Time to Delivery Address-->
<!--                                </p>-->
<!--                                <p class="order-address-value">-->
<!--                                    {{duration}}-->
<!--                                </p>-->
<!--                            </div>-->
<!--                        </div>-->

<!--                        <div class="row">-->
<!--                            <div class="col-2">-->
<!--                                <img src="images/doorder_driver_assets/package-details.png" class="package-details-icon" alt="pickup-icon">-->
<!--                            </div>-->
<!--                            <div class="col-8 order-address-row">-->
<!--                                <p class="order-address-title">-->
<!--                                    Package details-->
<!--                                </p>-->
<!--                                <p class="order-address-value">-->
<!--                                  {{job_data.weight ? job_data.weight + ' / ' : ''}}  {{!job_data.fragile ? 'Not' : ''}} Fragile / {{job_data.dimensions ? job_data.dimensions : 'N/A Dimensions'}}-->
<!--                                  <br v-if="job_data.notes != ''">-->
<!--                                  <br v-if="job_data.notes != ''">-->
<!--                                  {{job_data.notes != '' ? 'Notes: ' + job_data.notes : ''}}-->
<!--                                </p>-->
<!--                            </div>-->
<!--                            <div>-->
<!--&lt;!&ndash;                                <img src="images/doorder_driver_assets/whatsapp.png" class="whatsapp-icon" alt="whatsapp">&ndash;&gt;-->
<!--                                <button class="btn btn-round doorder-btn-map" @click="navigateToAddress()">-->
<!--                                    <i class="fas fa-map-marked-alt"></i>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="order-details-cart-actions">
                    <div class="row accept-reject-container" v-if="job_data.status == 'ready' || job_data.status == 'assigned'">
                        <div class="col-md-12">
                          <button class="btn btn-lg doorder-btn block" @click="openConfirmationDialog('accepted')">
                            Accept
                          </button>
                          <div class="mb-1"></div>
                          <button class="btn btn-lg doorder-btn danger block" @click="openConfirmationDialog('rejected')">
                            Reject
                          </button>
<!--                          <img src="images/doorder_driver_assets/accept.png" width="40" height="40" alt="accept" @click="openConfirmationDialog('accepted')" >-->
<!--                          <img src="images/doorder_driver_assets/reject.png" width="40" height="40" alt="reject" @click="openConfirmationDialog('rejected')">-->
                        </div>
                    </div>
                    <div class="order-details-button-container" v-else>
                        <div class="row mb-1" v-if="job_data.status == 'arrived'">
                          <button class="btn order-details-button" v-if="current_working_status == 'start_working'" @click="workingTracker('start_working')">
                            Start Working
                          </button>
                          <button class="btn order-details-button keep_working" v-else-if="current_working_status == 'break' || current_working_status == ''" @click="workingTracker('keep_working')">
                            Keep Working
                          </button>
                          <button class="btn order-details-button danger" v-else @click="workingTracker('break')">
                            Break
                          </button>
                        </div>
                        <div class="row">
                          <button v-for="(status, index) in job_status" v-if="job_data.status == status.status" :class="'btn order-details-button ' + job_status[index + 1].status " @click="openConfirmationDialog(job_status[index + 1].status)">
                            {{ job_status[index + 1].text}}
                          </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {gmapApi} from 'vue2-google-maps';

    export default {
        computed: {
            google: gmapApi
        },
        data() {
            return {
                map_center: {
                    lat: 53.350140,
                    lng: -6.266155
                },
                markers: {
                    current_location: {
                        position: '',
                        icon: 'images/doorder_driver_assets/deliverer-location-pin.png'
                    },
                    customer_location: {
                        position: '',
                        icon: 'images/doorder_driver_assets/customer-address-pin.png'
                    },
                    // pickup_location: {
                    //     position: '',
                    //     icon: 'images/doorder_driver_assets/pickup-address-pin-grey.png'
                    // },
                },
                currentTouchStartY: '',
                job_data: '',
                job_status: [
                    {
                        status: 'ready',
                        text: 'Online',
                        color: '#60a244'
                    },

                    {
                        status: 'assigned',
                        text: 'Online',
                        color: '#60a244'
                    },
                    {
                        status: 'matched',
                        text: 'Online',
                        color: '#60a244'
                    },
                    {
                        status: 'on_route',
                        text: 'On the way to Job Location',
                        color: '#8d6f3a'
                    },
                    {
                        status: 'arrived',
                        text: 'Arrived to Job Location',
                        color: '#5590f5'
                    },
                    // {
                    //     status: 'on_route',
                    //     text: 'On the Way to Delivery Address',
                    //     color: '#ef9065'
                    // },
                    {
                        status: 'completed',
                        text: 'Job Completed',
                        color: '#60a244'
                    }
                ],
                infoContent: '',
                infoWindowPos: {
                    lat: 0,
                    lng: 0
                },
                infoWinOpen: false,
                currentMidx: null,
                //optional: offset infowindow so it visually sits nicely on top of our marker
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    }
                },
                latestDirection: '',
                maxHeight: '25',
                minHeight: '16',
                distance: '0',
                duration: '0',
                durationTime: '0',
                job_service_types: [],
                current_working_status: 'start_working'
            }
        },
        mounted() {
            this.getJobData();
        },
        methods: {
            getJobData() {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.post(process.env.MIX_API_URL + 'job-details',{
                    job_id: this.$route.params.id
                },
                {
                    headers: {
                        Accept: "application/json",
                        Authorization: user.access_token
                    }
                }).then(
                    res => this.fetchJobDataResponse(res)
                ).catch(
                    err => this.fetchJobDataError(err)
                );
            },
            fetchJobDataResponse(res) {
                this.job_data = res.data.job;
                if (this.job_data.status == 'completed') {
                    this.navigateToOrderDelivered(res.data.order.delivery_confirmation_code);
                } else {
                  this.job_service_types = JSON.parse(this.job_data.services_types_json);
                  // this.markers.pickup_location.position = {
                    //     lat: parseFloat(this.job_data.pickup_lat),
                    //     lng: parseFloat(this.job_data.pickup_lon)
                    // };
                    // if (this.job_data.status != 'ready' && this.job_data.status != 'assigned') {
                      let job_coordinates = JSON.parse(this.job_data.location_coordinates);
                        this.markers.customer_location.position = {
                            lat: parseFloat(job_coordinates.lat),
                            lng: parseFloat(job_coordinates.lon)
                        };
                    // }
                    // this.getOrderPassedTime(this.job_data.created_at).then(data => {
                    //     this.durationTime = data;
                    // });
                    this.setCardMaxHeight();
                    this.getCurrentLocation();
                    $('#loading').fadeOut();
                    this.current_working_status = this.job_data.contractor_status ? this.job_data.contractor_status : 'start_working'
                }
            },
            fetchJobDataError(err) {
              if (err.response.status === 401) {
                this.unauthorizedUser();
              }
            },
            getCurrentLocation() {
                this.getGeolocationPosition().then(position => {
                    this.setDistance(position);
                    this.showCurrentPosition(position);
                })
            },
            setDistance(position) {
                var directionsService = new this.google.maps.DirectionsService();
                var job_coordinates = JSON.parse(this.job_data.location_coordinates);

                var request = {
                    origin : new this.google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    destination : new this.google.maps.LatLng(parseFloat(job_coordinates.lat), parseFloat(job_coordinates.lon)),
                    travelMode : this.google.maps.TravelMode.WALKING
                };

                directionsService.route(request, (response, status) => {
                    if (status == this.google.maps.DirectionsStatus.OK) {
                        this.distance = response.routes[0].legs[0].distance.text;
                        this.duration = response.routes[0].legs[0].duration.text;
                    } else {
                        console.log('Not Ok')
                    }
                });
            },
            showCurrentPosition(position) {
                this.markers.current_location.position = {
                    lat: parseFloat(position.coords.latitude),
                    lng: parseFloat(position.coords.longitude),
                };
                // this.watchUserPosition();
                // this.getDrivingDistance(position.coords.latitude, position.coords.longitude, this.job_data.pickup_lat, this.job_data.pickup_lon)
                //     .then(data => {
                //         this.distance = data.distance;
                //         this.duration = data.duration;
                //     });
                this.setDistance(position);
                this.mapFitBound();
            },
            touchStartHandler(e) {
                this.currentTouchStartY = e.changedTouches[0].clientY;
            },
            movingHandler(e) {
                let direction = '';
                if (e.changedTouches[0].screenY < this.currentTouchStartY) {
                    direction = 'top';
                } else {
                    direction = 'bottom';
                }
                this.currentTouchStartY = e.changedTouches[0].screenY;
                this.latestDirection = direction;
                this.changeExpandedCardHeight(direction)
            },
            movedHandler(e) {
                if (this.latestDirection == 'top') {
                    $('#expanded-card').animate({height: this.maxHeight+'em'}, 300);
                } else {
                    $('#expanded-card').animate({height: this.minHeight+'em'}, 300);
                }
            },
            changeExpandedCardHeight(direction) {
                if (direction == 'top') {
                    $('#expanded-card').height($('#expanded-card').height() + 3)
                } else {
                    $('#expanded-card').height($('#expanded-card').height() - 2)
                }
            },
            updateJobStatus(jobStatus) {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.post(process.env.MIX_API_URL + 'contractor-status-update',{
                        job_id: this.$route.params.id,
                        status: jobStatus,
                    },
                    {
                        headers: {
                            Accept: "application/json",
                            Authorization: user.access_token
                        }
                    })
                    .then(res => this.fetchUpdateStatusResponse(res, jobStatus))
                    .catch(err => this.fetchUpdateStatusError(err));
            },
            fetchUpdateStatusResponse(res, jobStatus) {
                if (jobStatus == 'completed') {
                    this.navigateToOrderDelivered(res.data.delivery_confirmation_code);
                } else if (jobStatus == 'accepted') {
                    this.job_data.status = 'matched';
                    // this.markers.customer_location.position = {
                    //     lat: parseFloat(this.job_data.customer_address_lat),
                    //     lng: parseFloat(this.job_data.customer_address_lon),
                    // };
                    // this.setCardMaxHeight();
                    // this.mapFitBound();
                } else {
                    this.job_data.status = jobStatus;
                }
                Vue.$toast.success(res.data.message, {
                    position: 'top'
                });
            },
            fetchUpdateStatusError(err) {
              if (err.response.status === 401) {
                this.unauthorizedUser();
              }
                Vue.$toast.error(err.response.data.message, {
                    position: 'top'
                });
            },
            toggleInfoWindow(marker, idx) {
                this.infoWindowPos = marker.position;
                this.infoContent = this.getInfoWindowContent(marker, idx);


                //check if its the same marker that was selected if yes toggle
                if (this.currentMidx == idx) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMidx = idx;
                }
            },
            getInfoWindowContent(marker, index) {
                let address = '';
                if (index == 'pickup_location') {
                    address = this.job_data.pickup_address
                } else if (index == 'customer_location') {
                    address = this.job_data.customer_address
                } else {
                    return ('<p>I\'m Here</p>');
                }
                return ('<a target="_blank" href="http://www.google.com/maps/place/' + marker.position.lat + ',' + marker.position.lng +'">' + address +'</p>');
            },
            mapFitBound() {
                this.$refs.gmap.$mapPromise.then((map) => {
                    const bounds = new this.google.maps.LatLngBounds()
                    for (let m in this.markers) {
                        if(this.markers[m].position != '') {
                            bounds.extend(this.markers[m].position)
                        }
                    }
                    map.fitBounds(bounds);
                });
            },
            setCardMaxHeight() {
                if (this.job_data.status != 'ready') {
                    this.maxHeight = 50;
                } else {
                    this.maxHeight = 50;
                }
            },
            navigateToOrderDelivered(delivery_confirmation_code = null) {
                this.$router.push({
                    name: 'order-delivered',
                    params: {
                        order_id: this.job_data.order_id,
                        delivery_confirmation_code,
                        id: this.job_data.id,
                        delivery_confirmation_status: this.job_data.delivery_confirmation_status
                    }
                })
            },
            openConfirmationDialog(ordersStatus) {
                let message = '';
                let status = {
                    accepted: 'Are you sure you want to accept this Job?',
                    rejected: 'Are you sure you want to reject this Job?',
                };
                if (ordersStatus == 'accepted' || ordersStatus == 'rejected') {
                    message = status[ordersStatus];
                } else {
                    for (let value of this.job_status) {
                        if (value.status == ordersStatus) {
                            message = 'You will change your status to "' + value.text + '"';
                        }
                    }
                }
                this.$confirm(
                    {
                        title: 'Are you sure?',
                        message: message,
                        button: {
                            yes: 'Yes',
                            no: 'No'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            if (confirm) {
                              if (ordersStatus == 'completed') {
                                this.$router.push({name: 'job-finalizing', params: {
                                    id: this.job_data.id,
                                    contractor_confirmation_code: this.job_data.contractor_confirmation_code,
                                    services_types: this.job_data.services_types_json,
                                  }});

                              } else {
                                this.updateJobStatus(ordersStatus);
                              }
                            }
                        }
                    }
                )
            },
            watchUserPosition() {
                navigator.geolocation.watchPosition(this.updateUserPosition);
            },
            updateUserPosition(position) {
                this.markers.current_location.position = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
            },
            navigateToAddress() {
                //Get Lat Lang
                let lat = '';
                let lng = '';
                if (this.job_data.status == 'picked_up' || this.job_data.status == 'on_route') {
                    lat = this.markers['customer_location'].position.lat;
                    lng = this.markers['customer_location'].position.lng;
                } else {
                    lat = this.markers['pickup_location'].position.lat;
                    lng = this.markers['pickup_location'].position.lng;
                }
                // If it's an iPhone..
                if( (navigator.platform.indexOf("iPhone") != -1)
                    || (navigator.platform.indexOf("iPod") != -1)
                    || (navigator.platform.indexOf("iPad") != -1))
                    window.open("maps://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination="+ lat +"," + lng);
                else
                    window.open("https://www.google.com/maps/dir/?api=1&travelmode=driving&layer=traffic&destination="+ lat +"," + lng);
            },
            redirectToGoogleMaps(location_coordinates) {
              let coordinates = JSON.parse(location_coordinates);
                window.open('http://maps.google.com?q='+coordinates.lat+','+coordinates.lon);
            },
          workingTracker(status) {
            let user = JSON.parse(localStorage.getItem('user'));
            axios.post(process.env.MIX_API_URL + 'job-time-tracker',{
                  job_id: this.$route.params.id,
                  status: status
                },
                {
                  headers: {
                    Accept: "application/json",
                    Authorization: user.access_token
                  }
                }).then(
                res => {
                  console.log(status);
                  if (status == 'start_working' || status == 'keep_working') {
                    this.current_working_status = 'keep_working';
                  } else {
                    this.current_working_status = 'break'
                  }
                }
            ).catch(
                err => console.log(err)
            );
          },
          calcMinHours() {
              let min_hours = 0;
              for (let service of this.job_service_types) {
                min_hours += service.min_hours
              }
              return min_hours;
          }
        }
    }
</script>

<style>
    .order-status {
        font-size: 16px;
        font-weight: 500;
        letter-spacing: 1px;
        text-align: center;
        color: #4d4d4d;
    }

    .order-status .fas {
        /*margin: 5px 18px 4px 0;*/
        color: #60a244;
    }

    .back-btn {
        left: 16px;
        position: absolute;
        font-size: 17px;
    }

    .order-details-cart {
        padding: 30px 28px 18px 31.5px;
        border-radius: 44px 44px 0 0;
        box-shadow: 10px 10px 20px 0 rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        bottom: 0;
        height: 50em;
        width: 100%;
        position: fixed;
    }

    /*.order-card-container {*/
    /*    height: 50%;*/
    /*}*/

    .card-drag {
        width: 30%;
        height: 4px;
        /*margin: 0 64px 11px 37.6px;*/
        border-radius: 2px;
        background-color: #d8d8d8;
    }

    .delivery-info{
        margin: 11px 70.5px 2px 0;
        font-family: Roboto;
        font-size: 16px;
        font-weight: bold;
        font-stretch: normal;
        font-style: normal;
        line-height: normal;
        letter-spacing: 1px;
        color: #4d4d4d;
    }

    .order-number {
        margin: 2px 37.6px 17px 1.9px;
        font-family: Roboto;
        font-size: 10.8px;
        letter-spacing: 0.77px;
        color: #dcbb2f;
    }

    .order-details-container {
        padding-top: 10px;
    }

    .pickup-icon {
        width: 25px;
        margin-top: 20px;
    }
    .service-icon {
        width: 15px;
        margin-top: 20px;
        margin-left: 5px;
    }

    .package-details-icon {
        width: 17px;
        margin-top: 20px;
    }


    .order-address-row {
        padding-bottom: 0px;
        border-bottom: 0.8px solid #ebeced;
        margin-top: 12px;
    }

    .order-address-title {
        font-size: 11px;
        letter-spacing: 0.79px;
        color: #45597a;
        margin-bottom: 5px;
    }

    .order-address-value {
        /*margin: 5px 0 0;*/
        font-family: Roboto;
        font-size: 12px;
        font-weight: normal;
        font-stretch: normal;
        font-style: normal;
        line-height: normal;
        letter-spacing: 0.75px;
        color: #1e2843;
    }

    .whatsapp-icon {
        width: 38px;
        margin-top: 15px;
    }

    .accept-reject-container {
        /*padding-left: 50px;*/
        /*padding-right: 50px;*/
        padding-top: 12px;
    }

    .order-details-button {
        width: 100%;
        height: 43px;
        /*margin: 17px 17px 0 8.5px;*/
        /*padding: 12px 40px 14px;*/
        border-radius: 24px;
        box-shadow: 0 10px 31px -10px rgba(76, 151, 161, 0.35);
        background-color: #8d6f3a;
        color: white;
    }

    .order-details-button-container {
        padding-top: 10px;
    }

    .picked_up {
        background-color: #5590f5;
    }

    .on_route {
        background-color: #8d6f3a;
    }

    .completed {
        background-color: #60a244
    }

    .arrived {
        background-color: #5590f5
    }

    .ready, .matched .assigned {
        color: #60a244;
    }

    .order-details-cart-actions {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: white;
        padding: 5px 40px 10px 40px;
    }
    .request-date {
      font-size: 10px;
      font-weight: 500;
      font-stretch: normal;
      font-style: normal;
      line-height: 1.8;
      letter-spacing: normal;
      color: #60a244;
    }
    .danger {
      background-color: #d85656!important;
    }
    .block {
      width: 100%!important;
    }
    .keep_working {
      background-color: rgb(85, 144, 245);
    }
</style>
