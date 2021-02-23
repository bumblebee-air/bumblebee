<template>
    <div class="order-cart" @click="navigateToJobDetails()">
        <div class="row">
            <div class="col-9">
                <p class="order-address">
                    From: {{ order_data.location }}
                </p>
<!--                <p class="order-address">-->
<!--                    To: {{ order_data.customer_address }}-->
<!--                </p>-->

<!--                <p class="package-order-number">-->
<!--&lt;!&ndash;                    {{order_data.order_id}}&ndash;&gt;-->
<!--                  Friday 23/10/2020  10:00 am-->
<!--                </p>-->
                <p class="request-date">
                  <i class="fas fa-calendar-alt"></i>
                  {{ order_data.created_at | moment("dddd, MMMM Do YYYY, h:mm a")}}
                </p>
            </div>

            <div class="col-3 d-flex justify-content-end align-items-center">
                <div class="time-distance">
<!--                    <div class="d-flex delivery-time-container justify-content-center">-->
<!--                        <img class="delivery-time" src="images/doorder_driver_assets/delivery-time.png" alt="delivery time">-->
<!--                        {{durationTime}}-->
<!--                    </div>-->
                    <div class="delivery-distance">
                        {{distance}} Away
                    </div>
<!--                    <div class="fulfill-countdown">-->
<!--                      <p v-if="count_down_timer > 0">-->
<!--                        {{count_down_timer_text}} until ready-->
<!--                      </p>-->
<!--                      <p v-else style="color: #069a06;">-->
<!--                        Ready for pickup-->
<!--                      </p>-->
<!--                    </div>-->
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
        props: ['order_data'],
        data () {
            return {
                durationTime: '0',
                distance: '0',
                count_down_date: 0,
                count_down_timer: 0,
                count_down_timer_text: ''
            }
        },
        mounted() {
            this.getOrderPassedTime(this.order_data.created_at).then(data => {
                this.durationTime = data;
            });
            this.getCurrentLocation();
            // if (this.order_data.fulfilment != '' && this.order_data.fulfilment != null) {
            //   this.count_down_date = Vue.moment(this.order_data.created_at).add(parseInt(this.order_data.fulfilment), 'minutes').toISOString();
            //   this.timecount = setInterval(() => {
            //     this.count_down_timer = Vue.moment(this.count_down_date).diff(Vue.moment());
            //     let duration = Vue.moment.duration(this.count_down_timer)
            //     this.count_down_timer_text = duration._data.hours + ':' + duration._data.minutes
            //   }, 1000);
            // }
        },
        methods: {
            navigateToJobDetails() {
                this.$router.push({name: 'order-details', params: {
                    id: this.order_data.id,
                }});
            },
            getCurrentLocation() {
                this.getGeolocationPosition().then(position => this.setDistance(position))
            },
            setDistance(position) {
                var directionsService = new this.google.maps.DirectionsService();
                var job_coordinates = JSON.parse(this.order_data.location_coordinates);

                var request = {
                    origin : new this.google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                    destination : new this.google.maps.LatLng(parseFloat(job_coordinates.lat), parseFloat(job_coordinates.lon)),
                    travelMode : this.google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, (response, status) => {
                    if (status == this.google.maps.DirectionsStatus.OK) {
                        this.distance = response.routes[0].legs[0].distance.text;
                    } else {
                        console.log('Not Ok')
                    }
                });
            }
        },
    }
</script>

<style>
    .order-cart {
        padding: 13px 16px 11px 14px;
        border-radius: 10.8px;
        box-shadow: 0 2px 43px 0 rgba(0, 0, 0, 0.13);
        background-color: #ffffff;
        margin-top: 13px;
    }

    .order-address {
        font-size: 12px;
        letter-spacing: 0.75px;
        color: #1e2843;
        padding-right: 12px;
    }

    .package-order-number {
        border-radius: 10.8px;
        font-size: 10.8px;
        letter-spacing: 0.77px;
        color: #dcbb2f;
    }
    p.package-order-number {
        margin-bottom: 10px
    }
    p.order-address {
        margin-bottom: 4px;
    }
    .time-distance {
      text-align: center;
      /*margin-bottom: 24px;*/
    }
    .fulfill-countdown {
      font-size: 10px;
      letter-spacing: 0.71px;
      color: #eb5c15;
      white-space: nowrap;
      margin: 2px 0 0;
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
</style>
