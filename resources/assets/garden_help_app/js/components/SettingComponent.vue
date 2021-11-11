<template>
  <div>
    <form>
      <div class="form-group row justify-content-between align-items-center pt-3">
        <label class="col">Reminder Notifications</label>
        <div class="col">
          <toggle-button class="float-right" :sync="true" v-model="is_notifiable"/>
        </div>
      </div>
      <div class="form-group row justify-content-center pt-3">
        <button class="btn btn-lg doorder-btn btn-block" @click="updateData()">
          Save
        </button>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        is_notifiable: false
      }
    },
    mounted() {
      this.getData();
    },
    methods: {
      getData() {
        let user = JSON.parse(localStorage.getItem('user'));
        axios.get(process.env.MIX_API_URL + 'get-setting', {
          headers: {
            Accept: "application/json",
            Authorization: user.access_token
          }
        }).then(
            res => {
              this.is_notifiable = res.data.data.is_notifiable == 1 ? true : false
            }
        ).catch(
            err => console.log(err)
        );
      },
      updateData() {
        let user = JSON.parse(localStorage.getItem('user'));
        axios.post(process.env.MIX_API_URL + 'update-setting', {'is_notifiable': this.is_notifiable}, {
          headers: {
            Accept: "application/json",
            Authorization: user.access_token
          }
        }).then(
            res => {
              Vue.$toast.success('Setting updated successfully',{
                position: 'top'
              });
            }
        ).catch(
            err => console.log(err)
        );
      }
    }
  }
</script>
