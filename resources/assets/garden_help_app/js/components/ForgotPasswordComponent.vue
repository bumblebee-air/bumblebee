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
              <form class="form-signin" @submit="forgotPassword" v-if="current_step == 1">

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

                <div class="d-flex justify-content-center align-content-center">
                  <button class="btn btn-lg doorder-btn" type="submit" :disabled="isLoading">
                    {{!isLoading ? 'Forgot Password' : ''}}
                    <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
                  </button>
                </div>
              </form>
              <form class="form-signin" @submit="checkPasswordResetCode" v-if="current_step == 2">
                <div class="bmd-form-group my-4">
                  <div class="input-group">
                    <input type="text" id="code" name="code" class="form-control" placeholder="Forgot Password Code" required v-model="password_reset_code" :disabled="isLoading">
                  </div>
                </div>

                <div class="d-flex justify-content-center align-content-center">
                  <button class="btn btn-lg doorder-btn" type="submit" :disabled="isLoading">
                    {{!isLoading ? 'Check Code' : ''}}
                    <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
                  </button>
                </div>
              </form>
              <form class="form-signin" @submit="changeDriverPassword" v-if="current_step == 3">
                <div class="bmd-form-group my-4">
                  <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required v-model="password" :disabled="isLoading">
                  </div>
                </div>

                <div class="bmd-form-group my-4">
                  <div class="input-group">
                    <input type="password" id="confirmation_password" name="confirmation_password" class="form-control" placeholder="Confirmation Password" required v-model="confirmation_password" :disabled="isLoading">
                  </div>
                </div>

                <div class="d-flex justify-content-center align-content-center">
                  <button class="btn btn-lg doorder-btn" type="submit" :disabled="isLoading">
                    {{!isLoading ? 'Reset Password' : ''}}
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
      confirmation_password: '',
      password_reset_code: '',
      firebase_token: '',
      isLoading: false,
      current_step: 1,
    }
  },
  mounted() {
    if (Notification.permission === "granted") {
      this.firebase_token = localStorage.getItem('firebase_token')
    }
  },
  methods: {
    forgotPassword(e) {
      e.preventDefault();
      this.isLoading = true;
      axios.post(process.env.MIX_API_URL + 'contractor-forgot-password', {
        phone: this.phone.replaceAll(' ', ''),
      }, {
        headers: {
          Accept: "application/json"
        }
      }).then(
          res => this.fetchForgotPasswordResponse(res)
      ).catch(
          err => this.fetchForgotPasswordError(err)
      );
    },
    fetchForgotPasswordResponse(res) {
      Vue.$toast.success(res.data.message, {
        position: 'top'
      });
      this.current_step = 2;
      this.isLoading = false
    },
    fetchForgotPasswordError(err) {
      this.isLoading = false;
      Vue.$toast.error(err.response.data.message, {
        position: 'top'
      });
    },
    checkPasswordResetCode(e) {
      e.preventDefault();
      this.isLoading = true;
      axios.post(process.env.MIX_API_URL + 'driver-check-code', {
        phone: this.phone.replaceAll(' ', ''),
        password_reset_code: this.password_reset_code,
      }, {
        headers: {
          Accept: "application/json"
        }
      }).then(
          res => {
            if (res.data.message != '') {
              Vue.$toast.success(res.data.message, {
                position: 'top'
              });
            }
            this.current_step = 3;
            this.isLoading = false;
          }
      ).catch(
          err => {
            this.isLoading = false;
            Vue.$toast.error(err.response.data.message, {
              position: 'top'
            });
          }
      );
    },
    changeDriverPassword(e) {
      e.preventDefault();
      if (this.password !== this.confirmation_password) {
        Vue.$toast.error('Password is not matched with the confirmation', {
          position: 'top'
        });
      } else {
        this.isLoading = true;
        axios.post(process.env.MIX_API_URL + 'driver-change-password', {
          phone: this.phone.replaceAll(' ', ''),
          password_reset_code: this.password_reset_code,
          password: this.password
        }, {
          headers: {
            Accept: "application/json"
          }
        }).then(
            res => {
              Vue.$toast.success(res.data.message, {
                position: 'top'
              });
              this.isLoading = false;
              this.$router.push({name: 'login'})
            }
        ).catch(
            err => {
              this.isLoading = false;
              Vue.$toast.error(err.response.data.message, {
                position: 'top'
              });
            }
        );
      }
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
  color: #dcbd3b;
}
</style>
