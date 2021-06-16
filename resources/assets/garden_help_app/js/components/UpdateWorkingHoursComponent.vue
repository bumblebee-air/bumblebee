<template>
  <div>
    <div class="row mt-4">
      <div class="col-md-12 text-center">
        <p class="complete-profile-text text-bold">
          Welcome back, {{full_name}}
        </p>

        <p class="complete-profile-text bold">
          Please update your weekly working days and hours with GardenHelp
        </p>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12 text-center">
        <img class="profile-image" src="images/garden_help_driver_assets/add_date_and_time.png" alt="GardenHelp">
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12 text-center">
        <button class="btn doorder-btn" data-toggle="modal" data-target="#workingHoursModal">
          SET DAYS AND HOURS
        </button>
      </div>
    </div>

    <!-- Working Hours Modal -->
    <div class="modal fade" id="workingHoursModal" tabindex="-1" role="dialog" aria-labelledby="workingHoursModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="workingHoursModalLabel">Update Working Hours</h5>
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
</template>

<script>

export default {
  name: 'UpdateWorkingHours',
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
      this.updateProfile()
    },
    updateProfile() {
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
            if (res.data.data.business_hours != null) {
              let business_hours_array = [];
              for (let item in res.data.data.business_hours) {
                business_hours_array.push(res.data.data.business_hours[item]);
              }
              this.business_hours_initial_array = business_hours_array;
            }
            this.moveToStepTwo();
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

.text-bold {
  font-weight: bolder;
}
</style>
