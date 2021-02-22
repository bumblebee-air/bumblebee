<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
<!--        <i class="fas fa-bars" id="menu-toggle"></i>-->
        <div class="navbar-brand d-flex">
            <span class="navbar-toggler-icon" id="menu-toggle"></span>
            <img class="navbar-brand-logo float-left" src="images/gardenhelp/Garden-help-new-logo.png" alt="DoOrder Logo">
        </div>

        <div class="current-time">
            {{new Date | moment('Do MMMM YYYY')}}
        </div>

    </nav>
</template>

<script>
    export default {
        mounted() {
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });
        }
    }
</script>

<style>
    .bg-white {
        background-color: white;
    }

    .bg-transparent {
        background-color: transparent;
    }

    .navbar-brand-logo {
        /*width: 85px;*/
        height: 52px;
        margin-left: 25px;
    }

    #menu-toggle {
        color: #767676;
        margin-top: 17px;
    }

    .current-time {
        font-size: 11px;
        letter-spacing: 0.79px;
        color: #45597a;
        margin-top: 32px;
    }
</style>
