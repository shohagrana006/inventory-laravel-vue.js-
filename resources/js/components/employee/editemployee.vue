<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/employee" class="btn btn-primary"
              >All Employee</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4">Update Employee</h1>
              </div>
              <form
                class="user"
                @submit.prevent="employeeUpdate"
                enctype="multipart/form-data"
              >
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleFirstName"
                      placeholder="Name"
                      v-model="form.name"
                    />
                    <small class="text-danger" v-if="errors.name">{{
                      errors.name[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="email"
                      class="form-control form-control-user"
                      id="exampleInputEmail"
                      placeholder="Email Address"
                      v-model="form.email"
                    />
                    <small class="text-danger" v-if="errors.email">{{
                      errors.email[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      placeholder="Phone"
                      v-model="form.phone"
                    />
                    <small class="text-danger" v-if="errors.phone">{{
                      errors.phone[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Address"
                      v-model="form.address"
                    />
                    <small class="text-danger" v-if="errors.address">{{
                      errors.address[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      placeholder="Salary"
                      v-model="form.salary"
                    />
                    <small class="text-danger" v-if="errors.salary">{{
                      errors.salary[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <input
                      type="date"
                      class="form-control form-control-user resize_int"
                      id="exampleRepeatPassword"
                      placeholder="Joining Date"
                      v-model="form.joining_date"
                    />
                    <small class="text-danger" v-if="errors.joining_date">{{
                      errors.joining_date[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleInputPassword"
                      placeholder="Nid"
                      v-model="form.nid"
                    />
                    <small class="text-danger" v-if="errors.nid">{{
                      errors.nid[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="file"
                      class="form-control form-control-user resize_int"
                      id="exampleInputPassword"
                      placeholder="Choose Image"
                      @change="onFileSelected"
                    />
                    <small class="text-danger" v-if="errors.photo">{{
                      errors.photo[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <img :src="form.photo" height="50" width="50" alt="" />
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Update Employee
                </button>
              </form>
              <hr />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  data() {
    return {
      form: {
        name: "",
        email: "",
        phone: "",
        address: "",
        salary: "",
        nid: "",
        photo: "",
        new_photo: "",
        joining_date: "",
      },
      errors: {},
    };
  },
  created() {
    let id = this.$route.params.id;
    axios
      .get("/api/employee/" + id)
      .then(({ data }) => (this.form = data))
      .catch(console.log("error"));
  },
  methods: {
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.img_validation();
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.new_photo = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    employeeUpdate() {
      let id = this.$route.params.id;
      axios
        .patch("/api/employee/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "employee" });
          Notification.create();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>

<style>
.resize_int {
  padding-top: 15px !important;
  padding-bottom: 35px !important;
}
</style>
