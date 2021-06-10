<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/expense" class="btn btn-primary"
              >All Expense</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4">Add Expense</h1>
              </div>
              <form class="user" @submit.prevent="expenseInsert">
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <textarea
                      v-model="form.details"
                      class="form-control form-control-user"
                      placeholder="Write Your Expense Details"
                    ></textarea>
                    <small class="text-danger" v-if="errors.details">{{
                      errors.details[0]
                    }}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleFirstName"
                      placeholder="Expense Ammount"
                      v-model="form.ammount"
                    />
                    <small class="text-danger" v-if="errors.ammount">{{
                      errors.ammount[0]
                    }}</small>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input
                      type="date"
                      class="form-control form-control-user resize_int"
                      id="exampleFirstName"
                      placeholder="Expense Date"
                      v-model="form.date"
                    />
                    <small class="text-danger" v-if="errors.date">{{
                      errors.date[0]
                    }}</small>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Add Expense
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
      this.$router.push("/");
    }
  },
  data() {
    return {
      form: {
        details: null,
        ammount: null,
        date: null,
      },
      errors: {},
    };
  },
  methods: {
    expenseInsert() {
      axios
        .post("/api/expense/", this.form)
        .then(() => {
          this.$router.push({ name: "expense" });
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
