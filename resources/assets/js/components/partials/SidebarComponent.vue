<template>
    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">DoOrder App </div>
        <div class="list-group list-group-flush">
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>-->
<!--            <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>-->
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
    }
</script>
