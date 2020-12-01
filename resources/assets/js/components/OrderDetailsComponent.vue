<template>
    <div ref="myel">
<!--        <div v-if="order_data != '' && order_data.status != 'delivered'">-->
            <nav class="navbar navbar-light bg-light d-flex justify-content-center">
                <a class="navbar-brand d-flex justify-content-center order-status my-auto" href="#">
                    <i class="fas fa-circle"></i>
                    Online
                </a>
                <i class="fas fa-arrow-left back-btn" @click="$router.go(-1)"></i>
            </nav>
            <div>
                <GmapMap
                        ref="gmap"
                        :center="map_center"
                        :zoom="7"
                        map-type-id="roadmap"
                        style="width: 100%; height: 600px;"
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
                                        PKG5678902341
                                    </p>
                                </div>
                                <div class="col-2 d-flex justify-content-end align-items-center">
                                    <div class="time-distance">
                                        <div class="d-flex delivery-time-container justify-content-center">
                                            <img class="delivery-time" src="images/doorder_driver_assets/delivery-time.png" alt="delivery time">
                                            07
                                        </div>
                                        <div class="delivery-distance">
                                            5 Mile Away
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
                                        Brown Thomas Cork 18-21 Patrick Street
                                        , Cork Ireland
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
                                        Brown Thomas Cork 18-21 Patrick Street
                                        , Cork Ireland
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
                                        0 mins
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
                                        3 kG / Fragile
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
                            <img src="images/doorder_driver_assets/accept.png" width="40" alt="accept" @click="updateOrderStatus('accepted')" >
                            <img src="images/doorder_driver_assets/reject.png" width="40" alt="reject" @click="updateOrderStatus('rejected')">
                        </div>
                        <div class="order-details-button-container" v-else>
                            <button v-for="(status, index) in order_status" v-if="order_data.status == status.status" :class="'btn order-details-button ' + order_status[index + 1].status " @click="updateOrderStatus(order_status[index + 1].status)">
                                {{ order_status[index + 1].text}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
<!--        </div>-->
<!--        <div v-if="order_data && order_data.status == 'delivered'">-->
<!--            <div class="wrapper">-->
<!--                <div class="row mx-auto my-auto">-->
<!--                    <div class="col-md-12">-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-12 delivered-title-container">-->
<!--                                Order #PKG5678902341-->
<!--                                Delivered Successfully!-->
<!--                            </div>-->
<!--                            <div class="col-md-12 delivered-image-container">-->
<!--                                <img src="images/doorder_driver_assets/delivered-successfully.png" alt="delivered successfully">-->
<!--                            </div>-->
<!--                            <div class="col-md-12 delivered-button-container">-->
<!--                                <button class="btn order-details-button">-->
<!--                                    Back To My Order List-->
<!--                                </button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
    import {gmapApi} from 'vue2-google-maps'

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
                        text: 'On the Way to Pickup Address',
                    },
                    {
                        status: 'matched',
                        text: 'Arrived to Pickup Address'
                    },
                    {
                        status: 'on_route_pickup',
                        text: 'On the Way to Pickup Address'
                    },
                    {
                        status: 'picked_up',
                        text: 'Arrived to Pickup Address'
                    },
                    {
                        status: 'on_route',
                        text: 'On the Way to Delivery Address'
                    },
                    {
                        status: 'delivered',
                        text: 'Delivered'
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
                minHeight: '16'
            }
        },
        mounted() {
            // this.mapFitBound()
            this.getCurrentLocation();
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
                this.markers.pickup_location.position = {
                    lat: parseFloat(this.order_data.pickup_lat),
                    lng: parseFloat(this.order_data.pickup_lon)
                };
                this.setCardMaxHeight()
                this.mapFitBound();
            },
            fetchOrderDataError(err) {
                console.log(err)
            },
            getCurrentLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.showCurrentPosition);
                    this.mapFitBound();
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            },
            showCurrentPosition(position) {
                this.markers.current_location.position = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
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
                console.log(orderStatus);
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
                    alert('done');
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
                return ('<a href="https://maps.google.com/?ll=' + marker.position.lat + ',' + marker.position.lng +'">' + address +'</p>');
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
        margin: 5px 18px 4px 0;
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
        /*z-index: 999;*/
        position: fixed;
        /*transition: height .3s ease;*/
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
        background-color: #60a244;
    }

    .delivered-title-container {
        font-size: 18px;
        letter-spacing: 0.99px;
        text-align: center;
        color: #4d4d4d;
    }

    .delivered-image-container {

    }

    .delivered-button-container {

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
