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
                <h1 class="h4 text-gray-900 mb-4">Pay Salary</h1>
              </div>
              <form class="user" @submit.prevent="paySalary">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Employee Name:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="exampleFirstName"
                      v-model="form.name"
                    />
                    <small class="text-danger" v-if="errors.name">{{
                      errors.name[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6">
                    <label for="">Employee Email:</label>
                    <input
                      type="email"
                      class="form-control"
                      v-model="form.email"
                    />
                    <small class="text-danger" v-if="errors.email">{{
                      errors.email[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Select Month:</label>
                    <select class="form-control" v-model="form.salary_month">
                      <option>January</option>
                      <option>February</option>
                      <option>March</option>
                      <option>April</option>
                      <option>May</option>
                      <option>June</option>
                      <option>July</option>
                      <option>August</option>
                      <option>Semtember</option>
                      <option>Octobor</option>
                      <option>Novembor</option>
                      <option>Decembor</option>
                    </select>
                    <small class="text-danger" v-if="errors.salary_month">{{
                      errors.salary_month[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Salary Ammount:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="exampleInputPassword"
                      v-model="form.salary"
                    />
                    <small class="text-danger" v-if="errors.salary">{{
                      errors.salary[0]
                    }}</small>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Pay Salary
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
        salary_month: "",
        salary: "",
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
    paySalary() {
      let id = this.$route.params.id;
      axios
        .post("/api/salary/paid/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "givensalary" });
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
