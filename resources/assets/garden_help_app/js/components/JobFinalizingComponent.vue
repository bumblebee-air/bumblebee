<template>
  <div class="container" v-if="steps == 1" style="overflow-x: auto;">
    <form action="" @submit="submitServices">
      <div class="row">
        <div class="col-md-12 image-container">
          <img class="job-finaliz-image" src="images/garden_help_driver_assets/complete-your -profile.png" alt="No Data Found">
        </div>
      </div>
      <div class="row justify-content-center pt-5 pb-5">
        <p class="form-title">
          Please Complete the Following Details
        </p>
      </div>
      <div class="row justify-content-center pl-1 pr-1">
        <div class="col-md-12 mb-2">
          <label class="form-label" for="services_types">Services Type</label>
          <input class="form-control" id="services_types" type="text" data-toggle="modal" data-target="#services_types_Modal" v-model="service_types_input" required>
        </div>

        <div class="col-md-12 mb-2" v-for="item in service_types" v-if="item.is_checked == true">
          <label class="form-label" for="number_of_hours">Number of Hours ({{item.title}})</label>
          <input class="form-control" id="number_of_hours" type="text" v-model="item.min_hours" required>
        </div>
      </div>
      <div class="row justify-content-center pl-1 pr-1">
        <div class="col-md-12 mb-2">
          <label class="form-label" for="services_types">Other Expenses</label>
          <input class="form-control" id="services_types" type="text" data-toggle="modal" data-target="#other_expenses_Modal" v-model="other_expenses_input">
        </div>
        <div class="col-md-12 mt-2" v-for="item in other_expenses" v-if="item.is_checked == true">
          <div v-if="item.name !== 'other'">
            <label class="form-label" for="number_of_hours">{{item.name == 'other' ? 'Add The Other Expenses type' : item.title+' Cost (€)'}}</label>
            <input class="form-control" id="number_of_hours" type="number" v-model="item.value" required>
          </div>
          <div v-else>
            <div>
              <label class="form-label" for="number_of_hours">Add The Other Expenses Type</label>
              <input class="form-control" id="number_of_hours" type="text" v-model="item.title" required>
            </div>
            <label class="form-label" for="number_of_hours">Add The Other Expenses Cost (€)</label>
            <input class="form-control" id="number_of_hours" type="number" v-model="item.value" required>
          </div>
        </div>
        <div class="col-md-12 mb-2">
          <label class="form-label" for="services_types">Other Expenses Receipt</label>
          <input class="form-control" type="text" id="expenses_receipt" @click="clickOnExpensesReceiptPhoto()">
          <input type="file" id="expenses_receipt_input" @change="changeExpensesReceiptImage" accept="image/*" style="display: none">
        </div>
        <div class="col-md-12 mb-2">
          <label class="form-label" for="notes">Notes: (Optional)</label>
          <textarea class="form-control" type="text" id="expenses_receipt" rows="4"></textarea>
        </div>
      </div>

      <div class="row justify-content-center align-content-center mt-5">
        <button class="btn btn-lg doorder-btn" type="submit">
          <!--        {{!isLoading ? 'Submit' : ''}}-->
          <!--        <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>-->
          SUBMIT
        </button>
      </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="services_types_Modal" tabindex="-1" role="dialog" aria-labelledby="services_types_Modal_Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="services_types_Modal_Label">Services Types</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12" v-for="(type, index) in service_types">
                <div class="d-flex justify-content-between" @click="toggleCheckedValue(type)">
                  <label :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">{{ type.title }}</label>
                  <div class="my-check-box" id="check">
                    <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modal-button-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn modal-button-done" data-dismiss="modal" @click="changeSelectedValue()">Save changes</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="other_expenses_Modal" tabindex="-1" role="dialog" aria-labelledby="services_types_Modal_Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="services_types_Modal_Label">Others Expenses</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12" v-for="(type, index) in other_expenses">
                <div class="d-flex justify-content-between" @click="toggleCheckedValue(type)">
                  <label :class="type.is_checked == true ? 'my-check-box-label my-check-box-label-checked' : 'my-check-box-label'">{{ type.title }}</label>
                  <div class="my-check-box" id="check">
                    <i :class="type.is_checked == true ? 'fas fa-check-square checked' : 'fas fa-check-square'"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modal-button-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn modal-button-done" data-dismiss="modal" @click="changeSelectedValue('other_expences')">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container" v-else-if="steps == 2">
    <div class="row justify-content-center pt-4">
      <p class="upload-title">
        Please Upload some of the
        <br>
        Job Images
      </p>
    </div>
    <div class="row justify-content-center">
      <div class="upload-logo text-center" @click="clickOnJobImagePhoto()">
        <i class="fas fa-cloud-upload-alt"></i>
      </div>
      <input type="file" id="job_image" @change="changeJobImage" accept="image/*" style="display: none">
    </div>
    <div class="row text-center p-2">
      <img :src="job_image" alt="Job Image" v-if="job_image" style="width: 100%">
    </div>
    <div class="row justify-content-center align-content-center mt-5">
      <div class="col-md-12 text-center">
        <button class="btn btn-lg doorder-btn" style="width: 80%" type="submit" @click="submitJobImage('submit')" :disabled="isLoading">
                  {{!isLoading ? 'SUBMIT' : ''}}
                  <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
<!--          SUBMIT-->
        </button>
      </div>
      <div class="col-md-12 mt-2"></div>
      <div class="col-md-12 text-center">
        <button class="btn btn-lg doorder-btn danger" style="width: 80%" type="submit" data-toggle="modal" data-target="#job_image_skip_Modal">
          <!--        {{!isLoading ? 'Submit' : ''}}-->
          <!--        <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>-->
          SKIP
        </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="job_image_skip_Modal" tabindex="-1" role="dialog" aria-labelledby="job_image_skip_Modal_Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="job_image_skip_Modal_Label">Skip reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <textarea class="form-control" v-model="skip_reason" rows="10" style="width: 100%"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modal-button-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn modal-button-done" data-dismiss="modal" @click="submitJobImage('skip')" :disabled="isLoading">
              {{!isLoading ? 'Submit' : ''}}
              <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container" v-else>
    <div class="row justify-content-center pt-4">
      <p class="text-center">
        Please Scan the QR
        <br>
        Code to Confirm Delivery
      </p>
    </div>
    <div class="row justify-content-center p-3">
            <qrcode-vue :value="$route.params.contractor_confirmation_code" size="200" level="H" id="scanner">
              hello there
            </qrcode-vue>
    </div>
    <div class="row justify-content-center align-content-center mt-5">
      <div class="col-md-12 text-center">
        <button class="btn btn-lg doorder-btn danger" style="width: 80%" type="submit" data-toggle="modal" data-target="#confiramtion_skip_Modal">
          <!--        {{!isLoading ? 'Submit' : ''}}-->
          <!--        <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>-->
          SKIP
        </button>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confiramtion_skip_Modal" tabindex="-1" role="dialog" aria-labelledby="confirmation_skip_Modal_Label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmation_skip_Modal_Label">Confirmation Skip reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <textarea class="form-control" v-model="confirmation_skip_reason" rows="10" style="width: 100%"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn modal-button-close" data-dismiss="modal">Close</button>
            <button type="button" class="btn modal-button-done" data-dismiss="modal" @click="skipConfirmation" :disabled="isLoading">
              {{!isLoading ? 'Submit' : ''}}
              <i class="fas fa-spinner fa-pulse" v-if="isLoading"></i>
            </button>
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
      steps: 1,
      service_types_input: '',
      service_types: [],
      job_image: '',
      skip_reason: '',
      job_services_types_json: [],
      submittedForm: '',
      other_expenses: [
        {
          name: 'green_waste',
          title: 'Green Waste',
          is_checked: false,
          value: ''
        },
        {
          name: 'parking',
          title: 'Parking',
          is_checked: false,
          value: ''
        },
        {
          name: 'material',
          title: 'Material',
          is_checked: false,
          value: ''
        },
        {
          name: 'other',
          title: 'Other',
          is_checked: false,
          value: ''
        },
      ],
      other_expenses_input: '',
      job_other_expenses_json: [],
      other_expenses_receipt: '',
      isLoading: false,
      confirmation_skip_reason: ''
    }
  },
  mounted() {
    if (!this.$route.params.id || !this.$route.params.contractor_confirmation_code) {
      this.$router.go(-1);
    } else {
      this.service_types = JSON.parse(this.$route.params.services_types);
      this.changeSelectedValue();
    }
  },
  methods: {
    toggleCheckedValue(type) {
      type.is_checked = !type.is_checked;
    },
    changeSelectedValue(type = 'services_types') {
      if (type === 'services_types') {
        let service_types_input = '';
        let job_services_types_json = [];
        for (let item of this.service_types) {
          item.is_checked === true ? service_types_input += (service_types_input == '' ? item.title : ', ' + item.title) : '';
          item.is_checked === true ? job_services_types_json.push(item) : '';
        }
        this.service_types_input = service_types_input;
        this.job_services_types_json = job_services_types_json;
      } else {
        let other_expenses_input = '';
        let job_other_expenses_json = [];
        for (let item of this.other_expenses) {
          item.is_checked === true ? other_expenses_input += (other_expenses_input == '' ? item.title : ', ' + item.title) : '';
          item.is_checked === true ? job_other_expenses_json.push(item) : '';
        }
        this.other_expenses_input = other_expenses_input;
        this.job_other_expenses_json = job_other_expenses_json;
      }
    },
    submitServices(e) {
      e.preventDefault();
      this.steps = 2;
    },
    submitJobImage(type) {
      this.isLoading = true;
      if (type !== 'skip' && !this.job_image) {
        Vue.$toast.warning('Job image is required.', {
          position: 'top'
        });
        return;
      }
      this.submitJobDetails();
    },
    submitJobDetails() {
      let user = JSON.parse(localStorage.getItem('user'));
      axios.post(process.env.MIX_API_URL + 'contractor-status-update',{
            job_id: this.$route.params.id,
            status: 'completed',
            job_services_types_json: this.job_services_types_json,
            job_image: this.job_image,
            skip_reason: this.skip_reason,
            extra_expenses_json: this.job_other_expenses_json,
            extra_expenses_receipt: this.extra_expenses_receipt
          },
          {
            headers: {
              Accept: "application/json",
              Authorization: user.access_token
            }
          }).then(
          res => this.fetchJobDetailsResponse(res)
      ).catch(
          err => this.fetchJobDetailsError(err)
      );
    },
    fetchJobDetailsResponse(res) {
        // this.$router.push({
        //   name: 'orders-list',
        // });
      this.steps = 3
      Vue.$toast.success('The job completed successfully', {
        position: "top"
      });
    },
    fetchJobDetailsError(err) {
      if (err.response.status === 401) {
        this.unauthorizedUser();
      }
    },
    clickOnJobImagePhoto() {
      $('#job_image').trigger('click');
    },
    clickOnExpensesReceiptPhoto() {
      console.log('clicked');
      $('#expenses_receipt_input').trigger('click');
    },
    changeJobImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
        this.job_image = e.target.result;
      };
    },
    changeExpensesReceiptImage(e) {
      const image = e.target.files[0];
      const reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e =>{
        this.extra_expenses_receipt = e.target.result;
      };
      $('#expenses_receipt').val(image.name)
    },
    skipConfirmation() {
      let user = JSON.parse(localStorage.getItem('user'));
      axios.post(process.env.MIX_API_URL + 'skip-confirmation',{
            job_id: this.$route.params.id,
            skip_reason: this.confirmation_skip_reason,
          },
          {
            headers: {
              Accept: "application/json",
              Authorization: user.access_token
            }
          }).then(
          res => {
            this.$router.push({
              name: 'orders-list',
            });
            Vue.$toast.success('The job confirmation skipped successfully', {
              position: "top"
            });
          }
      ).catch(
          err => this.fetchJobDetailsError(err)
      );
    },
  }
}
</script>

<style scope>
  .image-container {
    text-align: center;
    padding-top: 60px;
  }

  .job-finaliz-image {
    width: 80%;
  }
  .form-title {
    font-size: 16px;
    line-height: 1.19;
    letter-spacing: 1.14px;
    color: #4d4d4d;
  }

  lable.form-label {
    font-size: 17px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: 0.32px;
    color: #acb1c0;
  }

  input.form-control {
    border: none;
    border-bottom: 1px solid #d7d7d7;
  }

  input.form-control:focus {
    outline: none;
    border: none;
    border-bottom: 1px solid #60a244;
  }

  .my-check-box-label-checked {
    color: #6c707c !important;
    font-weight: bold !important;
  }

  .my-check-box {
    width: 15px;
    height: 15px;
    color: #c3c7d2;
  }

  .my-check-box .checked, .checked {
    color: #60a244 !important;
  }

  .modal-header {
    border-bottom: none;
  }

  .modal-footer {
    border-top: none;
    padding: 0 !important;
  }

  .modal-button-close {
    font-family: Roboto;
    font-size: 18px !important;
    font-weight: 500;
    font-stretch: normal;
    font-style: normal;
    line-height: 2.5 !important;
    letter-spacing: 0.17px !important;
    color: #767676 !important;
  }

  .modal-button-done {
    font-family: Roboto;
    font-size: 18px !important;
    font-weight: 500;
    font-stretch: normal;
    font-style: normal;
    line-height: 2.5 !important;
    letter-spacing: 0.17px !important;
    color: #60a244 !important;
  }
  .upload-title {
    font-size: 18px;
    letter-spacing: 0.99px;
    text-align: center;
    color: #4d4d4d;
  }

  .upload-logo {
    width: 117px;
    height: 117px;
    padding: 35px 24px 33px 23px;
    box-shadow: 0 3px 5px 0 #60a244;
    background-color: #60a244;
    border-radius: 50%;
  }

  .upload-logo i {
    font-size: 50px;
    color: white;
  }

  .danger {
    background-color: #d85656!important;
  }
  #app {
    overflow: auto;
  }
</style>
