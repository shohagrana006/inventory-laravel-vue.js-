<template>
  <div>
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <div class="row mt-3">
          <div class="col-lg-4 ml-4">
            <router-link to="/stock" class="btn btn-primary"
              >Go Back</router-link
            >
          </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-4">
              <div class="">
                <h1 class="h4 text-gray-900 mb-4">Update Product Quantity</h1>
              </div>
              <form class="user" @submit.prevent="quantityUpdate">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <input
                      type="text"
                      class="form-control form-control-user"
                      id="exampleRepeatPassword"
                      placeholder="Product Quantity"
                      v-model="form.product_quantity"
                    />
                    <small class="text-danger" v-if="errors.product_quantity">{{
                      errors.product_quantity[0]
                    }}</small>
                  </div>
                </div>
                <button
                  type="submit"
                  class="btn btn-primary btn-user btn-block"
                >
                  Update Quantity
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
        product_quantity: "",
      },
      errors: {},
    };
  },
  mounted() {
    let id = this.$route.params.id;
    axios
      .get("/api/product/" + id)
      .then(({ data }) => (this.form = data))
      .catch(console.log("error"));
  },
  methods: {
    quantityUpdate() {
      let id = this.$route.params.id;
      axios
        .post("/api/product/update/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "stock" });
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
