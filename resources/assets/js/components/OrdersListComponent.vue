<template>
    <div>
        <ul class="nav nav-tabs d-flex justify-content-around orders-nav" id="myTab" role="tablist">
            <li class="nav-item col-6">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#orders-requests" role="tab" aria-controls="home" aria-selected="true">Order Request List</a>
            </li>
            <li class="nav-item col-6">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#my-orders" role="tab" aria-controls="profile" aria-selected="false">My Orders</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="orders-requests" role="tabpanel" aria-labelledby="orders-list-tab">
                <order-card-component v-for="(order, index) in orders_requests" :key="index" :order_data="order"></order-card-component>
                <div v-if="orders_requests.length == 0">
                    <empty-component></empty-component>
                </div>
            </div>
            <div class="tab-pane fade" id="my-orders" role="tabpanel" aria-labelledby="my-orders-tab">
                <order-card-component v-for="(order, index) in my_orders" :key="index" :order_data="order"></order-card-component>
                <div v-if="my_orders.length == 0">
                    <empty-component></empty-component>
                </div>
            </div>
        </div>
        <loading-component></loading-component>
            <GmapMap
                    ref="mapRef"
                    :center="{lat: 0, lng: 0}"
                    :zoom="7"
                    map-type-id="roadmap"
                    style="width: 100%; height: 0%; position: absolute"
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
            ></GmapMap>
    </div>
</template>

<script>
    export default {
        data() {
            return ({
                orders_requests: [],
                my_orders: []
            })
        },
        mounted() {
            this.getOrdersData();
            this.timer = setInterval(() => {
                this.getOrdersData();
            }, 5000);
        },
        methods: {
            getOrdersData() {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.get(process.env.MIX_API_URL + 'orders-list', {
                    headers: {
                        Accept: "application/json",
                        Authorization: user.access_token
                    }
                }).then(
                    res => this.fetchOrdersDataResponse(res)
                ).catch(
                    err => this.fetchOrdersDataError(err)
                );
            },
            fetchOrdersDataResponse(res) {
                this.my_orders = [];
                this.orders_requests = [];
                this.orders_requests = res.data.available_orders;
                this.my_orders = res.data.driver_orders;
                $('#loading').fadeOut();
            },
            fetchOrdersDataError(err) {
                console.log(err)
            }
        }
    }
</script>

<style>
    .tab-pane {
        padding-top: 15px
    }

</style>
