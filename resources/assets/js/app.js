import VueRouter from 'vue-router';
import VueToast from 'vue-toast-notification';
import * as VueGoogleMaps from 'vue2-google-maps'
import router from './routes';
import Vue2TouchEvents from 'vue2-touch-events'
import VueDraggableResizable from 'vue-draggable-resizable'
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'


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
        libraries: 'places', // This is required if you use the Autocomplete plugin
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
})

//Vue Router
Vue.use(VueRouter);

//Vue Toast
Vue.use(VueToast);

//Vue Moment js
Vue.use(require('vue-moment'));

//Vue touch event
Vue.use(Vue2TouchEvents);

//Vue Resizable
Vue.component('vue-draggable-resizable', VueDraggableResizable);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('sidebar-component', require('./components/partials/SidebarComponent'));
Vue.component('topnav-component', require('./components/partials/TopnavComponent'));
Vue.component('order-card-component', require('./components/partials/OrderCardComponent'));

const app = new Vue({
    el: '#app',
    router
});
