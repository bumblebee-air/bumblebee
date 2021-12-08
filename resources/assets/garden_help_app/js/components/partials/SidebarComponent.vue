<template>
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">GardenHelp App </div>
        <div class="list-group list-group-flush">
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>-->
<!--            <router-link :to="{name: 'profile'}" href="#" class="list-group-item list-group-item-action bg-light">Profile</router-link>-->
            <router-link :to="{name: 'orders-list'}" href="#" class="list-group-item list-group-item-action bg-light">Jobs list</router-link>
            <router-link :to="{name: 'settings'}" href="#" class="list-group-item list-group-item-action bg-light">Settings</router-link>
            <a @click="logout" class="list-group-item list-group-item-action bg-light">Logout</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        methods: {

        }
    }
</script>
