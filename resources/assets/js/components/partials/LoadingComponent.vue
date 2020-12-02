<template>
    <div id="loading">
        <div style="height: 100%; width: 100%;" class="d-flex justify-content-center align-items-center">
            <img src="images/doorder_driver_assets/loading.gif" alt="Loading">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>

<style>
    #loading {
        position: fixed;
        bottom: 0;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 999999;
        background-color: white;
    }
</style>
