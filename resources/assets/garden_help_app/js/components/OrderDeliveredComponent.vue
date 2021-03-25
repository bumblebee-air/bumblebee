<template>
    <div class="wrapper" style="height: 100%">
        <div class="row" style="height: 100%">
            <div class="col-md-12" v-if="delivery_confirmation_status == 'skipped' || delivery_confirmation_status == 'confirmed'">
                <div class="row">
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
            <div class="col-md-12" v-else>
                <div class="row">
                    <div class="col-md-12 delivered-title-container">
                        <p>
                            Please Scan the QR
                            <br>
                            Code to Confirm Delivery
                        </p>
                    </div>
                    <div class="col-md-12 confirmation-qrcode-container">
                        <qrcode-vue :value="delivery_confirmation_code" size="300" level="H" id="scanner">
                            hello there
                        </qrcode-vue>
                    </div>
                    <div class="col-md-12 confirmation-buttons-container">
                        <button id="skip-dialog" class="btn btn-lg doorder-btn" data-toggle="modal" data-target="#exampleModal">
                            Skip
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-md-12 dialog-title-container">
                            <p>
                                Skip QR Code Scan Reasons
                            </p>
                        </div>
                        <div class="col-md-12 text-area-container">
                            <textarea class="form-control" rows="5" v-model="skip_reason"></textarea>
                        </div>
                        <div class="col-md-12" @click="skipDeliveryConfirmation">
                            <button class="btn btn-lg doorder-btn" :disabled="!skip_reason || isLoading">
                                {{!isLoading ? 'Submit' : ''}}
                                <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
                            </button>
                        </div>

                    </div>
<!--                    <div class="modal-footer">-->
<!--                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                        <button type="button" class="btn btn-primary">Save changes</button>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order_id: '',
                delivery_confirmation_code: '',
                delivery_confirmation_status: '',
                skip_reason: '',
                id: '',
                isLoading: false,
                socketInstance: io.connect(window.location.protocol+'//' + window.location.hostname + ':8890')
            }
        },
        mounted() {
            if (this.$route.params.order_id) {
                this.order_id = this.$route.params.order_id;
                this.delivery_confirmation_code = this.$route.params.delivery_confirmation_code;
                this.delivery_confirmation_status = this.$route.params.delivery_confirmation_status;
                this.id = this.$route.params.id;
                this.subscribeIntoConfirmationChannel()
            } else {
                this.$router.push({
                    name: 'orders-list'
                });
            }
        },
        destroyed() {
            this.socketInstance.close();
        },
        methods: {
            skipDeliveryConfirmation() {
                this.isLoading = true;
                let user = JSON.parse(localStorage.getItem('user'));
                axios.post(process.env.MIX_API_URL + 'skip-delivery-confirmation',
                    {
                        order_id: this.id,
                        skip_reason: this.skip_reason
                    },
                    {
                        headers: {
                            Accept: "application/json",
                            Authorization: user.access_token
                        }
                    }).then(
                    res => this.fetchSkipDeliveryConfirmationResponse(res)
                ).catch(
                    err => this.fetchSkipDeliveryConfirmationError(err)
                );
            },
            fetchSkipDeliveryConfirmationResponse(res)
            {
                this.isLoading = false;
                $('#skip-dialog').click();
                this.delivery_confirmation_status = 'skipped';
                Vue.$toast.success(res.data.message,{
                    position: 'top'
                });
            },
            fetchSkipDeliveryConfirmationError(err) {
              if (err.response.status === 401) {
                this.unauthorizedUser();
              }
            },
            subscribeIntoConfirmationChannel() {
                this.socketInstance.on('doorder-channel:delivery-confirmation-order-id-' + this.id, (data) => {
                    let decodedData = JSON.parse(data);
                    this.delivery_confirmation_status = 'confirmed';
                    Vue.$toast.success(decodedData.data.message, {
                        position: 'top'
                    })
                });
            }
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
        /*padding-top: 30px*/
    }

    .delivered-button-container {
        padding: 50px 40px 0 40px;
    }
    .doorder-btn {
        width: 100%;
    }

    .wrapper {
        background-color: #fefefe;
    }

    .confirmation-qrcode-container {
        text-align: center;
        padding-top: 20px;
    }

    .confirmation-buttons-container {
        padding: 65px 40px 0 40px;
    }

    .text-area-container {
        padding-bottom: 25px
    }

    .dialog-title-container {
        font-size: 18px;
        line-height: 2.5;
        letter-spacing: 0.17px;
        color: #555555;
        text-align: center
    }
</style>
