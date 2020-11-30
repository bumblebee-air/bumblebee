<template>
    <div>
        <nav class="navbar navbar-light bg-light d-flex justify-content-center">
            <a class="navbar-brand d-flex justify-content-center order-status my-auto" href="#">
                <i class="fas fa-circle"></i>
                Online
            </a>
            <i class="fas fa-arrow-left back-btn" @click="$router.go(-1)"></i>
        </nav>
        <div>
            <GmapMap
                    v-if="current_location != ''"
                    :center="current_location"
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
                       gestureHandling: 'none'
                    }"
            >
                <GmapMarker
                        v-if="current_location != ''"
                        :position="current_location"
                        :clickable="true"
                        :draggable="false"
                        :icon="{
                            url: 'images/doorder_driver_assets/deliverer-location-pin.png',
                            scaledSize: { height: 29, width: 25 },
                        }"
                        gestureHandling="cooperative",
                />
            </GmapMap>
        </div>
        <div class="order-card-container">
            <div class="order-details-cart">
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

                        <div class="row">
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
<!--                <div class="row justify-content-around accept-reject-container">-->
<!--                    <img src="images/doorder_driver_assets/accept.png" width="40" alt="accept">-->
<!--                    <img src="images/doorder_driver_assets/reject.png" width="40" alt="reject">-->
<!--                </div>-->
                <div class="order-details-button-container">
                    <button class="btn order-details-button">
                        On the way to create
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                current_location: '',
                customer_location: '',
                pickup_location: ''
            }
        },
        mounted() {
            this.getCurrentLocation();
        },
        methods: {
            getCurrentLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(this.showCurrentPosition);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            },
            showCurrentPosition(position) {
                this.current_location = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
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
    }

    .order-card-container {
        height: 50%;
    }

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
</style>
