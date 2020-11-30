<template>
    <div class="order-cart" @click="navigateToOrderDetails();">
        <div class="row">
            <div class="col-10">
                <p class="order-address">
                    From: {{ order_data.pickup_address }}
                </p>
                <p class="order-address">
                    To: {{ order_data.customer_address }}
                </p>

                <p class="package-order-number">
                    {{order_data.order_id}}
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
    </div>
</template>

<script>
    export default {
        props: ['order_data'],
        data () {
            return {

            }
        },
        methods: {
            navigateToOrderDetails() {
                this.$router.push({name: 'order-details', params: {
                    id: this.order_data.id,
                }});
            }
        }
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
        margin-bottom: 24px;
    }
</style>
