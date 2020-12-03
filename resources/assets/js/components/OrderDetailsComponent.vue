<template>
    <div style="height: 100%; overflow-y: hidden;">
        <loading-component></loading-component>
        <nav class="navbar navbar-light bg-light d-flex justify-content-center">
            <a class="navbar-brand d-flex justify-content-center order-status my-auto" href="#">
                <div v-for="(status, index) in order_status" v-if="order_data.status == status.status">
                    <i class="fas fa-circle" :style="'color:' + status.color "></i>
                    {{status.text}}
                </div>
            </a>
            <i class="fas fa-arrow-left back-btn" @click="$router.go(-1)"></i>
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
                    <div class="col-12 order-details-container">
                        <div class="row">
                            <div class="col-10">
                                <p class="delivery-info">
                                    Delivery Information
                                </p>
                                <p class="order-number">
                                    {{this.order_data.order_number}}
                                </p>
                            </div>
                            <div class="col-2 d-flex justify-content-end align-items-center">
                                <div class="time-distance">
                                    <div class="d-flex delivery-time-container justify-content-center">
                                        <img class="delivery-time" src="images/doorder_driver_assets/delivery-time.png" alt="delivery time">
                                        {{durationTime}}
                                    </div>
                                    <div class="delivery-distance">
                                        {{distance}} KM Away
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <img src="images/doorder_driver_assets/pickup-address-pin.png" class="pickup-icon" alt="pickup-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                    Pickup Address
                                </p>
                                <p class="order-address-value">
                                    {{order_data.pickup_address}}
                                </p>
                            </div>
                        </div>

                        <div class="row" v-if="order_data.status != 'ready'">
                            <div class="col-2">
                                <img src="images/doorder_driver_assets/pickup-address-pin.png" class="pickup-icon" alt="pickup-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                    Delivery Address
                                </p>
                                <p class="order-address-value">
                                    {{order_data.customer_address}}
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <img src="images/doorder_driver_assets/time.png" class="package-details-icon" alt="pickup-icon">
                            </div>
                            <div class="col-10 order-address-row">
                                <p class="order-address-title">
                                    Estimated Arrival Time to Delivery Address
                                </p>
                                <p class="order-address-value">
                                    {{duration}}
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <img src="images/doorder_driver_assets/package-details.png" class="package-details-icon" alt="pickup-icon">
                            </div>
                            <div class="col-8 order-address-row">
                                <p class="order-address-title">
                                    Package details
                                </p>
                                <p class="order-address-value">
                                    {{order_data.weight > 0 ? order_data.weight : 0}} kG / {{!order_data.fragile ? 'Not' : ''}} Fragile / {{order_data['dimensions'] > 0 ? order_data['dimensions'] : 'N/A Dimensions'}}
                                </p>
                            </div>
                            <div>
                                <img src="images/doorder_driver_assets/whatsapp.png" class="whatsapp-icon" alt="whatsapp">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-details-cart-actions">
                    <div class="row justify-content-around accept-reject-container" v-if="order_data.status == 'ready'">
                        <img src="images/doorder_driver_assets/accept.png" width="40" alt="accept" @click="openConfirmationDialog('accepted')" >
                        <img src="images/doorder_driver_assets/reject.png" width="40" alt="reject" @click="openConfirmationDialog('rejected')">
                    </div>
                    <div class="order-details-button-container" v-else>
                        <button v-for="(status, index) in order_status" v-if="order_data.status == status.status" :class="'btn order-details-button ' + order_status[index + 1].status " @click="openConfirmationDialog(order_status[index + 1].status)">
                            {{ order_status[index + 1].text}}
                        </button>
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
                    pickup_location: {
                        position: '',
                        icon: 'images/doorder_driver_assets/pickup-address-pin-grey.png'
                    },
                },
                currentTouchStartY: '',
                order_data: '',
                order_status: [
                    {
                        status: 'ready',
                        text: 'Online',
                        color: '#60a244'
                    },
                    {
                        status: 'matched',
                        text: 'Online',
                        color: '#60a244'
                    },
                    {
                        status: 'on_route_pickup',
                        text: 'On the Way to Pickup Address',
                        color: '#e8ca49'
                    },
                    {
                        status: 'picked_up',
                        text: 'Arrived to Pickup Address',
                        color: '#5590f5'
                    },
                    {
                        status: 'on_route',
                        text: 'On the Way to Delivery Address',
                        color: '#ef9065'
                    },
                    {
                        status: 'delivered',
                        text: 'Delivered',
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
                durationTime: '0'
            }
        },
        mounted() {
            this.getOrderData();
        },
        methods: {
            getOrderData() {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.post(process.env.MIX_API_URL + 'order-details',{
                    order_id: this.$route.params.id
                },
                {
                    headers: {
                        Accept: "application/json",
                        Authorization: user.access_token
                    }
                }).then(
                    res => this.fetchOrderDataResponse(res)
                ).catch(
                    err => this.fetchOrderDataError(err)
                );
            },
            fetchOrderDataResponse(res) {
                this.order_data = res.data.order;
                if (this.order_data.status == 'delivered') {
                    this.navigateToOrderDelivered();
                } else {
                    this.markers.pickup_location.position = {
                        lat: parseFloat(this.order_data.pickup_lat),
                        lng: parseFloat(this.order_data.pickup_lon)
                    };
                    if (this.order_data.status != 'ready') {
                        this.markers.customer_location.position = {
                            lat: parseFloat(this.order_data.customer_address_lat),
                            lng: parseFloat(this.order_data.customer_address_lon)
                        };
                    }
                    this.getOrderPassedTime(this.order_data.created_at).then(data => {
                        this.durationTime = data;
                    });
                    this.setCardMaxHeight();
                    this.getCurrentLocation();
                    $('#loading').fadeOut();
                }
            },
            fetchOrderDataError(err) {
                console.log(err.response.status);
            },
            getCurrentLocation() {
                this.getGeolocationPosition().then(position => {
                    this.setDistance(position);
                    this.showCurrentPosition(position);
                })
            },
            setDistance(position) {
                console.log('here');
                var directionsService = new this.google.maps.DirectionsService();

                var request = {
                    origin : new this.google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    destination : new this.google.maps.LatLng(this.order_data.pickup_lat, this.order_data.pickup_lon),
                    travelMode : this.google.maps.TravelMode.WALKING
                };

                directionsService.route(request, (response, status) => {
                    if (status == this.google.maps.DirectionsStatus.OK) {
                        console.log(response);
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
                // this.getDrivingDistance(position.coords.latitude, position.coords.longitude, this.order_data.pickup_lat, this.order_data.pickup_lon)
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
            updateOrderStatus(orderStatus) {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.post(process.env.MIX_API_URL + 'driver-status-update',{
                        order_id: this.$route.params.id,
                        status: orderStatus,
                    },
                    {
                        headers: {
                            Accept: "application/json",
                            Authorization: user.access_token
                        }
                    })
                    .then(res => this.fetchUpdateStatusResponse(res, orderStatus))
                    .catch(err => this.fetchUpdateStatusError(err));
            },
            fetchUpdateStatusResponse(res, orderStatus) {
                if (orderStatus == 'delivered') {
                    this.navigateToOrderDelivered();
                } else if (orderStatus == 'accepted') {
                    this.order_data.status = 'matched';
                    this.markers.customer_location.position = {
                        lat: parseFloat(this.order_data.customer_address_lat),
                        lng: parseFloat(this.order_data.customer_address_lon),
                    };
                    this.setCardMaxHeight();
                    this.mapFitBound();
                } else {
                    this.order_data.status = orderStatus;
                }
                Vue.$toast.success(res.data.message, {
                    position: 'top'
                });
            },
            fetchUpdateStatusError(err) {
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
                    address = this.order_data.pickup_address
                } else if (index == 'customer_location') {
                    address = this.order_data.customer_address
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
                if (this.order_data.status != 'ready') {
                    this.maxHeight = 30;
                } else {
                    this.maxHeight = 25;
                }
            },
            navigateToOrderDelivered() {
                this.$router.push({
                    name: 'order-delivered',
                    params: {
                        order_id: this.order_data.order_id
                    }
                })
            },
            openConfirmationDialog(ordersStatus) {
                let message = '';
                let status = {
                    accepted: 'Are you sure you want to accept this Delivery?',
                    rejected: 'Are you sure you want to reject this Delivery?',
                };
                if (ordersStatus == 'accepted' || ordersStatus == 'rejected') {
                    message = status[ordersStatus];
                } else {
                    for (let value of this.order_status) {
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
                            no: 'No',
                            yes: 'Yes'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            if (confirm) {
                                this.updateOrderStatus(ordersStatus);
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
            // getDistance(lat1, long1, lat2, long2) {
            //     // let originLanLang = new this.google.maps.LatLng(lat1, long1);
            //     // let destinationLanLang = new this.google.maps.LatLng(lat2, long2);
            //     // let distance = this.google.maps.geometry.spherical.computeDistanceBetween(originLanLang, destinationLanLang);
            //     // console.log(distance)
            //
            //     var directionsService = new this.google.maps.DirectionsService();
            //
            //     var request = {
            //         origin : new this.google.maps.LatLng(lat1, long1),
            //         destination : new this.google.maps.LatLng(lat2, long2),
            //         travelMode : this.google.maps.TravelMode.WALKING
            //     };
            //
            //     directionsService.route(request, function(response, status) {
            //         if (status == this.google.maps.DirectionsStatus.OK) {
            //             console.log(response)
            //             // ... and triggers listener for 'directions_changed'
            //         } else {
            //             console.log('Not Ok')
            //         }
            //     });
            // }
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
        height: 25em;
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
        font-family: Quicksand;
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
        font-family: Quicksand;
        font-size: 10.8px;
        letter-spacing: 0.77px;
        color: #dcbb2f;
    }

    .order-details-container {
        padding-top: 10px;
    }

    .pickup-icon {
        width: 15px;
        margin-top: 20px;
    }

    .package-details-icon {
        width: 17px;
        margin-top: 20px;
    }


    .order-address-row {
        padding-bottom: 0px;
        border-bottom: 0.8px solid #ebeced;
        margin-top: 10px;
    }

    .order-address-title {
        font-size: 11px;
        letter-spacing: 0.79px;
        color: #45597a;
        margin-bottom: 5px;
    }

    .order-address-value {
        /*margin: 5px 0 0;*/
        font-family: Quicksand;
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
        padding-left: 50px;
        padding-right: 50px;
        padding-top: 12px;
    }

    .order-details-button {
        width: 100%;
        height: 43px;
        /*margin: 17px 17px 0 8.5px;*/
        /*padding: 12px 40px 14px;*/
        border-radius: 18.7px 0 18.7px 0;
        box-shadow: 0 10px 31px -10px rgba(76, 151, 161, 0.35);
        background-color: #e8ca49;
        color: white;
    }

    .order-details-button-container {
        padding-top: 10px;
    }

    .picked_up {
        background-color: #5590f5;
    }

    .on_route {
        background-color: #ef9065;
    }

    .delivered {
        background-color: #60a244
    }

    .ready, .matched {
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
</style>
