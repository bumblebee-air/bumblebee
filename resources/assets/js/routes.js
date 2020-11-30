import VueRouter from 'vue-router';
import LoginComponent from "./components/LoginComponent";
import AppComponent from "./components/AppComponent";
import OrdersListComponent from "./components/OrdersListComponent";
import OrderDetailsComponent from "./components/OrderDetailsComponent";

const router = new VueRouter({
    routes: [
        // dynamic segments start with a colon
        {
            path: '/login',
            name: 'login',
            component: LoginComponent
        },
        {
            path: '/order-details/:id',
            name: 'order-details',
            component: OrderDetailsComponent
        },
        {
            path: '/',
            name: 'main-app',
            component: AppComponent,
            children: [
                {
                    path: '/',
                    redirect: {name: 'orders-list'}
                },
                {
                    path: 'orders-list',
                    name: 'orders-list',
                    component: OrdersListComponent
                }
            ]
        }
    ]
});

export default router;
