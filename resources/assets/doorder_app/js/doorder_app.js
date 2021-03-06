import VueRouter from 'vue-router';
import VueToast from 'vue-toast-notification';
import * as VueGoogleMaps from 'vue2-google-maps'
import router from './routes';
import Vue2TouchEvents from 'vue2-touch-events'
import VueDraggableResizable from 'vue-draggable-resizable'
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
import VueMoment from 'vue-moment';
import moment from 'moment-timezone';
import VueConfirmDialog from 'vue-confirm-dialog';
import QrcodeVue from 'qrcode.vue'
import {gmapApi} from 'vue2-google-maps';
import firebase from "firebase";
import 'firebase/messaging';
import VueTelInput from 'vue-tel-input'


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//Vue Google MAps
Vue.use(VueGoogleMaps, {
    load: {
        key: process.env.MIX_GOOGLE_API_KEY,
        libraries: ['geometry'], // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    },

    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    // autobindAllEvents: false,

    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then disable the following:
    // installComponents: true,
});

//Vue Router
Vue.use(VueRouter);

//Vue Toast
Vue.use(VueToast);

//Vue Moment js
Vue.use(VueMoment, {
    moment,
});

//Vue touch event
Vue.use(Vue2TouchEvents);

//VueJS Confirmation Dialog
Vue.use(VueConfirmDialog);
Vue.component('vue-confirm-dialog', VueConfirmDialog.default);

//Vue QR code generator
Vue.component('qrcode-vue', QrcodeVue);

//Vue Tel Input
Vue.use(VueTelInput);


Vue.mixin({
    computed: {
        'google': gmapApi
    },
    methods: {
        getOrderPassedTime(endData) {
            var now = Vue.moment(new Date()); //today date
            var end = Vue.moment(endData); // another date
            var duration = Vue.moment.duration(now.diff(end));
            return new Promise(resolve => {
                resolve(24 - duration.asHours().toFixed(0) < 0 ? 0 : 24 - duration.asHours().toFixed(0))
            })
        },
        getGeolocationPosition() {
            return new Promise(resolve => {
                navigator.geolocation.getCurrentPosition(position => {
                    resolve(position);
                },
    error => {
                    $('#access_location').fadeIn();
                });
            });
        },
        updateGeolocationPosition(position, user) {
            axios.post(process.env.MIX_API_URL + 'driver-location-update',
                {
                    coordinates: {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }
                },
                {
                    headers: {
                        Accept: "application/json",
                        Authorization: user.access_token
                    }
                })
        },
        logout() {
            this.$confirm({
                title: 'Are you sure?',
                message: 'Are you sure you want to logout?',
                button: {
                    yes: 'Yes',
                    no: 'Cancel'
                },
                callback: confirm => {
                    if (confirm) {
                        localStorage.removeItem('user');
                        this.$router.push({name: 'login'})
                    }
                }
            })
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('sidebar-component', require('./components/partials/SidebarComponent'));
Vue.component('topnav-component', require('./components/partials/TopnavComponent'));
Vue.component('order-card-component', require('./components/partials/OrderCardComponent'));
Vue.component('empty-component', require('./components/partials/EmptyDataComponent'));
Vue.component('loading-component', require('./components/partials/LoadingComponent'));

const doorder_app = new Vue({
    created: function () {
        //Update User Location
        this.timer = setInterval(() => {
            let user = JSON.parse(localStorage.getItem('user'));
            if (user != null) {
                this.getGeolocationPosition().then(position => this.updateGeolocationPosition(position, user));
                console.log('driver location updated');
            }
        }, 20000);

        //Firebase Configuration
        var config = {
            apiKey: "AIzaSyBYqNsqffWTgHtxdt7Pl5SXMJEJdsaWwrM",
            authDomain: "bumblebee-833833.firebaseapp.com",
            projectId: "bumblebee-833833",
            storageBucket: "bumblebee-833833.appspot.com",
            messagingSenderId: "589243070383",
            appId: "1:589243070383:web:96a6bc7fa6006c81b2e15a",
            measurementId: "G-V7JBXL9PL5"
        };
        firebase.initializeApp(config);
        let messaging = this.messaging = firebase.messaging();

        Notification.requestPermission().then(function (permission) {
            messaging.getToken().then(token => {
                let user = JSON.parse(localStorage.getItem('user'));
                let oldToken = localStorage.getItem('firebase_token');
                if (user && token !== oldToken) {
                    axios.post(process.env.MIX_API_URL + 'update-driver-firebase-token',{
                            firebase_token: token
                        },
                        {
                            headers: {
                                Accept: "application/json",
                                Authorization: user.access_token
                            }
                        }).then(res => {
                        localStorage.setItem('firebase_token', token)
                    }).catch(err => {
                        console.log(err);
                    });
                }
            });

            messaging.onMessage(notification => {
                Vue.$confirm(
                    {
                        title: notification.data.title,
                        message: notification.data.message,
                        button: {
                            yes: 'View'
                        },
                        /**
                         * Callback Function
                         * @param {Boolean} confirm
                         */
                        callback: confirm => {
                            router.push({name: 'order-details', params: {
                                id: notification.data.order_id,
                            }});
                            window.location.reload();
                        }
                    }
                )
            });
        });
    },
    el: '#app',
    router
});
