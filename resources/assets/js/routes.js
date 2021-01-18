import VueRouter from 'vue-router';
import LoginComponent from "./components/LoginComponent";
import AppComponent from "./components/AppComponent";
import OrdersListComponent from "./components/OrdersListComponent";
import OrderDetailsComponent from "./components/OrderDetailsComponent";
import OrderDeliveredComponent from "./components/OrderDeliveredComponent";
import ForgotPasswordComponent from "./components/ForgotPasswordComponent";

const router = new VueRouter({
    routes: [
        // dynamic segments start with a colon
        {
            path: '/login',
            name: 'login',
            component: LoginComponent,
            beforeEnter: (to, from, next) => checkIfAuthed(to, from, next)
        },
        {
            path: '/forgot-password',
            name: 'forgot-password',
            component: ForgotPasswordComponent,
            beforeEnter: (to, from, next) => checkIfAuthed(to, from, next)
        },
        {
            path: '/order-details/:id',
            name: 'order-details',
            component: OrderDetailsComponent,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next)
        },
        {
            path: '/order-delivered',
            name: 'order-delivered',
            component: OrderDeliveredComponent,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next)
        },
        {
            path: '/',
            name: 'main-app',
            component: AppComponent,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next),
            children: [
                {
                    path: '/',
                    redirect: {name: 'orders-list'},
                    beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next),
                },
                {
                    path: 'orders-list',
                    name: 'orders-list',
                    component: OrdersListComponent,
                    beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next),
                }
            ]
        }
    ]
});

function checkIfAuthed(to, from, next) {
    let user = localStorage.getItem('user')
    if (user != null) {
        next({name: 'orders-list'})
    } else {
        next();
    }
}

function redirectIfNotAuthed(to, from, next) {
    let user = localStorage.getItem('user');
    if (user === null) {
        next({name: 'login'})
    } else {
        next();
    }
}

// router.beforeEach((to, from, next) => {
//     // navigator.permissions.query({name: 'geolocation'}).then(function (permissionStatus) {
//     //     console.log('geolocation permission state is ', permissionStatus.state);
//     //     permissionStatus.onchange = function () {
//     //         console.log('geolocation permission state has changed to ', this.state);
//     //     };
//     // });
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(this.showCurrentPosition);
//     } else {
//         alert("Geolocation is not supported by this browser.");
//     }
//
// });


export default router;
