<template>
  <div>
    <div class="step-one" v-if="currentStep === 1">
      <div class="row mt-4">
        <div class="col-md-12 text-center">
          <img class="profile-image" src="images/garden_help_driver_assets/complete-your -profile.png" alt="GardenHelp">
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12 text-center">
          <p class="complete-profile-text">
            Please Complete your Profile
            <br>
            To Start Receiving Jobs
          </p>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12 text-center">
          <button class="btn doorder-btn" @click="moveToStepTwo()">
            Complete
          </button>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="container mt-3">
        <form @submit="updateProfile">
          <div class="row">
            <div class="col-md-12 mb-3 title-text">
              My Profile
            </div>
<!--            <div class="col-md-12">-->
<!--              <div class="form-group">-->
<!--                <label class="my-label">First Name</label>-->
<!--                <input type="text" class="form-control" v-model="fist_name">-->
<!--              </div>-->
<!--            </div>-->
            <div class="col-md-12">
              <div class="form-group">
                <label class="my-label">Full Name</label>
                <input type="text" class="form-control" v-model="full_name" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="my-label">Email</label>
                <input type="text" class="form-control" v-model="email" readonly>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="my-label">Phone Number</label>
                <input type="text" class="form-control" v-model="phone" readonly>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="my-label">Select Working hours</label>
                <input type="text" class="form-control" data-toggle="modal" data-target="#workingHoursModal" v-model="business_hours" required>
              </div>
            </div>
            <div class="col-md-12 text-center mt-3 mb-3">
              <a href="#" class="change-password" data-toggle="modal" data-target="#changePasswordModal">
                Change password
              </a>
            </div>
            <div class="col-md-12 text-center">
              <button class="btn btn-lg doorder-btn" style="width: 100%" type="submit" :disabled="isLoading">
                {{!isLoading ? 'Save' : ''}}
                <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Change Password Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
              </div>
              <form @submit="changePassword">
                <div class="modal-body">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="my-label">Old Password</label>
                        <input type="text" class="form-control" v-model="old_password" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="my-label">New Password</label>
                        <input type="text" class="form-control" v-model="new_password" required>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="my-label">Password Confirmation</label>
                        <input type="text" class="form-control" v-model="password_confirmation" required>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn doorder-btn">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Working Hours Modal -->
      <div class="modal fade" id="workingHoursModal" tabindex="-1" role="dialog" aria-labelledby="workingHoursModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="workingHoursModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
              <div id="business_hours_container" class="row"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn doorder-btn" @click="serializeBusinessHours()" data-dismiss="modal">Save changes</button>
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
    return ({
      currentStep: 1,
      isLoading: false,
      business_hours_initial_array: [
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null},
        {"isActive":true,"timeFrom":null,"timeTill":null}
      ],
      full_name: '',
      email: '',
      phone: '',
      business_hours: '',
      business_hours_json: '',
      old_password: '',
      new_password: '',
      password_confirmation: '',
    });
  },
  mounted() {
    this.getProfile();
  },
  destroyed() {

  },
  methods: {
    moveToStepTwo() {
      this.currentStep = 2;
      setTimeout(() => {
        window['business_hours_container'] = $('#business_hours_container').businessHours({
          operationTime: this.business_hours_initial_array,
          dayTmpl:'<div class="dayContainer" style="width: 80px;">' +
              '<div data-original-title="" class="colorBox"><input type="checkbox" class="invisible operationState"></div>' +
              '<div class="weekday"></div>' +
              '<div class="operationDayTimeContainer">' +
              '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sun"></i></span></div><input type="text" class="mini-time form-control operationTimeFrom" name="startTime" value=""></div>' +
              '<div class="operationTime input-group" style="flex-wrap: nowrap;"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-moon"></i></span></div><input type="text" class="mini-time form-control operationTimeTill" name="endTime" value=""></div>' +
              '</div></div>',
          checkedColorClass: 'workingBusinssDay',
          uncheckedColorClass: 'dayOff',
        })
      }, 300);
    },
    serializeBusinessHours() {
      let businessHoursoutput = window['business_hours_container'].serialize()
      let businessHoursText = '';
      let businessHours = {};
      let weekDays = {
        0:'Monday',
        1:'Tuesday',
        2:'Wednesday',
        3:'Thursday',
        4:'Friday',
        5:'Saturday',
        6:'Sunday',
      }
      for (let item of businessHoursoutput) {
        if (item.isActive) {
          businessHoursText += weekDays[businessHoursoutput.indexOf(item)] + ': From:' + item.timeFrom + ', To: ' + item.timeTill + '/'
        }
        let key = weekDays[businessHoursoutput.indexOf(item)]
        businessHours[key] = item;
      }
      this.business_hours = businessHoursText;
      this.business_hours_json = businessHours;
    },
    changePassword(e) {
      e.preventDefault();
      //Check if password confirmed
      if (this.new_password === this.password_confirmation) {
        let user = JSON.parse(localStorage.getItem('user'));
        axios.post(process.env.MIX_API_URL + 'change-password',{
              old_password: this.old_password,
              new_password: this.new_password,
            },
            {
              headers: {
                Accept: "application/json",
                Authorization: user.access_token
              }
            })
            .then(res => {
              Vue.$toast.success(res.data.message, {
                position: 'top'
              });
            })
            .catch(err => {
              if (err.response.status === 401) {
                this.unauthorizedUser();
              }
              Vue.$toast.error(err.response.data.message, {
                position: 'top'
              });
            });
      } else {
        Vue.$toast.error('Password confirmation doesn\'t match Password', {
          position: 'top'
        });
      }
    },
    updateProfile(e) {
      e.preventDefault();
      let user = JSON.parse(localStorage.getItem('user'));
      axios.post(process.env.MIX_API_URL + 'update-profile',{
            name: this.full_name,
            business_hours: this.business_hours,
            business_hours_json: this.business_hours_json,
          },
          {
            headers: {
              Accept: "application/json",
              Authorization: user.access_token
            }
          })
          .then(res => {
            Vue.$toast.success(res.data.message, {
              position: 'top'
            });
            //Profile has comleted
            user.is_profile_completed = 1

            localStorage.setItem('user', JSON.stringify(user))

            this.$router.push({
              name: 'orders-list'
            });
          })
          .catch(err => {
            Vue.$toast.error(err.response.data.message, {
              position: 'top'
            });
          });
    },
    getProfile() {
      let user = JSON.parse(localStorage.getItem('user'));
      axios.get(process.env.MIX_API_URL + 'get-profile',
          {
            headers: {
              Accept: "application/json",
              Authorization: user.access_token
            }
          })
          .then(res => {
            this.full_name = res.data.data.full_name;
            this.email = res.data.data.email;
            this.phone = res.data.data.phone;
          })
          .catch(err => {
            Vue.$toast.error(err.response.data.message, {
              position: 'top'
            });
          });
    }
  }
}
</script>

<style>
 .profile-image {
   width: 344px;
   height: 162px;
   margin: 20px 0px;
   padding: 0 0 5px;
 }
 .complete-profile-text {
   font-family: Roboto;
   font-size: 18px;
   font-weight: 300;
   letter-spacing: 0.99px;
   text-align: center;
   color: #4d4d4d;
 }
 .doorder-btn {
   width: 316px;
 }
 .change-password {
   font-size: 14px;
   letter-spacing: 0.77px;
   color: #4d4d4d;
 }
 .title-text {
   font-family: Roboto;
   font-size: 16px;
   line-height: 1.19;
   letter-spacing: 1.14px;
   color: #4d4d4d;

 }

 label {
   font-family: Roboto;
   font-size: 15px;
   letter-spacing: 0.32px;
   color: #cdcdcd;
   margin-bottom: 0;
 }

 input.form-control {
   border: none;
   border-bottom: 1px solid #d7d7d7;
 }
 input.form-control:focus {
   border: none;
   border-bottom: 1px solid #60a244;
   box-shadow: none;
   outline: 0 none;
 }

 .modal-header,.modal-footer {
   border: none;
 }

 .workingBusinssDay {
   background-color: #60a244;
   border-radius: 2px !important;
   border: none !important;
   max-height: 21px !important;
 }

 .dayOff {
   background-color: #eeeeee;
   border-radius: 2px;
   border: none!important;
   max-height: 21px!important;
 }

 .dayContainer {
   height: 135px;
 }

 input.form-control[readonly] {
   background-color: transparent;
 }
</style>
