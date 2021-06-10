<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/category" class="btn btn-primary"
              >All Category</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4">Add Category</h1>
              </div>
              <form class="user" @submit.prevent="categoryInsert">
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleFirstName"
                      placeholder="Category Name"
                      v-model="form.category_name"
                    />
                    <small class="text-danger" v-if="errors.category_name">{{
                      errors.category_name[0]
                    }}</small>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Add Category
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
        category_name: null,
      },
      errors: {},
    };
  },
  methods: {
    categoryInsert() {
      axios
        .post("/api/category", this.form)
        .then(() => {
          this.$router.push({ name: "category" });
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
