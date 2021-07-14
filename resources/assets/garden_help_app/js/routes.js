import VueRouter from 'vue-router';
import LoginComponent from "./components/LoginComponent";
import AppComponent from "./components/AppComponent";
import OrdersListComponent from "./components/OrdersListComponent";
import OrderDetailsComponent from "./components/OrderDetailsComponent";
import OrderDeliveredComponent from "./components/OrderDeliveredComponent";
import ForgotPasswordComponent from "./components/ForgotPasswordComponent";
import ProfileComponent from "./components/ProfileComponent";
import JobFinalizingComponent from './components/JobFinalizingComponent';
import UpdateWorkingHours from "./components/UpdateWorkingHoursComponent";
import PageNotFound from './components/PageNotFoundComponent'

const router = new VueRouter({
    routes: [
        // dynamic segments start with a colon
        {
            path: '/login',
            name: 'login',
            component: LoginComponent,
            beforeEnter: (to, from, next) => checkIfAuthed(to, from, next)
        },// dynamic segments start with a colon
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
            path: '/profile',
            name: 'user-profile',
            component: ProfileComponent,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next)
        },
        {
            path: '/update-working-hours',
            name: 'user-profile',
            component: UpdateWorkingHours,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next)
        },
        {
            path: '/job-finalizing',
            name: 'job-finalizing',
            component: JobFinalizingComponent,
            beforeEnter: (to, from, next) => redirectIfNotAuthed(to, from, next)
        },
        {
            path: '/',
            name: 'main-app',
            component: AppComponent,
            beforeEnter: (to, from, next) => {
                redirectIfNotAuthed(to, from, next);
                checkIfProfileCompleted(to, from, next);
            },
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
        },
        {
            path: '*',
            name: '404',
            component: PageNotFound,
        },
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

function checkIfProfileCompleted(to, from, next) {
    let user = localStorage.getItem('user');
    if (user === null) {
        next({name: 'login'})
    } else {
        user = JSON.parse(user);
        if (user.is_profile_completed === 0) {
            next({name: 'user-profile'})
        } else {
            next();
        }
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
