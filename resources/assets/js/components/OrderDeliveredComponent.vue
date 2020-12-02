<template>
    <div class="wrapper" style="height: 100%">
        <div class="row" style="height: 100%">
            <div class="col-md-12">
                <div class="row ">
                    <div class="col-md-12 delivered-title-container">
                        <p>
                            Order #{{order_id}}
                        </p>
                        <p>
                            Delivered Successfully!
                        </p>
                    </div>
                    <div class="col-md-12 delivered-image-container">
                        <img src="images/doorder_driver_assets/delivered-successfully.png" alt="delivered successfully">
                    </div>
                    <div class="col-md-12 delivered-button-container">
                        <button class="btn doorder-btn" @click="$router.push({name: 'orders-list'})">
                            Back To My Order List
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order_id: ''
            }
        },
        mounted() {
            this.order_id = this.$route.params.order_id;
        }
    }
</script>

<style scoped>
    .delivered {
        background-color: #60a244;
    }

    .delivered-title-container {
        font-size: 18px;
        letter-spacing: 0.99px;
        text-align: center;
        color: #4d4d4d;
        padding-top: 30px

    }

    .delivered-image-container {
        padding-top: 30px
    }

    .delivered-button-container {
        padding: 90px 40px 0 40px;
    }
    .doorder-btn {
        width: 100%;
    }

    .wrapper {
        background-color: #fefefe;
    }
</style>
