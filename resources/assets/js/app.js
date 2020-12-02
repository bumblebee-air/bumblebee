import VueRouter from 'vue-router';
import VueToast from 'vue-toast-notification';
import * as VueGoogleMaps from 'vue2-google-maps'
import router from './routes';
import Vue2TouchEvents from 'vue2-touch-events'
import VueDraggableResizable from 'vue-draggable-resizable'
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
import VueMoment from 'vue-moment'
import VueConfirmDialog from 'vue-confirm-dialog'


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM',
        libraries: ['places', 'geometry'], // This is required if you use the Autocomplete plugin
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
Vue.use(VueMoment);

//Vue touch event
Vue.use(Vue2TouchEvents);

//VueJS Confirmation Dialog
Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)

Vue.mixin({
    methods: {
        getDrivingDistance(lat1, long1, lat2, long2) {
            return new Promise(resolve => {
                axios.get("https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyCeP4XM-6BoHM5qfPNh4dHC39t492y3BjM&origins="+ lat1 +","+ long1 +"&destinations="+ lat2 +","+ long2 +"&mode=driving")
                    .then(res => {
                        resolve({
                            distance: res.data.rows[0]['elements'][0].distance.value / 100,
                            duration: res.data.rows[0]['elements'][0].duration.text
                        });
                    })
            })
        },
        getOrderPassedTime(endData) {
            var now = Vue.moment(new Date()); //today date
            var end = Vue.moment(endData); // another date
            var duration = Vue.moment.duration(now.diff(end));
            return new Promise(resolve => {
                resolve(24 - duration.asHours().toFixed(0) < 0 ? 0 : 24 - duration.asHours().toFixed(0))
            })
        },
    },
})

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


//Geolocation Event
navigator.permissions.query({name: 'geolocation'}).then(function (permissionStatus) {
    if (permissionStatus.state != 'granted') {
        $('#access_location').fadeIn();
        requestGeolocationAccess();
    } else {
        $('#access_location').fadeOut();
    }
    permissionStatus.onchange = function () {
        if (this.state != 'granted') {
            requestGeolocationAccess();
            $('#access_location').fadeIn();
        } else {
            $('#access_location').fadeOut();
            location.reload();
        }
    };
});

function requestGeolocationAccess() {
    navigator.geolocation;
}


const app = new Vue({
    el: '#app',
    router
});
