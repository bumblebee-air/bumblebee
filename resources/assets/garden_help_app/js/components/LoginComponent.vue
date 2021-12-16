<template>
    <div class="wrapper" style='background-image: url("images/garden-help-side-bg.jpg");'>
        <div class="container">
            <div class="row login-row">
                <div class="col-lg-4 col-md-6 col-sm-8 mx-auto my-auto">
                    <div class="card card-login">
                        <div class="card-header text-center">
<!--                            <a href="https://bumblebee.host">-->
                                <img class="img-fluid login-logo" src="images/gardenhelp/Garden-help-new-logo.png" alt="GardenHelp Logo">
<!--                            </a>-->
                        </div>
                        <div class="card-body">
                            <form class="form-signin" @submit="login">
                                <div class="bmd-form-group my-4">
                                    <div class="input-group">
<!--                                        <input id="phone" class="form-control" name="phone" placeholder="Phone" required autofocus v-model="phone" :disabled="isLoading">-->
                                        <vue-tel-input
                                                v-model="phone"
                                                class="form-control"
                                                placeholder="Phone"
                                                defaultCountry="IE"
                                                :required="true"
                                                mode="international"
                                                :disabled="isLoading"
                                                :enabledCountryCode="false"></vue-tel-input>
                                    </div>
                                </div>

                                <div class="bmd-form-group my-4">
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required v-model="password" :disabled="isLoading">
                                    </div>
                                </div>
                                <div class="col-md-9 my-4 text-center">
                                  <router-link :to="{name: 'forgot-password'}" class="forgot-password">Forgot password?</router-link>
                                  <br>
                                  <a href="garden-help/contractors/registration" class="forgot-password">Sign Up</a>
                                </div>
                                <div class="d-flex justify-content-center align-content-center">
                                    <button class="btn btn-lg doorder-btn" type="submit" :disabled="isLoading">
                                        {{!isLoading ? 'Login' : ''}}
                                        <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                phone: '',
                password: '',
                firebase_token: '',
                isLoading: false
            }
        },
        mounted() {
            if (Notification.permission === "granted") {
                this.firebase_token = localStorage.getItem('firebase_token')
            }
        },
        methods: {
            login(e) {
                e.preventDefault();
                this.isLoading = true;
                axios.post(process.env.MIX_API_URL + 'driver-login', {
                    phone: this.phone.replaceAll(' ', ''),
                    password: this.password,
                    firebase_token: this.firebase_token
                }, {
                    headers: {
                        Accept: "application/json"
                    }
                }).then(
                    res => this.fetchLoginResponse(res)
                ).catch(
                    err => this.fetchLoginError(err)
                );
            },
            fetchLoginResponse(res) {
                localStorage.setItem('user', JSON.stringify({
                    access_token: res.data.token_type + res.data.access_token,
                    is_profile_completed: res.data.is_profile_completed,
                    user_name: res.data.user_name
                }));
                this.$router.push({
                    name: 'orders-list'
                });
            },
            fetchLoginError(err) {
                console.log(err);
                this.isLoading = false;
                Vue.$toast.error(err.response.data.message, {
                    position: 'top'
                });
            },
        }
    }
</script>

<style>
    .wrapper, .container, .login-row{
        height: 100%;
    }

    .wrapper {
        background-size: cover;
    }

    .card-login {
        padding: 41px 14px 27px 16px;
        opacity: 0.95;
        border-radius: 10.8px;
        box-shadow: 0 2px 43px 0 rgba(0, 0, 0, 0.13);
        background-color: #ffffff;
    }

    .card-login .card-header {
        background-color: transparent;
        border-bottom: 0;
    }

    .login-logo {
        width: 85px;
        /*height: 52px;*/
    }

    .forgot-password {
      font-size: 13px;
      letter-spacing: 0.24px;
      color: #60a244;
    }
</style>
