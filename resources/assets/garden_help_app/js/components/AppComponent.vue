<template>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
            <sidebar-component></sidebar-component>
        <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper">

        <!-- Topnav-->
            <topnav-component></topnav-component>
        <!-- Topnav-->

            <div class="container-fluid">
                <router-view></router-view>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return ({

            })
        },
        mounted() {

        }
    }
</script>

<style>
    #wrapper {
        overflow-x: hidden;
    }

    #sidebar-wrapper {
        min-height: 100vh;
        margin-left: -15rem;
        -webkit-transition: margin .25s ease-out;
        -moz-transition: margin .25s ease-out;
        -o-transition: margin .25s ease-out;
        transition: margin .25s ease-out;
    }

    #sidebar-wrapper .sidebar-heading {
        padding: 0.875rem 1.25rem;
        font-size: 1.2rem;
    }

    #sidebar-wrapper .list-group {
        width: 15rem;
    }

    #page-content-wrapper {
        min-width: 100vw;
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: 0;
    }

    @media (min-width: 768px) {
        #sidebar-wrapper {
            margin-left: 0;
        }

        #page-content-wrapper {
            min-width: 0;
            width: 100%;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: -15rem;
        }
    }
</style>
