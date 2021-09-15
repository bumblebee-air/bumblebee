<template>
    <div>
        <ul class="nav nav-tabs d-flex justify-content-around orders-nav" id="myTab" role="tablist">
            <li class="nav-item col-6">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#orders-requests" role="tab" aria-controls="home" aria-selected="true">Job Request list</a>
            </li>
            <li class="nav-item col-6">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#my-orders" role="tab" aria-controls="profile" aria-selected="false">My Job List</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="orders-requests" role="tabpanel" aria-labelledby="orders-list-tab">
                <order-card-component v-for="(item, index) in available_jobs" :key="index" :order_data="item"></order-card-component>
                <div v-if="available_jobs.length == 0">
                    <empty-component></empty-component>
                </div>
            </div>
            <div class="tab-pane fade" id="my-orders" role="tabpanel" aria-labelledby="my-orders-tab">
                <order-card-component v-for="(item, index) in my_jobs" :key="index" :order_data="item"></order-card-component>
                <div v-if="my_jobs.length == 0">
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
                available_jobs: [],
                my_jobs: []
            })
        },
        mounted() {
            this.getJobsData();
            this.timer = setInterval(() => {
                this.getJobsData();
            }, 30000);
            $('#app').css('overflow', 'scroll')
        },
        destroyed() {
            clearInterval(this.timer);
          $('#app').css('overflow', 'hidden')
        },
        methods: {
            getJobsData() {
                let user = JSON.parse(localStorage.getItem('user'));
                axios.get(process.env.MIX_API_URL + 'jobs-list', {
                    headers: {
                        Accept: "application/json",
                        Authorization: user.access_token
                    }
                }).then(
                    res => this.fetchJobsDataResponse(res)
                ).catch(
                    err => this.fetchJobsDataError(err)
                );
            },
            fetchJobsDataResponse(res) {
                this.my_jobs = [];
                this.available_jobs = [];
                this.available_jobs = res.data.available_jobs;
                this.my_jobs = res.data.my_jobs;
                $('#loading').fadeOut();
            },
            fetchJobsDataError(err) {
              if (err.response.status === 401) {
                this.unauthorizedUser();
              }
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
